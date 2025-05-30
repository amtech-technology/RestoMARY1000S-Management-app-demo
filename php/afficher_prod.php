<?php
///////////////////////////////////////////////////////////////////
require_once("./config.php");

$sql = "SELECT * FROM produit ORDER BY id DESC";
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
            <a href="php/delete-prod.php?id=' . $row['id'] . '"><button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Supprimer</button></a>
          </td>
        </tr>
        ';
  }
} else {
  echo "Pas de données disponible";
}
