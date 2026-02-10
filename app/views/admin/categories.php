<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestion des catégories — Backoffice</title>
  <link rel="stylesheet" href="/assets/main-CFKPan32.css">
</head>
<body class="p-4">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h4">Catégories</h1>
      <div>
        <a href="/admin/logout" class="btn btn-outline-secondary">Se déconnecter</a>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <form method="post" action="/admin/categories">
          <div class="row g-2">
            <div class="col-md-5">
              <input type="text" name="name" class="form-control" placeholder="Nom de la catégorie" required>
            </div>
            <div class="col-md-5">
              <input type="text" name="description" class="form-control" placeholder="Description (optionnelle)">
            </div>
            <div class="col-md-2 d-grid">
              <button class="btn btn-primary">Ajouter</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Objets</th>
                <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (($categories ?? []) as $c): ?>
              <tr>
                <td><?= e($c['nom']) ?></td>
                <td><?= e($c['description']) ?></td>
                <td><?= e(isset($c['objets']) ? $c['objets'] : 0) ?></td>
                <td>
                  <form style="display:inline" method="post" action="/admin/categories/delete/<?= e($c['id']) ?>" onsubmit="return confirm('Supprimer ?');">
                    <button class="btn btn-sm btn-danger">Supprimer</button>
                  </form>
                  <form style="display:inline" method="post" action="/admin/categories/edit/<?= e($c['id']) ?>" onsubmit="return confirm('Modifier ?');">
                    <button class="btn btn-sm btn-danger">Modifier</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
