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
Я добавила 
* 
