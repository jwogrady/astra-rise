/**
 * Rise Local Smooth Scroll Enhancement
 * Optimized for performance with proper event delegation
 */

(function() {
  'use strict';
  
  // Wait for DOM content to be loaded
  document.addEventListener('DOMContentLoaded', function() {
    
    // Use event delegation for better performance
    document.addEventListener('click', function(e) {
      // Check if clicked element is an anchor link
      const anchor = e.target.closest('a[href^="#"]');
      
      if (!anchor) return;
      
      const href = anchor.getAttribute('href');
      
      // Skip if href is just "#"
      if (href === '#') return;
      
      const target = document.querySelector(href);
      
      if (target) {
        e.preventDefault();
        
        // Smooth scroll with reduced motion preference check
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        target.scrollIntoView({
          behavior: prefersReducedMotion ? 'auto' : 'smooth',
          block: 'start'
        });
        
        // Update URL without triggering scroll
        if (history.pushState) {
          history.pushState(null, null, href);
        }
      }
    });
    
    // Handle back/forward browser navigation
    window.addEventListener('popstate', function() {
      if (location.hash) {
        const target = document.querySelector(location.hash);
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      }
    });
    
  });
  
})();