# Лабораторная №3
# Цель работы
Освоить работу с массивами в PHP, применяя различные операции: создание, добавление, удаление, сортировка и поиск. Закрепить навыки работы с функциями, включая передачу аргументов, возвращаемые значения и анонимные функции.
# Условие
# Задание 1. Работа с массивами
Разработать систему управления банковскими транзакциями с возможностью:
* добавления новых транзакций;
* удаления транзакций;
* сортировки транзакций по дате или сумме;
* поиска транзакций по описанию.
# Создание массива транзакций
Я создала отдельный файл с транзакциями, который потом подключу в основой файл.
```php
<?php
declare(strict_types=1);

$transactions = [
    [
        "id" => 1,
        "date" => new DateTime("2024-03-08"),
        "amount" => 95.75,
        "description" => "Payment for toys",
        "merchant" => "ToyLand",
    ],
    [
        "id" => 2,
        "date" => new DateTime("2024-03-10"),
        "amount" => 40.00,
        "description" => "Payment for coffee",
        "merchant" => "CoffeLike",
    ],
    [
        "id" => 3,
        "date" => new DateTime("2024-02-27"),
        "amount" => 254.92,
        "description" => "Cinema",
        "merchant" => "CoffeLike",
    ],
];
```
Для дальнейшего удобства работы с датами я сразу использовала DateTime, благодаря которому можно сравнивать и работать с датами.
# Вывод списка транзакций
В моем html коде я создала таблицу, с колонками, которые соответствут по значению ключам из массива транзакций. С помощью цикла foreach я прохожусь по каждой транзакции из массива и вывожу ее содержимое в соответствующих колонках, указывая нужный ключ. В дате я казываю формат, в отором хочу, чтобы выводилась дата. В последней колонке вызываю функцию, о которой будет сказано далее.
```php
  <table border='1'>
        <thead>
            <tr>
                <th>Transaction id</th>
                <th>Date</th>
                <th>Total amount</th>
                <th>Description</th>
                <th>Merchant</th>
                <th>Amount of passed days</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?php echo $transaction["id"]; ?></td>
                    <td><?php echo $transaction["date"]->format('Y-m-d'); ?></td>
                    <td><?php echo $transaction["amount"]; ?> lei</td>
                    <td><?php echo $transaction["description"]; ?></td>
                    <td><?php echo $transaction["merchant"]; ?></td>
                    <td><?php echo daysSinceTransaction($transaction["date"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
  </table>
```
# Реализация функций
Я создала ряд функций из списка по заданию:
1. Функция для вычисления общей суммы транзакций. Для этого я иницализирую в начале общее значение как 0, затем прохожусь по каждой транзакции и увеличиваю значение.
```php
/**
 * Вычисляет общую сумму транзакций.
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
```
2. Функция для поиска транзакции по заданной в описании подстроке. Для этого я прохожусь по каждой транзакции, 
```php
/**
 * Ищет транзакции, содержащие заданную подстроку в описании.
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
```
3. Функция для поиска транзакции по ее идентификатору. Для этого я прохожусь по всем транзакциям, сравниваю идентификатор текущей транзакции с тем, который ищу и если есть совпадение, то возвращаю транзакцию.
```php
/**
 * Ищет транзакцию по её идентификатору.
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
```
4. Функция, которая Вычисляет количество дней, прошедших с момента указанной даты транзакции. Для этого я с помощью new DateTime() устанавливаю текущую дату, после этого вычитаю из даты из массива текущую дату и возвращаю ее. Для этого использую diff(), который позволяет вычислить разницу между двумя объектами DateTime.
```php
/**
 * Вычисляет количество дней, прошедших с момента указанной даты транзакции.
 * @param DateTime $date
 * @return int
 */
function daysSinceTransaction(DateTime $date): int {
    $currentDate = new DateTime();
    return $date->diff($currentDate)->days;
}
```
5. Функция, которая добавляет новую транзакцию в глобальный массив транзакций. Для этого я внчале использую ключевое слово global, что означает, что функция может изменять глобальную переменную, которая находится за пределами этой функции. После этого уже делаю шаблон для нового массива животного.
```php
/**
 * Добавляет новую транзакцию в глобальный массив транзакций.
 * @param int $id
 * @param string $date
 * @param float $amount
 * @param string $description
 * @param string $merchant
 * @return void
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
```
6. Функция, которая сортирует массив транзакций по дате в порядке возрастания. Для этого я использую пользовательскую сортировку, где она берет транзакции и сравнивает их даты. в зависимости от этого происходит сортировка.
```php
/**
 * Сортирует массив транзакций по дате в порядке возрастания.
 * @param array $transactions
 * @return void
 */
function sortTransactionsByDate(array &$transactions) {
    usort($transactions, function ($a, $b) {
        return $a["date"] <=> $b["date"];
    });
}
```
7. Функция, которая сортирует массив транзакций по сумме в порядке убывания. Для этого я прохожусь по всем транзакциям, использую пользовательскую сортировку, котоая сравнивает суммы транзакций и в зависимости от этого располагает их.
```php
/**
 * Сортирует массив транзакций по сумме в порядке убывания.
 * @param array $transactions
 * @return void
 */
function sortTransactionsByAmount(array &$transactions): void {
    usort($transactions, function ($a, $b) {
        return $b["amount"] <=> $a["amount"];
});
}
```
