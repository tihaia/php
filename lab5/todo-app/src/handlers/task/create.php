<?php
require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/../../../src/db.php';

session_start();

$title = trim($_POST['title'] ?? '');
$category = trim($_POST['category'] ?? '');
$description = trim($_POST['description'] ?? '');
$tags = $_POST['tags'] ?? [];
$stepsRaw = trim($_POST['steps'] ?? '');

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

$steps = array_filter(array_map('trim', explode("\n", $stepsRaw)));

$pdo = getPDO();

$sql = "INSERT INTO tasks (title, category, description, tags, steps) VALUES (:title, :category, :description, :tags, :steps)";
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
