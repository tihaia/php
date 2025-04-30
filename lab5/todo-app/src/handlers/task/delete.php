<?php
require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/../../../src/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    exit('ID не указан');
}

$pdo = getPDO();
$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: /todo-app/public/index.php');
exit;
