<?php
require_once __DIR__ . '/../../../db.php';

/**
 * Обработчик добавления новой задачи.
 * Получает данные из POST, сохраняет в базе данных.
 */

$pdo = getPDO();

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';

if (trim($title) !== '') {
    $stmt = $pdo->prepare("INSERT INTO tasks (title, description) VALUES (?, ?)");
    $stmt->execute([$title, $description]);

    header("Location: /");
    exit;
} else {
    echo "Ошибка: Название обязательно!";
}
