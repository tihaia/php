# Лабораторная работа №2
# Цель работы
Освоить использование условных конструкций и циклов в PHP.
# Условие
# Условные конструкции
```php
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lab 2</title>
    <style>
        table {
            width: 40%;
            border-collapse: collapse;
        }
        th, td {
            border: 2px solid grey;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>№</th>
            <th>Фамилия Имя</th>
            <th>График работы</th>
        </tr>
        <?php

            $weekDay = date('D');

            $johnSchedule = (in_array($weekDay, ['Mon', 'Wed', 'Fri'])) ? "8:00-12:00" : "Нерабочий день";

            $janeSchedule = (in_array($weekDay, ['Tue', 'Thu', 'Sat'])) ? "12:00-16:00" : "Нерабочий день";

        ?>
        <tr>
            <td>1</td>
            <td>John Styles</td>
            <td>
                <?php echo $johnSchedule; ?>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>Jane Doe</td>
            <td>
                <?php echo $janeSchedule; ?>
            </td>
        </tr>
    </table>
</body>
</html>
```
# Циклы
# for
```php
<?php

$a = 0;
$b = 0;

for ($i = 0; $i <= 5; $i++) {
   $a += 10;
   echo "a = $a";
   $b += 5;
   echo "b = $b";
}

echo "End of the loop: a = $a, b = $b";
```
# while
```php
$i = 0;
$a = 0;
$b = 0;

while ($i <= 5) {
    $a += 10;
    $b += 5;
    $i++;
}
echo "End of the loop: a = $a, b = $b";
```
# do...while
```php
$i = 0;
$a = 0;
$b = 0;

do {
    $a += 10;
    $b += 5;
    $i++;
} while ($i <= 5);

echo "End of the loop: a = $a, b = $b";
```
# Контрольные вопросы
1. В чем разница между циклами for, while и do-while? В каких случаях лучше использовать каждый из них?
  Разница циклов в синтаксисе и условии, когда их лучше использовать. Цикл while выполняет код, пока условие истинно. Цикл do...while выполняет блок кода хотя бы один раз, даже если условие ложно. Цикл for используется, когда известно количество итераций заранее. 
2. Как работает тернарный оператор ? : в PHP?

3. Что произойдет, если в do-while поставить условие, которое изначально ложно?
