<?php
class UserLogin {
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
                echo "Logged in! Redirecting in 2 seconds..."; 
                echo '<meta http-equiv="refresh" content="2;url=../FASTAanalysys.php">';
            } else {
                return "Invalid password.";
            }
        } else {
            return "User does not exist.";
        }
    }
};
