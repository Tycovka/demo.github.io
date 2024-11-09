<?php
require 'db.php';
session_start();

// Проверяем, что пользователь авторизован и является обычным пользователем
if (!isset($_SESSION['user_id'])) {
    // Если пользователь не авторизован, перенаправить его на страницу входа
    header('Location: index.php');
    exit;
}

// Получаем все заявления текущего пользователя
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM reports WHERE user_id = ?");
$stmt->execute([$user_id]);
$reports = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Личный кабинет</title>
</head>
<body>
    <h2>Ваши заявления</h2>
    
    <!-- Кнопка для создания нового заявления -->

    
    <table>
        <tr>
            <th>Номер автомобиля</th>
            <th>Описание</th>
            <th>Статус</th>
        </tr>
        <?php foreach ($reports as $report): ?>
            <tr>
                <td><?= htmlspecialchars($report['car_number']) ?></td>
                <td><?= htmlspecialchars($report['description']) ?></td>
                <td><?= htmlspecialchars($report['status']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    <!-- Кнопка для выхода -->
    <div class="content">
        <a href="create_report.php" class="button">Создать новое заявление</a>
        <form method="post" action="logout.php">
            <button type="submit">Выйти</button>
        </form>
    </div>
</body>
</html>
