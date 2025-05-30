<?php
session_start();

$response = ["status" => "unauthorized"];

if (isset($_SESSION["user_uniqueID"]) || isset($_COOKIE["user_uniqueID"])) {
    $response["status"] = "success";
}

echo json_encode($response);
