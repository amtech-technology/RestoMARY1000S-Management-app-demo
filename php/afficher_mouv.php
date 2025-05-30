<?php
//////////////////////////////////////////////////////////////////////////////
require_once("./config.php");

$sql = "SELECT * FROM mouvement ORDER BY id DESC";
$query = $pdo->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);
if (count($results) > 0) {
    foreach ($results as $row) {

        ($row['type_mouvement'] == "entrée") ? $movType = "<span class='text-green-700 font-semibold'>{$row['type_mouvement']}</span>" : $movType = "<span class='text-red-700 font-semibold'>{$row['type_mouvement']}</span>";

        echo '
            <tr class="border-t">
                <td class="p-4">' . $row['date_mouvement'] . '</td>
                <td class="p-4">' . $row['produit'] . '</td>
                <td class="p-4 text-green-600 font-semibold">' . $movType . '</td>
                <td class="p-4">' . $row['quantite'] . '</td>
                <td class="p-4">' . $row['service'] . '</td>
                <td class="p-4">' . $row['responsable'] . '</td>
                <td class="p-4">
                    <a href="php/delete-mouv.php?id=' . $row['id'] . '"><button class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-900">Supprimer</button></a>
                </td>
            </tr>
        ';
    }
} else {
    echo "<span class='text-gray-700 font-bold'>Pas de données disponible</span>";
}
