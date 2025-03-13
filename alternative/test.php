<?php
/**
 * Подключаем файл для обработки теста.
 * В этом файле содержится логика обработки ответов пользователя и вычисления результатов.
 */
require_once 'testAnalyze.php'; // Подключаем логику из process_test.php
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
    <h2>Проверь свои знания о кофе:</h2>
    <form action="test.php" method="POST">
        <label>Введите ваше имя:</label>
        <input type="text" name="username" required>

        <?php 
        /**
         * Проходим по всем вопросам, загруженным из JSON
         * Все вопросы содержать такие данные как текст вопроса, варианты ответа. Эти данные отображаются вользователю в форме
         */
        foreach ($questions as $index => $q): 
            if (empty($q["question"]) || empty($q["answers"])) continue;
        ?>
            <p><?php echo ($index + 1) . ". " .htmlspecialchars($q["question"]); ?></p>
            
            <?php 
            /**
             * Перебираем все ответы для текущего вопроса.
             * В зависимости от его типа (radio или checkbox) создаем соответствующие HTML-элементы
             */
            foreach ($q["answers"] as $key => $answer): 
                $inputType = htmlspecialchars($q["type"]);  // Тип элемента (radio или checkbox)
                $inputName = "answer[$index]"; // Имя для передачи данных в POST

                /**
                 * Если ответ типа checkbox, то добавляем [] в имя,
                 * чтобы можно было передавать массив нескольких значений, которые были выбраны.
                 */
                if ($inputType == 'checkbox') {
                    $inputName .= '[]';
                }
            ?>
                <!-- Генерируем поле ввода для ответа -->
                <input type="<?= $inputType ?>" name="<?= $inputName ?>" value="<?= $key ?>"> 
                <?=htmlspecialchars($answer) ?><br>
            <?php endforeach; ?>
            <br>
        <?php endforeach; ?>
        <button type="submit">Отправить</button>
</form>
</body>
</html>
