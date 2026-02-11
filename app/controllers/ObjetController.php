<?php
class ObjetController {

  // Vérifier si l'utilisateur est connecté
  private static function checkAuth() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user_id'])) {
      Flight::redirect('/auth/login');
      exit;
    }
    return (int)$_SESSION['user_id'];
  }

  // Afficher la liste des objets de l'utilisateur
  public static function index() {
    $userId = self::checkAuth();
    
    $pdo = Flight::db();
    $repo = new ObjetRepository($pdo);
    
    $objets = $repo->getByUserId($userId);
    
    // Récupérer les images pour chaque objet
    foreach ($objets as &$objet) {
      $objet['images'] = $repo->getImages($objet['id']);
    }
    
    Flight::render('pages/objet', [
      'objets' => $objets,
      'success' => Flight::request()->query->success ?? null,
      'error' => Flight::request()->query->error ?? null
    ]);
  }

  // Afficher le formulaire de création
  public static function showCreate() {
    $userId = self::checkAuth();
    
    $pdo = Flight::db();
    $repo = new ObjetRepository($pdo);
    
    Flight::render('pages/objet_create', [
      'categories' => $repo->getAllCategories(),
      'error' => Flight::request()->query->error ?? null
    ]);
  }

  // Créer un objet
  public static function create() {
    $userId = self::checkAuth();
    
    // Utiliser $_POST car le formulaire a enctype="multipart/form-data"
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $categorie_id = !empty($_POST['categorie_id']) ? $_POST['categorie_id'] : null;
    $etat_objet = $_POST['etat_objet'] ?? 'bon';
    $prix_estime = !empty($_POST['prix_estime']) ? floatval($_POST['prix_estime']) : null;
    
    // Validation
    if (mb_strlen($nom) < 3) {
      Flight::redirect('/pages/objet?error=' . urlencode('Le nom doit contenir au moins 3 caractères'));
      return;
    }
    
    $pdo = Flight::db();
    $repo = new ObjetRepository($pdo);
    
    try {
      $objetId = $repo->create($nom, $description, $categorie_id, $userId, $etat_objet, $prix_estime);
      
      // Gérer l'upload des images
      if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        self::handleImageUpload($objetId, $_FILES['images'], $repo);
      }
      
      Flight::redirect('/pages/objet?success=' . urlencode('Objet ajouté avec succès'));
    } catch (Exception $e) {
      Flight::redirect('/pages/objet?error=' . urlencode('Erreur lors de l\'ajout'));
    }
  }

  // Afficher le formulaire d'édition
  public static function showEdit($id) {
    $userId = self::checkAuth();
    
    $pdo = Flight::db();
    $repo = new ObjetRepository($pdo);
    
    // Vérifier que l'objet appartient à l'utilisateur
    if (!$repo->belongsToUser($id, $userId)) {
      Flight::redirect('/pages/objet?error=' . urlencode('Accès non autorisé'));
      return;
    }
    
    $objet = $repo->getById($id);
    if (!$objet) {
      Flight::redirect('/pages/objet?error=' . urlencode('Objet introuvable'));
      return;
    }
    
    // Récupérer les images de cet objet
    $objet['images'] = $repo->getImages($id);
    
    Flight::render('pages/objet_edit', [
      'objet' => $objet,
      'categories' => $repo->getAllCategories(),
      'error' => Flight::request()->query->error ?? null
    ]);
  }

  // Mettre à jour un objet
  public static function update($id) {
    $userId = self::checkAuth();
    
    $pdo = Flight::db();
    $repo = new ObjetRepository($pdo);
    
    // Vérifier que l'objet appartient à l'utilisateur
    if (!$repo->belongsToUser($id, $userId)) {
      Flight::redirect('/pages/objet?error=' . urlencode('Accès non autorisé'));
      return;
    }
    
    // Utiliser $_POST car le formulaire a enctype="multipart/form-data"
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $categorie_id = !empty($_POST['categorie_id']) ? $_POST['categorie_id'] : null;
    $etat_objet = $_POST['etat_objet'] ?? 'bon';
    $disponible = isset($_POST['disponible']) ? true : false;
    $prix_estime = !empty($_POST['prix_estime']) ? floatval($_POST['prix_estime']) : null;
    
    // Validation
    if (mb_strlen($nom) < 3) {
      Flight::redirect('/pages/objet/edit/' . $id . '?error=' . urlencode('Le nom doit contenir au moins 3 caractères'));
      return;
    }
    
    try {
      $result = $repo->update($id, $nom, $description, $categorie_id, $etat_objet, $disponible, $prix_estime);
      
      if (!$result) {
        throw new Exception("La mise à jour a échoué");
      }
      
      // Gérer l'upload des nouvelles images
      if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        self::handleImageUpload($id, $_FILES['images'], $repo);
      }
      
      Flight::redirect('/pages/objet?success=' . urlencode('Objet modifié avec succès'));
    } catch (Exception $e) {
      Flight::redirect('/pages/objet/edit/' . $id . '?error=' . urlencode('Erreur: ' . $e->getMessage()));
    }
  }

  // Supprimer un objet
  public static function delete($id) {
    $userId = self::checkAuth();
    
    $pdo = Flight::db();
    $repo = new ObjetRepository($pdo);
    
    try {
      // Supprimer les images physiques avant de supprimer l'objet
      $images = $repo->getImages($id);
      foreach ($images as $img) {
        $filePath = __DIR__ . '/../../public' . $img['url'];
        if (file_exists($filePath)) {
          unlink($filePath);
        }
      }
      
      $repo->delete($id, $userId);
      Flight::redirect('/pages/objet?success=' . urlencode('Objet supprimé avec succès'));
    } catch (Exception $e) {
      Flight::redirect('/pages/objet?error=' . urlencode('Erreur lors de la suppression'));
    }
  }

  // Supprimer une image individuelle
  public static function deleteImage($image_id) {
    $userId = self::checkAuth();
    
    $pdo = Flight::db();
    $repo = new ObjetRepository($pdo);
    
    // Vérifier que l'image appartient à l'utilisateur
    if (!$repo->imagebelongsToUser($image_id, $userId)) {
      Flight::redirect('/pages/objet?error=' . urlencode('Accès non autorisé'));
      return;
    }
    
    try {
      $imageUrl = $repo->deleteImage($image_id);
      
      // Supprimer le fichier physique
      if ($imageUrl) {
        $filePath = __DIR__ . '/../../public' . $imageUrl;
        if (file_exists($filePath)) {
          unlink($filePath);
        }
      }
      
      // Rediriger vers la page d'édition si on vient de là
      $referer = $_SERVER['HTTP_REFERER'] ?? '/pages/objet';
      header('Location: ' . $referer . (strpos($referer, '?') ? '&' : '?') . 'success=' . urlencode('Image supprimée'));
      exit;
    } catch (Exception $e) {
      Flight::redirect('/pages/objet?error=' . urlencode('Erreur lors de la suppression de l\'image'));
    }
  }

  // Gérer l'upload multiple d'images
  private static function handleImageUpload($objet_id, $files, $repo) {
    $uploadDir = __DIR__ . '/../../public/uploads/objets/';
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    $count = count($files['name']);
    
    for ($i = 0; $i < $count; $i++) {
      // Vérifier si le fichier a été uploadé
      if ($files['error'][$i] !== UPLOAD_ERR_OK) {
        continue;
      }
      
      // Vérifier le type de fichier
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mimeType = finfo_file($finfo, $files['tmp_name'][$i]);
      finfo_close($finfo);
      
      if (!in_array($mimeType, $allowedTypes)) {
        continue;
      }
      
      // Vérifier la taille
      if ($files['size'][$i] > $maxSize) {
        continue;
      }
      
      // Générer un nom unique
      $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
      $filename = uniqid('obj_' . $objet_id . '_', true) . '.' . $extension;
      $uploadPath = $uploadDir . $filename;
      
      // Déplacer le fichier
      if (move_uploaded_file($files['tmp_name'][$i], $uploadPath)) {
        // Enregistrer dans la base de données
        $url = '/uploads/objets/' . $filename;
        $repo->addImage($objet_id, $url, $i);
      }
    }
  }
}
