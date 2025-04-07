<?php
/**
 * Обработчик формы добавления новой задачи
 * Выполняет валидацию, фильтрацию и сохранение данных в JSON-файл
 * При наличии ошибок возвращает пользователя обратно на форму с сообщениями
 */

require_once __DIR__ . '/../../src/helpers.php';

session_start();

/**
 * @var string $title Название задачи
 * @var string $category Категория задачи
 * @var string $description Описание задачи
 * @var array<string> $tags Список тэгов
 * @var string $stepsRaw Сырые шаги (текст)
 */
$title = trim($_POST['title'] ?? '');
$category = trim($_POST['category'] ?? '');
$description = trim($_POST['description'] ?? '');
$tags = $_POST['tags'] ?? [];
$stepsRaw = trim($_POST['steps'] ?? '');

/**
 * @var array<string, string> $errors Ассоциативный массив ошибок
 */
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

// Если есть ошибки — вернём пользователя обратно
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;

    // Редирект на форму
    header('Location: ../../public/task/create.php');
    exit;
}

/**
 * @var array<string> $steps Список шагов
 */
$steps = array_filter(array_map('trim', explode("\n", $stepsRaw)));

/**
 * @var array<string, mixed> $task Новая задача
 */
$task = [
    'title' => $title,
    'category' => $category,
    'description' => $description,
    'tags' => $tags,
    'steps' => $steps,
    'created_at' => date('Y-m-d H:i:s'),
];

$file = __DIR__ . '/../../storage/tasks.json';
$tasks = [];

if (file_exists($file)) {
    $content = file_get_contents($file);
    $tasks = json_decode($content, true) ?? [];
}

$tasks[] = $task;

// Сохраняем в формате JSON с отступами и без экранирования юникода
file_put_contents($file, json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Location: ../../public/index.php');
exit;
