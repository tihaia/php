<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/mysql.php';

if (!$isAuthenticated || !isAdmin()) {
    header('Location: /login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    die("⚠️ ID товара не указан.");
}

// Получаем товар
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("⚠️ Товар не найден.");
}

// Получаем категории
$catStmt = $pdo->query("SELECT * FROM categories");
$categories = $catStmt->fetchAll();

require_once __DIR__ . '/../templates/header.php';
?>

<h2>Редактировать товар</h2>

<form action="/actions/edit_product_handler.php" method="POST">
  <input type="hidden" name="id" value="<?= $product['id'] ?>">

  <label>Название:</label>
  <input type="text" name="title" value="<?= htmlspecialchars($product['title']) ?>" required><br>

  <label>Цена:</label>
  <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required><br>

  <label>Категор
