const add_prod = document.getElementById("ajoutProd");

const xhr = new XMLHttpRequest();
xhr.open("POST", "php/admin-checker.php", true);
xhr.onload = () => {
  if (xhr.readyState == xhr.DONE && xhr.status == 200) {
    const data = xhr.response;
    if (data == "sucess") {
      add_prod.style.display = "none";
      window.location.href = "dash.html";
    } else {
      add_prod.style.display = "block";
    }
  }
};
xhr.send();
