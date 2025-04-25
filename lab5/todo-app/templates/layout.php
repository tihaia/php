<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'ToDo-приложение' ?></title>
</head>
<body>
    <h1>ToDo-лист</h1>
    <nav>
        <a href="/">Главная</a> |
        <a href="/task/create.php">Добавить задачу</a>
    </nav>
    <hr>
    <?= $content ?>
</body>
</html>
