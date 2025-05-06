<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../db/mysql.php';

if (!$isAuthenticated || !isAdmin()) {
    header('Location: /login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    abort("⚠️ ID не указан.");
}

$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

header('Location: /index.php');
exit;
