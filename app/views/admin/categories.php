<?php
ob_start();
?>

<div class="container" style="max-width: 1100px;">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-size: 2rem; font-weight: 500; font-family:'Georgia', serif;">
            Gestion des Catégories
        </h2>
        <a href="/admin" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Retour au dashboard
        </a>
    </div>


    <div class="card mb-4" style="border: 2px solid var(--beige-accent);">
        <div class="card-body p-4">
            <h5 style="font-weight: 600; margin-bottom: 1.5rem;">
                <i class="fas fa-plus-circle" style="color: var(--beige-accent);"></i> Ajouter une nouvelle catégorie
            </h5>
            <form method="POST" action="/admin/categories">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label for="name" class="form-label" style="font-weight: 500;">Nom de la catégorie </label>
                        <input type="text" 
                               class="form-control form-control-lg" 
                               id="name" 
                               name="name" 
                               placeholder="Ex: Électronique" 
                               required
                               style="border: 2px solid var(--beige-light); border-radius: 8px;">
                    </div>
                    <div class="col-md-5">
                        <label for="description" class="form-label" style="font-weight: 500;">Description</label>
                        <input type="text" 
                               class="form-control form-control-lg" 
                               id="description" 
                               name="description" 
                               placeholder="Ex: Appareils électroniques"
                               style="border: 2px solid var(--beige-light); border-radius: 8px;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="opacity: 0;">Actions</label>
                        <button type="submit" class="btn btn-primary w-100 btn-lg" style="border-radius: 8px; padding: 0.75rem;">
                            <i class="fas fa-plus"></i> Ajouter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card" style="border: 2px solid var(--beige-light);">
        <div class="card-body p-4">
            <h5 style="font-weight: 600; margin-bottom: 1.5rem;">
                <i class="fas fa-list"></i> Liste des catégories
            </h5>
            
            <?php if (empty($categories)): ?>
                <div class="alert alert-info" style="text-align: center; padding: 2rem;">
                    <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                    <p style="margin: 0; font-size: 1.1rem;">Aucune catégorie pour le moment. Ajoutez-en une ci-dessus !</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background-color: var(--beige-light);">
                            <tr>
                              
                                <th style="padding: 1rem; font-weight: 600;">Nom</th>
                                <th style="padding: 1rem; font-weight: 600;">Description</th>
                                <th style="padding: 1rem; font-weight: 600; text-align: center; width: 120px;">Objets</th>
                                <th style="padding: 1rem; font-weight: 600; text-align: center; width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                            <tr style="border-bottom: 1px solid var(--beige-light);">
                                
                                <td style="padding: 1rem; font-weight: 600;">
                                    <?php echo htmlspecialchars($cat['nom']); ?>
                                </td>
                                <td style="padding: 1rem; color: var(--text-medium);">
                                    <?php echo htmlspecialchars($cat['description'] ?? '-'); ?>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span class="badge" style="background-color: var(--beige-accent); color: var(--text-dark); font-size: 0.9rem; padding: 0.4rem 0.8rem;">
                                        <?php echo htmlspecialchars($cat['objets'] ?? 0); ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <a href="/admin/categories/edit/<?php echo $cat['id']; ?>" 
                                       class="btn btn-sm btn-outline-secondary me-1"
                                       style="border-radius: 6px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" 
                                          action="/admin/categories/delete/<?php echo $cat['id']; ?>" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                                        <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 6px;">
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Gestion Catégories - Takalo-takalo';
require __DIR__ . '/../layouts/main.php';
?>
