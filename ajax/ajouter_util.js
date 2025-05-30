const util_form = document.getElementById("util_form");
const visualizer_v = document.getElementById("visualizer_v");

util_form.addEventListener("submit", (e) => {
  e.preventDefault();

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/ajouter_util.php", true);
  xhr.onload = () => {
    if (xhr.readyState == xhr.DONE) {
      if (xhr.status == 200) {
        let data = xhr.response;
        if (data == "success") {
          setTimeout(() => {
            visualizer_v.innerHTML = "";
            util_form.reset();
          }, 3000);
          visualizer_v.innerHTML =
            "<span class='text-green-700'>Ajouté avec succès!</span>";
          util_form.reset();
        } else {
          setTimeout(() => {
            visualizer_v.innerHTML = "";
            util_form.reset();
          }, 3000);
          visualizer_v.innerHTML = data;
          util_form.reset();
        }
      }
    }
  };
  let formData = new FormData(util_form);
  xhr.send(formData);
});
