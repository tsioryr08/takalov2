<?php
ob_start();
?>

<div class="container" style="max-width: 700px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-size: 2rem; font-weight: 500;">
            <i class="fas fa-edit"></i> Modifier une catégorie
        </h2>
        <a href="/admin/categories" class="btn btn-outline-secondary">
            <i class="fas fa-times"></i> Annuler
        </a>
    </div>

    <!-- Formulaire pour notre update-->
    <div class="card" style="border: 2px solid var(--beige-accent);">
        <div class="card-body p-5">
            <form method="POST" action="/admin/categories/edit/<?php echo htmlspecialchars($category['id']); ?>">
                <div class="mb-4">
                    <label for="name" class="form-label" style="font-weight: 600; font-size: 1rem;">
                        <i class="fas fa-tag"></i> Nom de la catégorie 
                    </label>
                    <input type="text" 
                           class="form-control form-control-lg" 
                           id="name" 
                           name="name" 
                           value="<?php echo htmlspecialchars($category['nom']); ?>"
                           required
                           style="border: 2px solid var(--beige-light); border-radius: 8px; font-size: 1.1rem; padding: 1rem;">
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label" style="font-weight: 600; font-size: 1rem;">
                        <i class="fas fa-align-left"></i> Description
                    </label>
                    <textarea class="form-control form-control-lg" 
                              id="description" 
                              name="description" 
                              rows="3"
                              style="border: 2px solid var(--beige-light); border-radius: 8px; font-size: 1rem; padding: 1rem;"
                              placeholder="Description de la catégorie (optionnel)"><?php echo htmlspecialchars($category['description'] ?? ''); ?></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg" style="padding: 1rem; font-size: 1.1rem; border-radius: 8px;background-color: #8d6045;">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                    <a href="/admin/categories" class="btn btn-outline-secondary btn-lg" style="padding: 1rem; font-size: 1rem; border-radius: 8px;">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                </div>
            </form>
        </div>
    </div>

   
</div>

<?php
$content = ob_get_clean();
$title = 'Modifier Catégorie - Takalo-takalo';
require __DIR__ . '/../layouts/main.php';
?>
