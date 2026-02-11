# 🚀 Guide pour activer le Login et Register Utilisateurs

## ✅ Changements effectués

1. ✔️ **Table SQL créée** : `database/create_users_table.sql`
2. ✔️ **Routes corrigées** : `/auth/login`, `/auth/register`, `/auth/logout`
3. ✔️ **Vues créées** : `login.php` et `register.php` avec le design cohérent
4. ✔️ **Code backend** : Déjà en place (AuthController, UserService, Validator)

---

## 📋 Étapes pour finaliser l'installation

### 1️⃣ Créer la table `users` dans la base de données

```bash
# Se connecter à MySQL
mysql -u root -p

# Exécuter le script SQL
source /home/onja/Documents/GitHub/takalov2/database/create_users_table.sql
```

**OU via phpMyAdmin** :
- Ouvrir phpMyAdmin
- Sélectionner la base de données `takalo`
- Aller dans l'onglet "SQL"
- Copier-coller le contenu de `database/create_users_table.sql`
- Cliquer sur "Exécuter"

### 2️⃣ Vérifier la configuration de la base de données

Ouvrir [`app/config.php`](../app/config.php) et vérifier :

```php
Flight::register('db', 'PDO', [
    'mysql:host=localhost;dbname=takalo;charset=utf8mb4',
    'root',  // Votre username MySQL
    ''       // Votre password MySQL
]);
```

### 3️⃣ Démarrer le serveur PHP

```bash
cd /home/onja/Documents/GitHub/takalov2/public
php -S localhost:8000
```

### 4️⃣ Tester les fonctionnalités

#### **Inscription** 
1. Aller sur http://localhost:8000/
2. Cliquer sur "Espace Utilisateur" (désactivé pour l'instant)
3. OU aller directement sur http://localhost:8000/register
4. Remplir le formulaire :
   - Nom : minimum 2 caractères
   - Prénom : minimum 2 caractères  
   - Email : format valide (ex: user@example.com)
   - Mot de passe : minimum 8 caractères
   - Confirmation : doit correspondre au mot de passe
   - Téléphone : 8-15 chiffres

#### **Connexion**
1. Aller sur http://localhost:8000/auth/login
2. Utiliser les identifiants créés lors de l'inscription
3. OU utiliser le compte test :
   - Email : `test@example.com`
   - Mot de passe : `password`
4. Après connexion, vous serez redirigé vers `/messages`

#### **Déconnexion**
- Aller sur http://localhost:8000/auth/logout

---

## 🔧 Structure du système

### Routes disponibles
```
GET  /                      → Page d'accueil
GET  /register              → Formulaire d'inscription
POST /register              → Traitement inscription
GET  /auth/login            → Formulaire de connexion
POST /auth/login            → Traitement connexion
GET  /auth/logout           → Déconnexion
GET  /messages              → Page de messagerie (nécessite connexion)
```

### Fichiers modifiés/créés
```
database/
  └── create_users_table.sql      ← Nouveau

app/
  ├── routes.php                  ← Modifié (routes corrigées)
  ├── controllers/
  │   └── AuthController.php      ← Existe déjà
  ├── repositories/
  │   └── UserRepository.php      ← Existe déjà
  ├── services/
  │   ├── UserService.php         ← Existe déjà
  │   └── Validator.php           ← Existe déjà
  └── views/
      └── auth/
          ├── login.php           ← Remplacé
          ├── register.php        ← Remplacé
          ├── login_admin_old.php ← Sauvegarde ancienne vue
          └── register_old.php    ← Sauvegarde ancienne vue
```

---

## 🐛 Dépannage

### Erreur "Table 'users' doesn't exist"
➡️ Exécuter le script SQL `database/create_users_table.sql`

### Erreur de connexion à la base de données
➡️ Vérifier [`app/config.php`](../app/config.php) avec vos credentials MySQL

### Page blanche / 500 Error
➡️ Activer l'affichage des erreurs dans [`public/index.php`](../public/index.php) :
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### La redirection après login ne fonctionne pas
➡️ Vérifier que la session est démarrée dans `AuthController::postLogin()`

### Les validations AJAX ne fonctionnent pas
➡️ Vérifier que le fichier [`public/js/validation-ajax.js`](../public/js/validation-ajax.js) existe

---

## 🎯 Prochaines étapes

1. Activer le lien "Espace Utilisateur" sur la page d'accueil
2. Créer une page de profil utilisateur
3. Ajouter la récupération de mot de passe
4. Implémenter la gestion des objets à échanger
5. Améliorer l'espace messagerie

---

## 📚 Ressources

- **FlightPHP Documentation** : https://docs.flightphp.com/
- **Bootstrap 5** : https://getbootstrap.com/docs/5.0/
- **Font Awesome Icons** : https://fontawesome.com/icons

---

## ✨ Compte test disponible

```
Email    : test@example.com
Password : password
```

---

**Note** : Le système d'auto-création de compte lors de la première connexion est actif dans `AuthController::postLogin()`. Si un utilisateur tente de se connecter avec un email qui n'existe pas, un compte sera automatiquement créé.
