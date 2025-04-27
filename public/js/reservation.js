document.addEventListener('DOMContentLoaded', function() {
 
    const reservationDateInput = document.getElementById('reservation_date');
    const reservationTimeInput = document.getElementById('reservation_time');
    const guestsInput = document.getElementById('guests');
    const tablesContainer = document.getElementById('tables-container');
    const availableTablesDiv = document.getElementById('available-tables');
    const reservationForm = document.getElementById('reservation-form');
    const searchTablesBtn = document.getElementById('search-tables-btn');
    const restaurantIdInput = document.querySelector('input[name="restaurant_id"]');
    const quantitySelects = document.querySelectorAll('.quantity-select');
    const reservationTotalSpan = document.getElementById('reservation-total');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    let allBookedDates = [];
    let allBookedTimes = {};
    
    if (typeof flatpickr === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js';
        script.onload = initAll;
        document.head.appendChild(script);
    } else {
        initAll();
    }
    
    function initAll() {
        if (restaurantIdInput) {
            fetch('/reservations/booked-dates', {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
                body: JSON.stringify({ restaurant_id: restaurantIdInput.value })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la récupération des dates réservées');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    allBookedDates = data.fullyBookedDates || [];
                    allBookedTimes = data.bookedTimeSlots || {};
                }
                initPickers();
            })
            .catch(error => {
                initPickers();
            });
        } else {
            initPickers();
        }
    }
    
    function initPickers() {
        if (reservationDateInput) {
            if (reservationDateInput._flatpickr) reservationDateInput._flatpickr.destroy();
            
            flatpickr(reservationDateInput, {
                dateFormat: "d/m/Y",
                minDate: "today",
                locale: "fr",
                disable: allBookedDates,
                clickOpens: true,
                allowInput: false,
                onChange: function() {
                    if (tablesContainer && tablesContainer.style.display !== 'none') {
                        tablesContainer.style.display = 'none';
                        if (availableTablesDiv) availableTablesDiv.innerHTML = '';
                    }
                }
            });
            
            const dateIcon = document.querySelector('.date-picker-group .input-group-text');
            if (dateIcon) {
                dateIcon.addEventListener('click', () => reservationDateInput._flatpickr?.open());
            }
        }
        
        if (reservationTimeInput) {
            if (reservationTimeInput._flatpickr) reservationTimeInput._flatpickr.destroy();
            
            flatpickr(reservationTimeInput, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minTime: "10:00",
                maxTime: "22:00",
                defaultHour: 12,
                defaultMinute: 0,
                minuteIncrement: 30,
                clickOpens: true,
                allowInput: false
            });
            
            const timeIcon = document.querySelector('.time-picker-group .input-group-text');
            if (timeIcon) {
                timeIcon.addEventListener('click', () => reservationTimeInput._flatpickr?.open());
            }
        }
    }
    
    function checkAvailableTables() {
        if (!restaurantIdInput || !reservationDateInput || !reservationTimeInput || !guestsInput || !availableTablesDiv) {
            alert("Certains éléments du formulaire sont manquants");
            return;
        }
        
        const restaurantId = restaurantIdInput.value;
        const reservationDate = reservationDateInput.value;
        const reservationTime = reservationTimeInput.value;
        const guests = guestsInput.value;
    
        if (!restaurantId || !reservationDate || !reservationTime || !guests) {
            alert('Veuillez remplir tous les champs requis (date, heure et nombre de personnes).');
            return;
        }
    
        availableTablesDiv.innerHTML = '<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Recherche des tables disponibles...</p>';
        tablesContainer.style.display = 'block';
    
        fetch('/reservations/available-tables', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                restaurant_id: restaurantId,
                reservation_date: reservationDate,
                reservation_time: reservationTime,
                guests: parseInt(guests)
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Une erreur est survenue lors de la communication avec le serveur.');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                displayAvailableTables(data.tables);
            } else {
                availableTablesDiv.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> 
                        ${data.message || "Aucune table disponible pour cette date et heure."}
                    </div>`;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            availableTablesDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i> 
                    ${error.message || "Une erreur est survenue lors de la communication avec le serveur."}
                </div>`;
        });
    }

    function displayAvailableTables(tables) {
        if (!availableTablesDiv) return;
        availableTablesDiv.innerHTML = '';
    
        const tablesArray = Array.isArray(tables) ? tables : Object.values(tables || {});
        
        if (!tablesArray || tablesArray.length === 0) {
            availableTablesDiv.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle"></i> 
                    Aucune table disponible pour cette date et heure.
                </div>`;
            return;
        }
    
        const infoDiv = document.createElement('div');
        infoDiv.className = 'reservation-duration-info';
        infoDiv.innerHTML = '<p><i class="fa fa-info-circle"></i> Chaque réservation occupe la table pour une durée de 2 heures.</p>';
        availableTablesDiv.appendChild(infoDiv);
    
        const titleElem = document.createElement('h5');
        titleElem.className = 'mb-3';
        titleElem.textContent = 'Sélectionnez une ou plusieurs tables :';
        availableTablesDiv.appendChild(titleElem);
        
        const tablesList = document.createElement('div');
        tablesList.className = 'tables-list row';
    
        tablesArray.sort((a, b) => {
            const capA = a.capacity || 4;
            const capB = b.capacity || 4;
            return capA - capB;
        });
    
        tablesArray.forEach(table => {
            const tableItem = document.createElement('div');
            tableItem.className = 'table-item col-md-3 col-sm-6 mb-2';
    
            const tableCard = document.createElement('div');
            tableCard.className = 'card h-100 small-table-card';
            
            const cardBody = document.createElement('div');
            cardBody.className = 'card-body compact-card';
    
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'tables[]';
            checkbox.value = table.id;
            checkbox.id = `table_${table.id}`;
            checkbox.className = 'table-checkbox mr-2';
            
            const label = document.createElement('label');
            label.htmlFor = `table_${table.id}`;
            label.className = 'table-label mb-0';
            label.innerHTML = `<strong>${table.table_label}</strong> <span class="badge badge-info">${table.capacity || 4} personnes</span>`;
    
            cardBody.appendChild(checkbox);
            cardBody.appendChild(label);
            tableCard.appendChild(cardBody);
            tableItem.appendChild(tableCard);
            
            checkbox.addEventListener('change', function() {
                if (this.checked) tableCard.classList.add('selected-table');
                else tableCard.classList.remove('selected-table');
            });
            
            tablesList.appendChild(tableItem);
        });
    
        availableTablesDiv.appendChild(tablesList);
        
        if (tablesArray.length > 0) {
            const firstCheckbox = document.getElementById(`table_${tablesArray[0].id}`);
            if (firstCheckbox) {
                firstCheckbox.checked = true;
                firstCheckbox.dispatchEvent(new Event('change'));
            }
        }
    }

    function updateTotalAmount() {
        if (!quantitySelects || !reservationTotalSpan) return;
        
        let total = 0;
        quantitySelects.forEach(select => {
            const mealId = select.id.replace('meal_', '');
            const quantity = parseInt(select.value);
            const priceElement = document.querySelector(`input[name="meals[${mealId}][price]"]`);
            
            if (priceElement) {
                const price = parseFloat(priceElement.value);
                if (quantity > 0 && !isNaN(price)) {
                    total += quantity * price;
                }
            }
        });
        
        reservationTotalSpan.textContent = total.toFixed(2);
    }

    if (searchTablesBtn) {
        searchTablesBtn.addEventListener('click', function() {
            if (guestsInput?.value && reservationDateInput?.value && reservationTimeInput?.value) {
                checkAvailableTables();
            } else {
                alert('Veuillez remplir tous les champs requis (date, heure et nombre de personnes).');
            }
        });
    }
    
    if (quantitySelects && quantitySelects.length > 0) {
        quantitySelects.forEach(select => {
            select.addEventListener('change', updateTotalAmount);
        });
        updateTotalAmount();
    }
    
    if (reservationForm) {
        reservationForm.addEventListener('submit', function(event) {
            const selectedTables = document.querySelectorAll('input[name="tables[]"]:checked');
            if (selectedTables.length === 0 && tablesContainer?.style.display === 'block') {
                event.preventDefault();
                alert('Veuillez sélectionner au moins une table.');
                return;
            }
            
            let hasMeals = false;
            if (quantitySelects) {
                quantitySelects.forEach(select => { if (parseInt(select.value) > 0) hasMeals = true; });
                
                if (!hasMeals && !confirm('Vous n\'avez sélectionné aucun repas. Voulez-vous continuer?')) {
                    event.preventDefault();
                }
            }
        });
    }
    
    if (guestsInput) {
        guestsInput.addEventListener('input', function() {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) value = 1;
            else if (value > 20) value = 20;
            
            if (this.value != value) this.value = value;
        });
    }
    
    window.checkAvailableTables = checkAvailableTables;
});