<?php
require_once __DIR__ . '/../../../db.php';

/**
 * Обработчик удаления задачи по ID.
 */

$pdo = getPDO();

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: /");
exit;
