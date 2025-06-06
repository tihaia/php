<?php
/**
 * Страница со списком всех задач с пагинацией.
 */

require_once __DIR__ . '/../../src/db.php';

/** @var PDO $pdo Подключение к базе данных */
$pdo = getPDO();

/** @var int $perPage Количество задач на странице */
$perPage = 5;

/** @var int $page Текущая страница */
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

/** @var int $offset Смещение для SQL-запроса */
$offset = ($page - 1) * $perPage;

/** @var int $total Общее количество задач */
$total = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();

/** @var int $totalPages Общее количество страниц */
$totalPages = ceil($total / $perPage);

$stmt = $pdo->prepare("SELECT * FROM tasks ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

/** @var array<int, array<string, mixed>> $tasks Список задач */
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Все задачи</h1>

<?php if (empty($tasks)): ?>
  <p>Задачи отсутствуют.</p>
<?php else: ?>
  <ul>
    <?php foreach ($tasks as $task): ?>
      <li>
        <strong><?= htmlspecialchars($task['title']) ?></strong><br>
        Категория: <?= htmlspecialchars($task['category']) ?><br>
        Описание: <?= nl2br(htmlspecialchars($task['description'])) ?><br>
        <a href="/todo-app/public/index.php?page=show&id=<?= $task['id'] ?>">Просмотр</a> |
        <a href="/todo-app/public/index.php?page=edit&id=<?= $task['id'] ?>">Редактировать</a> |
        <a href="/todo-app/src/handlers/task/delete.php?id=<?= $task['id'] ?>" onclick="return confirm('Удалить задачу?')">Удалить</a>
        <hr>
      </li>
    <?php endforeach; ?>
  </ul>

  <?php if ($totalPages > 1): ?>
    <div class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i === $page): ?>
          <strong><?= $i ?></strong>
        <?php else: ?>
          <a href="?page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
<?php endif; ?>
