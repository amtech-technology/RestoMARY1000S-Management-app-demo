<?php
//////////////////////////////////////////////////////////////////////////////////////////////
$database_name = "restaurent_mary";
$user_name = "root";
$password = "";
$host = "localhost";

try {
    $pdo = new PDO("mysql:host={$host};dbname={$database_name}", "{$user_name}", "{$password}");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($pdo) {
       // echo "connection établie avec succès!";
    } else {
        echo "La connection a echoué";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
