<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log'); // Update with real path
error_reporting(E_ALL);

header("Content-Type: application/json");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once("./config.php");

// Fetch all mouvements
$sql = "SELECT * FROM mouvement";
$query = $pdo->prepare($sql);
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);

// Init counters
$totalStock = 0;
$stockBar = 0;
$produitsCritiques = 0;
$mouvementsDuJour = 0;
$today = date('Y-m-d');

// Init chart data
$barData = [];
$lineData = [];

$sqlCritique = "SELECT * FROM produit WHERE quantite <= 10";
$queryCritique = $pdo->prepare($sqlCritique);
$queryCritique->execute();
$resultatCritique = $queryCritique->fetchAll(PDO::FETCH_ASSOC);

if (count($resultatCritique) > 0) {
    foreach ($resultatCritique as $rowCritique) {
        $quantiteCritique++;
        $totalStock++;
    }
}

$sqlTotal = "SELECT * FROM produit";
$queryTotal = $pdo->prepare($sqlCritique);
$queryTotal->execute();
$resultatTotal = $queryTotal->fetchAll(PDO::FETCH_ASSOC);

if (count($resultatTotal) > 0) {
    foreach ($resultatTotal as $rowTotal) {
        $totalStock++;
    }
}

foreach ($res as $row) {

    // Count critical stock
    if ($row['quantite'] <= 5) {
        $produitsCritiques++;
    }

    // Stock for bar service
    if ($row['service'] === 'bar' && $row['type_mouvement'] === 'entrée') {
        $stockBar++;
        $nom = $row['designation'] ?? 'Service inconnu';
        $barData[$nom] = ($barData[$nom] ?? 0) + ($row['quantite'] ?? 0);
    }

    // Count today's mouvements
    $dateMouvement = isset($row['date_mouvement']) ? substr($row['date_mouvement'], 0, 10) : null;
    if ($dateMouvement === $today) {
        $mouvementsDuJour++;
    }


    // Count total quantity per day for line chart
    $lineData[$dateMouvement] = ($lineData[$dateMouvement] ?? 0) + ($row['quantite'] ?? 0);
}

// Format chart data
ksort($lineData); // Ensure line chart is sorted by date

echo json_encode([
    "stock_total" => $totalStock,
    "produits_critiques" => $quantiteCritique,
    /* "stock_bar" => $stockBar, */
    "mouvements_jour" => $mouvementsDuJour,
    "chart_stock" => [$totalStock, $stockBar, $produitsCritiques],
    "chart_produits_bar" => [
        "labels" => array_keys($barData),
        "data" => array_values($barData)
    ],
    "chart_mouvements" => [
        "labels" => array_keys($lineData),
        "data" => array_values($lineData)
    ]
]);
