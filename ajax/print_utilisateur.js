const print_user = document.getElementById("print_user");

const xhr = new XMLHttpRequest();
xhr.open("POST", "php/print_utilisateur.php", true);

xhr.onload = () => {
  if (xhr.readyState == xhr.DONE) {
    if (xhr.status == 200) {
      const data = xhr.response;
      print_user.innerHTML = data;
    }
  }
};
xhr.send();
