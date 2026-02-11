<?php
class ObjetRepository {
  private $pdo;
  
  public function __construct(PDO $pdo) { 
    $this->pdo = $pdo; 
  }

  // Récupérer tous les objets d'un utilisateur
  public function getByUserId($userId) {
    $st = $this->pdo->prepare("
      SELECT o.*, c.nom as categorie_nom 
      FROM objet o 
      LEFT JOIN categorie c ON o.categorie_id = c.id 
      WHERE o.proprietaire_id = ? 
      ORDER BY o.date_creation DESC
    ");
    $st->execute([(int)$userId]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  // Récupérer un objet par ID
  public function getById($id) {
    $st = $this->pdo->prepare("
      SELECT o.*, c.nom as categorie_nom 
      FROM objet o 
      LEFT JOIN categorie c ON o.categorie_id = c.id 
      WHERE o.id = ? 
      LIMIT 1
    ");
    $st->execute([(int)$id]);
    $result = $st->fetch(PDO::FETCH_ASSOC);
    return $result ?: null;
  }

  // Créer un nouvel objet
  public function create($nom, $description, $categorie_id, $proprietaire_id, $etat_objet = 'bon', $prix_estime = null) {
    $st = $this->pdo->prepare("
      INSERT INTO objet(nom, description, categorie_id, proprietaire_id, etat_objet, disponible, prix_estime)
      VALUES(?, ?, ?, ?, ?, TRUE, ?)
    ");
    $st->execute([
      (string)$nom, 
      (string)$description, 
      $categorie_id ? (int)$categorie_id : null, 
      (int)$proprietaire_id, 
      (string)$etat_objet,
      $prix_estime !== null ? (float)$prix_estime : null
    ]);
    return $this->pdo->lastInsertId();
  }

  // Mettre à jour un objet
  public function update($id, $nom, $description, $categorie_id, $etat_objet, $disponible, $prix_estime = null) {
    $st = $this->pdo->prepare("
      UPDATE objet 
      SET nom = ?, description = ?, categorie_id = ?, etat_objet = ?, disponible = ?, prix_estime = ?
      WHERE id = ?
    ");
    return $st->execute([
      (string)$nom, 
      (string)$description, 
      $categorie_id ? (int)$categorie_id : null, 
      (string)$etat_objet,
      $disponible ? 1 : 0,
      $prix_estime !== null ? (float)$prix_estime : null,
      (int)$id
    ]);
  }

  // Supprimer un objet (seulement si appartient à l'utilisateur)
  public function delete($id, $proprietaire_id) {
    $st = $this->pdo->prepare("DELETE FROM objet WHERE id = ? AND proprietaire_id = ?");
    return $st->execute([(int)$id, (int)$proprietaire_id]);
  }

  // Récupérer toutes les catégories
  public function getAllCategories() {
    $st = $this->pdo->prepare("SELECT * FROM categorie ORDER BY nom ASC");
    $st->execute();
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  // Vérifier si un objet appartient à un utilisateur
  public function belongsToUser($id, $proprietaire_id) {
    $st = $this->pdo->prepare("SELECT 1 FROM objet WHERE id = ? AND proprietaire_id = ? LIMIT 1");
    $st->execute([(int)$id, (int)$proprietaire_id]);
    return (bool)$st->fetchColumn();
  }

  // === GESTION DES IMAGES ===

  // Récupérer toutes les images d'un objet
  public function getImages($objet_id) {
    $st = $this->pdo->prepare("
      SELECT * FROM image_objet 
      WHERE objet_id = ? 
      ORDER BY ordre ASC, id ASC
    ");
    $st->execute([(int)$objet_id]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  // Ajouter une image à un objet
  public function addImage($objet_id, $url, $ordre = 0) {
    $st = $this->pdo->prepare("
      INSERT INTO image_objet(objet_id, url, ordre)
      VALUES(?, ?, ?)
    ");
    $st->execute([(int)$objet_id, (string)$url, (int)$ordre]);
    return $this->pdo->lastInsertId();
  }

  // Supprimer une image
  public function deleteImage($image_id) {
    // Récupérer l'URL avant suppression pour supprimer le fichier
    $st = $this->pdo->prepare("SELECT url FROM image_objet WHERE id = ? LIMIT 1");
    $st->execute([(int)$image_id]);
    $image = $st->fetch(PDO::FETCH_ASSOC);
    
    if ($image) {
      $st = $this->pdo->prepare("DELETE FROM image_objet WHERE id = ?");
      $st->execute([(int)$image_id]);
      return $image['url'];
    }
    return null;
  }

  // Supprimer toutes les images d'un objet
  public function deleteAllImages($objet_id) {
    $images = $this->getImages($objet_id);
    $st = $this->pdo->prepare("DELETE FROM image_objet WHERE objet_id = ?");
    $st->execute([(int)$objet_id]);
    return $images;
  }

  // Vérifier si une image appartient à un objet de l'utilisateur
  public function imagebelongsToUser($image_id, $user_id) {
    $st = $this->pdo->prepare("
      SELECT 1 FROM image_objet i
      INNER JOIN objet o ON i.objet_id = o.id
      WHERE i.id = ? AND o.proprietaire_id = ?
      LIMIT 1
    ");
    $st->execute([(int)$image_id, (int)$user_id]);
    return (bool)$st->fetchColumn();
  }
}
