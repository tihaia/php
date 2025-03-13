<?php
/**
 * Файл для вывода таблицы со статистикой по тестам
 * 
 * Считывает данные о результатах тестов из файла data.json и отображает их в виде таблицы
 * Загружает содержимое файла, декодирует JSON и выводит результаты тестов
 * Если на этом этапе случается ошибка, тогда выводится соответствующее сообщение.
 * 
 * Выводит таблицу с результатами прохождения пользователями теста
 */

$dataFile = "testData.json";

/**
 * Проверяет существование файла с данными.
 * 
 * Если файл `data.json` отсутствует, выводится сообщение об ошибке и выполнение скрипта прекращается.
 */
if (!file_exists($dataFile)) {
    echo "Файл данных не найден.";
    exit;
}

/**
 * Загружает и декодирует данные из JSON-файла.
 * 
 * Считывает содержимое файла `data.json` и преобразует его в ассоциативный массив.
 * Если при декодировании произошла ошибка, выводится сообщение и выполнение скрипта прекращается.
 */
$data = json_decode(file_get_contents($dataFile), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Ошибка чтения JSON.";
    exit;
}

/**
 * Получает массив результатов тестов из данных.
 * 
 * Если в загруженном JSON отсутствует ключ "results", используется пустой массив,
 * чтобы избежать ошибок при обработке данных.
 */
$results = isset($data["results"]) ? $data["results"] : []; // Проверка наличия результатов
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
<h2>Статистика результатов</h2>
<table class="table">
    <thead>
        <tr>
            <th>Имя</th>
            <th>Правильные ответы</th>
            <th>Процент прохождения</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $result): ?>
            <tr>
                <td><?=htmlspecialchars($result["username"]) ?></td>
                <td><?=htmlspecialchars($result["correct"]) ?></td>
                <td><?=htmlspecialchars($result["score"]) ?>%</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
