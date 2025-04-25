<?php if (empty($tasks)): ?>
    <p>Нет задач. Добавьте первую!</p>
<?php else: ?>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <strong><?= htmlspecialchars($task['title']) ?></strong><br>
                <small><?= nl2br(htmlspecialchars($task['description'])) ?></small><br>
                <em>Создано: <?= $task['created_at'] ?> | Статус: <?= $task['is_done'] ? '✅' : '❌' ?></em><br>
                <a href="/task/edit.php?id=<?= $task['id'] ?>">✏️</a> |
                <a href="/src/handlers/task/delete.php?id=<?= $task['id'] ?>" onclick="return confirm('Удалить задачу?')">🗑</a>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
