<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/services/Validator.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/controllers/MessageController.php';
require_once __DIR__ . '/repositories/MessageRepository.php';
require_once __DIR__ . '/services/MessageService.php';
// Admin
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/repositories/CategoryRepository.php';
// Objet
require_once __DIR__ . '/controllers/ObjetController.php';
require_once __DIR__ . '/repositories/ObjetRepository.php';

Flight::route('GET /', function () {
    Flight::render('home');
});

// Objet routes (CRUD)
Flight::route('GET /pages/objet', ['ObjetController', 'index']);
Flight::route('GET /pages/objet/create', ['ObjetController', 'showCreate']);
Flight::route('POST /pages/objet/create', ['ObjetController', 'create']);
Flight::route('GET /pages/objet/edit/@id', ['ObjetController', 'showEdit']);
Flight::route('POST /pages/objet/edit/@id', ['ObjetController', 'update']);
Flight::route('POST /pages/objet/delete/@id', ['ObjetController', 'delete']);
Flight::route('POST /pages/objet/image/delete/@id', ['ObjetController', 'deleteImage']);

Flight::route('GET /register', ['AuthController', 'showRegister']);
Flight::route('POST /register', ['AuthController', 'postRegister']);
Flight::route('POST /api/validate/register', ['AuthController', 'validateRegisterAjax']);

// Messages
Flight::route('GET /messages', ['MessageController', 'showMessages']);
Flight::route('POST /messages/send', ['MessageController', 'sendMessage']);
Flight::route('GET /messages/refresh', ['MessageController', 'refreshMessages']);

//login
Flight::route('GET /auth/login', ['AuthController', 'showLogin']);
Flight::route('POST /auth/login', ['AuthController', 'postLogin']);
Flight::route('GET /auth/logout', ['AuthController', 'logout']);

// Admin routes
Flight::route('GET /admin/login', ['AdminController', 'showLogin']);
Flight::route('POST /admin/login', ['AdminController', 'postLogin']);
Flight::route('GET /admin/logout', ['AdminController', 'logout']);
Flight::route('GET /admin/categories', ['AdminController', 'listCategories']);
Flight::route('POST /admin/categories', ['AdminController', 'createCategory']);
Flight::route('POST /admin/categories/delete/@id', ['AdminController', 'deleteCategory']);
