<?php

/**
 * Очистка текста от пробелов и HTML-символов.
 *
 * @param string|null $value
 * @return string
 */
function clean(string|null $value): string {
    return htmlspecialchars(trim($value ?? ''));
}

/**
 * Проверка, что переменная является положительным целым числом.
 *
 * @param mixed $value
 * @return bool
 */
function isPositiveInt(mixed $value): bool {
    return filter_var($value, FILTER_VALIDATE_INT) !== false && $value > 0;
}

/**
 * Перенаправление с сообщением об ошибке.
 *
 * @param string $message
 */
function abort(string $message) {
    echo "<p style='color:red;'>$message</p>";
    echo "<p><a href='javascript:history.back()'>← Назад</a></p>";
    exit;
}
