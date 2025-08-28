/**
 * Mobile Navigation Module
 * Handles mobile hamburger menu toggle functionality
 */

export class MobileNavigation {
    constructor() {
        this.mobileToggle = document.getElementById('mobileToggle');
        this.headerNav = document.getElementById('headerNav');
        
        this.init();
    }

    init() {
        if (this.mobileToggle && this.headerNav) {
            this.bindEvents();
        }
    }

    bindEvents() {
        // Mobile menu toggle
        this.mobileToggle.addEventListener('click', () => this.toggleMenu());
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => this.handleOutsideClick(e));
        
        // Handle window resize
        window.addEventListener('resize', () => this.handleResize());
    }

    toggleMenu() {
        this.mobileToggle.classList.toggle('active');
        this.headerNav.classList.toggle('active');
        
        // If closing menu, reset all dropdowns
        if (!this.headerNav.classList.contains('active')) {
            this.resetDropdowns();
        }
    }

    handleOutsideClick(e) {
        if (!this.headerNav.contains(e.target) && !this.mobileToggle.contains(e.target)) {
            this.closeMenu();
        }
    }

    handleResize() {
        if (window.innerWidth > 768) {
            this.closeMenu();
        }
    }

    closeMenu() {
        this.mobileToggle.classList.remove('active');
        this.headerNav.classList.remove('active');
        this.resetDropdowns();
    }

    resetDropdowns() {
        document.querySelectorAll('.nav__dropdown').forEach(dropdown => {
            dropdown.classList.remove('active');
        });
        document.querySelectorAll('[data-dropdown]').forEach(link => {
            link.classList.remove('active');
        });
    }
}