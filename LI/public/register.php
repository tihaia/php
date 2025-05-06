<?php require_once __DIR__ . '/../templates/header.php'; ?>

<h2>Регистрация</h2>
<form action="/actions/register_handler.php" method="POST">
  <label>Имя пользователя:</label>
  <input type="text" name="username" required><br>

  <label>Email:</label>
  <input type="email" name="email" required><br>

  <label>Пароль:</label>
  <input type="password" name="password" required><br>

  <label>Подтверждение пароля:</label>
  <input type="password" name="confirm_password" required><br>

  <button type="submit">Зарегистрироваться</button>
</form>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
