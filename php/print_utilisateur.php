<?php
//////////////////////////////////////////////////////////////////////////
require_once("./config.php");

$sql = "SELECT * FROM utilisateur ORDER BY id DESC";
$query = $pdo->prepare($sql);
$query->execute();

$result = $query->fetchAll(PDO::FETCH_ASSOC);
if (count($result) > 0) {
    foreach ($result as $row) {
        echo '
            <tr class="border-t">
                <td class="p-4">' . $row['nom_utilisateur'] . '</td>
                <td class="p-4">' . $row['unique_id'] . '</td>
                <td class="p-4">' . $row['email'] . '</td>
                <td class="p-4">' . $row['role_utilisateur'] . '</td>
                <td class="p-4 text-green-600">Actif</td>
                <td class="p-4">
                    <a href="php/modif-util.php?id=' . $row['id'] . '"><button class="text-blue-500 hover:underline mr-2">Modifier</button></a>
                    <a href="php/delete-util.php?id=' . $row['id'] . '"><button class="text-red-500 hover:underline">Supprimer</button></a>
                </td>
            </tr>
        ';
    }
} else {
    echo "<span class='text-gray-400 font-semibold'>Pas de données disponible</span>";
}
