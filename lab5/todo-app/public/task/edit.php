<?php
require_once __DIR__ . '/../../src/db.php';

$pdo = getPDO();
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die('Некорректный ID задачи');
}

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task) {
    die('Задача не найдена');
}

$title = "Редактировать задачу";

ob_start(); ?>
    <h1>Редактировать задачу</h1>

    <form action="/src/handlers/task/edit.php" method="post">
        <input type="hidden" name="id" value="<?= $task['id'] ?>">

        <label for="title">Название:</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($task['title']) ?>" required><br><br>

        <label for="description">Описание:</label><br>
        <textarea id="description" name="description"><?= htmlspecialchars($task['description']) ?></textarea><br><br>

        <label>
            <input type="checkbox" name="is_done" value="1" <?= $task['is_done'] ? 'checked' : '' ?>>
            Задача выполнена
        </label><br><br>

        <button type="submit">Сохранить</button>
    </form>

    <p><a href="/">← Назад</a></p>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../templates/layout.php';
