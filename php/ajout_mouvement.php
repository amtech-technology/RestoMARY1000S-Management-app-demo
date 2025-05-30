<?php
/////////////////////////////////////////////////////////////////////////
require_once('./config.php');

$type_de_mouvment = htmlspecialchars($_POST['type']);
$produit = htmlspecialchars($_POST['produit']);
$quantite = htmlspecialchars($_POST['quantite']);
$date_du_mouvement = htmlspecialchars($_POST['date']);
$observation = htmlspecialchars($_POST['observation']);
$observationEmp = "Aucune Observation";
$service = htmlspecialchars($_POST['service']);
$responsable = htmlspecialchars($_POST['responsable']);

$unique_id = rand(1000, 100000);

if (!empty($type_de_mouvment) && !empty($produit) && !empty($quantite) && !empty($date_du_mouvement)) {

    if (!empty($observation)) {
        $sql = "INSERT INTO mouvement(`unique_id`,`type_mouvement`,`produit`,`quantite`,`date_mouvement`,`Observation`,`service`,`responsable`) VALUES(?,?,?,?,?,?,?,?)";
        $query = $pdo->prepare($sql);
        $execution = $query->execute([$unique_id, $type_de_mouvment, $produit, $quantite, $date_du_mouvement, $observation, $service, $responsable]);
        if ($execution) {
            echo "success";
        } else {
            echo "L'erreur s'est produit lors de l'enregistrement!";
        }
    } else {
        $sql = "INSERT INTO mouvement(`unique_id`,`type_mouvement`,`produit`,`quantite`,`date_mouvement`,`Observation`,`service`,`responsable`) VALUES(?,?,?,?,?,?,?,?)";
        $query = $pdo->prepare($sql);
        $execution = $query->execute([$unique_id, $type_de_mouvment, $produit, $quantite, $date_du_mouvement, $observationEmp, $service, $responsable]);
        if ($execution) {
            echo "success";
        } else {
            echo "L'erreur s'est produit lors de l'enregistrement!";
        }
    }
} else {
    echo "Remplissez tous les champs s'il vous plaît!";
}
