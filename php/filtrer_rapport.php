<?php
//////////////////////////////////////////////////////////////////////////
require_once("./config.php");

$date1 = htmlspecialchars($_POST['date1']);
$data2 = htmlspecialchars($_POST['data2']);
$service = htmlspecialchars($_POST['service']);

$sql = "SELECT produit, type_mouvement, COUNT(*) AS total 
        FROM mouvement";

$params = [];
$conditions = [];

// Add filters conditionally
if (!empty($date1)) {
    $conditions[] = "date_mouvement >= ?";
    $params[] = $date1;
}

if (!empty($date2)) {
    $conditions[] = "date_mouvement <= ?";
    $params[] = $date2;
}

if (!empty($service)) {
    $conditions[] = "`service` = ?";
    $params[] = $service;
}

// Append WHERE clause if any conditions exist
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Then GROUP BY comes after the WHERE clause
$sql .= " GROUP BY produit, type_mouvement ORDER BY id DESC";

// Prepare and execute
$query = $pdo->prepare($sql);
$query->execute($params);
$rawResults = $query->fetchAll(PDO::FETCH_ASSOC);

// Organize data
$results = [];
$totals = ['entrée' => 0, 'sortie' => 0];

foreach ($rawResults as $row) {
    $produit = $row['produit'];
    $type = $row['type_mouvement'];
    $total = (int)$row['total'];

    if (!isset($results[$produit])) {
        $results[$produit] = ['entrée' => 0, 'sortie' => 0];
    }

    if ($type === 'entrée') {
        $results[$produit]['entrée'] = $total;
        $totals['entrée'] += $total;
    } elseif ($type === 'sortie') {
        $results[$produit]['sortie'] = $total;
        $totals['sortie'] += $total;
    }
}

// Output the table rows
foreach ($results as $produit => $counts) {
    $entree = $counts['entrée'];
    $sortie = $counts['sortie'];
    $stock = $entree - $sortie;

    echo '
        <tr class="border-t">
            <td class="p-4">' . htmlspecialchars($produit) . '</td>
            <td class="p-4 text-green-600">+ ' . $entree . '</td>
            <td class="p-4 text-red-600">- ' . $sortie . '</td>
            <td class="p-4 font-semibold">' . $stock . '</td>
        </tr>
    ';
}
