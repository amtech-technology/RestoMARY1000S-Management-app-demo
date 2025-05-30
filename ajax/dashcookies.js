const currentPage = window.location.pathname;

window.onload = () => {
  if (
    currentPage.includes("dash.html") ||
    currentPage.includes("produit.html") ||
    currentPage.includes("mvmtStok.html") ||
    currentPage.includes("rapport.html") ||
    currentPage.includes("utilisateurs.html") ||
    currentPage.includes("ajoutUtil.html") ||
    currentPage.includes("nouvMvmt.html") ||
    currentPage.includes("ajoutProd.html")
  ) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "php/checkcookies.php", true);
    xhr.onload = () => {
      if (xhr.readyState === xhr.DONE && xhr.status === 200) {
        try {
          let res = JSON.parse(xhr.responseText);
          if (res.status != "success") {
            window.location.href = "http://localhost/RestoMARY1000S/";
          }
        } catch (e) {
          console.error("Invalid JSON response", xhr.responseText);
        }
      }
    };
    xhr.send();
  }
};
