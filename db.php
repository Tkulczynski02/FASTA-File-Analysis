<?php

class Database {
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "users_database";
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function query($sql) {
        $result = $this->conn->query($sql);

        if ($result === FALSE) {
            return "Error: " . $this->conn->error;
        }

        if ($result instanceof mysqli_result) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }

        return $this->conn->affected_rows;
    }
}

?>
