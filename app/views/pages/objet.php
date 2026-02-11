<?php
ob_start();
$objets = $objets ?? [];
$success = $success ?? null;
$error = $error ?? null;
?>

<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 style="font-size: 2rem; font-weight: 600; margin-bottom: 0.5rem;">
                <i class="fas fa-box" style="color: var(--beige-accent);"></i> Mes Objets
            </h1>
            <p style="color: var(--text-medium); margin: 0;">Gérez vos objets pour l'échange</p>
        </div>
        <a href="/pages/objet/create" class="btn btn-primary btn-lg" style="padding: 0.75rem 1.5rem;">
            <i class="fas fa-plus"></i> Ajouter un objet
        </a>
    </div>

    <!-- Messages de succès/erreur -->
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Liste des objets -->
    <?php if (empty($objets)): ?>
        <div class="card" style="box-shadow: 0 4px 16px var(--shadow);">
            <div class="card-body p-5 text-center">
                <i class="fas fa-box-open" style="font-size: 5rem; color: var(--beige-accent); margin-bottom: 2rem;"></i>
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Aucun objet pour le moment</h3>
                <p style="color: var(--text-medium); font-size: 1.1rem; margin-bottom: 2rem;">
                    Commencez par ajouter votre premier objet à échanger !
                </p>
                <a href="/pages/objet/create" class="btn btn-primary btn-lg" style="padding: 1rem 2rem;">
                    <i class="fas fa-plus"></i> Ajouter mon premier objet
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($objets as $objet): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 objet-card" style="box-shadow: 0 2px 8px var(--shadow); transition: all 0.3s;">
                        <!-- Images de l'objet -->
                        <?php if (!empty($objet['images'])): ?>
                            <div id="carousel-<?php echo $objet['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner" style="border-radius: 8px 8px 0 0; height: 250px; background: var(--beige-light);">
                                    <?php foreach ($objet['images'] as $index => $img): ?>
                                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>" style="height: 250px;">
                                            <img src="<?php echo htmlspecialchars($img['url']); ?>" 
                                                 class="d-block w-100" 
                                                 style="height: 250px; object-fit: cover;">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($objet['images']) > 1): ?>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $objet['id']; ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $objet['id']; ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                    <!-- Indicateurs -->
                                    <div class="carousel-indicators">
                                        <?php foreach ($objet['images'] as $index => $img): ?>
                                            <button type="button" 
                                                    data-bs-target="#carousel-<?php echo $objet['id']; ?>" 
                                                    data-bs-slide-to="<?php echo $index; ?>" 
                                                    <?php echo $index === 0 ? 'class="active"' : ''; ?>></button>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div style="height: 250px; background: linear-gradient(135deg, var(--beige-light) 0%, var(--beige-accent) 100%); display: flex; align-items: center; justify-content: center; border-radius: 8px 8px 0 0;">
                                <i class="fas fa-image" style="font-size: 4rem; color: var(--text-medium); opacity: 0.3;"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body p-4">
                            <!-- Badge statut -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge" style="background-color: <?php echo $objet['disponible'] ? '#28a745' : '#6c757d'; ?>; font-size: 0.85rem;">
                                    <?php echo $objet['disponible'] ? 'Disponible' : 'Non disponible'; ?>
                                </span>
                                <span class="badge" style="background-color: var(--beige-accent); color: var(--brown-dark); font-size: 0.85rem;">
                                    <?php 
                                        $etats = [
                                            'neuf' => 'Neuf',
                                            'tres_bon' => 'Très bon',
                                            'bon' => 'Bon',
                                            'moyen' => 'Moyen',
                                            'usage' => 'Usagé'
                                        ];
                                        echo $etats[$objet['etat_objet']] ?? $objet['etat_objet'];
                                    ?>
                                </span>
                            </div>

                            <!-- Nom -->
                            <h4 style="font-weight: 600; margin-bottom: 0.75rem; font-size: 1.35rem;">
                                <?php echo htmlspecialchars($objet['nom']); ?>
                            </h4>

                            <!-- Catégorie -->
                            <?php if ($objet['categorie_nom']): ?>
                                <p style="color: var(--text-medium); font-size: 0.9rem; margin-bottom: 0.75rem;">
                                    <i class="fas fa-tag"></i> <?php echo htmlspecialchars($objet['categorie_nom']); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Prix estimé -->
                            <?php if (isset($objet['prix_estime']) && $objet['prix_estime']): ?>
                                <p style="color: var(--brown-dark); font-size: 1rem; margin-bottom: 0.75rem; font-weight: 600;">
                                    <i class="fas fa-money-bill-wave"></i> <?php echo number_format($objet['prix_estime'], 2, ',', ' '); ?> Ar
                                </p>
                            <?php endif; ?>

                            <!-- Description -->
                            <?php if ($objet['description']): ?>
                                <p style="color: var(--text-medium); margin-bottom: 1rem; font-size: 0.95rem; line-height: 1.5;">
                                    <?php 
                                        $desc = $objet['description'];
                                        echo nl2br(htmlspecialchars(mb_strlen($desc) > 120 ? mb_substr($desc, 0, 120) . '...' : $desc)); 
                                    ?>
                                </p>
                            <?php endif; ?>

                            <!-- Actions -->
                            <div class="d-flex gap-2 mt-3">
                                <a href="/pages/objet/edit/<?php echo $objet['id']; ?>" 
                                   class="btn btn-sm btn-outline-primary flex-fill"
                                   style="border-width: 2px; padding: 0.5rem;">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <form method="POST" 
                                      action="/pages/objet/delete/<?php echo $objet['id']; ?>" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet objet ?');"
                                      class="flex-fill">
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger w-100"
                                            style="border-width: 2px; padding: 0.5rem;">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>

                            <!-- Date -->
                            <p style="color: var(--text-medium); font-size: 0.85rem; margin-top: 1rem; margin-bottom: 0;">
                                <i class="fas fa-clock"></i> Ajouté le <?php echo date('d/m/Y', strtotime($objet['date_creation'])); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.objet-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px var(--shadow) !important;
}

.btn-outline-primary:hover {
    background-color: var(--brown-dark);
    border-color: var(--brown-dark);
    color: white;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.carousel-control-prev,
.carousel-control-next {
    opacity: 0;
    transition: opacity 0.3s;
}

.card:hover .carousel-control-prev,
.card:hover .carousel-control-next {
    opacity: 1;
}
</style>

<?php
$content = ob_get_clean();
$title = 'Mes Objets - Takalo-takalo';
require __DIR__ . '/../layouts/main.php';
?>
