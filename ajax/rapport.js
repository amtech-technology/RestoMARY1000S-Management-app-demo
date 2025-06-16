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
    const prix_global_total = response.prix_total_global;

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
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-sm font-medium text-gray-500">Total achat</h2>
        <p class="text-xl font-bold text-green-600 mt-2">+ ${prix_global_total} RWF</p>
      </div>
    `;

    // 📄 Fill table
    rappot_table.innerHTML = "";
    for (let produitNom in produits) {
      const data = produits[produitNom];
      const entree = data.entrée || 0;
      const sortie = data.sortie || 0;
      const stock = entree - sortie;
      const prix = data.prix_achat || 0;
      const nom = data.nom || produitNom;

      rappot_table.innerHTML += `
        <tr class="border-t">
          <td class="p-4">${nom}</td>
          <td class="p-4 text-green-600">+ ${entree}</td>
          <td class="p-4 text-red-600">- ${sortie}</td>
          <td class="p-4 font-semibold">${stock}</td>
          <td class="p-4 font-semibold">${prix} RWF</td>
        </tr>
      `;
    }
  }
};

xhr.send();
