<?php
session_start(); // Always start the session before modifying

// 1. Unset the specific session variable
unset($_SESSION['user_uniqueID']);

// 2. Unset the session array completely (optional)
$_SESSION = [];

// 3. Destroy the session itself
session_destroy();

// 4. Delete the cookie by setting its expiration time in the past
setcookie("user_uniqueID", "", time() - 3600, "/");

header("Location: ../index.html");
