<?php
/**
 * Страница добавления новой задачи
 * Отображает HTML-форму с полями для заполнения задачи
 * Обрабатывает ошибки валидации и сохраняет старые значения
 */

session_start();

require_once __DIR__ . '/../../src/helpers.php';

/**
 * @var array<string, mixed> $old Старые значения, введённые в форму
 * @var array<string, string> $errors Сообщения об ошибках валидации
 */
$old = getOldInput();
$errors = getErrors();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Добавить задачу</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <h1>Добавление новой задачи</h1>

  <div class="form-container">
    <form action="/handlers/handle_task_form.php" method="POST">
      
      <!-- Название задачи -->
      <label for="title">Название задачи:</label><br>
      <input type="text" id="title" name="title" value="<?= $old['title'] ?? '' ?>"><br>
      <span style="color: red"><?= $errors['title'] ?? '' ?></span><br><br>

      <!-- Категория -->
      <label for="category">Категория:</label><br>
      <select id="category" name="category">
        <option value="">Выберите категорию</option>
        <option value="Работа" <?= selected($old['category'] ?? '', 'Работа') ?>>Работа</option>
        <option value="Личное" <?= selected($old['category'] ?? '', 'Личное') ?>>Личное</option>
        <option value="Учёба" <?= selected($old['category'] ?? '', 'Учёба') ?>>Учёба</option>
      </select><br>
      <span style="color: red"><?= $errors['category'] ?? '' ?></span><br><br>

      <!-- Описание -->
      <label for="description">Описание:</label><br>
      <textarea id="description" name="description"><?= $old['description'] ?? '' ?></textarea><br>
      <span style="color: red"><?= $errors['description'] ?? '' ?></span><br><br>

      <label for="tags">Теги (удерживайте Ctrl/Command):</label><br>
      <select id="tags" name="tags[]" multiple>
        <?php foreach (['срочно', 'важно', 'дом', 'работа'] as $tag): ?>
          <option value="<?= $tag ?>" <?= in_array($tag, $old['tags'] ?? []) ? 'selected' : '' ?>><?= $tag ?></option>
        <?php endforeach; ?>
      </select><br><br>

      <!-- Шаги -->
      <label for="steps">Шаги выполнения (каждый с новой строки):</label><br>
      <textarea id="steps" name="steps"><?= $old['steps'] ?? '' ?></textarea><br><br>

      <!-- Кнопка отправки -->
      <button type="submit">Добавить задачу</button>
    </form>
  </div>
</body>
</html>
