const mouvementTable = document.getElementById("mouvementTable");

let xhr = new XMLHttpRequest();
xhr.open("POST", "php/afficher_mouv.php", true);
xhr.onload = () => {
  if (xhr.readyState == xhr.DONE) {
    if (xhr.status == 200) {
      let data = xhr.response;
      mouvementTable.innerHTML = data;
    }
  }
};
xhr.send();
