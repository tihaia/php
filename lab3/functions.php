<?php

declare(strict_types=1);

/**
 * Summary of calculateTotalAmount
 * @param array $transactions
 * @return float|int
 */
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction["amount"];
    }
    return $total;
};

/**
 * Summary of findTransactionByDescription
 * @param array $transactions
 * @param string $descriptionPart
 * @return array
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
 * Summary of findTransactionById
 * @param array $transactions
 * @param int $id
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
 * Summary of sortTransactionsByDate
 * @param array $transactions
 * @return void
 */
function sortTransactionsByDate(array &$transactions) {
    usort($transactions, function ($a, $b) {
        return $a["date"] <=> $b["date"];
    });
}

/**
 * Summary of sortTransactionsByAmount
 * @param array $transactions
 * @return void
 */
function sortTransactionsByAmount(array &$transactions): void {
    usort($transactions, function ($a, $b) {
        return $b["amount"] <=> $a["amount"];
});
}
