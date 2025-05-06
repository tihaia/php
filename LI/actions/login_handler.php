<?php
require_once __DIR__ . '/../db/mysql.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();

$login = clean($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';

if (!$login || !$password) {
    abort("⚠️ Введите логин и пароль.");
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
$stmt->execute([$login, $login]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password_hash'])) {
    abort("⚠️ Неверный логин или пароль.");
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

header('Location: /index.php');
exit;
