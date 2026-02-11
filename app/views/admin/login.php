<?php ob_start(); ?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h1 class="card-title text-center mb-4">Backoffice (Admin)</h1>

          <?php if (!empty($errors['_global'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($errors['_global'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>

          <form method="post" action="/admin/login">
            <div class="mb-3">
              <label class="form-label">Login:</label>
              <input type="text" name="login" class="form-control" value="<?php echo htmlspecialchars($values['login'] ?? 'Backoffice', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Password:</label>
              <input type="password" name="password" class="form-control" value="<?php echo htmlspecialchars($values['password'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
          </form>

          <div class="text-center mt-3">
            <a href="/" class="text-muted">← Retour à l'accueil</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layouts/main.php'; ?>
