<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../db/mongo.php';

if (!$isAuthenticated || !isAdmin()) {
    header('Location: /login.php');
    exit;
}

$id = $_GET['id'] ?? null;
$product_id = intval($_GET['product_id'] ?? 0);

if (!$id || !$product_id) {
    abort("⚠️ Некорректные параметры.");
}

$reviewsCollection->deleteOne([
    '_id' => new MongoDB\BSON\ObjectId($id)
]);

header("Location: /product.php?id=$product_id");
exit;
