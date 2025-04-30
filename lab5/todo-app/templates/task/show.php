<?php
/**
 * Страница просмотра задачи по ID.
 * Загружает данные задачи и отображает её содержимое.
 */

require_once __DIR__ . '/../../src/db.php';

/** @var PDO $pdo Подключение к базе данных */
$pdo = getPDO();

/** @var string|null $id Идентификатор задачи из GET-запроса */
$id = $_GET['id'] ?? null;

if (!$id) {
    exit('ID не указан');
}

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->execute(['id' => $id]);

/** @var array<string, mixed>|false $task Данные задачи */
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    exit('Задача не найдена');
}

/** @var array<int, string> $tags Массив тегов задачи */
$tags = json_decode($task['tags'], true);

/** @var array<int, string> $steps Массив шагов задачи */
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
