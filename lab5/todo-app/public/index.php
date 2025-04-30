<?php
/**
 * Точка входа в приложение.
 * Загружает нужную страницу в зависимости от параметра ?page=
 */

require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/helpers.php';

/** @var string $page Текущая запрошенная страница */
$page = $_GET['page'] ?? 'index';

ob_start();

switch ($page) {
    case 'create':
        require __DIR__ . '/../templates/task/create.php';
        break;
    case 'edit':
        require __DIR__ . '/../templates/task/edit.php';
        break;
    case 'show':
        require __DIR__ . '/../templates/task/show.php';
        break;
    default:
        require __DIR__ . '/../templates/task/index.php';
        break;
}

/** @var string $content Буферизированный HTML-контент страницы */
$content = ob_get_clean();

require __DIR__ . '/../templates/layout.php';
