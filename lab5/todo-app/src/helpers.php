<?php

/**
 * Возвращает ошибки валидации из сессии.
 *
 * @return array<string, string>
 */
function getErrors(): array {
    /** @var array<string, string> $errors */
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);
    return $errors;
}

/**
 * Возвращает ранее введённые данные из сессии.
 *
 * @return array<string, mixed>
 */
function getOldInput(): array {
    /** @var array<string, mixed> $old */
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['old']);
    return $old;
}

/**
 * Устанавливает атрибут selected для выбранной опции.
 *
 * @param string $value Значение из формы
 * @param string $expected Ожидаемое значение
 * @return string
 */
function selected(string $value, string $expected): string {
    return $value === $expected ? 'selected' : '';
}
