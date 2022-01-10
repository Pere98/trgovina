<?php

require_once("model/UserDB.php");
require_once("model/User.php");
require_once("ViewHelper.php");

class UserController {

    public static function loginForm() {
        ViewHelper::render("view/user-login-form.php", ["formAction" => "login"]);
    }

    public static function login() {
        $rules = [
            "username" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        $user = UserDB::getUser($data["username"], $data["password"]);

        $errorMessage =  empty($data["username"]) || empty($data["password"]) || $user == null ? "Invalid username or password." : "";

        if (empty($errorMessage)) {
            User::login($user);

            $vars = [
                "username" => $data["username"],
                "password" => $data["password"]
            ];

            ViewHelper::render("view/user-login-success.php", $vars);
        } else {
            ViewHelper::render("view/user-login-form.php", [
                "errorMessage" => $errorMessage,
                "formAction" => "login"
            ]);
        }
    }

    public static function logout() {
        User::logout();

        ViewHelper::redirect(BASE_URL . "izdelek");
    }
    public static function addForm($data = [], $errors = []) {
        // If $data is an empty array, let's set some default values
        if (empty($data)) {
            $data = [
                "username" => "ep",
                "password" => "ep",
                "ime" => "a",
                "priimek" => "b",
                "email" => "c",
                "naslov" => "d"
                
            ];
        }

        // If $errors array is empty, let's make it contain the same keys as
        // $data array, but with empty values
        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }

        $vars = ["izdelek" => $data, "errors" => $errors];
        ViewHelper::render("view/user-add.php", $vars);
    }
        public static function addFormP($data = [], $errors = []) {
        // If $data is an empty array, let's set some default values
        if (empty($data)) {
            $data = [
                "username" => "ep1",
                "password" => "ep1",
                "ime" => "a",
                "priimek" => "b",
                "email" => "c",

                
            ];
        }

        // If $errors array is empty, let's make it contain the same keys as
        // $data array, but with empty values
        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }

        $vars = ["izdelek" => $data, "errors" => $errors];
        ViewHelper::render("view/prodajalec-add.php", $vars);
    }

    public static function add() {
        $rules = [
            "username" => FILTER_UNSAFE_RAW,
            "password" => FILTER_UNSAFE_RAW,
            "ime" => FILTER_UNSAFE_RAW,
            "priimek" => FILTER_UNSAFE_RAW,
            "email" => FILTER_UNSAFE_RAW,
            "naslov" => FILTER_UNSAFE_RAW
            
            
        ];
        
        $data = filter_input_array(INPUT_POST, $rules);
           
        $errors["ime"] = empty($data["ime"]) ? "Nepravilno ime" : "";
        $errors["priimek"] = empty($data["priimek"]) ? "Nepravilen priimek" : "";
        $errors["email"] = empty($data["email"]) ? "Nepravilen email" : "";
        $errors["username"] = empty($data["username"]) ? "Nepravilno uporabniško ime" : "";
        $errors["password"] = empty($data["password"]) ? "Nepravilen password" : "";
        $errors["naslov"] = empty($data["naslov"]) ? "Nepravilen naslov" : "";
        

        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }
if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

                // Google secret API
                $secretAPIkey = '6LfRzQAeAAAAAAjBbMILLZfWyJtwicNsGamqmmNC';

                // reCAPTCHA response verification
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretAPIkey.'&response='.$_POST['g-recaptcha-response']);

                // Decode JSON data
                $response = json_decode($verifyResponse);
                    if($response->success){
        if ($isDataValid) {
            
            UserDB::insert($data["username"], $data["password"], $data["ime"], $data["priimek"], $data["email"], $data["naslov"]);
            ViewHelper::redirect(BASE_URL . "izdelek");
        } else {
            self::showAddForm($data, $errors);
        }
                    }
}
                    else{
                           echo '<script>alert("Failed CAPTCHA")</script>';
                           
                    }

    }
        public static function addP() {
        $rules = [
            "username" => FILTER_UNSAFE_RAW,
            "password" => FILTER_UNSAFE_RAW,
            "ime" => FILTER_UNSAFE_RAW,
            "priimek" => FILTER_UNSAFE_RAW,
            "email" => FILTER_UNSAFE_RAW,

            
            
        ];
        
        $data = filter_input_array(INPUT_POST, $rules);
           
        $errors["ime"] = empty($data["ime"]) ? "Nepravilno ime" : "";
        $errors["priimek"] = empty($data["priimek"]) ? "Nepravilen priimek" : "";
        $errors["email"] = empty($data["email"]) ? "Nepravilen email" : "";
        $errors["username"] = empty($data["username"]) ? "Nepravilno uporabniško ime" : "";
        $errors["password"] = empty($data["password"]) ? "Nepravilen password" : "";

        

        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            
            UserDB::insertP($data["username"], $data["password"], $data["ime"], $data["priimek"], $data["email"]);
            ViewHelper::redirect(BASE_URL . "izdelek");
        } else {
            self::showAddForm($data, $errors);
        }
    }
    
    
    
    
    
    
    
    
        public static function editForm($data = [], $errors = []) {
        if (empty($data)) {
            $data = UserDB::get($_GET["id"]);
        }

        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }
        
        ViewHelper::render("view/user-edit.php", ["izdelek" => $data, "errors" => $errors]);
    }    

    public static function edit() {
        $rules = [
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ],
            "username" => FILTER_UNSAFE_RAW,
            "password" => FILTER_UNSAFE_RAW,
            "ime" => FILTER_UNSAFE_RAW,
            "priimek" => FILTER_UNSAFE_RAW,
            "email" => FILTER_UNSAFE_RAW
            
        ];

        $data = filter_input_array(INPUT_POST, $rules);
//print_r($data);
           
        $errors["ime"] = empty($data["ime"]) ? "Nepravilno ime" : "";
        $errors["priimek"] = empty($data["priimek"]) ? "Nepravilen priimek" : "";
        $errors["email"] = empty($data["email"]) ? "Nepravilen email" : "";
        $errors["username"] = empty($data["username"]) ? "Nepravilno uporabniško ime" : "";
        $errors["password"] = empty($data["password"]) ? "Nepravilen password" : "";
        $errors["id"] = empty($data["id"]) ? "ID is missing." : "";

        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            UserDB::update($data["id"], $data["username"], $data["password"], $data["ime"], $data["priimek"], $data["email"]);
            ViewHelper::redirect(BASE_URL . "izdelek");
        } else {
            self::showEditForm($data, $errors);
        }
    }

    
    
    
    
    
            public static function editFormP($data = [], $errors = []) {
        if (empty($data)) {
            $data = UserDB::get($_GET["id"]);
        }

        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }
        
        ViewHelper::render("view/user-edit.php", ["izdelek" => $data, "errors" => $errors]);
    }    

    public static function editP() {
        $rules = [
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ],
            "username" => FILTER_UNSAFE_RAW,
            "password" => FILTER_UNSAFE_RAW,
            "ime" => FILTER_UNSAFE_RAW,
            "priimek" => FILTER_UNSAFE_RAW,
            "email" => FILTER_UNSAFE_RAW
            
        ];

        $data = filter_input_array(INPUT_POST, $rules);
//print_r($data);
           
        $errors["ime"] = empty($data["ime"]) ? "Nepravilno ime" : "";
        $errors["priimek"] = empty($data["priimek"]) ? "Nepravilen priimek" : "";
        $errors["email"] = empty($data["email"]) ? "Nepravilen email" : "";
        $errors["username"] = empty($data["username"]) ? "Nepravilno uporabniško ime" : "";
        $errors["password"] = empty($data["password"]) ? "Nepravilen password" : "";
        $errors["id"] = empty($data["id"]) ? "ID is missing." : "";

        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            UserDB::update($data["id"], $data["username"], $data["password"], $data["ime"], $data["priimek"], $data["email"]);
            ViewHelper::redirect(BASE_URL . "izdelek");
        } else {
            self::showEditForm($data, $errors);
        }
    }
    
    
    
    
    
    
}
