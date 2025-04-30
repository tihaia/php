<?php
/**
 * Обработчик создания новой задачи.
 * Выполняет валидацию данных и сохраняет их в базу данных.
 */

require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/../../../src/db.php';

session_start();

/** @var string $title Название задачи */
$title = trim($_POST['title'] ?? '');

/** @var string $category Категория задачи */
$category = trim($_POST['category'] ?? '');

/** @var string $description Описание задачи */
$description = trim($_POST['description'] ?? '');

/** @var array $tags Список тегов (массив строк) */
$tags = $_POST['tags'] ?? [];

/** @var string $stepsRaw Многострочный текст шагов выполнения задачи */
$stepsRaw = trim($_POST['steps'] ?? '');

/** @var array<string, string> $errors Ассоциативный массив ошибок валидации */
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
    header('Location: /todo-app/public/index.php?page=create');
    exit;
}

/** @var array<int, string> $steps Массив шагов (каждый шаг — строка) */
$steps = array_filter(array_map('trim', explode("\n", $stepsRaw)));

/** @var PDO $pdo Подключение к базе данных */
$pdo = getPDO();

$sql = "INSERT INTO tasks (title, category, description, tags, steps) 
        VALUES (:title, :category, :description, :tags, :steps)";
$stmt = $pdo->prepare($sql);

$stmt->execute([
    'title' => $title,
    'category' => $category,
    'description' => $description,
    'tags' => json_encode($tags, JSON_UNESCAPED_UNICODE),
    'steps' => json_encode($steps, JSON_UNESCAPED_UNICODE),
]);

header('Location: /todo-app/public/index.php');
exit;
