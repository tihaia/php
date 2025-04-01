<?php

declare(strict_types=1);

/**
 * Подсчитывает общую сумму транзакций.
 *
 * @param array $transactions Массив транзакций, каждая из которых содержит ключ 'amount'.
 * @return float Итоговая сумма.
 */
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction["amount"];
    }
    return $total;
};

/**
 * Ищет транзакции по части описания.
 *
 * @param array $transactions Массив транзакций, каждая из которых содержит ключ 'description'.
 * @param string $descriptionPart Часть строки, по которой осуществляется поиск.
 * @return array Найденные транзакции, содержащие указанную подстроку в описании.
 * @throws InvalidArgumentException Если у транзакции нет ключа 'description'.
 */
function findTransactionByDescription(array $transactions, string $descriptionPart): array {
    $foundTransactions = [];

    foreach ($transactions as $transaction) {
        if (stripos($transaction["description"], $descriptionPart) !== false) {
            $foundTransactions[] = $transaction;
        }
    }

    return $foundTransactions;
}

/**
 * Ищет транзакцию по её идентификатору.
 *
 * @param array $transactions Массив транзакций, каждая из которых содержит ключ 'id'.
 * @param int $id Идентификатор искомой транзакции.
 * @return array|null Найденная транзакция или null, если не найдена.
 * @throws InvalidArgumentException Если у транзакции нет ключа 'id' или он не является числом.
 */
function findTransactionById(array $transactions, int $id): ?array {
    foreach ($transactions as $transaction) {
        if ($transaction["id"] === $id) {
            return $transaction; // Если нашли, сразу возвращаем
        }
    }
    return null; // Если не нашли, возвращаем null
}

/**
 * Возвращает количество дней, прошедших с момента транзакции.
 *
 * @param DateTime $date Дата транзакции.
 * @return int Количество дней с момента транзакции до текущей даты.
 */
function daysSinceTransaction(DateTime $date): int {
    $currentDate = new DateTime();
    return $date->diff($currentDate)->days;
}

/**
 * Добавляет новую транзакцию в глобальный массив $transactions.
 *
 * @param int $id Уникальный идентификатор транзакции.
 * @param string $date Дата транзакции в формате 'YYYY-MM-DD'.
 * @param float $amount Сумма транзакции.
 * @param string $description Описание транзакции.
 * @param string $merchant Продавец или получатель платежа.
 */
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;

    $transactions[] = [
        "id" => $id,
        "date" => new DateTime($date),
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
}

/**
 * Сортирует массив транзакций по дате (от старых к новым).
 *
 * @param array $transactions Массив транзакций (по ссылке).
 * @return void
 */
function sortTransactionsByDate(array &$transactions) {
    usort($transactions, function ($a, $b) {
        return $a["date"] <=> $b["date"];
    });
}

/**
 * Сортирует массив транзакций по убыванию суммы.
 *
 * @param array $transactions Массив транзакций (по ссылке).
 * @return void
 */
function sortTransactionsByAmount(array &$transactions): void {
    usort($transactions, function ($a, $b) {
        return $b["amount"] <=> $a["amount"];
});
}
