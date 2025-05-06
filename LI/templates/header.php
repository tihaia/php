<?php
if (!isset($isAuthenticated)) {
    require_once __DIR__ . '/../includes/auth.php';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Каталог товаров</title>
  <link rel="stylesheet" href="/style/style.css">
</head>
<body>
  <header style="background: #222; color: white; padding: 10px;">
    <h1>Каталог товаров с отзывами</h1>
    <nav>
      <a href="/index.php" style="color: white; margin-right: 10px;">Главная</a>

      <?php if ($isAuthenticated): ?>
        <?php if (isAdmin()): ?>
          <a href="/add_product.php" style="color: white; margin-right: 10px;">➕ Добавить товар</a>
          <a href="/admin.php" style="color: white; margin-right: 10px;">⚙️ Админ-панель</a>
        <?php endif; ?>
        <span style="margin-left: 10px;">👤 <?= htmlspecialchars($username) ?></span>
        <a href="/logout.php" style="color: white; margin-left: 10px;">Выход</a>
      <?php else: ?>
        <a href="/login.php" style="color: white; margin-right: 10px;">Вход</a>
        <a href="/register.php" style="color: white;">Регистрация</a>
      <?php endif; ?>
    </nav>
  </header>

  <main style="padding: 20px;">
