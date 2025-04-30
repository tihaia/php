<?php

require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/helpers.php';

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

$content = ob_get_clean();
require __DIR__ . '/../templates/layout.php';
