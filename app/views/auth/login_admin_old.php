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
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h2 style="font-size: 2rem; font-weight: 600; margin-bottom: 0.5rem;">Administration</h2>
                        <p style="color: var(--text-medium); font-size: 1rem;">Accès au backoffice</p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger mb-4" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/admin/login">
                        <div class="mb-4">
                            <label for="email" class="form-label" style="font-weight: 500; color: var(--text-dark); margin-bottom: 0.75rem;">
                                <i class="fas fa-envelope"></i> Adresse email
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo htmlspecialchars($default_email); ?>"
                                   required
                                   style="border: 2px solid var(--beige-light); border-radius: 8px; padding: 0.75rem 1rem;">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label" style="font-weight: 500; color: var(--text-dark); margin-bottom: 0.75rem;">
                                <i class="fas fa-lock"></i> Mot de passe
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control form-control-lg" 
                                       id="password" 
                                       name="password" 
                                       value="admin"
                                       required
                                       style="border: 2px solid var(--beige-light); border-radius: 8px 0 0 8px; padding: 0.75rem 1rem; border-right: none;">
                                <button class="btn" type="button" onclick="togglePassword()" 
                                        style="background-color: var(--white); border: 2px solid var(--beige-light); border-left: none; border-radius: 0 8px 8px 0; padding: 0 1rem;">
                                    <i class="fas fa-eye" id="toggleIcon" style="color: var(--text-medium);"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-4" style="padding: 1rem; font-size: 1.05rem; background-color: #7a4a2e; border-color: #6a4026;">
                            <i class="fas fa-sign-in-alt"></i> Se connecter
                        </button>

                      
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

<!-- <script>
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
</script> -->

<?php
$content = ob_get_clean();
$title = 'Connexion utilisateurs - Takalo-takalo';
require __DIR__ . '/../layouts/main.php';
?>