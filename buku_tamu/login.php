<?php
session_start();
include "db.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check user credentials (you should hash passwords in production)
    $result = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1");

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id']; // Store user session
        header("Location: tambah_berita.html");
        exit(); // Stop further execution
    } else {
        echo "Login failed! Invalid username or password.";
    }
}
?>

<html>
<head>
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="post">
        <h1>Login</h1>
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" required></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Login" name="login">
    </form>
</body>
</html>