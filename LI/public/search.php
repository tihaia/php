<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/mysql.php';
require_once __DIR__ . '/../templates/header.php';

$query = trim($_GET['q'] ?? '');
if (!$query) {
    die("⚠️ Строка поиска не задана.");
}

// Поиск по названию (LIKE)
$stmt = $pdo->prepare("SELECT products.*, categories.name AS category
                       FROM products
                       LEFT JOIN categories ON products.category_id = categories.id
                       WHERE products.title LIKE ?
                       ORDER BY products.created_at DESC");
$stmt->execute(["%$query%"]);
$results = $stmt->fetchAll();
?>

<h2>Результаты поиска по запросу: "<?= htmlspecialchars($query) ?>"</h2>

<?php if ($results): ?>
  <?php foreach ($results as $product): ?>
    <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
      <h3><?= htmlspecialchars($product['title']) ?></h3>
      <p><strong>Категория:</strong> <?= htmlspecialchars($product['category']) ?></p>
      <p><strong>Цена:</strong> <?= $product['price'] ?> MDL</p>
      <p><a href="/product.php?id=<?= $product['id'] ?>">Подробнее</a></p>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>❌ Ничего не найдено.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
