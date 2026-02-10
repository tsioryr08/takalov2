<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function cls_invalid($errors, $field){ return ($errors[$field] ?? '') !== '' ? 'is-invalid' : ''; }
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Metis</title>
    <link rel="icon" type="image/svg+xml" href="/assets/favicon-CvUZKS4z.svg">
    <link rel="stylesheet" crossorigin href="/assets/main-CFKPan32.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" crossorigin src="/assets/vendor-bootstrap-C9iorZI5.js"></script>
</head>
<body class="auth-page bg-image" style="background: linear-gradient(180deg,#0e1726 0%, #0b1220 100%); min-height:100vh;">
  <div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <div class="card shadow-lg">
        <div class="card-body p-4">
          <div class="text-center mb-4">
            <img src="data:image/svg+xml,%3csvg%20width='48'%20height='48'%20viewBox='0%200%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3ccircle%20cx='16'%20cy='16'%20r='16'%20fill='%236366f1'/%3e%3c/svg%3e" alt="Logo" class="mb-2">
            <h1 class="h5 mb-0 fw-bold text-center">Inscription</h1>
            <p class="text-muted small">Créez un compte pour utiliser la messagerie</p>
          </div>

          <?php if (!empty($success)): ?>
            <div class="alert alert-success">Inscription réussie ✅</div>
          <?php endif; ?>

          <form id="registerForm" method="post" action="/register" novalidate>
            <div id="formStatus" class="alert d-none"></div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input id="nom" name="nom" class="form-control <?= cls_invalid($errors,'nom') ?>" value="<?= e($values['nom'] ?? '') ?>">
                <div class="invalid-feedback" id="nomError"><?= e($errors['nom'] ?? '') ?></div>
              </div>

              <div class="col-md-6 mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input id="prenom" name="prenom" class="form-control <?= cls_invalid($errors,'prenom') ?>" value="<?= e($values['prenom'] ?? '') ?>">
                <div class="invalid-feedback" id="prenomError"><?= e($errors['prenom'] ?? '') ?></div>
              </div>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input id="email" name="email" type="email" class="form-control <?= cls_invalid($errors,'email') ?>" value="<?= e($values['email'] ?? '') ?>">
              <div class="invalid-feedback" id="emailError"><?= e($errors['email'] ?? '') ?></div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" name="password" type="password" class="form-control <?= cls_invalid($errors,'password') ?>">
                <div class="invalid-feedback" id="passwordError"><?= e($errors['password'] ?? '') ?></div>
              </div>

              <div class="col-md-6 mb-3">
                <label for="confirm_password" class="form-label">Confirmation</label>
                <input id="confirm_password" name="confirm_password" type="password" class="form-control <?= cls_invalid($errors,'confirm_password') ?>">
                <div class="invalid-feedback" id="confirmPasswordError"><?= e($errors['confirm_password'] ?? '') ?></div>
              </div>
            </div>

            <div class="mb-3">
              <label for="telephone" class="form-label">Téléphone</label>
              <input id="telephone" name="telephone" class="form-control <?= cls_invalid($errors,'telephone') ?>" value="<?= e($values['telephone'] ?? '') ?>">
              <div class="invalid-feedback" id="telephoneError"><?= e($errors['telephone'] ?? '') ?></div>
            </div>

            <div class="d-grid">
              <button class="btn btn-primary btn-lg" type="submit">S'inscrire</button>
            </div>
          </form>

          <div class="text-center mt-3">
            <a href="/login" class="text-decoration-none">Déjà un compte ? Se connecter</a>
          </div>

          <script src="/js/validation-ajax.js" defer></script>
        </div>
      </div>
      <p class="text-center text-muted small mt-3">&copy; <?= date('Y') ?> Metis — Prototype</p>
    </div>
  </div>

  <script type="module" crossorigin src="/assets/vendor-ui-CflGdlft.js"></script>
</body>
</html>
