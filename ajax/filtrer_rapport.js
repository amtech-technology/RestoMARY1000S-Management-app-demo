const rapport_form = document.getElementById("rapport_form");
const date1 = document.getElementById("date1");
const date2 = document.getElementById("date2");
const service = document.getElementById("service");

function sendDataToPHP() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/filtrer_rapport.php", true);
  xhr.onload = () => {
    if (xhr.readyState == xhr.DONE) {
      if (xhr.status == 200) {
        let data = xhr.response;
        rappot_table.innerHTML = data;
      }
    }
  };
  let formData = new FormData(rapport_form);
  xhr.send(formData);
}

service.addEventListener("change", () => {
  sendDataToPHP();
});

date1.addEventListener("input", () => {
  sendDataToPHP();
});

date2.addEventListener("input", () => {
  sendDataToPHP();
});
