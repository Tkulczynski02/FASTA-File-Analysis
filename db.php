<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_database";

$conn = new mysqli($servername, $username, $password, $email, $dbname);

if ($conn->connect_error) {
    die("Can't connect: " . $conn->connect_error);
}
?>
