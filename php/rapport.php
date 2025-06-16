<?php
require_once("./config.php");

$sql = "SELECT produit, type_mouvement, COUNT(*) AS total 
        FROM mouvement 
        GROUP BY produit, type_mouvement";

$query = $pdo->prepare($sql);
$query->execute();
$rawResults = $query->fetchAll(PDO::FETCH_ASSOC);

// Initialize
$results = [];
$totals = ['entrée' => 0, 'sortie' => 0];
$prix_total_global = 0; // 🛠️ MUST initialize this!

foreach ($rawResults as $row) {
    $produit = $row['produit'];
    $type = $row['type_mouvement'];
    $total = (int)$row['total'];

    // Fetch product info
    $sql_product = "SELECT nom_produit, prix_achat FROM produit WHERE nom_produit = ?";
    $query_product = $pdo->prepare($sql_product);
    $query_product->execute([$produit]);
    $product = $query_product->fetch(PDO::FETCH_ASSOC);

    // ⛔ Skip if product not found
    if (!$product) {
        continue;
    }

    // Get total quantity for "entrée"
    $sql_quantite = "SELECT SUM(quantite) AS total_quantite 
                     FROM mouvement 
                     WHERE produit = ? AND type_mouvement = ?";
    $query_quantite = $pdo->prepare($sql_quantite);
    $query_quantite->execute([$product['nom_produit'], "entrée"]);
    $result_quantite = $query_quantite->fetch(PDO::FETCH_ASSOC);

    $quantite = (int)$result_quantite['total_quantite'];
    $prix_total = $quantite * $product['prix_achat'];

    // Build result entry
    if (!isset($results[$produit])) {
        $results[$produit] = [
            'entrée' => 0,
            'sortie' => 0,
            'prix_achat' => $prix_total,
            'nom_produit' => $product['nom_produit'],
        ];
    }

    // Fill entrée / sortie counts
    if ($type === 'entrée') {
        $results[$produit]['entrée'] = $total;
        $totals['entrée'] += $total;
        $prix_total_global += $prix_total;
    } elseif ($type === 'sortie') {
        $results[$produit]['sortie'] = $total;
        $totals['sortie'] += $total;
    }
}

// Add global price to response
$response = [
    'produits' => $results,
    'totaux' => $totals,
    'prix_total_global' => $prix_total_global
];

header('Content-Type: application/json');
echo json_encode($response);
