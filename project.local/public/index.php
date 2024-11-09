<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: ' . ($user['role'] === 'admin' ? 'admin.php' : 'dashboard.php'));
    } else {
        echo "Неправильный логин или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Авторизация</title>
</head>
<body>
    <h2>Авторизация</h2>
        <div class="content-login">
        <form class="login-form" method="post">
            <input type="text" name="login" placeholder="Логин" required>
            <input type="password" name="password" placeholder="Пароль" required>

            <div class="login-btn">
                <button type="submit">Войти</button>
                <a href="register.php" class="button">Зарегистрироваться</a>
            </div>
        </form>
    </div>
</body>
</html>