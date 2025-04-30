<?php
/**
 * Обработчик удаления задачи по ID.
 * Удаляет запись из базы данных и перенаправляет на главную страницу.
 */

require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/../../../src/db.php';

/** @var string|null $id Идентификатор задачи из GET-запроса */
$id = $_GET['id'] ?? null;
if (!$id) {
    exit('ID не указан');
}

/** @var PDO $pdo Подключение к базе данных */
$pdo = getPDO();
$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: /todo-app/public/index.php');
exit;
