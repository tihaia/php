<?php
$title = "Добавить задачу";

ob_start(); ?>
    <h1>Добавить задачу</h1>
    <form action="/src/handlers/task/create.php" method="post">
        <label for="title">Название:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Описание:</label><br>
        <textarea id="description" name="description"></textarea><br><br>

        <button type="submit">Сохранить</button>
    </form>
    <p><a href="/">← Назад к списку</a></p>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../templates/layout.php';
