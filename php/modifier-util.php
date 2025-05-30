<?php
///////////////////////////////////////////////////////////////////////////
require_once("./config.php");

$nom_util = htmlspecialchars($_POST['nom']);
$email = htmlspecialchars($_POST['email']);
$role = htmlspecialchars($_POST['role']);
$id = htmlspecialchars($_POST['id']);

if (!empty($nom_util) && !empty($email) && !empty($role)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $sql = "UPDATE utilisateur SET nom_utilisateur = ?, email = ?, role_utilisateur = ? WHERE id = ?";
        $query = $pdo->prepare($sql);
        $execution = $query->execute([$nom_util, $email, $role, $id]);
        if ($execution) {
            echo "success";
            exit;
        }
    } else {
        echo "<span class='text-red-700'>Votre Adresse mail est incorrect!</span>";
    }
} else {
    echo "<span class='text-red-700'>Remplissez tout les champ s'il vous plaît!</span>";
}
