<?php
session_start();
include_once("./config.php");

$user_unique_id = $_SESSION['user_uniqueID'];

$sql_admin = "SELECT * FROM utilisateur WHERE unique_id = ?";
$query_admin = $pdo->prepare($sql_admin);
$query_admin->execute([$user_unique_id]);
$res_admin = $query_admin->fetchAll(PDO::FETCH_ASSOC);

if (count($res_admin) > 0) {
    foreach ($res_admin as $row_admin) {
        if ($row_admin['role_utilisateur'] == "Admin") {
            echo "sucess";
        } else {
            echo "failed";
        }
    }
}
