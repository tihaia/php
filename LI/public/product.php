<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/mysql.php';
require_once __DIR__ . '/../db/mongo.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    die("⚠️ Товар не найден.");
}

// Получаем товар из MySQL
$stmt = $pdo->prepare("SELECT p.*, c.name AS category FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("⚠️ Товар не существует.");
}

// Получаем отзывы из MongoDB
$reviews = $reviewsCollection->find(['product_id' => $id])->toArray();

require_once __DIR__ . '/../templates/header.php';
?>

<h2><?= htmlspecialchars($product['title']) ?></h2>
<p><strong>Категория:</strong> <?= htmlspecialchars($product['category']) ?></p>
<p><strong>Цена:</strong> <?= $product['price'] ?> MDL</p>
<p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

<?php if ($product['image']): ?>
  <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" width="200">
<?php endif; ?>

<hr>
<h3>Отзывы</h3>

<?php if ($reviews): ?>
  <?php foreach ($reviews as $review): ?>
    <div style="border: 1px solid #ccc; padding: 8px; margin-bottom: 5px;">
      <strong><?= htmlspecialchars($review['user']) ?></strong>
      <em>(оценка: <?= $review['rating'] ?>/5)</em><br>
      <?= nl2br(htmlspecialchars($review['text'])) ?><br>
      <small><?= $review['created_at']->toDateTime()->format('d.m.Y H:i') ?></small>
      <?php if (isAdmin()): ?>
        | <a href="/actions/delete_review.php?id=<?= $review['_id'] ?>&product_id=<?= $id ?>" onclick="return confirm('Удалить отзыв?')">Удалить</a>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>Отзывов пока нет.</p>
<?php endif; ?>

<?php if ($isAuthenticated): ?>
  <hr>
  <h4>Добавить отзыв</h4>
  <form action="/actions/add_review.php" method="POST">
    <input type="hidden" name="product_id" value="<?= $id ?>">
    <label>Оценка (1–5):</label>
    <input type="number" name="rating" min="1" max="5" required><br>
    <label>Ваш отзыв:</label><br>
    <textarea name="text" required></textarea><br>
    <button type="submit">Оставить отзыв</button>
  </form>
<?php else: ?>
  <p><a href="/login.php">Войдите</a>, чтобы оставить отзыв.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>