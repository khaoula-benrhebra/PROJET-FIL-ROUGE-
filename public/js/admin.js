/**
 * Admin Dashboard JavaScript
 * For Restaurant Management System
 */

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle Function
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active');
        });
    }
    
    // Responsive sidebar behavior
    function handleResize() {
        if (window.innerWidth < 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        } else {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('expanded');
        }
    }
    
    // Initialize on page load
    handleResize();
    
    // Add resize event listener
    window.addEventListener('resize', handleResize);
    
    // Handle action buttons
    const editButtons = document.querySelectorAll('.btn-action.edit');
    const deleteButtons = document.querySelectorAll('.btn-action.delete');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const name = row.cells[0].textContent;
            alert('Modification de la réservation de ' + name);
        });
    });
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const name = row.cells[0].textContent;
            if (confirm('Êtes-vous sûr de vouloir supprimer la réservation de ' + name + ' ?')) {
                row.remove();
            }
        });
    });
});