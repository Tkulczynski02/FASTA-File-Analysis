<?php

file_put_contents("log.txt", var_export("12345", true), FILE_APPEND);

include '../db.php';
include 'user_registration.php';

try {
    file_put_contents("log.txt", var_export("12346", true), FILE_APPEND);
    $db = new Database();
    $conn = $db->getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            echo json_encode(["success" => false, "message" => "Invalid request."]);
            exit;
        }

        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $registration = new UserRegistration($conn);
        $result = $registration->register($username, $email, $password);

        echo json_encode($result);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request method."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Server error: " . $e->getMessage()]);
}

$db->closeConnection();
