<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Пример: Проверка пользователя в базе данных
    $users = [
        ['username' => 'user1', 'password' => 'password1', 'nickname' => 'Nickname1'],
        ['username' => 'user2', 'password' => 'password2', 'nickname' => 'Nickname2'],
    ];

    $user = array_filter($users, function($user) use ($username, $password) {
        return $user['username'] === $username && $user['password'] === $password;
    });

    if (!empty($user)) {
        $_SESSION['username'] = $username;
        $_SESSION['nickname'] = $user[0]['nickname'];
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
