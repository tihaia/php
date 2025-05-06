<?php
require_once __DIR__ . '/../db/mysql.php';
require_once __DIR__ . '/../includes/functions.php';

$username = clean($_POST['username'] ?? '');
$email = clean($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if (!$username || !$email || !$password || !$confirm) {
    abort("⚠️ Все поля обязательны для заполнения.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    abort("⚠️ Некорректный email.");
}

if ($password !== $confirm) {
    abort("⚠️ Пароли не совпадают.");
}

// Проверка на существующего пользователя
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$stmt->execute([$username, $email]);
if ($stmt->fetch()) {
    abort("⚠️ Пользователь с таким именем или email уже существует.");
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, 'user')");
$stmt->execute([$username, $email, $hash]);

header('Location: /login.php');
exit;
