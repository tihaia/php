<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/mysql.php';
require_once __DIR__ . '/../templates/header.php';

$stmt = $pdo->query("SELECT products.*, categories.name AS category FROM products LEFT JOIN categories ON products.category_id = categories.id ORDER BY products.created_at DESC");
$products = $stmt->fetchAll();
?>

<form action="/search.php" method="GET">
  <input type="text" name="q" placeholder="Поиск по названию" required>
  <button type="submit">🔎 Найти</button>
</form>

<h2>Каталог товаров</h2>

<?php foreach ($products as $product): ?>
  <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
    <h3><?= htmlspecialchars($product['title']) ?></h3>
    <p><strong>Категория:</strong> <?= htmlspecialchars($product['category']) ?></p>
    <p><strong>Цена:</strong> <?= $product['price'] ?> MDL</p>
    <p><a href="/product.php?id=<?= $product['id'] ?>">Подробнее</a></p>
    
    <?php if (isAdmin()): ?>
      <a href="/edit_product.php?id=<?= $product['id'] ?>">✏️ Редактировать</a> |
      <a href="/actions/delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('Удалить товар?')">🗑️ Удалить</a>
    <?php endif; ?>
  </div>
<?php endforeach; ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
