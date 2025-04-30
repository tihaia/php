<?php
require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/../../../src/db.php';

session_start();

$id = $_POST['id'];
$title = trim($_POST['title']);
$category = trim($_POST['category']);
$description = trim($_POST['description']);
$tags = $_POST['tags'] ?? [];
$stepsRaw = trim($_POST['steps']);
$steps = array_filter(array_map('trim', explode("\n", $stepsRaw)));

$errors = [];

if ($title === '') $errors['title'] = 'Название обязательно';
if ($category === '') $errors['category'] = 'Категория обязательна';
if ($description === '') $errors['description'] = 'Описание обязательно';

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;
    header("Location: /todo-app/public/index.php?page=edit&id=" . $id);
    exit;
}

$pdo = getPDO();
$stmt = $pdo->prepare("UPDATE tasks SET title=:title, category=:category, description=:description, tags=:tags, steps=:steps WHERE id=:id");
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
