<?php
/**
 * Шаблон формы редактирования задачи.
 * Загружает задачу из базы данных и выводит форму редактирования.
 */

require_once __DIR__ . '/../../src/db.php';
require_once __DIR__ . '/../../src/helpers.php';

session_start();

/** @var PDO $pdo Подключение к базе данных */
$pdo = getPDO();

/** @var string|null $id Идентификатор задачи из запроса */
$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->execute(['id' => $id]);

/** @var array<string, mixed>|false $task Данные задачи */
$task = $stmt->fetch(PDO::FETCH_ASSOC);

/** @var array<string, mixed> $old Ранее введённые значения */
$old = getOldInput();

/** @var array<string, string> $errors Ошибки валидации */
$errors = getErrors();

if (!$task) {
    exit("Задача не найдена");
}
?>

<h1>Редактировать задачу</h1>
<div class="form-container">
  <form action="/todo-app/src/handlers/task/edit.php" method="POST">
    <input type="hidden" name="id" value="<?= $task['id'] ?>">

    <label for="title">Название:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($old['title'] ?? $task['title']) ?>"><br>

    <label for="category">Категория:</label>
    <select name="category">
      <?php foreach (['Работа', 'Личное', 'Учёба'] as $cat): ?>
        <option value="<?= $cat ?>" <?= selected($old['category'] ?? $task['category'], $cat) ?>><?= $cat ?></option>
      <?php endforeach; ?>
    </select><br>

    <label for="description">Описание:</label>
    <textarea name="description"><?= htmlspecialchars($old['description'] ?? $task['description']) ?></textarea><br>

    <label for="tags">Теги:</label>
    <select name="tags[]" multiple>
      <?php
        /** @var array<int, string> $tags Массив тегов из задачи */
        $tags = json_decode($task['tags'], true) ?? [];
        foreach (['срочно', 'важно', 'дом', 'работа'] as $tag):
      ?>
        <option value="<?= $tag ?>" <?= in_array($tag, $tags) ? 'selected' : '' ?>><?= $tag ?></option>
      <?php endforeach; ?>
    </select><br>

    <label for="steps">Шаги:</label>
    <textarea name="steps"><?= htmlspecialchars(implode("\n", json_decode($task['steps'], true))) ?></textarea><br>

    <button type="submit">Сохранить</button>
  </form>
</div>
