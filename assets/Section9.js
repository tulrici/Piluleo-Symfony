

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
  

  document.addEventListener('DOMContentLoaded', function() {
    const BoutonMenu = document.getElementById('BoutonMenu');
    const Defilement = document.getElementById('Defilement');

    BoutonMenu.addEventListener('click', function(event) {
      event.stopPropagation();
      Defilement.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
      if (!Defilement.contains(event.target) && !BoutonMenu.contains(event.target)) {
        Defilement.classList.add('hidden');
      }
    });
  });


  document.addEventListener('DOMContentLoaded', function() {
    dayjs.locale('fr');
    dayjs.extend(window.dayjs_plugin_updateLocale);
    dayjs.updateLocale('fr', {
        formats: {
            LLL: 'dddd D MMMM YYYY'
        }
    });

    function updateTime() {
        const date = dayjs();
        const currentTimeElement = document.querySelector('.current-time');
        if (currentTimeElement) {
            currentTimeElement.innerHTML = `
                <span class="date">${date.format('dddd D MMMM YYYY, HH:mm').toUpperCase()}</span>
            `;
        }
    }

    // Mettre à jour l'heure immédiatement
    updateTime();

    // Calculer le délai jusqu'à la prochaine seconde
    const now = new Date();
    const delay = 1000 - now.getMilliseconds();

    // Attendre jusqu'à la prochaine seconde, puis mettre à jour toutes les secondes
    setTimeout(() => {
        updateTime();
        setInterval(updateTime, 60000);
    }, delay);
});