<?php
session_start();

$old = getOldInput();
$errors = getErrors();
?>

<h1>Добавление новой задачи</h1>
<div class="form-container">
  <form action="/todo-app/src/handlers/task/create.php" method="POST">
    <label for="title">Название задачи:</label><br>
    <input type="text" id="title" name="title" value="<?= $old['title'] ?? '' ?>"><br>
    <span style="color: red"><?= $errors['title'] ?? '' ?></span><br><br>

    <label for="category">Категория:</label><br>
    <select id="category" name="category">
      <option value="">Выберите категорию</option>
      <option value="Работа" <?= selected($old['category'] ?? '', 'Работа') ?>>Работа</option>
      <option value="Личное" <?= selected($old['category'] ?? '', 'Личное') ?>>Личное</option>
      <option value="Учёба" <?= selected($old['category'] ?? '', 'Учёба') ?>>Учёба</option>
    </select><br>
    <span style="color: red"><?= $errors['category'] ?? '' ?></span><br><br>

    <label for="description">Описание:</label><br>
    <textarea id="description" name="description"><?= $old['description'] ?? '' ?></textarea><br>
    <span style="color: red"><?= $errors['description'] ?? '' ?></span><br><br>

    <label for="tags">Теги:</label><br>
    <select id="tags" name="tags[]" multiple>
      <?php foreach (['срочно', 'важно', 'дом', 'работа'] as $tag): ?>
        <option value="<?= $tag ?>" <?= in_array($tag, $old['tags'] ?? []) ? 'selected' : '' ?>><?= $tag ?></option>
      <?php endforeach; ?>
    </select><br><br>

    <label for="steps">Шаги выполнения:</label><br>
    <textarea id="steps" name="steps"><?= $old['steps'] ?? '' ?></textarea><br><br>

    <button type="submit">Добавить задачу</button>
  </form>
</div>
