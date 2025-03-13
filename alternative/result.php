<?php
/**
 * Извлекает параметры с результатами из URL.
 * 
 * Получает количество правильных ответов и процент правильных ответов из GET-параметров.
 * Если параметры не указаны, используется значение по умолчанию:
 * 
 * @var int $correctCount Количество правильных ответов.
 * @var float $score Процент правильных ответов.
 */
$correctCount = isset($_GET["correct"]) ? (int)$_GET["correct"] : 0;
$score = isset($_GET["score"]) ? (float)$_GET["score"] : 0;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест по кофе</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="result-box">
        <h2>Ваш результат</h2>
        <p class="result-text">Количество правильных ответов: <b><?= $correctCount ?></b></p>
        <p class="result-text">Процент сдачи теста: <b><?= $score ?>%</b></p>
        <a href="test.php" class="button">Пройти тест заново</a>
    </div>
</body>
</html>
