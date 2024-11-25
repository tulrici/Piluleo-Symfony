// Function to apply the theme
function applyTheme(isDark) {
    const htmlElement = document.documentElement;
    if (isDark) {
        htmlElement.classList.add("dark");
        htmlElement.setAttribute("data-theme", "black");
    } else {
        htmlElement.classList.remove("dark");
        htmlElement.setAttribute("data-theme", "light");
    }
}

// Initialize theme toggle logic
function initializeTheme(themeToggle) {
    // Check if a theme is saved in localStorage
    const savedTheme = localStorage.getItem("theme");

    // Apply saved theme or default to light
    if (savedTheme) {
        applyTheme(savedTheme === "dark");
        themeToggle.checked = savedTheme === "dark"; // Ensure the toggle state matches the theme
    } else {
        // Default to light mode if no saved theme
        applyTheme(false);
        localStorage.setItem("theme", "light");
    }

    // Add an event listener to the toggle
    themeToggle.addEventListener("change", function () {
        const isDark = this.checked;
        applyTheme(isDark);
        localStorage.setItem("theme", isDark ? "dark" : "light");
    });
}

// Initialize the script when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.querySelector(".theme-controller");
    if (themeToggle) {
        initializeTheme(themeToggle);
    } else {
        console.warn("Theme toggle element not found. Ensure the toggle is rendered with the correct class.");
    }
});

// Export functions for external usage or testing
export { applyTheme, initializeTheme };