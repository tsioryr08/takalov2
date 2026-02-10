<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function cls_invalid($errors, $field){ return ($errors[$field] ?? '') !== '' ? 'is-invalid' : ''; }
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Metis</title>
    <link rel="icon" type="image/svg+xml" href="/assets/favicon-CvUZKS4z.svg">
    <link rel="stylesheet" crossorigin href="/assets/main-CFKPan32.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" crossorigin src="/assets/vendor-bootstrap-C9iorZI5.js"></script>
</head>
<body class="auth-page bg-image" style="background: linear-gradient(180deg,#0e1726 0%, #0b1220 100%); min-height:100vh;">
  <div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">
      <div class="card shadow-lg">
        <div class="card-body p-4">
          <div class="text-center mb-4">
            <img src="data:image/svg+xml,%3csvg%20width='48'%20height='48'%20viewBox='0%200%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3ccircle%20cx='16'%20cy='16'%20r='16'%20fill='%236366f1'/%3e%3c/svg%3e" alt="Logo" class="mb-2">
            <h1 class="h5 mb-0 fw-bold text-center">Connexion</h1>
            <p class="text-muted small">Connectez-vous pour accéder à la messagerie</p>
          </div>

          <?php if (($errors['_global'] ?? '') !== ''): ?>
            <div class="alert alert-danger"><?= e($errors['_global']) ?></div>
          <?php endif; ?>

          <form method="post" action="/login" novalidate>
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                  <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control <?= cls_invalid($errors,'email') ?>"
                    placeholder="Enter email"
                    value="<?= e($values['email'] ?? '') ?>"
                    required
                  >
                </div>
                <div class="invalid-feedback"><?= e($errors['email'] ?? '') ?></div>
              </div>

              <div class="col-12">
                <label class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock"></i></span>
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control <?= cls_invalid($errors,'password') ?>"
                    placeholder="Enter password"
                    required
                  >
                  <button type="button" class="btn btn-outline-secondary" id="togglePassword" aria-label="Toggle password visibility">
                    <i id="toggleIcon" class="bi bi-eye"></i>
                  </button>
                </div>
                <div class="invalid-feedback"><?= e($errors['password'] ?? '') ?></div>

              
                <div class="password-strength mt-2" id="passwordStrengthWrap" style="display:none;">
                  <div class="strength-bar bg-light rounded-1" style="height:8px; overflow:hidden;">
                    <div id="strengthFill" class="strength-fill bg-danger" style="width:0%; height:100%; transition:width .2s"></div>
                  </div>
                  <small id="strengthText" class="d-block mt-1 text-danger">Password strength: Faible</small>
                </div>
              </div>

              <div class="col-12">
                <div class="d-grid mt-2">
                  <button class="btn btn-success btn-lg" type="submit">Se connecter</button>
                </div>
              </div>
            </div>
          </form>

          <div class="text-center mt-3">
            <a href="/register" class="text-decoration-none">Pas encore de compte ? S'inscrire</a>
          </div>
        </div>
      </div>
      <p class="text-center text-muted small mt-3">&copy; <?= date('Y') ?> Metis — Prototype</p>
    </div>
  </div>

  <script type="module" crossorigin src="/assets/vendor-ui-CflGdlft.js"></script>
</body>
</html>

