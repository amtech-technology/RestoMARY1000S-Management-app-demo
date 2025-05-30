const filtrer_prodForm = document.getElementById("filtrer_prodForm");
const filterInput = document.getElementById("filterInput");
/* const table_data = document.getElementById("table-data"); */

filtrer_prodForm.addEventListener("submit", (e) => {
  e.preventDefault();
});

filterInput.addEventListener("input", () => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/filtrer_produit.php", true);
  xhr.onload = () => {
    if (xhr.readyState == xhr.DONE) {
      if (xhr.status == 200) {
        let data = xhr.response;
        table_data.innerHTML = data;
      }
    }
  };
  let formData = new FormData(filtrer_prodForm);
  xhr.send(formData);
});
