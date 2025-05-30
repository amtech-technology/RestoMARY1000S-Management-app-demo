<?php
//////////////////////////////////////////////////////////////////////////////////////////////
require_once("./config.php");

$id = $_GET['id'];

$sql1 = "DELETE FROM utilisateur WHERE id = :id";
$query1 = $pdo->prepare($sql1);
$execution1 = $query1->execute([":id" => $id]);
if ($execution1) {
    header("Location: ../utilisateurs.html");
    exit;
}
