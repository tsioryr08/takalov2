<?php

class AdminController
{
    // Afficher le formulaire de login
    public static function showLogin()
    {
        // Si déjà connecté, rediriger
        if (isset($_SESSION['admin_id'])) {
            Flight::redirect('/admin');
            return;
        }
        
        // 🎯 RÉCUPÉRER L'EMAIL ADMIN PAR DÉFAUT
        $pdo = Flight::db();
        $stmt = $pdo->query("SELECT email FROM utilisateur WHERE statut = 'admin' LIMIT 1");
        $admin_default = $stmt->fetch();
        $default_email = $admin_default ? $admin_default['email'] : '';
        
        // Passer les données à la vue
        Flight::render('admin/login', [
            'default_email' => $default_email,
            'error' => $_SESSION['error'] ?? ''
        ]);
        
        // Nettoyer l'erreur après affichage
        unset($_SESSION['error']);
    }
    
    // Traiter le formulaire de login
    public static function processLogin()
    {
        $pdo = Flight::db();
        
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Veuillez remplir tous les champs.';
            Flight::redirect('/admin/login');
            return;
        }
        
        // Vérifier les identifiants (SANS HASH - comparaison directe)
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ? AND password_hash = ? AND statut = 'admin'");
        $stmt->execute([$email, $password]);
        $admin = $stmt->fetch();
        
        if ($admin) {
            // Connexion réussie
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nom'] = $admin['nom'];
            $_SESSION['admin_prenom'] = $admin['prenom'];
            $_SESSION['admin_email'] = $admin['email'];
            
            Flight::redirect('/admin');
        } else {
            $_SESSION['error'] = 'Email ou mot de passe incorrect.';
            Flight::redirect('/admin/login');
        }
    }
    
    // Dashboard admin
    public static function dashboard()
    {
        // Vérifier si admin connecté
        if (!isset($_SESSION['admin_id'])) {
            Flight::redirect('/admin/login');
            return;
        }
        
        $pdo = Flight::db();
        
        // Statistiques
        $stats = [
            'users' => $pdo->query("SELECT COUNT(*) FROM utilisateur WHERE statut='simple'")->fetchColumn(),
            'categories' => $pdo->query("SELECT COUNT(*) FROM categorie")->fetchColumn(),
            'objets' => $pdo->query("SELECT COUNT(*) FROM objet")->fetchColumn(),
            'propositions' => $pdo->query("SELECT COUNT(*) FROM proposition_echange WHERE statut='en_attente'")->fetchColumn()
        ];
        
        Flight::render('admin/dashboard', [
            'stats' => $stats,
            'admin' => $_SESSION
        ]);
    }
    
    // Déconnexion
    public static function logout()
    {
        session_destroy();
        Flight::redirect('/admin/login');
    }

    // Liste des catégories
    public static function listCategories()
    {
        if (!isset($_SESSION['admin_id'])) {
            Flight::redirect('/admin/login');
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

    // Créer une catégorie
    public static function createCategory()
    {
        if (!isset($_SESSION['admin_id'])) {
            Flight::redirect('/admin/login');
            return;
        }
        
        $req = Flight::request();
        $name = trim((string)$req->data->name);
        $desc = trim((string)$req->data->description);
        $pdo = Flight::db();
        $repo = new CategoryRepository($pdo);
        if ($name !== '') {
            try { 
                $repo->create($name, $desc); 
            } catch (Throwable $e) { 
                /* ignore */ 
            }
        }
        Flight::redirect('/admin/categories');
    }

    // Afficher le formulaire d'édition d'une catégorie
    public static function showEditCategory($id)
    {
        if (!isset($_SESSION['admin_id'])) {
            Flight::redirect('/admin/login');
            return;
        }
        
        $pdo = Flight::db();
        $repo = new CategoryRepository($pdo);
        $category = $repo->getById((int)$id);
        if (!$category) {
            Flight::redirect('/admin/categories');
            return;
        }
        Flight::render('admin/edit_category', ['category' => $category]);
    }

    // Mettre à jour une catégorie
    public static function updateCategory($id)
    {
        if (!isset($_SESSION['admin_id'])) {
            Flight::redirect('/admin/login');
            return;
        }
        
        $req = Flight::request();
        $name = trim((string)$req->data->name);
        $desc = trim((string)$req->data->description);
        $pdo = Flight::db();
        $repo = new CategoryRepository($pdo);
        if ($name !== '') {
            try { 
                $repo->update((int)$id, $name, $desc); 
            } catch (Throwable $e) { 
                /* ignore */ 
            }
        }
        Flight::redirect('/admin/categories');
    }

    // Supprimer une catégorie
    public static function deleteCategory($id)
    {
        if (!isset($_SESSION['admin_id'])) {
            Flight::redirect('/admin/login');
            return;
        }
        
        $pdo = Flight::db();
        $repo = new CategoryRepository($pdo);
        $repo->delete((int)$id);
        Flight::redirect('/admin/categories');
    }
}