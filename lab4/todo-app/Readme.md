# Лабораторная работа №4.

## Цель работы

Освоить основные принципы работы с HTML-формами в PHP, включая отправку данных на сервер и их обработку, включая валидацию данных.

Данная работа станет основой для дальнейшего изучения разработки веб-приложений. Дальнейшие лабораторные работы будут основываться на данной.

## Условие

Выбрать тему проекта для лабораторной работы, которая будет развиваться на протяжении курса.
Я выбрала:
- ToDo-лист;

### Задание 1. Создание проекта

1. Создаю корневую директорию проекта "todo-app".
2. Организую файловую структуру проекта.
   ```

   ```
### Задание 2. Создание формы добавления задачи
1. Создаю HTML-форму для добавления рецепта.
2. Форма содержит следующие поля:
   - Название задачи;
   - Категория задачи;
   - Описание задачи;
   - Тэги важности;
3. Добавила поле для шагов выполнения зачачи.
4. Добавила кнопку **"Отправить"** для отправки формы.
```php
<?php
/**
 * Страница добавления новой задачи
 * Отображает HTML-форму с полями для заполнения задачи
 * Обрабатывает ошибки валидации и сохраняет старые значения
 */

session_start();

require_once __DIR__ . '/../../src/helpers.php';

/**
 * @var array<string, mixed> $old Старые значения, введённые в форму
 * @var array<string, string> $errors Сообщения об ошибках валидации
 */
$old = getOldInput();
$errors = getErrors();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Добавить задачу</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <h1>Добавление новой задачи</h1>

  <div class="form-container">
    <form action="/handlers/handle_task_form.php" method="POST">
      
      <!-- Название задачи -->
      <label for="title">Название задачи:</label><br>
      <input type="text" id="title" name="title" value="<?= $old['title'] ?? '' ?>"><br>
      <span style="color: red"><?= $errors['title'] ?? '' ?></span><br><br>

      <!-- Категория -->
      <label for="category">Категория:</label><br>
      <select id="category" name="category">
        <option value="">Выберите категорию</option>
        <option value="Работа" <?= selected($old['category'] ?? '', 'Работа') ?>>Работа</option>
        <option value="Личное" <?= selected($old['category'] ?? '', 'Личное') ?>>Личное</option>
        <option value="Учёба" <?= selected($old['category'] ?? '', 'Учёба') ?>>Учёба</option>
      </select><br>
      <span style="color: red"><?= $errors['category'] ?? '' ?></span><br><br>

      <!-- Описание -->
      <label for="description">Описание:</label><br>
      <textarea id="description" name="description"><?= $old['description'] ?? '' ?></textarea><br>
      <span style="color: red"><?= $errors['description'] ?? '' ?></span><br><br>

      <label for="tags">Теги (удерживайте Ctrl/Command):</label><br>
      <select id="tags" name="tags[]" multiple>
        <?php foreach (['срочно', 'важно', 'дом', 'работа'] as $tag): ?>
          <option value="<?= $tag ?>" <?= in_array($tag, $old['tags'] ?? []) ? 'selected' : '' ?>><?= $tag ?></option>
        <?php endforeach; ?>
      </select><br><br>

      <!-- Шаги -->
      <label for="steps">Шаги выполнения (каждый с новой строки):</label><br>
      <textarea id="steps" name="steps"><?= $old['steps'] ?? '' ?></textarea><br><br>

      <!-- Кнопка отправки -->
      <button type="submit">Добавить задачу</button>
    </form>
  </div>
</body>
</html>
```
### Задание 3. Обработка формы

1. Создаю в директории `handlers` файл, который будет обрабатывать данные формы.
2. **В обработчике реализую**:
   - Фильрацию данных;
   - Валидацию данных;
   - Сохранение данных в файл `storage/tasks.json`.
3. После успешного сохранения данных выполняю перенаправление пользователя на главную страницу.
4. Если валидация не пройдена, отображаю соответствующие ошибки на странице добавления рецепта под соответствующими полями.
```php
<?php
/**
 * Обработчик формы добавления новой задачи
 * Выполняет валидацию, фильтрацию и сохранение данных в JSON-файл
 * При наличии ошибок возвращает пользователя обратно на форму с сообщениями
 */

require_once __DIR__ . '/../../src/helpers.php';

session_start();

/**
 * @var string $title Название задачи
 * @var string $category Категория задачи
 * @var string $description Описание задачи
 * @var array<string> $tags Список тэгов
 * @var string $stepsRaw Сырые шаги (текст)
 */
$title = trim($_POST['title'] ?? '');
$category = trim($_POST['category'] ?? '');
$description = trim($_POST['description'] ?? '');
$tags = $_POST['tags'] ?? [];
$stepsRaw = trim($_POST['steps'] ?? '');

/**
 * @var array<string, string> $errors Ассоциативный массив ошибок
 */
$errors = [];

if ($title === '') {
    $errors['title'] = 'Название обязательно';
}

if ($category === '') {
    $errors['category'] = 'Категория обязательна';
}

if ($description === '') {
    $errors['description'] = 'Описание обязательно';
}

// Если есть ошибки — вернём пользователя обратно
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;

    // Редирект на форму
    header('Location: ../../public/task/create.php');
    exit;
}

/**
 * @var array<string> $steps Список шагов
 */
$steps = array_filter(array_map('trim', explode("\n", $stepsRaw)));

/**
 * @var array<string, mixed> $task Новая задача
 */
$task = [
    'title' => $title,
    'category' => $category,
    'description' => $description,
    'tags' => $tags,
    'steps' => $steps,
    'created_at' => date('Y-m-d H:i:s'),
];

$file = __DIR__ . '/../../storage/tasks.json';
$tasks = [];

if (file_exists($file)) {
    $content = file_get_contents($file);
    $tasks = json_decode($content, true) ?? [];
}

$tasks[] = $task;

// Сохраняем в формате JSON с отступами и без экранирования юникода
file_put_contents($file, json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Location: ../../public/index.php');
exit;
```
### Задание 4. Отображение задач

1. В файле `public/index.php` отображаю 2 последние задачи из `storage/tasks.json`:
```php
<?php
/**
 * Главная страница ToDo-приложения
 * Отображает 2 последние добавленные задачи
 */

require_once __DIR__ . '/../src/helpers.php';

$file = __DIR__ . '/../storage/tasks.json';

$tasks = [];

/**
 * Если файл существует, читаем задачи из JSON
 * @var array<int, array> $tasks Массив задач
 */
if (file_exists($file)) {
    $content = file_get_contents($file);
    $tasks = json_decode($content, true) ?? [];
}

$latestTasks = array_slice(array_reverse($tasks), 0, 2);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>ToDo-лист</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <div class="task-container">
    <h1>Последние задачи</h1>

    <?php if (empty($latestTasks)): ?>
      <p>Нет задач для отображения.</p>
    <?php else: ?>
      <ul>
        <?php foreach ($latestTasks as $task): ?>
          <li>
            <strong><?= htmlspecialchars($task['title']) ?></strong><br>
            Категория: <?= htmlspecialchars($task['category']) ?><br>
            Описание: <?= nl2br(htmlspecialchars($task['description'])) ?><br>
            <?php if (!empty($task['tags'])): ?>
              Теги: <?= implode(', ', $task['tags']) ?><br>
            <?php endif; ?>
            <?php if (!empty($task['steps'])): ?>
              <details>
                <summary>Шаги выполнения</summary>
                <ol>
                  <?php foreach ($task['steps'] as $step): ?>
                    <li><?= htmlspecialchars($step) ?></li>
                  <?php endforeach; ?>
                </ol>
              </details>
            <?php endif; ?>
            <hr>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <a href="/task/create.php">Добавить новую задачу</a><br>
    <a href="/task/index.php">Посмотреть все задачи</a>
  </div>
</body>
</html>
```
2. В файле `public/task/index.php` отображаю все задачи из файла `storage/tasks.json`.
```php
<?php
/**
 * Страница со списком всех задач ToDo
 * Реализует постраничный вывод задач (пагинация)
 */

require_once __DIR__ . '/../../src/helpers.php';

// Количество задач на одной странице
$perPage = 2;

/**
 * Получение текущей страницы из параметра GET
 * @var int $page Номер текущей страницы
 */
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$startIndex = ($page - 1) * $perPage;

$file = __DIR__ . '/../../storage/tasks.json';

$tasks = [];

/**
 * Загрузка задач из файла, если файл существует
 * @var array<int, array> $tasks
 */
if (file_exists($file)) {
    $content = file_get_contents($file);
    $tasks = json_decode($content, true) ?? [];
}

// Подсчёт общего количества страниц
$totalTasks = count($tasks);
$totalPages = (int) ceil($totalTasks / $perPage);

// Задачи на текущей странице
$tasks = array_reverse($tasks); // новые выше
$tasksOnPage = array_slice($tasks, $startIndex, $perPage);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Список задач</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <div class="task-container">
    <h1>Все задачи</h1>

    <?php if (empty($tasksOnPage)): ?>
      <p>Задачи отсутствуют.</p>
    <?php else: ?>
      <ul>
        <?php foreach ($tasksOnPage as $task): ?>
          <li>
            <strong><?= htmlspecialchars($task['title']) ?></strong><br>
            Категория: <?= htmlspecialchars($task['category']) ?><br>
            Описание: <?= nl2br(htmlspecialchars($task['description'])) ?><br>
            <?php if (!empty($task['tags'])): ?>
              Теги: <?= implode(', ', $task['tags']) ?><br>
            <?php endif; ?>
            <?php if (!empty($task['steps'])): ?>
              <details>
                <summary>Шаги</summary>
                <ol>
                  <?php foreach ($task['steps'] as $step): ?>
                    <li><?= htmlspecialchars($step) ?></li>
                  <?php endforeach; ?>
                </ol>
              </details>
            <?php endif; ?>
            <hr>
          </li>
        <?php endforeach; ?>
      </ul>

      <!-- Пагинация -->
      <?php if ($totalPages > 1): ?>
        <div class="pagination">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i === $page): ?>
              <strong><?= $i ?></strong>
            <?php else: ?>
              <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <br>
    <a href="/index.php">На главную</a> | 
    <a href="/task/create.php">Добавить задачу</a>
  </div>
</body>
</html>
```
### Дополнительное задание
1. Реализую пагинацию (постраничный вывод) списка рецептов.
2. На странице `public/task/index.php` отображайте по 2 задачи на страницу.
```php
<?php
/**
 * Страница со списком всех задач ToDo
 * Реализует постраничный вывод задач (пагинация)
 */

require_once __DIR__ . '/../../src/helpers.php';

// Количество задач на одной странице
$perPage = 2;

/**
 * Получение текущей страницы из параметра GET
 * @var int $page Номер текущей страницы
 */
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$startIndex = ($page - 1) * $perPage;

$file = __DIR__ . '/../../storage/tasks.json';

$tasks = [];

/**
 * Загрузка задач из файла, если файл существует
 * @var array<int, array> $tasks
 */
if (file_exists($file)) {
    $content = file_get_contents($file);
    $tasks = json_decode($content, true) ?? [];
}

// Подсчёт общего количества страниц
$totalTasks = count($tasks);
$totalPages = (int) ceil($totalTasks / $perPage);

// Задачи на текущей странице
$tasks = array_reverse($tasks); // новые выше
$tasksOnPage = array_slice($tasks, $startIndex, $perPage);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Список задач</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <div class="task-container">
    <h1>Все задачи</h1>

    <?php if (empty($tasksOnPage)): ?>
      <p>Задачи отсутствуют.</p>
    <?php else: ?>
      <ul>
        <?php foreach ($tasksOnPage as $task): ?>
          <li>
            <strong><?= htmlspecialchars($task['title']) ?></strong><br>
            Категория: <?= htmlspecialchars($task['category']) ?><br>
            Описание: <?= nl2br(htmlspecialchars($task['description'])) ?><br>
            <?php if (!empty($task['tags'])): ?>
              Теги: <?= implode(', ', $task['tags']) ?><br>
            <?php endif; ?>
            <?php if (!empty($task['steps'])): ?>
              <details>
                <summary>Шаги</summary>
                <ol>
                  <?php foreach ($task['steps'] as $step): ?>
                    <li><?= htmlspecialchars($step) ?></li>
                  <?php endforeach; ?>
                </ol>
              </details>
            <?php endif; ?>
            <hr>
          </li>
        <?php endforeach; ?>
      </ul>

      <!-- Пагинация -->
      <?php if ($totalPages > 1): ?>
        <div class="pagination">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i === $page): ?>
              <strong><?= $i ?></strong>
            <?php else: ?>
              <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <br>
    <a href="/index.php">На главную</a> | 
    <a href="/task/create.php">Добавить задачу</a>
  </div>
</body>
</html>
```
## Документация кода
Код корректно задокументирован, используя стандарт `PHPDoc`. Каждая функция и метод описаны с указанием их входных параметров, выходных данных и описанием функционала. Комментарии понятные, четкие и информативные, чтобы обеспечить понимание работы кода другим разработчикам.

## Контрольные вопросы

1. Какие методы HTTP применяются для отправки данных формы?<br>
Для отправки данных формы в HTML чаще всего используются два метода HTTP — GET и POST. Метод GET передаёт данные через URL, добавляя их в строку запроса после знака вопроса. Метод POST, напротив, передаёт данные в теле запроса, что делает его более безопасным и позволяет отправлять большие объёмы информации.
2. Что такое валидация данных, и чем она отличается от фильтрации?<br>
Валидация данных — это процесс проверки, соответствуют ли введённые пользователем данные определённым правилам или требованиям. Фильтрация данных — это процесс очистки или преобразования введённых данных для повышения безопасности и удобства работы с ними. Главное отличие между ними заключается в цели:
валидация проверяет корректность данных, а фильтрация — очищает и подготавливает данные к использованию.
3. Какие функции PHP используются для фильтрации данных?<br>
В PHP для фильтрации данных часто используются встроенные функции из расширения filter, в первую очередь — filter_var() и filter_input(). Также можно использовать функции htmlspecialchars(), strip_tags(), trim()
