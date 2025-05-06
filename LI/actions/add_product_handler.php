<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../db/mysql.php';

if (!$isAuthenticated || !isAdmin()) {
    header('Location: /login.php');
    exit;
}

$title = clean($_POST['title'] ?? '');
$price = $_POST['price'] ?? '';
$category_id = intval($_POST['category_id'] ?? 0);
$description = clean($_POST['description'] ?? '');
$image = clean($_POST['image'] ?? '');

if (!$title || !is_numeric($price) || $price <= 0) {
    abort("⚠️ Заполните все поля корректно: цена должна быть положительным числом.");
}

$stmt = $pdo->prepare("INSERT INTO products (title, price, category_id, description, image) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$title, floatval($price), $category_id ?: null, $description, $image]);

header('Location: /index.php');
exit;
