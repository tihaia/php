<?php
/**
 * Страница со списком всех задач ToDo
 * Реализует постраничный вывод задач (пагинация)
 */

require_once __DIR__ . '/../../src/helpers.php';

// Количество задач на одной странице
$perPage = 2;

/**
 * Получение текущей страницы из параметра GET
 * @var int $page Номер текущей страницы
 */
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$startIndex = ($page - 1) * $perPage;

$file = __DIR__ . '/../../storage/tasks.json';

$tasks = [];

/**
 * Загрузка задач из файла, если файл существует
 * @var array<int, array> $tasks
 */
if (file_exists($file)) {
    $content = file_get_contents($file);
    $tasks = json_decode($content, true) ?? [];
}

// Подсчёт общего количества страниц
$totalTasks = count($tasks);
$totalPages = (int) ceil($totalTasks / $perPage);

// Задачи на текущей странице
$tasks = array_reverse($tasks); // новые выше
$tasksOnPage = array_slice($tasks, $startIndex, $perPage);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Список задач</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <div class="task-container">
    <h1>Все задачи</h1>

    <?php if (empty($tasksOnPage)): ?>
      <p>Задачи отсутствуют.</p>
    <?php else: ?>
      <ul>
        <?php foreach ($tasksOnPage as $task): ?>
          <li>
            <strong><?= htmlspecialchars($task['title']) ?></strong><br>
            Категория: <?= htmlspecialchars($task['category']) ?><br>
            Описание: <?= nl2br(htmlspecialchars($task['description'])) ?><br>
            <?php if (!empty($task['tags'])): ?>
              Теги: <?= implode(', ', $task['tags']) ?><br>
            <?php endif; ?>
            <?php if (!empty($task['steps'])): ?>
              <details>
                <summary>Шаги</summary>
                <ol>
                  <?php foreach ($task['steps'] as $step): ?>
                    <li><?= htmlspecialchars($step) ?></li>
                  <?php endforeach; ?>
                </ol>
              </details>
            <?php endif; ?>
            <hr>
          </li>
        <?php endforeach; ?>
      </ul>

      <!-- Пагинация -->
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

    <br>
    <a href="/index.php">На главную</a> | 
    <a href="/task/create.php">Добавить задачу</a>
  </div>
</body>
</html>
