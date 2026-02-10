<?php
ob_start();
?>

<!-- Ajouter une police cursive depuis Google Fonts (ex: Dancing Script) -->
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

<div class="container">
    <div class="text-center mb-5" style="padding-top: 2rem;">
        <div style="font-size: 5rem; color: var(--beige-accent); margin-bottom: 1.5rem;">
            <i class="fas fa-exchange-alt"></i>
        </div>
        <h1 style="font-size: 3rem; font-weight: 600; margin-bottom: 1rem;">
            Bienvenue sur 
            <span style="font-family: 'Dancing Script', cursive; color: var(--brown-dark); font-weight: 700; font-size: 3.5rem;">
                Takalo-Takalo
            </span>
        </h1>
        <p class="lead" style="color: var(--text-medium); font-size: 1.25rem; max-width: 600px; margin: 0 auto;">
            Plateforme d'échange d'objets entre particuliers
        </p>
    </div>

    <div class="row justify-content-center g-4" style="max-width: 1000px; margin: 0 auto;">
        <!-- Carte Admin -->
        <div class="col-md-6">
            <a href="/admin/login" style="text-decoration: none;">
                <div class="card h-100 hover-card" style="cursor: pointer;">
                    <div class="card-body text-center p-5">
                        <div style="font-size: 4rem; color: var(--beige-accent); margin-bottom: 1.5rem;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h3 class="card-title mb-3" style="font-size: 1.75rem; font-weight: 600;">
                            Administration
                        </h3>
                        <p class="card-text mb-4" style="color: var(--text-medium); font-size: 1rem; line-height: 1.6;">
                            Accès au backoffice et gestion complète de la plateforme
                        </p>
                        <span class="badge-custom">
                            <i class="fas fa-bolt"></i> Connexion rapide
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Carte Utilisateur -->
        <div class="col-md-6">
            <div class="card h-100" style="opacity: 0.6; cursor: not-allowed;">
                <div class="card-body text-center p-5">
                    <div style="font-size: 4rem; color: var(--text-medium); margin-bottom: 1.5rem;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="card-title mb-3" style="font-size: 1.75rem; font-weight: 600; color: var(--text-medium);">
                        Espace Utilisateur
                    </h3>
                    <p class="card-text mb-4" style="color: var(--text-medium); font-size: 1rem; line-height: 1.6;">
                        Inscription et connexion pour échanger vos objets
                    </p>
                    <span class="badge bg-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <i class="fas fa-clock"></i> Prochainement
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px var(--shadow) !important;
}

.hover-card:hover .fas {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}
</style>

<?php
$content = ob_get_clean();
$title = 'Accueil - Takalo-takalo';
require __DIR__ . '/layouts/main.php';
?>