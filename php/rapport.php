<?php
require_once("./config.php");

$sql = "SELECT produit, type_mouvement, COUNT(*) AS total 
        FROM mouvement 
        GROUP BY produit, type_mouvement ORDER BY id DESC";

$query = $pdo->prepare($sql);
$query->execute();
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

$response = [
    'produits' => $results,
    'totaux' => $totals
];

header('Content-Type: application/json');
echo json_encode($response);
