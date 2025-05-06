<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/mysql.php';

if (!$isAuthenticated || !isAdmin()) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/../templates/header.php';

// Получаем всех пользователей
$stmt = $pdo->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>

<h2>Админ-панель: Пользователи</h2>

<table border="1" cellpadding="8" cellspacing="0">
  <thead>
    <tr>
      <th>ID</th>
      <th>Имя</th>
      <th>Email</th>
      <th>Роль</th>
      <th>Дата регистрации</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= $user['role'] === 'admin' ? 'Админ' : 'Пользователь' ?></td>
        <td><?= $user['created_at'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
