<?php
session_start();
/////////////////////////////////////////////////////////////////////
require_once("./config.php");

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

if (!empty($name) && !empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $sql1 = "SELECT * FROM utilisateur WHERE `status` = ?";
        $query1 = $pdo->prepare($sql1);
        $query1->execute(['SuperAdmin']);
        $res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
        if (count($res1) > 0) {
            echo "<span class='text-red-700'>On ne peut pas avoir deux super Admin. attendez votre invitation</span>";
        } else {
            $sql = "INSERT INTO utilisateur(`unique_id`,`nom_utilisateur`,`email`,`role_utilisateur`,`status`) VALUES(?,?,?,?,?)";
            $query = $pdo->prepare($sql);
            $execute = $query->execute([$password, $name, $email, "aucune", "SuperAdmin"]);
            if ($execute) {
                $_SESSION['user_uniqueID'] = $password;
                $setCookie = setcookie("user_uniqueID", "{$password}", time() + (86400 * 7), "/");
                // Expires in 7 days, available across the whole site
                if ($setCookie) {
                    echo "success";
                } else {
                    echo "<span class='text-red-700'>L'erreur s'est produit lors de la configuration des cookies!</span>";
                }
            } else {
                echo "<span class='text-red-700'>L'erreur s'est produit lors de l'enregistrement!</span>";
            }
        }
    } else {
        echo "<span class='text-red-700'>Votre Adresse mail est incorrect!</span>";
    }
} else {
    echo "<span class='text-red-700'>Remplissez tous les champs s'il vous plaît</span>";
}
