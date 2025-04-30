<?php

/**
 * Получает подключение к базе данных.
 *
 * @return PDO
 */
function getPDO(): PDO
{
    /** @var array $config Конфигурация подключения */
    $config = require __DIR__ . '/../config/db.php';

    /** @var string $dsn DSN-строка для подключения */
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

    try {
        return new PDO($dsn, $config['user'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    } catch (PDOException $e) {
        die('Ошибка подключения к базе данных: ' . $e->getMessage());
    }
}
