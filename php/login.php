<?php
session_start();
//////////////////////////////////////////////////////////////////////////////////
require_once("./config.php");

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

if (!empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM utilisateur WHERE email = ? AND unique_id = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$email, $password]);
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($res) > 0) {
            $_SESSION['user_uniqueID'] = $password;
            $setCookie = setcookie("user_uniqueID", "{$password}", time() + (86400 * 7), "/");
            // Expires in 7 days, available across the whole site
            if ($setCookie) {
                echo "success";
            } else {
                echo "<span class='text-red-700'>L'erreur s'est produit lors de la configuration des cookies!</span>";
            }
        } else {
            echo "<span class='text-red-700'>Votre Adresse mail ou mot de passe est invalide!</span>";
        }
    } else {
        echo "<span class='text-red-700'>Votre Adresse mail est invalide!</span>";
    }
} else {
    echo "<span class='text-red-700'>Remplisez tout les champs s'il vous plaît!</span>";
}
