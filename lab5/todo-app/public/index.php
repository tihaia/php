<?php
/**
 * Главная страница. Загружает все задачи и выводит их через шаблон.
 */

require_once __DIR__ . '/../src/db.php';

$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
$tasks = $stmt->fetchAll();

$title = "Список задач";

// Буферизация вывода шаблона
ob_start();
include __DIR__ . '/../templates/index.php';
$content = ob_get_clean();

// Подключение общего шаблона
include __DIR__ . '/../templates/layout.php';
