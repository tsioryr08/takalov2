<?php
require_once __DIR__ . '/config.php';

Flight::register('db', 'PDO', [
    'mysql:host=127.0.0.1;dbname=takalo;charset=utf8', // TCP, pas socket
    'root', 
    '', 
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]

]);


// start session and auto-login / seed demo users
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

Flight::set('flight.views.path', __DIR__ . '/views');

try {
    $pdo = Flight::db();
    $cnt = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ((int)$cnt === 0) {
        $pwd = password_hash('password123', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (nom, prenom, email, password_hash, telephone) VALUES (?,?,?,?,?)")
                ->execute(['Alice','Dupont','alice@example.com',$pwd,'0600000001']);
        $pdo->prepare("INSERT INTO users (nom, prenom, email, password_hash, telephone) VALUES (?,?,?,?,?)")
                ->execute(['Bob','Martin','bob@example.com',$pwd,'0600000002']);
    }
    // ensure an admin backoffice user exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['backoffice@example.com']);
    if ((int)$stmt->fetchColumn() === 0) {
      $pwdAdmin = password_hash('admin123', PASSWORD_DEFAULT);
      $pdo->prepare("INSERT INTO users (nom, prenom, email, password_hash, telephone) VALUES (?,?,?,?,?)")
          ->execute(['Backoffice','Admin','backoffice@example.com',$pwdAdmin,'0000000000']);
    }
    // set session user id if not set
    if (empty($_SESSION['user_id'])) {
        $first = $pdo->query("SELECT id FROM users ORDER BY id LIMIT 1")->fetchColumn();
        if ($first) $_SESSION['user_id'] = (int)$first;
    }
} catch (Throwable $e) {
    // ignore seeding errors in development
}

require_once __DIR__ . '/routes.php';
