<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    // Если пользователь не авторизован, перенаправить его на страницу входа
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $car_number = $_POST['car_number'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO reports (user_id, car_number, description) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $car_number, $description]);

    header('Location: dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Создать заявление</title>
</head>
<body>
    <h2>Создать заявление</h2>
    <div class="content">
        <form method="post">
            <input type="text" name="car_number" placeholder="Номер автомобиля" required>
            <textarea name="description" placeholder="Описание нарушения" required></textarea>
            <button class="btn-rep" type="submit">Подать заявление</button>
        </form>
    </div>
</body>
</html>
