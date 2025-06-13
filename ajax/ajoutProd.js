const ajoutProdForm = document.getElementById("ajoutProd");
const visualizer = document.getElementById("visualizer");

ajoutProdForm.addEventListener("submit", (e) => {
  e.preventDefault();

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/ajoutProd.php", true);
  xhr.onload = () => {
    if (xhr.readyState == xhr.DONE) {
      if (xhr.status == 200) {
        let data = xhr.response;
        if (data == "success") {
          setTimeout(() => {
             window.scrollTo({ top: 0, behavior: "smooth" });
            visualizer.innerHTML = "";
            ajoutProdForm.reset();
          }, 3000);
         /*  visualizer.innerHTML = `<span class="text-green-600 text-center">Ajouté avec succès!</span>`; */
         window.location.href = "./produit.html";
        } else {
          setTimeout(() => {
            window.scrollTo({ top: 0, behavior: "smooth" });
            visualizer.innerHTML = "";
            ajoutProdForm.reset();
          }, 3000);
          visualizer.innerHTML = `<span class="text-red-600 text-center">${data}</span>`;
        }
      } else {
        visualizer.innerHTML = `<span class="text-red-600 text-center">La Requette à echoué: ${xhr.status} </span>`;
      }
    } else {
      visualizer.innerHTML = `<span class="text-red-600 text-center">Erreur d'etat de la requêtte: ${xhr.status} </span>`;
    }
  };
  let formData = new FormData(ajoutProdForm);
  xhr.send(formData);
});
