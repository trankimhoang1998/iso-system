import './bootstrap';
import { MobileNavigation } from './modules/navigation.js';
import { DropdownManager } from './modules/dropdown.js';

/**
 * Application Entry Point
 * Initialize all modules when DOM is ready
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile navigation
    new MobileNavigation();
    
    // Initialize dropdown manager
    new DropdownManager();
    
    console.log('Application modules initialized successfully');
});
