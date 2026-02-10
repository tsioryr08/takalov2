<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Backoffice — Takalo-takalo</title>
</head>
<body>
  <h1>Backoffice (Admin)</h1>

  <?php if (!empty($errors['_global'])): ?>
    <div style="color:red"><?php echo htmlspecialchars($errors['_global'], ENT_QUOTES, 'UTF-8'); ?></div>
  <?php endif; ?>

  <form method="post" action="/admin/login">
    <div>
      <label>Login:
        <input type="text" name="login" value="<?php echo htmlspecialchars($values['login'] ?? 'Backoffice', ENT_QUOTES, 'UTF-8'); ?>">
      </label>
    </div>
    <div>
      <label>Password:
        <input type="password" name="password" value="<?php echo htmlspecialchars($values['password'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
      </label>
    </div>
    <div>
      <button type="submit">Se connecter</button>
    </div>
  </form>

  <footer style="margin-top:1em; font-size:0.9em; color:#666">Projet Takalo-takalo — Backoffice</footer>
</body>
</html>
