<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../db/mongo.php';

if (!$isAuthenticated) {
    header('Location: /login.php');
    exit;
}

$product_id = intval($_POST['product_id'] ?? 0);
$text = clean($_POST['text'] ?? '');
$rating = intval($_POST['rating'] ?? 0);

if (!$product_id || $rating < 1 || $rating > 5 || strlen($text) < 3) {
    abort("⚠️ Введите корректный отзыв и оценку от 1 до 5.");
}

$reviewsCollection->insertOne([
    'product_id' => $product_id,
    'user' => $username,
    'text' => $text,
    'rating' => $rating,
    'created_at' => new MongoDB\BSON\UTCDateTime()
]);

header("Location: /product.php?id=$product_id");
exit;
