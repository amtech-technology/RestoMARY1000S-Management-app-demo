<?php
session_start();
require_once("./config.php");

$unique_id = $_SESSION['user_uniqueID'];
$unique_idCookie = $_COOKIE['user_uniqueID'];

$sql = "SELECT * FROM utilisateur WHERE `unique_id` = ? OR `unique_id` = ?";
$query = $pdo->prepare($sql);
$query->execute([$unique_id, $unique_idCookie]);
$result = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($result) > 0) {
    foreach ($result as $row) {
        if ($row['status'] == "SuperAdmin") {
            echo "superAdmin";
        } else {
            echo "normal";
        }
    }
}
