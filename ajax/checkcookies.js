const currentPage = window.location.pathname;

window.onload = () => {
  if (
    currentPage.includes("sign-up.html") ||
    currentPage.includes("index.html") ||
    currentPage.endsWith("/")
  ) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "php/checkcookies.php", true);
    xhr.onload = () => {
      if (xhr.readyState === xhr.DONE && xhr.status === 200) {
        try {
          let res = JSON.parse(xhr.responseText);
          if (res.status === "success") {
            window.location.href = "http://localhost/RestoMARY1000S/dash.html";
          }
        } catch (e) {
          console.error("Invalid JSON response", xhr.responseText);
        }
      }
    };
    xhr.send();
  }
};
