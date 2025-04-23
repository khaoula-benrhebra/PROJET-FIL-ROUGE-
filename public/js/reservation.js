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
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    allBookedDates = data.fullyBookedDates || [];
                    allBookedTimes = data.bookedTimeSlots || {};
                }
                initPickers();
            })
            .catch(() => initPickers());
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
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
            body: JSON.stringify({
                restaurant_id: restaurantId,
                reservation_date: reservationDate,
                reservation_time: reservationTime,
                guests: guests
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayAvailableTables(data.tables);
            } else {
                availableTablesDiv.innerHTML = `<p class="alert alert-danger">${data.message || 'Une erreur est survenue.'}</p>`;
            }
        })
        .catch(() => {
            availableTablesDiv.innerHTML = '<p class="alert alert-danger">Une erreur est survenue.</p>';
        });
    }

    function displayAvailableTables(tables) {
        if (!availableTablesDiv) return;
        availableTablesDiv.innerHTML = '';
    
        if (!tables || tables.length === 0) {
            availableTablesDiv.innerHTML = '<p class="alert alert-warning">Aucune table disponible pour cette date et heure.</p>';
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
    
        tables.sort((a, b) => a.capacity - b.capacity);
        tables.forEach(table => {
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
        
        if (tables.length > 0) {
            const firstCheckbox = document.getElementById(`table_${tables[0].id}`);
            if (firstCheckbox) {
                firstCheckbox.checked = true;
                firstCheckbox.dispatchEvent(new Event('change'));
            }
        }
    }

    window.checkAvailableTables = checkAvailableTables;
});