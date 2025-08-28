/**
 * Dropdown Module
 * Handles dropdown menu functionality for navigation
 */

export class DropdownManager {
    constructor() {
        this.dropdownLinks = document.querySelectorAll('[data-dropdown]');
        
        this.init();
    }

    init() {
        if (this.dropdownLinks.length > 0) {
            this.bindEvents();
        }
    }

    bindEvents() {
        this.dropdownLinks.forEach(link => {
            const dropdownId = 'dropdown-' + link.getAttribute('data-dropdown');
            const dropdown = document.getElementById(dropdownId);
            
            if (dropdown) {
                // Mobile click handler
                link.addEventListener('click', (e) => this.handleDropdownClick(e, link, dropdown));
            }
        });
    }

    handleDropdownClick(e, link, dropdown) {
        if (window.innerWidth <= 768) {
            e.preventDefault();
            
            // Close other dropdowns and remove active class from other links
            this.closeOtherDropdowns(link, dropdown);
            
            // Toggle current dropdown and link active state
            dropdown.classList.toggle('active');
            link.classList.toggle('active');
        }
    }

    closeOtherDropdowns(currentLink, currentDropdown) {
        document.querySelectorAll('.nav__dropdown').forEach(d => {
            if (d !== currentDropdown) {
                d.classList.remove('active');
            }
        });
        
        document.querySelectorAll('[data-dropdown]').forEach(otherLink => {
            if (otherLink !== currentLink) {
                otherLink.classList.remove('active');
            }
        });
    }

    // Public method to reset all dropdowns (called from navigation module)
    resetAllDropdowns() {
        document.querySelectorAll('.nav__dropdown').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
        document.querySelectorAll('[data-dropdown]').forEach(link => {
            link.classList.remove('active');
        });
    }
}