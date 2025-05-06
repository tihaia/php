<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/mysql.php';

if (!$isAuthenticated || !isAdmin()) {
    header('Location: /login.php');
    exit;
}

// Получаем список категорий из базы
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();
require_once __DIR__ . '/../templates/header.php';
?>

<h2>Добавить товар</h2>

<form action="/actions/add_product_handler.php" method="POST">
  <label>Название:</label>
  <input type="text" name="title" required><br>

  <label>Цена:</label>
  <input type="number" step="0.01" name="price" required><br>

  <label>Категория:</label>
  <select name="category_id">
    <?php foreach ($categories as $cat): ?>
      <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
    <?php endforeach; ?>
  </select><br>

  <label>Описание:</label><br>
  <textarea name="description"></textarea><br>

  <label>Изображение (ссылка):</label>
  <input type="text" name="image"><br>

  <button type="submit">Добавить товар</button>
</form>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
