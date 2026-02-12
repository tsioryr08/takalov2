<?php
ob_start();
?>

<div class="container" style="max-width: 900px;">

    <div class="card mb-4" style="border: 2px solid var(--beige-accent); background: linear-gradient(135deg, var(--beige-pale) 0%, var(--white) 100%);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 style="font-size: 2rem; font-weight: 600; margin-bottom: 0.5rem; font-family:'serif';">
                        Statistiques & Gestion
                    </h2>
                    <p style="color: var(--text-medium); margin: 0; font-size: 1rem;">
                        Backoffice Takalo-Takalo
                    </p>
                </div>
                <div class="text-end">
                    <h4 style="margin: 60; font-weight: 600;font-size: 1rem;">
                        <?php echo htmlspecialchars($_SESSION['admin_prenom'] ?? '') . ' ' . htmlspecialchars($_SESSION['admin_nom'] ?? ''); ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques en 3 colonnes -->
    <div class="row g-4 mb-4">
        <!-- Catégories -->
        <div class="col-md-4">
            <div class="card" style="border: 2px solid var(--beige-light);">
                <div class="card-body p-4 text-center">
                    <div style="font-size: 2.5rem; color: var(--beige-accent); margin-bottom: 1rem;">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3 style="font-size: 2.2rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">
                        <?php echo $stats['categories']; ?>
                    </h3>
                    <p style="color: var(--text-medium); font-size: 1rem; margin: 0;">
                        Catégorie(s)
                    </p>
                </div>
            </div>
        </div>

        <!-- Utilisateurs inscrits -->
        <div class="col-md-4">
            <div class="card" style="border: 2px solid var(--beige-light);">
                <div class="card-body p-4 text-center">
                    <div style="font-size: 2.5rem; color: #5B8C5A; margin-bottom: 1rem;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 style="font-size: 2.2rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">
                        <?php echo $stats['utilisateurs']; ?>
                    </h3>
                    <p style="color: var(--text-medium); font-size: 1rem; margin: 0;">
                        Utilisateur(s) inscrit(s)
                    </p>
                </div>
            </div>
        </div>

        <!-- Échanges effectués -->
        <div class="col-md-4">
            <div class="card" style="border: 2px solid var(--beige-light);">
                <div class="card-body p-4 text-center">
                    <div style="font-size: 2.5rem; color: #6B7FBD; margin-bottom: 1rem;">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h3 style="font-size: 2.2rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">
                        <?php echo $stats['echanges']; ?>
                    </h3>
                    <p style="color: var(--text-medium); font-size: 1rem; margin: 0;">
                        Échange(s) effectué(s)
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="/admin/categories" 
           class="btn btn-lg" 
           style="background-color: #8d6045; color: #FFFFFF; border: none; padding: 1.25rem 3rem; font-size: 1.15rem; font-weight: 600; border-radius: 10px; box-shadow: 0 4px 12px rgba(139, 90, 60, 0.3); transition: all 0.3s ease;"
           onmouseover="this.style.backgroundColor='#A06B4D'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(139, 90, 60, 0.4)'"
           onmouseout="this.style.backgroundColor='#8B5A3C'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(139, 90, 60, 0.3)'">
            <i class="fas fa-cog"></i> Gérer les catégories
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Dashboard Admin - Takalo-takalo';
require __DIR__ . '/../layouts/main.php';
?>
