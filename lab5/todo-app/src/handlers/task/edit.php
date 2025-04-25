<?php
require_once __DIR__ . '/../../../db.php';

/**
 * Обработчик редактирования задачи.
 * Обновляет данные задачи по ID из формы.
 */

$pdo = getPDO();

$id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$is_done = isset($_POST['is_done']) ? 1 : 0;

if (!$id || !is_numeric($id) || trim($title) === '') {
    die('Ошибка: некорректные данные');
}

$stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, is_done = ? WHERE id = ?");
$stmt->execute([$title, $description, $is_done, $id]);

header("Location: /");
exit;
