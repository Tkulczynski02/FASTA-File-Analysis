<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="register.php" method="post">
        <h2>Registration Form</h2>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <input type="submit" name="submit" value="Register">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db.php';

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password !== $confirm_password) {
            echo "Passwords do not match.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
    }
    ?>
</body>
</html>
