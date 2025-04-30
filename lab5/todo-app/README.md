# ToDo App

## Описание
Это простое PHP-приложение для управления задачами, созданное в рамках лабораторной №5.

## Используемые технологии
- PHP 8.x
- MySQL (XAMPP)
- PDO
- HTML/CSS
- Без фреймворков

## Структура таблицы `tasks`
```sql
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    tags TEXT,
    steps TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Защита от SQL-инъекций
В проекте используются подготовленные выражения (`$pdo->prepare(...)`), чтобы исключить возможность SQL-инъекций.

Пример:
```php
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->execute(['id' => $id]);
```

## Как запустить
1. Импортируйте структуру БД из `README.md`
2. Убедитесь, что база `todo_app` создана
3. Запустите `XAMPP` и положите папку `todo-app-final` в `htdocs`
4. Откройте в браузере: `http://localhost/todo-app-final/public/index.php`
