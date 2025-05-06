<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../db/mysql.php';

if (!$isAuthenticated || !isAdmin()) {
    header('Location: /login.php');
    exit;
}

$id = intval($_POST['id'] ?? 0);
$title = clean($_POST['title'] ?? '');
$price = $_POST['price'] ?? '';
$category_id = intval($_POST['category_id'] ?? 0);
$description = clean($_POST['description'] ?? '');
$image = clean($_POST['image'] ?? '');

if (!$id || !$title || !is_numeric($price) || floatval($price) <= 0) {
    abort("⚠️ Проверьте правильность ввода: название и цена обязательны.");
}

$stmt = $pdo->prepare("UPDATE products SET title = ?, price = ?, category_id = ?, description = ?, image = ? WHERE id = ?");
$stmt->execute([
    $title,
    floatval($price),
    $category_id ?: null,
    $description,
    $image,
    $id
]);

header('Location: /index.php');
exit;
