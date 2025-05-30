const table_data = document.getElementById("table-data");

let xhr = new XMLHttpRequest();
xhr.open("POST", "php/afficher_prod.php", true);
xhr.onload = () => {
  if (xhr.readyState == xhr.DONE) {
    if (xhr.status == 200) {
      let data = xhr.response;
      table_data.innerHTML = data;
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
