<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ToDo App</title>
    <link rel="stylesheet" href="/todo-app/public/style.css">
</head>
<body>
    <header>
        <h1><a href="/todo-app/public/index.php">ToDo App</a></h1>
        <nav>
            <a href="/todo-app/public/index.php?page=create">Добавить задачу</a>
        </nav>
    </header>
    <main>
        <?= $content ?>
    </main>
    <footer>
        <p>&copy; 2025 ToDo App</p>
    </footer>
</body>
</html>
