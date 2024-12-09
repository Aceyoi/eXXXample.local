<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nickname = $_POST['nickname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        header('Location: ../index.php?error=password_mismatch');
        exit();
    }

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        header('Location: ../index.php?error=username_taken');
        exit();
    }

    $sql = "INSERT INTO users (nickname, username, password) VALUES (:nickname, :username, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nickname' => $nickname, 'username' => $username, 'password' => $password]);

    header('Location: ../index.php?success=registration_success');
    exit();
} else {
    header('Location: ../index.php');
    exit();
}
?>
