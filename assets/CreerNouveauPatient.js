

tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        backgroundColor: {
          dark: "black",
        },
      
      },
    },
  };
  
  document.addEventListener("DOMContentLoaded", function () {
    document
      .querySelector(".theme-controller")
      .addEventListener("change", function () {
        if (this.checked) {
          document.documentElement.classList.add("dark");
          document.documentElement.setAttribute("data-theme", "black");
        } else {
          document.documentElement.classList.remove("dark");
          document.documentElement.setAttribute("data-theme", "light");
        }
      });
  });
  


