/**
 * Admin Mobile Menu Module
 * Handles mobile sidebar toggle functionality
 */

export class AdminMobileManager {
    constructor() {
        this.toggle = document.getElementById('adminMobileToggle');
        this.sidebar = document.querySelector('.admin-sidebar');
        this.overlay = null;
        
        this.init();
    }

    init() {
        if (this.toggle && this.sidebar) {
            this.createOverlay();
            this.bindEvents();
        }
    }

    createOverlay() {
        this.overlay = document.createElement('div');
        this.overlay.className = 'admin-mobile-overlay';
        document.body.appendChild(this.overlay);
    }

    bindEvents() {
        // Toggle button click
        this.toggle.addEventListener('click', () => {
            this.toggleSidebar();
        });

        // Overlay click to close
        this.overlay.addEventListener('click', () => {
            this.closeSidebar();
        });

        // Close on window resize if mobile breakpoint is exceeded
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                this.closeSidebar();
            }
        });

        // Escape key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.sidebar.classList.contains('active')) {
                this.closeSidebar();
            }
        });
    }

    toggleSidebar() {
        if (this.sidebar.classList.contains('active')) {
            this.closeSidebar();
        } else {
            this.openSidebar();
        }
    }

    openSidebar() {
        this.sidebar.classList.add('active');
        this.toggle.classList.add('active');
        this.overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    closeSidebar() {
        this.sidebar.classList.remove('active');
        this.toggle.classList.remove('active');
        this.overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
}