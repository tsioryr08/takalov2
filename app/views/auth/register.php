<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function cls_invalid($errors, $field){ return ($errors[$field] ?? '') !== '' ? 'is-invalid' : ''; }
ob_start();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card" style="box-shadow: 0 4px 16px var(--shadow);">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div style="font-size: 4rem; color: var(--beige-accent); margin-bottom: 1rem;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h2 style="font-size: 2rem; font-weight: 600; margin-bottom: 0.5rem;">Inscription</h2>
                        <p style="color: var(--text-medium); font-size: 1rem;">Créez un compte pour utiliser la messagerie</p>
                    </div>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success mb-4" role="alert">
                            <i class="fas fa-check-circle"></i> Inscription réussie ! Vous pouvez maintenant <a href="/auth/login" class="alert-link">vous connecter</a>.
                        </div>
                    <?php endif; ?>

                    <form id="registerForm" method="post" action="/register" novalidate>
                        <div id="formStatus" class="alert d-none"></div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label" style="font-weight: 500;">
                                    <i class="fas fa-user"></i> Nom
                                </label>
                                <input id="nom" 
                                       name="nom" 
                                       class="form-control form-control-lg <?= cls_invalid($errors,'nom') ?>" 
                                       value="<?= e($values['nom'] ?? '') ?>"
                                       style="border: 2px solid var(--beige-light); border-radius: 8px;">
                                <div class="invalid-feedback" id="nomError"><?= e($errors['nom'] ?? '') ?></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label" style="font-weight: 500;">
                                    <i class="fas fa-user"></i> Prénom
                                </label>
                                <input id="prenom" 
                                       name="prenom" 
                                       class="form-control form-control-lg <?= cls_invalid($errors,'prenom') ?>" 
                                       value="<?= e($values['prenom'] ?? '') ?>"
                                       style="border: 2px solid var(--beige-light); border-radius: 8px;">
                                <div class="invalid-feedback" id="prenomError"><?= e($errors['prenom'] ?? '') ?></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label" style="font-weight: 500;">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   class="form-control form-control-lg <?= cls_invalid($errors,'email') ?>" 
                                   value="<?= e($values['email'] ?? '') ?>"
                                   style="border: 2px solid var(--beige-light); border-radius: 8px;">
                            <div class="invalid-feedback" id="emailError"><?= e($errors['email'] ?? '') ?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label" style="font-weight: 500;">
                                    <i class="fas fa-lock"></i> Mot de passe
                                </label>
                                <input id="password" 
                                       name="password" 
                                       type="password" 
                                       class="form-control form-control-lg <?= cls_invalid($errors,'password') ?>"
                                       style="border: 2px solid var(--beige-light); border-radius: 8px;">
                                <div class="invalid-feedback" id="passwordError"><?= e($errors['password'] ?? '') ?></div>
                                <small class="form-text text-muted">Minimum 8 caractères</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label" style="font-weight: 500;">
                                    <i class="fas fa-lock"></i> Confirmation
                                </label>
                                <input id="confirm_password" 
                                       name="confirm_password" 
                                       type="password" 
                                       class="form-control form-control-lg <?= cls_invalid($errors,'confirm_password') ?>"
                                       style="border: 2px solid var(--beige-light); border-radius: 8px;">
                                <div class="invalid-feedback" id="confirmPasswordError"><?= e($errors['confirm_password'] ?? '') ?></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="telephone" class="form-label" style="font-weight: 500;">
                                <i class="fas fa-phone"></i> Téléphone
                            </label>
                            <input id="telephone" 
                                   name="telephone" 
                                   class="form-control form-control-lg <?= cls_invalid($errors,'telephone') ?>" 
                                   value="<?= e($values['telephone'] ?? '') ?>"
                                   placeholder="0123456789"
                                   style="border: 2px solid var(--beige-light); border-radius: 8px;">
                            <div class="invalid-feedback" id="telephoneError"><?= e($errors['telephone'] ?? '') ?></div>
                        </div>

                        <button class="btn btn-primary btn-lg w-100 mb-3" type="submit" style="padding: 1rem; font-size: 1.05rem;">
                            <i class="fas fa-user-plus"></i> S'inscrire
                        </button>

                        <div class="text-center">
                            <p class="mb-0" style="color: var(--text-medium);">
                                Déjà un compte ?
                                <a href="/auth/login" style="color: var(--brown-dark); font-weight: 600; text-decoration: none;">
                                    Se connecter
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/" style="color: var(--text-medium); text-decoration: none; font-weight: 500;">
                    <i class="fas fa-arrow-left"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>

<script src="/js/validation-ajax.js" defer></script>

<?php
$content = ob_get_clean();
$title = 'Inscription - Takalo-takalo';
require __DIR__ . '/../layouts/main.php';
?>
