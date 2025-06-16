document.addEventListener("DOMContentLoaded", function () {
  // Add a timestamp to the URL to prevent caching
  const url = "http://localhost/RestoMARY1000S/php/print-on-dashboard.php";

  fetch(url)
    .then((res) => res.json())
    .then((data) => {
      console.log("Données reçues :", data);

      // Update cards
      const cards = document.querySelectorAll("#dashbaord-cards h2");
      if (cards.length >= 4) {
        cards[0].textContent = data.stock_total ?? "0";
        cards[1].textContent = data.produits_critiques ?? "0";
        /* cards[2].textContent = data.stock_bar ?? "0"; */
        cards[3].textContent = data.mouvements_jour ?? "0";
        /*         console.log(cards[1]); */
      }

      // Stock Chart
      const stockCtx = document.getElementById("stockChart")?.getContext("2d");
      if (stockCtx && data.chart_stock) {
        new Chart(stockCtx, {
          type: "bar",
          data: {
            labels: ["Stock Total", "Produits Critiques"],
            datasets: [
              {
                label: "État du stock",
                data: data.chart_stock,
                backgroundColor: ["#3b82f6", "#ef4444"],
              },
            ],
          },
        });
      }

      // Mouvements de stock par jour
      const mouvementsCtx = document
        .getElementById("facebookChart")
        ?.getContext("2d");

      if (mouvementsCtx && data.chart_mouvements) {
        const gradient = mouvementsCtx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, "rgba(24, 118, 242, 0.4)");
        gradient.addColorStop(1, "rgba(24, 118, 242, 0)");

        new Chart(mouvementsCtx, {
          type: "line",
          data: {
            labels: data.chart_mouvements.labels,
            datasets: [
              {
                label: "Mouvements",
                data: data.chart_mouvements.data,
                borderColor: "#1877f2",
                borderWidth: 4,
                pointRadius: 0,
                fill: true,
                backgroundColor: gradient,
                tension: 0,
              },
            ],
          },
          options: {
            responsive: true,
            plugins: {
              legend: { display: false },
              tooltip: {
                enabled: true,
                backgroundColor: "#333",
                titleColor: "#fff",
                bodyColor: "#fff",
              },
            },
            scales: {
              x: {
                grid: { display: false },
                ticks: { color: "#666", font: { size: 8 } },
                title: {
                  display: true,
                  text: "Date",
                  color: "#444",
                  font: { weight: "bold" },
                },
              },
              y: {
                grid: {
                  color: "#e0e0e0",
                  drawTicks: false,
                  drawBorder: false,
                },
                ticks: { color: "#666", beginAtZero: true }, // <- dynamic ticks now
                title: {
                  display: true,
                  text: "Mouvements",
                  color: "#444",
                  font: { weight: "bold" },
                },
              },
            },
            elements: {
              line: { borderJoinStyle: "miter", borderCapStyle: "butt" },
            },
          },
        });
      }

      // Produits du bar
      const barCtx = document.getElementById("barChart")?.getContext("2d");
      if (barCtx && data.chart_produits_bar) {
        new Chart(barCtx, {
          type: "bar",
          data: {
            labels: data.chart_produits_bar.labels,
            datasets: [
              {
                label: "Produits du Bar",
                data: data.chart_produits_bar.data,
                backgroundColor: "#8b5cf6",
              },
            ],
          },
        });
      }
    })
    .catch((error) => {
      console.error(
        "Erreur lors du chargement des données du dashboard :",
        error
      );
    });
});
