const util_form = document.getElementById("util_form");
const visualizer_v = document.getElementById("visualizer_v");

util_form.addEventListener("submit", (e) => {
  e.preventDefault();

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../php/modifier-util.php", true);
  xhr.onload = () => {
    if (xhr.readyState == xhr.DONE) {
      if (xhr.status == 200) {
        const data = xhr.response;
        if (data == "success") {
          window.location.href = "../utilisateurs.html";
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
  const formData = new FormData(util_form);
  xhr.send(formData);
});
