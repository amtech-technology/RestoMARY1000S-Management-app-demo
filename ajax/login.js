const formLogin = document.getElementById("formLogin");
const visualizer = document.getElementById("visualizer");

formLogin.addEventListener("submit", (e) => {
  e.preventDefault();

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "php/login.php", true);
  xhr.onload = () => {
    if (xhr.readyState == xhr.DONE && xhr.status == 200) {
      const data = xhr.response;
      if (data == "success") {
        window.location.href = "http://localhost/RestoMARY1000S/dash.html";
      } else {
        setTimeout(() => {
          visualizer.innerHTML = "";
          formLogin.reset();
        }, 3000);
        visualizer.innerHTML = data;
        formLogin.reset();
      }
    }
  };
  const formData = new FormData(formLogin);
  xhr.send(formData);
});
