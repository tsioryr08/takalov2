<?php
class AdminController {

  public static function showLogin() {
    $pdo = Flight::db();
    $loginVal = 'admin';
    $pwdVal = 'admin';
    $admin = null;

    // Try to read from local `utilisateur` table
    try {
      $st = $pdo->prepare("SELECT id, nom, prenom, email, password_hash FROM utilisateur WHERE statut = 'admin' ORDER BY id LIMIT 1");
      $st->execute();
      $admin = $st->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (Throwable $e) {
      $admin = null;
    }

    // Do not use fully-qualified schema names; rely on configured DB
    // if not found above, keep $admin === null

    if ($admin) {
      // Use `nom` as the login value per your request
      $loginVal = $admin['nom'] ?? ($admin['email'] ?? ($admin['prenom'] ?? 'Backoffice'));
      $raw = $admin['password_hash'] ?? '';
      if ($raw !== '') {
        // If stored as a hash (contains $), don't display it; otherwise display raw password
        if (strpos($raw, '$') === false) {
          $pwdVal = $raw;
        }
      }
    }

    Flight::render('admin/login', [
      'values' => ['login' => $loginVal, 'password' => $pwdVal],
      'errors' => ['_global'=>'','login'=>'','password'=>'']
    ]);
  }

  public static function postLogin() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $pdo = Flight::db();
    // locate admin in utilisateur table and set session directly (no auth)
    try {
      $st = $pdo->prepare("SELECT id FROM utilisateur WHERE statut = 'admin' ORDER BY id LIMIT 1");
      $st->execute();
      $admin = $st->fetch(PDO::FETCH_ASSOC);
      if ($admin) {
        $_SESSION['is_admin'] = true;
        $_SESSION['user_id'] = (int)$admin['id'];
      } else {
        // fallback: mark admin without user id
        $_SESSION['is_admin'] = true;
      }
    } catch (Throwable $e) {
      $_SESSION['is_admin'] = true;
    }
    Flight::redirect('/admin/categories');
  }

  public static function logout() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['is_admin'] = false;
    Flight::redirect('/admin');
  }

  public static function listCategories() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['is_admin'])) {
      Flight::redirect('/admin');
      return;
    }
    $pdo = Flight::db();
    $repo = new CategoryRepository($pdo);
    try {
      $categories = $repo->getAll();
    } catch (Throwable $e) {
      $categories = [];
    }
    Flight::render('admin/categories', ['categories' => $categories]);
  }

  public static function createCategory() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['is_admin'])) { Flight::redirect('/admin'); return; }
    $req = Flight::request();
    $name = trim((string)$req->data->name);
    $desc = trim((string)$req->data->description);
    $pdo = Flight::db();
    $repo = new CategoryRepository($pdo);
    if ($name !== '') {
      try { $repo->create($name, $desc); } catch (Throwable $e) { /* ignore */ }
    }
    Flight::redirect('/admin/categories');
  }

  public static function deleteCategory($id) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['is_admin'])) { Flight::redirect('/admin'); return; }
    $pdo = Flight::db();
    $repo = new CategoryRepository($pdo);
    $repo->delete((int)$id);
    Flight::redirect('/admin/categories');
  }

}
