const ajout_mouvementForm = document.getElementById("ajout_mouvement");
const visualizer = document.getElementById("visualizer");

ajout_mouvementForm.addEventListener("submit", (e) => {
  e.preventDefault();

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/ajout_mouvement.php", true);

  xhr.onload = () => {
    if (xhr.readyState == xhr.DONE) {
      if (xhr.status == 200) {
        let data = xhr.response;
        if (data == "success") {
          setTimeout(() => {
            visualizer.innerHTML = "";
            ajout_mouvementForm.reset();
          }, 3000);
          visualizer.innerHTML = `<span class="text-center text-green-700">Le mouvement a été ajouté avec succès!</span>`;
          ajout_mouvementForm.reset();
          window.scrollTo({ top: 0, behavior: "smooth" });
        } else {
          setTimeout(() => {
            visualizer.innerHTML = "";
            ajout_mouvementForm.reset();
          }, 3000);
          visualizer.innerHTML = `<span class="text-center text-red-700">${data}</span>`;
          ajout_mouvementForm.reset();
          window.scrollTo({ top: 0, behavior: "smooth" });
        }
      }
    }
  };
  let formData = new FormData(ajout_mouvementForm);
  xhr.send(formData);
});
