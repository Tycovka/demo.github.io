<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Если пользователь не администратор, перенаправить на главную страницу
    header('Location: index.php');
    exit;
}

if (isset($_POST['report_id'], $_POST['status'])) {
    $report_id = $_POST['report_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE reports SET status = ? WHERE id = ?");
    $stmt->execute([$status, $report_id]);
}

$reports = $pdo->query("SELECT reports.*, users.fullname FROM reports JOIN users ON reports.user_id = users.id")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Панель администратора</title>
</head>
<body>
    <h2>Все заявления</h2>
    <table>
        <tr><th>ФИО</th><th>Номер автомобиля</th><th>Описание</th><th>Статус</th><th>Действие</th></tr>
        <?php foreach ($reports as $report): ?>
            <tr>
                <td><?= $report['fullname'] ?></td>
                <td><?= $report['car_number'] ?></td>
                <td><?= $report['description'] ?></td>
                <td><?= $report['status'] ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                        <select name="status">
                            <option value="new" <?= $report['status'] == 'new' ? 'selected' : '' ?>>Новое</option>
                            <option value="confirmed" <?= $report['status'] == 'confirmed' ? 'selected' : '' ?>>Подтверждено</option>
                            <option value="rejected" <?= $report['status'] == 'rejected' ? 'selected' : '' ?>>Отклонено</option>
                        </select>
                        <button type="submit">Обновить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<div class="btn-send">
    <form class="admin-exit" method="post" action="logout.php">
        <button type="submit">Выйти</button>
    </form>
</div>

</body>
</html>
