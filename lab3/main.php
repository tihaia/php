<?php

declare(strict_types=1);
require_once 'functions.php';
require_once 'transactions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отчет о транзакциях</title>
</head>
<body>
    <table border='1'>
        <thead>
            <tr>
                <th>Transaction id</th>
                <th>Date</th>
                <th>Total amount</th>
                <th>Description</th>
                <th>Merchant</th>
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p>Total Amount: <?php echo calculateTotalAmount($transactions); ?> lei</p>
</body>
</html>
