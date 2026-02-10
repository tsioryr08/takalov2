<?php
ob_start();
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 style="font-size: 2.25rem; font-weight: 600;">
            <i class="fas fa-tachometer-alt"></i> Tableau de bord
        </h2>
        <div>
            <span class="badge-custom" style="padding: 0.6rem 1.25rem; font-size: 0.95rem;">
                <i class="fas fa-user"></i> 
                <?php echo htmlspecialchars($admin['admin_prenom'] . ' ' . $admin['admin_nom']); ?>
            </span>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card h-100" style="background-color: var(--white); border-left: 4px solid var(--beige-primary);">
                <div class="card-body text-center p-4">
                    <div style="font-size: 3rem; color: var(--beige-primary); margin-bottom: 1rem;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="card-title mb-2" style="font-weight: 500; color: var(--text-medium);">Utilisateurs</h5>
                    <h2 class="mb-0" style="font-weight: 600; font-size: 2.5rem;"><?php echo $stats['users']; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100" style="background-color: var(--white); border-left: 4px solid var(--beige-primary);">
                <div class="card-body text-center p-4">
                    <div style="font-size: 3rem; color: var(--beige-primary); margin-bottom: 1rem;">
                        <i class="fas fa-folder"></i>
                    </div>
                    <h5 class="card-title mb-2" style="font-weight: 500; color: var(--text-medium);">Catégories</h5>
                    <h2 class="mb-0" style="font-weight: 600; font-size: 2.5rem;"><?php echo $stats['categories']; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100" style="background-color: var(--white); border-left: 4px solid var(--beige-primary);">
                <div class="card-body text-center p-4">
                    <div style="font-size: 3rem; color: var(--beige-primary); margin-bottom: 1rem;">
                        <i class="fas fa-box"></i>
                    </div>
                    <h5 class="card-title mb-2" style="font-weight: 500; color: var(--text-medium);">Objets</h5>
                    <h2 class="mb-0" style="font-weight: 600; font-size: 2.5rem;"><?php echo $stats['objets']; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100" style="background-color: var(--white); border-left: 4px solid var(--beige-primary);">
                <div class="card-body text-center p-4">
                    <div style="font-size: 3rem; color: var(--beige-primary); margin-bottom: 1rem;">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h5 class="card-title mb-2" style="font-weight: 500; color: var(--text-medium);">Propositions</h5>
                    <h2 class="mb-0" style="font-weight: 600; font-size: 2.5rem;"><?php echo $stats['propositions']; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="card" style="border: 2px solid var(--beige-light);">
        <div class="card-body p-5">
            <h4 style="font-weight: 600; margin-bottom: 2rem; font-size: 1.5rem;">
                <i class="fas fa-cog"></i> Actions rapides
            </h4>
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="/admin/categories" class="btn btn-primary w-100 py-3" style="font-size: 1rem;">
                        <i class="fas fa-folder"></i> Gérer les catégories
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/admin/users" class="btn btn-outline-secondary w-100 py-3" style="font-size: 1rem;">
                        <i class="fas fa-users"></i> Gérer les utilisateurs
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/admin/objets" class="btn btn-outline-secondary w-100 py-3" style="font-size: 1rem;">
                        <i class="fas fa-box"></i> Gérer les objets
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Dashboard Admin - Takalo-takalo';
require __DIR__ . '/../layouts/main.php';
?>