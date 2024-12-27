<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="login.php" method="post">
        <label for="username">Username</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" name="submit" value="Login">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db.php';

        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT password FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                echo "Logged in!";
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "User does not exist.";
        }

        $conn->close();
    }
    ?>
</body>
</html>
