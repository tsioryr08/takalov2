<?php
ob_start();
$objet = $objet ?? null;
$categories = $categories ?? [];
$error = $error ?? null;
?>

<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <!-- En-tête -->
            <div class="mb-4">
                <a href="/pages/objet" style="color: var(--text-medium); text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Retour à mes objets
                </a>
            </div>

            <div class="card" style="box-shadow: 0 4px 16px var(--shadow);">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div style="font-size: 3rem; color: var(--beige-accent); margin-bottom: 1rem;">
                            <i class="fas fa-edit"></i>
                        </div>
                        <h2 style="font-size: 2rem; font-weight: 600; margin-bottom: 0.5rem;">
                            Modifier l'objet
                        </h2>
                        <p style="color: var(--text-medium);">
                            <?php echo htmlspecialchars($objet['nom'] ?? ''); ?>
                        </p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/pages/objet/edit/<?php echo $objet['id']; ?>" enctype="multipart/form-data" id="editForm">
                        <div class="mb-3">
                            <label for="nom" class="form-label" style="font-weight: 500;">
                                Nom de l'objet <span style="color: red;">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="nom" 
                                   name="nom" 
                                   value="<?php echo htmlspecialchars($objet['nom'] ?? ''); ?>"
                                   required
                                   style="border: 2px solid var(--beige-light); border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label" style="font-weight: 500;">Description</label>
                            <textarea class="form-control form-control-lg" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      style="border: 2px solid var(--beige-light); border-radius: 8px;"><?php echo htmlspecialchars($objet['description'] ?? ''); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="categorie_id" class="form-label" style="font-weight: 500;">Catégorie</label>
                                <select class="form-select form-select-lg" 
                                        id="categorie_id" 
                                        name="categorie_id"
                                        style="border: 2px solid var(--beige-light); border-radius: 8px;">
                                    <option value="">-- Aucune catégorie --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" 
                                                <?php echo ($objet['categorie_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['nom']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="etat_objet" class="form-label" style="font-weight: 500;">État</label>
                                <select class="form-select form-select-lg" 
                                        id="etat_objet" 
                                        name="etat_objet"
                                        style="border: 2px solid var(--beige-light); border-radius: 8px;">
                                    <option value="neuf" <?php echo ($objet['etat_objet'] == 'neuf') ? 'selected' : ''; ?>>Neuf</option>
                                    <option value="tres_bon" <?php echo ($objet['etat_objet'] == 'tres_bon') ? 'selected' : ''; ?>>Très bon</option>
                                    <option value="bon" <?php echo ($objet['etat_objet'] == 'bon') ? 'selected' : ''; ?>>Bon</option>
                                    <option value="moyen" <?php echo ($objet['etat_objet'] == 'moyen') ? 'selected' : ''; ?>>Moyen</option>
                                    <option value="usage" <?php echo ($objet['etat_objet'] == 'usage') ? 'selected' : ''; ?>>Usagé</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="prix_estime" class="form-label" style="font-weight: 500;">
                                <i class="fas fa-money-bill-wave"></i> Prix estimé (optionnel)
                            </label>
                            <div class="input-group input-group-lg">
                                <input type="number" 
                                       class="form-control" 
                                       id="prix_estime" 
                                       name="prix_estime" 
                                       step="0.01"
                                       min="0"
                                       value="<?php echo $objet['prix_estime'] ?? ''; ?>"
                                       placeholder="Ex: 50.00"
                                       style="border: 2px solid var(--beige-light); border-radius: 8px 0 0 8px;">
                                <span class="input-group-text" style="background-color: var(--beige-light); border: 2px solid var(--beige-light); border-left: none; font-weight: 500;">Ar</span>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Estimation de la valeur de votre objet
                            </small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="disponible" 
                                       name="disponible"
                                       style="width: 3rem; height: 1.5rem;"
                                       <?php echo ($objet['disponible']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="disponible" style="font-weight: 500; margin-left: 0.5rem;">
                                    Disponible pour échange
                                </label>
                            </div>
                        </div>

                        <!-- Images existantes -->
                        <?php if (!empty($objet['images'])): ?>
                            <div class="mb-3">
                                <label class="form-label" style="font-weight: 500;">
                                    <i class="fas fa-images"></i> Images actuelles
                                </label>
                                <div class="row g-3">
                                    <?php foreach ($objet['images'] as $img): ?>
                                        <div class="col-6 col-md-4">
                                            <div class="position-relative">
                                                <img src="<?php echo htmlspecialchars($img['url']); ?>" 
                                                     class="img-thumbnail w-100" 
                                                     style="height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid var(--beige-light);">
                                                <a href="/pages/objet/image/delete/<?php echo $img['id']; ?>" 
                                                   style="position: absolute; top: 8px; right: 8px;"
                                                   onclick="event.preventDefault(); if(confirm('Supprimer cette image ?')) { var form = document.createElement('form'); form.method = 'POST'; form.action = this.href; document.body.appendChild(form); form.submit(); }"
                                                   class="btn btn-danger btn-sm"
                                                   style="padding: 0.4rem 0.6rem; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Upload de nouvelles images -->
                        <div class="mb-4">
                            <label for="images" class="form-label" style="font-weight: 500;">
                                <i class="fas fa-images"></i> Ajouter des images
                            </label>
                            <input type="file" 
                                   class="form-control form-control-lg" 
                                   id="images" 
                                   name="images[]" 
                                   multiple
                                   accept="image/*"
                                   style="border: 2px solid var(--beige-light); border-radius: 8px;">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Formats acceptés : JPG, PNG, GIF, WEBP (max 5MB par image)
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" style="padding: 1rem;">
                                <i class="fas fa-save"></i> Enregistrer les modifications
                            </button>
                            <a href="/pages/objet" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Modifier ' . ($objet['nom'] ?? 'objet') . ' - Takalo-takalo';
require __DIR__ . '/../layouts/main.php';
?>
