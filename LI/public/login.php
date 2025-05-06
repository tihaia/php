<?php require_once __DIR__ . '/../templates/header.php'; ?>

<h2>Вход в систему</h2>
<form action="/actions/login_handler.php" method="POST">
  <label>Имя пользователя или Email:</label>
  <input type="text" name="login" required><br>

  <label>Пароль:</label>
  <input type="password" name="password" required><br>

  <button type="submit">Войти</button>
</form>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
