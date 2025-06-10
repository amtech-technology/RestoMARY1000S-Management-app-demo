<?php
///////////////////////////////////////////////////////////////////////////////////
require_once("./config.php");

$nom_du_produit = htmlspecialchars($_POST['nom']);
$unite_du_produit = htmlspecialchars($_POST['unite']);
$service = htmlspecialchars($_POST['service']);
$seuil_minimum = htmlspecialchars($_POST['quantite']);
$unique_id = rand(1000, 10000);
$sell_price = htmlspecialchars($_POST['sell-price']);
$buy_price = htmlspecialchars($_POST['buy-price']);

if (!empty($nom_du_produit) && !empty($unite_du_produit) && !empty($service) && !empty($seuil_minimum)) {
    $sql = "INSERT INTO produit(`unique_id`,`nom_produit`,`unite_produit`,`service`,`quantite`,`prix_achat`,`prix_vente`) VALUES(?,?,?,?,?,?,?)";
    $query = $pdo->prepare($sql);
    $execution = $query->execute([$unique_id, $nom_du_produit, $unite_du_produit, $service, $seuil_minimum, $buy_price, $sell_price]);
    if ($execution) {
        echo "success";
    } else {
        echo "L'insertion a echoué!";
    }
} else {
    echo "Remplissez tout les champs s'il vous plaît";
}
