const rappot_table = document.getElementById("rappot_table");
const visualiseur_rapport_totale = document.getElementById(
  "visualiseur-rapport-totale"
);

let xhr = new XMLHttpRequest();
xhr.open("POST", "php/rapport.php", true);

xhr.onload = () => {
  if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
    const response = JSON.parse(xhr.responseText);
    const produits = response.produits;
    const totaux = response.totaux;

  
    // 🟩 Fill résumé totals
    visualiseur_rapport_totale.innerHTML = `
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-sm font-medium text-gray-500">Entrées totales</h2>
        <p class="text-xl font-bold text-green-600 mt-2">+ ${
          totaux.entrée
        } unités</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-sm font-medium text-gray-500">Sorties totales</h2>
        <p class="text-xl font-bold text-red-600 mt-2">- ${
          totaux.sortie
        } unités</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-sm font-medium text-gray-500">Stock actuel (global)</h2>
        <p class="text-xl font-bold text-blue-600 mt-2">${
          totaux.entrée - totaux.sortie
        } unités</p>
      </div>
    `;

    // 📄 Fill table
    rappot_table.innerHTML = "";
    for (let produit in produits) {
      const entree = produits[produit].entrée || 0;
      const sortie = produits[produit].sortie || 0;
      const stock = entree - sortie;

      rappot_table.innerHTML += `
        <tr class="border-t">
          <td class="p-4">${produit}</td>
          <td class="p-4 text-green-600">+ ${entree}</td>
          <td class="p-4 text-red-600">- ${sortie}</td>
          <td class="p-4 font-semibold">${stock}</td>
        </tr>
      `;
    }
  }
};

xhr.send();
