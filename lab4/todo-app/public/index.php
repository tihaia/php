<?php
/**
 * Главная страница ToDo-приложения
 * Отображает 2 последние добавленные задачи
 */

require_once __DIR__ . '/../src/helpers.php';

$file = __DIR__ . '/../storage/tasks.json';

$tasks = [];

/**
 * Если файл существует, читаем задачи из JSON
 * @var array<int, array> $tasks Массив задач
 */
if (file_exists($file)) {
    $content = file_get_contents($file);
    $tasks = json_decode($content, true) ?? [];
}

$latestTasks = array_slice(array_reverse($tasks), 0, 2);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>ToDo-лист</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <div class="task-container">
    <h1>Последние задачи</h1>

    <?php if (empty($latestTasks)): ?>
      <p>Нет задач для отображения.</p>
    <?php else: ?>
      <ul>
        <?php foreach ($latestTasks as $task): ?>
          <li>
            <strong><?= htmlspecialchars($task['title']) ?></strong><br>
            Категория: <?= htmlspecialchars($task['category']) ?><br>
            Описание: <?= nl2br(htmlspecialchars($task['description'])) ?><br>
            <?php if (!empty($task['tags'])): ?>
              Теги: <?= implode(', ', $task['tags']) ?><br>
            <?php endif; ?>
            <?php if (!empty($task['steps'])): ?>
              <details>
                <summary>Шаги выполнения</summary>
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
    <?php endif; ?>

    <a href="/task/create.php">Добавить новую задачу</a><br>
    <a href="/task/index.php">Посмотреть все задачи</a>
  </div>
</body>
</html>
