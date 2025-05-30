const filterMouvForm = document.getElementById("filterMouv");
const filterMouvInput = document.getElementById("filterMouvInput");
const filterMouvSelectType = document.getElementById("filterMouvSelectType");
const filterMouvSelectService = document.getElementById(
  "filterMouvSelectService"
);


function sendFilterRequest() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/filtre_mouv.php", true);
  xhr.onload = () => {
    if (xhr.readyState === xhr.DONE && xhr.status === 200) {
      let data = xhr.response;
      mouvementTable.innerHTML = data;
    }
  };
  let formData = new FormData(filterMouvForm);
  xhr.send(formData);
}


let inputTimeout;
filterMouvInput.addEventListener("input", () => {
  clearTimeout(inputTimeout);
  inputTimeout = setTimeout(() => {
    sendFilterRequest();
  }, 300); // adjust delay as needed
});

filterMouvSelectType.addEventListener("change", sendFilterRequest);
filterMouvSelectService.addEventListener("change", sendFilterRequest);
