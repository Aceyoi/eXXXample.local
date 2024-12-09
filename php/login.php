<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'password' => $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['username'] = $username;
        $_SESSION['nickname'] = $user['nickname'];
        header('Location: ../index.php');
        exit();
    } else {
        header('Location: ../index.php?error=invalid_credentials');
        exit();
    }
} else {
    header('Location: ../index.php');
    exit();
}
?>
