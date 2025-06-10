<?php
/* header("Content-Type: text/plain");
print_r($_POST);
exit; */
///////////////////////////////////////////////////////////////////////////////////
require_once("./config.php");

$produit = htmlspecialchars($_POST['produit']);
$type_mouv = htmlspecialchars($_POST['type_mouv']);
$service = htmlspecialchars($_POST['service']);

error_log("produit: $produit, type: $type_mouv, service: $service");

$sql = "SELECT * FROM mouvement WHERE 1=1";
$params = [];

// Add filters conditionally
if (!empty($produit)) {
    $sql .= " AND produit LIKE ?";
    $params[] = "%$produit%";
}

if (!empty($type_mouv)) {
    $sql .= " AND type_mouvement = ?";
    $params[] = $type_mouv;
}

if (!empty($service)) {
    $sql .= " AND service = ?";
    $params[] = $service;
}

// Now add ORDER BY at the end
$sql .= " ORDER BY date_mouvement DESC";

$query = $pdo->prepare($sql);
$query->execute($params);

$result = $query->fetchAll(PDO::FETCH_ASSOC);
if (count($result) > 0) {
    foreach ($result as $row) {
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
                    <a href="#"><button class="bg-red-700 text-white px-3 py-1 rounded hover:bg-blue-600">Supprimer</button></a>
                </td>
            </tr>
        ';
    }
} else {
    echo "<span class='text-gray-700 font-semibold'>Pas de données disponible</span>";
}
