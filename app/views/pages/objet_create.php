<?php
ob_start();
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
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <h2 style="font-size: 2rem; font-weight: 600; margin-bottom: 0.5rem;">
                            Ajouter un objet
                        </h2>
                        <p style="color: var(--text-medium);">
                            Remplissez les informations de votre objet à échanger
                        </p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/pages/objet/create" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nom" class="form-label" style="font-weight: 500;">
                                Nom de l'objet <span style="color: red;">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="nom" 
                                   name="nom" 
                                   required
                                   style="border: 2px solid var(--beige-light); border-radius: 8px;">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label" style="font-weight: 500;">Description</label>
                            <textarea class="form-control form-control-lg" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      style="border: 2px solid var(--beige-light); border-radius: 8px;"
                                      placeholder="Décrivez votre objet, son état, ses caractéristiques..."></textarea>
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
                                        <option value="<?php echo $cat['id']; ?>">
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
                                    <option value="neuf">Neuf</option>
                                    <option value="tres_bon">Très bon</option>
                                    <option value="bon" selected>Bon</option>
                                    <option value="moyen">Moyen</option>
                                    <option value="usage">Usagé</option>
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
                                       placeholder="Ex: 50.00"
                                       style="border: 2px solid var(--beige-light); border-radius: 8px 0 0 8px;">
                                <span class="input-group-text" style="background-color: var(--beige-light); border: 2px solid var(--beige-light); border-left: none; font-weight: 500;">Ar</span>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Estimation de la valeur de votre objet
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="images" class="form-label" style="font-weight: 500;">
                                <i class="fas fa-images"></i> Photos de l'objet
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
                                <i class="fas fa-plus"></i> Ajouter l'objet
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
$title = 'Ajouter un objet - Takalo-takalo';
require __DIR__ . '/../layouts/main.php';
?>
