<?php
///////////////////////////////////////////////////////////////////
session_start();
require_once("./config.php");

$nom_du_produit = htmlspecialchars($_POST['filtrer_prod']);

$sql = "SELECT * FROM produit WHERE nom_produit LIKE '%{$nom_du_produit}%' OR `service` LIKE '%{$nom_du_produit}%'";
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
if (count($result) > 0) {
  foreach ($result as $row) {
    $user_unique_id = $_SESSION['user_uniqueID'];

    $sql_admin = "SELECT * FROM utilisateur WHERE unique_id = ?";
    $query_admin = $pdo->prepare($sql_admin);
    $query_admin->execute([$user_unique_id]);
    $res_admin = $query_admin->fetchAll(PDO::FETCH_ASSOC);

    if (count($res_admin) > 0) {
      foreach ($res_admin as $row_admin) {

        if ($row_admin['role_utilisateur'] == "Admin") {

          if ($row['quantite'] <= 10) {
            $quantiteR = "<span class='text-red-700 font-bold'>" . $row['quantite'] . "</span>";
          } else {
            $quantiteR = "<span class='text-green-700 font-bold'>" . $row['quantite'] . "</span>";
          }
          echo '
              <tr class="border-t">
                <td class="p-4">' . $row['nom_produit'] . '</td>
                <td class="p-4">' . $row['unite_produit'] . '</td>
                <td class="p-4">' . $row['service'] . '</td>
                <td class="p-4">' . $quantiteR . '</td>
                <td class="p-4">' . $row['prix_achat'] . "$" . '</td>
                <td class="p-4">' . $row['prix_vente'] . "$" . '</td>
                <td class="p-4">' . ((int)$row['prix_vente'] * (int)$row['quantite']) . "$" . '</td>
                <td class="p-4">' . $row['date'] . '</td>
                <td class="p-4">
                  <a href="php/delete-prod.php?id=' . $row['id'] . '" hidden><button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Supprimer</button></a>
                </td>
              </tr>
        ';
        } else {

          if ($row['quantite'] <= 10) {
            $quantiteR = "<span class='text-red-700 font-bold'>" . $row['quantite'] . "</span>";
          } else {
            $quantiteR = "<span class='text-green-700 font-bold'>" . $row['quantite'] . "</span>";
          }
          echo '
              <tr class="border-t">
                <td class="p-4">' . $row['nom_produit'] . '</td>
                <td class="p-4">' . $row['unite_produit'] . '</td>
                <td class="p-4">' . $row['service'] . '</td>
                <td class="p-4">' . $quantiteR . '</td>
                <td class="p-4">' . $row['prix_achat'] . "$" . '</td>
                <td class="p-4">' . $row['prix_vente'] . "$" . '</td>
                <td class="p-4">' . ((int)$row['prix_vente'] * (int)$row['quantite']) . "$" . '</td>
                <td class="p-4">' . $row['date'] . '</td>
                <td class="p-4">
                  <a href="php/delete-prod.php?id=' . $row['id'] . '"><button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Supprimer</button></a>
                </td>
              </tr>
        ';
        }
      }
    }
  }
} else {
  echo "<span class='text-center text-gray-700 font-bold'>Pas de données disponible</span>";
}
