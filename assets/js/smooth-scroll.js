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

    // --- Navigation contrast guard (Astra headers) ---
    function parseColor(str) {
      if (!str) return null;
      // rgb/rgba
      const rgba = str.match(/^rgba?\(([^)]+)\)$/i);
      if (rgba) {
        const parts = rgba[1].split(',').map(s => parseFloat(s.trim()))
        const [r, g, b, a = 1] = parts;
        return { r, g, b, a };
      }
      // hex
      const hex = str.match(/^#([0-9a-f]{3,8})$/i);
      if (hex) {
        let h = hex[1];
        if (h.length === 3) {
          const r = parseInt(h[0] + h[0], 16);
          const g = parseInt(h[1] + h[1], 16);
          const b = parseInt(h[2] + h[2], 16);
          return { r, g, b, a: 1 };
        }
        if (h.length === 6 || h.length === 8) {
          const r = parseInt(h.slice(0,2), 16);
          const g = parseInt(h.slice(2,4), 16);
          const b = parseInt(h.slice(4,6), 16);
          const a = h.length === 8 ? parseInt(h.slice(6,8), 16) / 255 : 1;
          return { r, g, b, a };
        }
      }
      return null;
    }

    function relLuma({ r, g, b }) {
      const srgb = [r, g, b].map(v => v / 255);
      const lin = srgb.map(v => v <= 0.03928 ? v/12.92 : Math.pow((v + 0.055) / 1.055, 2.4));
      return 0.2126 * lin[0] + 0.7152 * lin[1] + 0.0722 * lin[2];
    }

    function guardHeaderContrast() {
      const headers = document.querySelectorAll('.main-header-bar, .ast-primary-header-bar');
      headers.forEach(h => {
        const bg = window.getComputedStyle(h).backgroundColor;
        const c = parseColor(bg);
        if (!c) return;
        if (typeof c.a === 'number' && c.a <= 0.01) {
          // Transparent background; leave styling to transparent-header CSS
          h.classList.remove('is-dark');
          return;
        }
        const luma = relLuma(c);
        const isDark = luma < 0.5; // threshold; tweak if needed
        h.classList.toggle('is-dark', isDark);
      });
    }

    // Run on load and resize
    guardHeaderContrast();
    window.addEventListener('resize', guardHeaderContrast, { passive: true });

    // Observe inline style changes on header (Customizer/live edits)
    const observer = new MutationObserver(guardHeaderContrast);
    document.querySelectorAll('.main-header-bar, .ast-primary-header-bar').forEach(h => {
      observer.observe(h, { attributes: true, attributeFilter: ['style', 'class'] });
    });
    
  });
  
})();