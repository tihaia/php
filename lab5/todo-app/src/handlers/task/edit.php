<?php
/**
 * Обработчик редактирования задачи.
 * Выполняет валидацию и обновляет запись в базе данных.
 */

require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/../../../src/db.php';

session_start();

/** @var string $id ID редактируемой задачи */
$id = $_POST['id'];

/** @var string $title Название задачи */
$title = trim($_POST['title']);

/** @var string $category Категория задачи */
$category = trim($_POST['category']);

/** @var string $description Описание задачи */
$description = trim($_POST['description']);

/** @var array $tags Массив тегов задачи */
$tags = $_POST['tags'] ?? [];

/** @var string $stepsRaw Многострочный текст шагов */
$stepsRaw = trim($_POST['steps']);

/** @var array<int, string> $steps Массив шагов */
$steps = array_filter(array_map('trim', explode("\n", $stepsRaw)));

/** @var array<string, string> $errors Ошибки валидации */
$errors = [];

if ($title === '') {
    $errors['title'] = 'Название обязательно';
}
if ($category === '') {
    $errors['category'] = 'Категория обязательна';
}
if ($description === '') {
    $errors['description'] = 'Описание обязательно';
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;
    header("Location: /todo-app/public/index.php?page=edit&id=" . $id);
    exit;
}

/** @var PDO $pdo Подключение к базе данных */
$pdo = getPDO();

$stmt = $pdo->prepare("
    UPDATE tasks 
    SET title = :title, category = :category, description = :description, tags = :tags, steps = :steps 
    WHERE id = :id
");

$stmt->execute([
    'id' => $id,
    'title' => $title,
    'category' => $category,
    'description' => $description,
    'tags' => json_encode($tags, JSON_UNESCAPED_UNICODE),
    'steps' => json_encode($steps, JSON_UNESCAPED_UNICODE),
]);

header("Location: /todo-app/public/index.php");
exit;
