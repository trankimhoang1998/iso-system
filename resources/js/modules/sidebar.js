/**
 * Sidebar Toggle Module
 * Handles collapsible sidebar functionality for all user levels
 */
export class SidebarToggle {
    constructor() {
        this.init();
    }

    init() {
        this.setupToggleButton();
        this.setupResponsiveHandling();
        this.setupMobileOverlay();
        this.restoreUserPreference();
    }

    setupToggleButton() {
        const toggleButton = document.getElementById('sidebarToggle');
        if (!toggleButton) return;

        toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            this.toggleSidebar();
        });
    }

    setupResponsiveHandling() {
        // Auto-collapse sidebar on mobile
        const mediaQuery = window.matchMedia('(max-width: 768px)');
        
        const handleResponsive = (e) => {
            const body = document.body;
            
            if (e.matches) {
                // Mobile view - collapse sidebar by default
                body.classList.add('sidebar-collapsed');
            } else {
                // Desktop view - restore user preference
                const userPreference = localStorage.getItem('sidebarCollapsed');
                if (userPreference === 'true') {
                    body.classList.add('sidebar-collapsed');
                } else {
                    body.classList.remove('sidebar-collapsed');
                }
            }
        };

        // Initial check
        handleResponsive(mediaQuery);
        
        // Listen for changes (use modern addEventListener)
        if (mediaQuery.addEventListener) {
            mediaQuery.addEventListener('change', handleResponsive);
        } else {
            // Fallback for older browsers
            mediaQuery.addListener(handleResponsive);
        }
    }

    setupMobileOverlay() {
        // Create mobile overlay if it doesn't exist
        let overlay = document.querySelector('.mobile-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'mobile-overlay';
            document.body.appendChild(overlay);
        }

        // Close sidebar when clicking overlay
        overlay.addEventListener('click', () => {
            document.body.classList.add('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', 'true');
        });
    }

    toggleSidebar() {
        const body = document.body;
        const isCollapsed = body.classList.contains('sidebar-collapsed');
        
        if (isCollapsed) {
            body.classList.remove('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', 'false');
        } else {
            body.classList.add('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', 'true');
        }

        // Animate toggle button
        this.animateToggleButton();
    }

    animateToggleButton() {
        const toggleButton = document.getElementById('sidebarToggle');
        if (!toggleButton) return;

        const icon = toggleButton.querySelector('svg');
        if (icon) {
            icon.style.transform = 'rotate(180deg)';
            setTimeout(() => {
                icon.style.transform = 'rotate(0deg)';
            }, 150);
        }
    }

    restoreUserPreference() {
        // Don't restore on mobile - handled by responsive function
        const mediaQuery = window.matchMedia('(min-width: 769px)');
        if (!mediaQuery.matches) return;

        const userPreference = localStorage.getItem('sidebarCollapsed');
        if (userPreference === 'true') {
            document.body.classList.add('sidebar-collapsed');
        }
    }
}