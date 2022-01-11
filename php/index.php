<?php
////RewriteRule "(^adm/.*)" "https://%{HTTP_HOST}%{REQUEST_URI}"
session_start();


require_once("controller/UserController.php");
require_once("controller/BooksRESTController.php");
require_once("controller/IzdelekController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
//define("BASE_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";




$urls = [
    
    "login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::login();
        } else {
            UserController::loginForm();
        }
    },
    "logout" => function () {
        UserController::logout();
    },
    "user/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::add();
        } else {
            UserController::addForm();
        }
    },
    "prodajalec/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::addP();
        } else {
            UserController::addFormP();
        }
    },
    "izdelek" => function () {
        IzdelekController::index();
    },
    "izdelek/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            IzdelekController::add();
        } else {
            IzdelekController::addForm();
        }
    },
    "api" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            IzdelekController::index();
        } else {
            IzdelekController::index();
        }
    },
    "izdelek/edit" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            IzdelekController::edit();
        } else {
            IzdelekController::editForm();
        }
    },
    "user/edit" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::edit();
        } else {
            UserController::editForm();
        }
    },
         "prodajalec/edit" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::editP();
        } else {
            UserController::editFormP();
        }
    },
    "izdelek/delete" => function () {
        IzdelekController::delete();
    },
     "cart" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            IzdelekController::kosarica();
        }
    },
    "izdelek/ocena" => function () {
        IzdelekController::addOcena();
    },
     "predracun" => function () {
        IzdelekController::predracun();
    },
    "oddaj" => function () {
        IzdelekController::oddaj();
    },
    "/api\/books\/(\d+)$/" => function ($id) {
        //var_dump($_SERVER);
                
                BooksRESTController::get($id);

    },
    "api/books" => function () {

            
                BooksRESTController::index();
              
        
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "izdelek");
    },

];

try {
        
    if (preg_match("/^api\/books\/(\d+)$/", $path, $params)) {
            $test = substr($path, -1);
            BooksRESTController::get($test);
        }
        
    else if (isset($urls[$path])) {

       $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
} 



?>
