# Индивидуальная работа PHP - Товары и отзывы на них

##  Инструкция по запуску проекта
1. Установите XAMPP.
2. Скопируйте проект в директорию htdocs.
3. Запустите Apache и MySQL.
4. Импортируйте базы данных:
   * product_catalog.sql → база education
   * reviews.db → база с отзывами
5. Откройте http://localhost/LI/public/index.php.

---

## Описание

* Product Catalog — веб-приложение для управления товарами и отзывами.
* Язык: PHP (без фреймворков)
* Базы данных:
MySQL (product_catalog) — основная база данных товаров и пользователей
SQLite (reviews.db) — база данных с отзывами
* Интерфейс: HTML + CSS
* Архитектура: модульная, с разделением на действия (actions/), шаблоны (templates/) и страницы (public/)
* Реализована аутентификация и система ролей:
гость — просмотр товаров и отзывов
пользователь — добавление отзывов
администратор — управление товарами и пользователями

---

##  Содержание

1. Функциональные возможности
2. Сценарии взаимодействия
3. Структура базы данных
4. Примеры использования кода
5. Ответы на контрольные вопросы
6. Источники
7. Дополнительно

---

1. Функциональные возможности
Регистрация и вход в систему

Публичная страница с каталогом товаров

Администратор может:

Добавлять, редактировать, удалять товары
!alt text
!alt text
!alt text

Добавлять категории
!alt text

Управлять пользователями (просмотр с ролями)
!alt text

Удалять отзывы
!alt text

Пользователь может:

Просматривать товары

Читать отзывы

Добавлять отзывы с оценкой (1–5)
---
2. Сценарии взаимодействия
Гость открывает index.php и видит каталог товаров

Пользователь регистрируется, входит и может оставлять отзывы

Администратор входит в систему, управляет товарами и категориями, просматривает список пользователей и удаляет отзывы при необходимости
---

3. Структура базы данных
product_catalog (MySQL)
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  category_id INT,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
reviews.db (SQLite)
CREATE TABLE reviews (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  product_id INTEGER NOT NULL,
  user_name TEXT NOT NULL,
  rating INTEGER NOT NULL,
  comment TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

---
4. Примеры использования кода
Добавление товара
```php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO products (title, price, category_id, description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $price, $category_id, $description]);
  }
```
Проверка роли администратора
```php
function isAdmin() {
  return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

```
Проверка входа в систему
```php
$isAuthenticated = isset($_SESSION['user_id']);

```
Удаление товара
```php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
  $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
  $stmt->execute([$_GET['id']]);
}

```
Редактирование товара
```php
$stmt = $pdo->prepare("
  UPDATE products
  SET title = ?, price = ?, category_id = ?, description = ?
  WHERE id = ?
");
$stmt->execute([$title, $price, $category_id, $description, $id]);

```
Добавление отзыва в SQLite
```php
$stmt = $sqlite->prepare("
  INSERT INTO reviews (product_id, user_name, rating, comment)
  VALUES (:product_id, :user_name, :rating, :comment)
");
$stmt->execute([
  ':product_id' => $product_id,
  ':user_name' => $user_name,
  ':rating' => $rating,
  ':comment' => $comment
]);

```
Получение отзывов по товару
```php
$stmt = $sqlite->prepare("SELECT * FROM reviews WHERE product_id = ?");
$stmt->execute([$product_id]);
$reviews = $stmt->fetchAll();
```
Публичная страница (каталог)
```php
$products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
```
---

5. Ответы на контрольные вопросы

1. Что такое PDO?
PDO (PHP Data Objects) — это объектно-ориентированный интерфейс для работы с базами данных в PHP. Он позволяет подключаться к различным СУБД и выполнять запросы безопасным способом, используя подготовленные выражения.

2. Для чего используется prepare()?
Метод prepare() подготавливает SQL-запрос с параметрами, что позволяет безопасно подставлять пользовательские данные и защищает от SQL-инъекций.

3. Что такое $_POST и isset()?
$_POST — это суперглобальный массив, содержащий данные, отправленные из формы методом POST.
isset() — функция, которая проверяет, была ли переменная установлена и не равна ли она null.

4. Как определяется роль администратора?
У каждого пользователя в базе данных есть поле role. Если его значение равно 'admin', пользователь считается администратором.

5. Как хранится пароль?
Пароль сохраняется в базе в виде зашифрованного хэша, созданного с помощью функции password_hash(). При входе пароль проверяется через password_verify().
---

6. Источники

* PHP.net
* MDN Web Docs
* XAMPP

---

7. Дополнительно
* В проекте используются две базы данных:
product_catalog — основная база (MySQL)
reviews.db — база отзывов (SQLite)
* Приложение построено без фреймворков или сторонних библиотек — только на чистом PHP\
* Структура проекта разделена на логические модули: public/, actions/, includes/, templates/, db/
* Код написан в чистом и понятном стиле с комментариями PHPDoc
* Пользовательский ввод очищается и валидируется
* Реализована простая система ролей: гость, пользователь, администратор
* Отзывы на товары сохраняются отдельно, без нагрузки на основную БД
