<?php

class UserRegistration
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function log($message)
    {
        file_put_contents("log.txt", var_export($message, true), FILE_APPEND);
    }

    public function register($username, $email, $password)
    {
        $this->log("User registration attempt for: $username");

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        $sql1 = "SELECT * FROM users WHERE username = ? OR email = ?"; 
        $stmt = $this->conn->prepare($sql1); 
        $stmt->bind_param("ss", $username, $email); 
        $stmt->execute(); $result = $stmt->get_result(); 
        if ($result->num_rows > 0) { 
            return ["success" => false, "message" => "Username or email already exists."];
        }
        
        if ($this->conn->query($sql) === TRUE) {
            return ["success" => true, "message" => "Registration successful!"];
        } else {
            return ["success" => false, "message" => "Error: " . $this->conn->error];
        }
    }
};