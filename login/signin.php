<?php

include '../db.php'; 
include 'user_login.php';

$db = new Database();
$conn = $db->getConnection();

$login = new UserLogin($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $login->authenticate($username, $password);

    echo $result;
}

$db->closeConnection();
?>