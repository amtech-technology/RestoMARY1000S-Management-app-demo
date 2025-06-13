const table_data = document.getElementById("table-data");
const util_checker = document.getElementById("util-checker");

let xhr = new XMLHttpRequest();
xhr.open("POST", "php/util-checker.php", true);
xhr.onload = () => {
  if (xhr.readyState == xhr.DONE) {
    if (xhr.status == 200) {
      let data = xhr.response;
      if (data == "superAdmin") {
        util_checker.style.display = "block";
      } else if (data == "normal") {
        util_checker.style.display = "none";
      }
    } else {
      table_data.innerHTML =
        "<span>L'erreur s'est produit lors de la lecture de données</span>";
    }
  } else {
    table_data.innerHTML =
      "<span>L'erreur s'est produit lors de la lecture de données</span>";
  }
};
xhr.send();


