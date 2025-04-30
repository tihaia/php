<?php
require_once __DIR__ . '/../../src/db.php';

$pdo = getPDO();
$id = $_GET['id'] ?? null;
if (!$id) {
    exit('ID не указан');
}

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->execute(['id' => $id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    exit('Задача не найдена');
}

$tags = json_decode($task['tags'], true);
$steps = json_decode($task['steps'], true);
?>

<h1><?= htmlspecialchars($task['title']) ?></h1>
<p><strong>Категория:</strong> <?= htmlspecialchars($task['category']) ?></p>
<p><strong>Описание:</strong><br><?= nl2br(htmlspecialchars($task['description'])) ?></p>

<?php if (!empty($tags)): ?>
  <p><strong>Теги:</strong> <?= implode(', ', $tags) ?></p>
<?php endif; ?>

<?php if (!empty($steps)): ?>
  <h3>Шаги:</h3>
  <ol>
    <?php foreach ($steps as $step): ?>
      <li><?= htmlspecialchars($step) ?></li>
    <?php endforeach; ?>
  </ol>
<?php endif; ?>
