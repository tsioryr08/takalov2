# Mini squelette FlightPHP MVC – Validation AJAX (PHP 7 + Bootstrap)

## Objectif
- Formulaire d’inscription avec **validation AJAX** (endpoint JSON) + **soumission finale** (POST classique).
- **Une seule source de verite** des regles de validation côte serveur (`app/services/Validator.php`).

## Prerequis
- PHP 7.x
- MySQL
- Apache (XAMPP/WAMP/MAMP)
- FlightPHP installe (recommande via Composer)

## Installation Flight (option Composer)
1) Ouvrir un terminal dans le dossier du projet
2) Installer les dependances :
```bash
composer install
```
> Si vous êtes offline, vous pouvez preparer le dossier `vendor/` une fois en ligne et le copier sur les PCs des etudiants.

## Configuration DB
1) Creer la base et la table : `database/schema.sql`
2) Configurer l’acces DB : `app/config.php`

## Lancement (XAMPP)
- Placez le projet dans `htdocs/` (ou equivalent).
- Acces : `http://localhost/flight-mvc-validation-skeleton/public/register`

## Routes
- GET  /register                 -> page formulaire
- POST /register                 -> inscription (revalide + insert)
- POST /api/validate/register     -> validation AJAX (JSON)

## Notes pedagogiques
- AJAX ameliore l’UX.
- La securite reste côte serveur : `POST /register` **revalide toujours**.
