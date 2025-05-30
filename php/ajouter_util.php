<?php
//////////////////////////////////////////////////////////////////////////////////
require_once("./config.php");

$nom = htmlspecialchars($_POST['nom']);
$email = htmlspecialchars($_POST['email']);
$role = htmlspecialchars($_POST['role']);
$unique_id = rand(10000, 100000);

if (!empty($nom) && !empty($email) && !empty($role)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "INSERT INTO utilisateur(`unique_id`,`nom_utilisateur`,`email`,`role_utilisateur`) VALUES(?, ?, ?, ?)";
        $query = $pdo->prepare($sql);
        $execution = $query->execute([$unique_id, $nom, $email, $role]);
        if ($execution) {
            echo "success";
        } else {
            echo "<span class='text-red-700'>Une erreur s'est produit lors de l'ajout de l'utilisaeur</span>";
        }
    } else {
        echo "<span class='text-red-700'>Votre Adresse mail est incorrect!</span>";
    }
} else {
    echo "<span class='text-red-700'>Remplissez tout les champs s'il vous plaît!</span>";
}
