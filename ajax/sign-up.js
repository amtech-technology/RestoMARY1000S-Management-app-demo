const sign_upFrom = document.getElementById("sign-upFrom");
const visulizer = document.getElementById("visulizer");

sign_upFrom.addEventListener("submit", (e) => {
  e.preventDefault();

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/sign-up.php", true);
  xhr.onload = () => {
    if (xhr.readyState == xhr.DONE && xhr.status == 200) {
      let data = xhr.response;
      if (data == "success") {
        window.location.href = "http://localhost/RestoMARY1000S/dash.html";
      } else {
        setTimeout(() => {
          visulizer.innerHTML = "";
          sign_upFrom.reset();
        }, 3000);
        visulizer.innerHTML = data;
        sign_upFrom.reset();
      }
    }
  };
  let formData = new FormData(sign_upFrom);
  xhr.send(formData);
});
