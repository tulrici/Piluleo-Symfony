// Function to apply the theme
function applyTheme(isDark) {
    const htmlElement = document.documentElement;
    if (isDark) {
        htmlElement.classList.add("dark");
        htmlElement.setAttribute("data-theme", "dark");
    } else {
        htmlElement.classList.remove("dark");
        htmlElement.setAttribute("data-theme", "light");
    }
}

// Initialize theme toggle logic
function initializeTheme(themeToggle) {
    // Check if a theme is saved in localStorage
    const savedTheme = localStorage.getItem("theme");
    const systemPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

    // Apply saved theme or fall back to system preference
    if (savedTheme) {
        applyTheme(savedTheme === "dark");
        themeToggle.checked = savedTheme === "dark"; // Ensure the toggle state matches the theme
    } else {
        applyTheme(systemPrefersDark);
        themeToggle.checked = systemPrefersDark;
        localStorage.setItem("theme", systemPrefersDark ? "dark" : "light");
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