<?php
ob_start();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card" style="box-shadow: 0 4px 16px var(--shadow);">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div style="font-size: 4rem; color: var(--beige-accent); margin-bottom: 1rem;">
                            <i class="fas fa-users"></i>
                        </div>
                        <h2 style="font-size: 2rem; font-weight: 600; margin-bottom: 0.5rem;">Connexion Utilisateur</h2>
                        <p style="color: var(--text-medium); font-size: 1rem;">Accédez à la messagerie</p>
                    </div>

                    <?php if (!empty($errors['_global'])): ?>
                        <div class="alert alert-danger mb-4" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($errors['_global']); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/auth/login">
                        <div class="mb-4">
                            <label for="email" class="form-label" style="font-weight: 500; color: var(--text-dark); margin-bottom: 0.75rem;">
                                <i class="fas fa-envelope"></i> Adresse email
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg <?php echo !empty($errors['email']) ? 'is-invalid' : ''; ?>" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo htmlspecialchars($values['email'] ?? ''); ?>"
                                   required
                                   style="border: 2px solid var(--beige-light); border-radius: 8px; padding: 0.75rem 1rem;">
                            <?php if (!empty($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo htmlspecialchars($errors['email']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label" style="font-weight: 500; color: var(--text-dark); margin-bottom: 0.75rem;">
                                <i class="fas fa-lock"></i> Mot de passe
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control form-control-lg <?php echo !empty($errors['password']) ? 'is-invalid' : ''; ?>"
                                       id="password" 
                                       name="password" 
                                       required
                                       style="border: 2px solid var(--beige-light); border-radius: 8px 0 0 8px; padding: 0.75rem 1rem;">
                                <button class="btn" type="button" onclick="togglePassword()" 
                                        style="background-color: var(--white); border: 2px solid var(--beige-light); border-left: none; border-radius: 0 8px 8px 0; padding: 0 1rem;">
                                    <i class="fas fa-eye" id="toggleIcon" style="color: var(--text-medium);"></i>
                                </button>
                            </div>
                            <?php if (!empty($errors['password'])): ?>
                                <div class="text-danger small mt-1">
                                    <?php echo htmlspecialchars($errors['password']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-4" style="padding: 1rem; font-size: 1.05rem;">
                            <i class="fas fa-sign-in-alt"></i> Se connecter
                        </button>

                        <div class="text-center">
                            <p class="mb-0" style="color: var(--text-medium);">
                                Pas encore de compte ?
                                <a href="/register" style="color: var(--brown-dark); font-weight: 600; text-decoration: none;">
                                    S'inscrire
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

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>

<?php
$content = ob_get_clean();
$title = 'Connexion utilisateur - Takalo-takalo';
require __DIR__ . '/../layouts/main.php';
?>
