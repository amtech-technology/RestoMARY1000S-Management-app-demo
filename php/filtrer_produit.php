<?php
///////////////////////////////////////////////////////////////////
require_once("./config.php");

$nom_du_produit = htmlspecialchars($_POST['filtrer_prod']);

$sql = "SELECT * FROM produit WHERE nom_produit LIKE '%{$nom_du_produit}%' OR `service` LIKE '%{$nom_du_produit}%'";
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
if (count($result) > 0) {
  foreach ($result as $row) {
    echo '
        <tr class="border-t">
          <td class="p-4">' . $row['nom_produit'] . '</td>
          <td class="p-4">' . $row['unite_produit'] . '</td>
          <td class="p-4">' . $row['service'] . '</td>
          <td class="p-4">' . $row['seuil_minimum'] . '</td>
          <td class="p-4">' . $row['date'] . '</td>
          <td class="p-4">
            <a href="#"><button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Supprimer</button></a>
          </td>
        </tr>
        ';
  }
} else {
  echo "<span class='text-center text-gray-700 font-bold'>Pas de données disponible</span>";
}
