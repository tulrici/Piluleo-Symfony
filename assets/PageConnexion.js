

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
  

  const pseudo = document.querySelector('.js-pseudo');
  const motdepasse = document.querySelector('.js-motdepasse');
  
  const bouton = document.querySelector('.js-bouton');
  const texte = document.querySelector('.js-texte');
  
  const pseudoRegex = /^[a-zA-Z0-9_-]{4,20}$/;
  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  
  function inscription() {
      bouton.addEventListener('click', (e) => {
          e.preventDefault(); 
  
          if (pseudo.value.trim() === '' || motdepasse.value.trim() === '') {
              texte.textContent = "Veuillez remplir tous les champs.";
              texte.classList.add('dark:text-red-600');
          } else if (!pseudoRegex.test(pseudo.value)) {
              texte.textContent = "Le nom d'utilisateur n'est pas valide (4-20 caractères, lettres, chiffres, tirets et underscores autorisés).";
              texte.classList.add('dark:text-red-600');
          } else if (!passwordRegex.test(motdepasse.value)) {
              texte.textContent = "Le mot de passe n'est pas valide (au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial).";
              texte.classList.add('dark:text-red-600');
          } else {
              texte.textContent = "Inscription validée !";
              texte.classList.add('dark:text-green-400');
          }
      });
  }
  
  inscription();


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
              <span class="date">${date.format('dddd D MMMM YYYY, HH:mm:ss').toUpperCase()}</span>
             
          `;
      }
  }

  setInterval(updateTime, 1000);

});

updateTime();