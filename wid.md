Installer les dependances :
    composer install(vendor/autoload.php no creer)

Redirection de la route principale '/' vers '/register'
    Flight::route('GET /', function () {
        Flight::redirect('/register');
    });

J'ai eu des erreurs :
    Resolution des erreurs liees à MySQL

    Au debut, tu avais l’erreur No such file or directory → MySQL n’etait pas correctement accessible depuis PHP.

    Apres verification :

    MariaDB etait soit arrête, soit un autre processus occupait le port 3306.

    Solution que tu as appliquee ou que tu devras appliquer :

    Forcer PDO à utiliser 127.0.0.1 au lieu de localhost pour la connexion TCP.

    Verifier que l’utilisateur MySQL a les droits sur la base.

    // Flight::register('db', 'PDO', array(
//     "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
//     DB_USER,
//     DB_PASS,
//     array(
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//     )
// ));
            en
Flight::register('db', 'PDO', [
    'mysql:host=127.0.0.1;dbname=tp_validation;charset=utf8', // TCP, pas socket
    'root', 
    '', 
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]

]);

ET VOILA