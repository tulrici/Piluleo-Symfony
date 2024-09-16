

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
  

  const pseudo = document.querySelector('.js-pseudo')
  const motdepasse = document.querySelector('.js-motdepasse')
  const retapezmotdepasse = document.querySelector('.js-retapezmotdepasse')
  const email = document.querySelector('.js-email')
  const datenaissance = document.querySelector('.js-datenaissance')
  const adresse = document.querySelector('.js-adresse')
  const codepostal = document.querySelector('.js-codepostal')
  const ville = document.querySelector('.js-ville')
  const pays = document.querySelector('.js-pays')
  const bouton = document.querySelector('.js-bouton')
  const texte = document.querySelector('.js-texte')
  
  const pseudoRegex = /^[a-zA-Z0-9_-]{4,20}$/;
  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
  const adresseRegex = /^[a-zA-Z0-9\s,'-]{3,100}$/;
  const codePostalRegex = /^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/;
  const villeRegex = /^[a-zA-Z\u00C0-\u017F\s'-]{2,50}$/;
  const paysRegex = /^[a-zA-Z\u00C0-\u017F\s'-]{2,56}$/;


  console.log(datenaissance)
  
  function inscription() {
      bouton.addEventListener('click', (e) => {
          e.preventDefault(); 

          const champs = [pseudo, motdepasse, retapezmotdepasse, email, datenaissance, adresse, codepostal, ville, pays];
          let champsVides = false;

          champs.forEach(champ => {
              if (champ.value.trim() === '') {
                  champsVides = true;
              }
          });

          if (champsVides) {
              texte.textContent = "Veuillez remplir tous les champs.";
              texte.classList.add('dark:text-red-600');  
          } else if (motdepasse.value !== retapezmotdepasse.value) {
              texte.textContent = "Les mots de passe ne correspondent pas.";
              texte.classList.add('dark:text-red-600');
          } else if (!pseudoRegex.test(pseudo.value)) {
              texte.textContent = "Le nom d'utilisateur n'est pas valide (4-20 caractères, lettres, chiffres, tirets et underscores autorisés).";
              texte.classList.add('dark:text-red-600');
          } else if (!passwordRegex.test(motdepasse.value)) {
              texte.textContent = "Le mot de passe n'est pas valide (au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial).";
              texte.classList.add('dark:text-red-600');
          } else if (!emailRegex.test(email.value)) {
              texte.textContent = "L'adresse email n'est pas valide.";
              texte.classList.add('dark:text-red-600');
          } else if (!dateRegex.test(datenaissance.value)) {
              texte.textContent = "La date de naissance n'est pas valide (format Jour/Mois/Année).";
              texte.classList.add('dark:text-red-600');
          } else if (!adresseRegex.test(adresse.value)) {
              texte.textContent = "L'adresse n'est pas valide (3-100 caractères).";
              texte.classList.add('dark:text-red-600');
          } else if (!codePostalRegex.test(codepostal.value)) {
              texte.textContent = "Le code postal n'est pas valide (5 chiffres, format français).";
              texte.classList.add('dark:text-red-600');
          } else if (!villeRegex.test(ville.value)) {
              texte.textContent = "La ville n'est pas valide (2-50 caractères, lettres et certains caractères spéciaux autorisés).";
              texte.classList.add('dark:text-red-600');
          } else if (!paysRegex.test(pays.value)) {
              texte.textContent = "Le pays n'est pas valide (2-56 caractères, lettres et certains caractères spéciaux autorisés).";
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