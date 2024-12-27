<?php

class Login {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function authenticate($username, $password) {
        $sql = "SELECT password FROM users WHERE username = '$username'";


        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();


            if (password_verify($password, $row['password'])) {
                return "Logged in!";
            } else {
                return "Invalid password.";
            }
        } else {
            return "User does not exist.";
        }
    }
}

include '../db.php'; 

$db = new Database();
$conn = $db->getConnection();

$login = new Login($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $login->authenticate($username, $password);

    echo $result;
}

$db->closeConnection();
?>