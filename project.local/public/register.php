<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (fullname, phone, email, login, password) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$fullname, $phone, $email, $login, $password])) {
        header('Location: index.php');
    } else {
        echo "Ошибка регистрации.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <div class="content">
        <form method="post">
            <input type="text" name="fullname" placeholder="ФИО" required>
            <input type="text" name="phone" placeholder="Телефон">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="login" placeholder="Логин" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
</body>
</html>
