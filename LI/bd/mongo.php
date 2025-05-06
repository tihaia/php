<?php
/**
 * Подключение к MongoDB с использованием MongoDB\Client.
 * Использует коллекцию "reviews" в базе "product_reviews".
 */

require_once __DIR__ . '/../vendor/autoload.php'; // путь к autoload composer

try {
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $mongoDb = $mongoClient->product_reviews; // имя базы
    $reviewsCollection = $mongoDb->reviews;   // коллекция отзывов
} catch (Exception $e) {
    die("Ошибка подключения к MongoDB: " . $e->getMessage());
}
