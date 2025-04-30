<?php

/**
 * Получение ошибок валидации из сессии
 *
 * @return array<string, string>
 */
function getErrors(): array {
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);
    return $errors;
}

/**
 * Получение ранее введённых данных из сессии (в случае ошибок)
 *
 * @return array<string, mixed>
 */
function getOldInput(): array {
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['old']);
    return $old;
}

/**
 * Установка атрибута selected для <option>
 *
 * @param string $value Значение из формы
 * @param string $expected Значение опции
 * @return string
 */
function selected(string $value, string $expected): string {
    return $value === $expected ? 'selected' : '';
}
