<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nickname = $_POST['nickname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        header('Location: ../index.php?error=password_mismatch');
        exit();
    }

    // Пример: Сохранение пользователя в базе данных
    $users = [];
    if (file_exists('users.json')) {
        $users = json_decode(file_get_contents('users.json'), true);
    }

    $existingUser = array_filter($users, function($user) use ($username) {
        return $user['username'] === $username;
    });

    if (!empty($existingUser)) {
        header('Location: ../index.php?error=username_taken');
        exit();
    }

    $users[] = ['username' => $username, 'password' => $password, 'nickname' => $nickname];
    file_put_contents('users.json', json_encode($users));

    header('Location: ../index.php?success=registration_success');
    exit();
} else {
    header('Location: ../index.php');
    exit();
}
?>
