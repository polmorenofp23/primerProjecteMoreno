// Initialize lucide icons when DOM is ready
// Usage in HTML: <i data-lucide="search" style="color: red;"></i>
// The SVGs use stroke="currentColor", so `color` CSS will change the icon stroke color.

// Global function to reinitialize icons (for dynamic content)
window.initLucideIcons = function() {
  if (window.lucide && typeof window.lucide.createIcons === 'function') {
    window.lucide.createIcons();
  }
};

document.addEventListener('DOMContentLoaded', function () {
  window.initLucideIcons();
});
