import './bootstrap';
import { MobileNavigation } from './modules/navigation.js';
import { DropdownManager } from './modules/dropdown.js';
import { AdminMobileManager } from './modules/admin-mobile.js';

/**
 * Application Entry Point
 * Initialize all modules when DOM is ready
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile navigation
    new MobileNavigation();
    
    // Initialize dropdown manager
    new DropdownManager();
    
    // Initialize admin mobile menu
    new AdminMobileManager();
    
    console.log('Application modules initialized successfully');
});
