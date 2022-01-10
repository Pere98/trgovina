<?php

require_once("model/IzdelekDB.php");
require_once("model/User.php");
require_once("model/OcenaDB.php");
require_once("ViewHelper.php");

class IzdelekController {
    
            public static function addOcena() {
            $ocena = filter_input_array(INPUT_POST, FILTER_SANITIZE_NUMBER_INT);
           // var_dump($ocena["ocena"]);
           // var_dump($ocena["iid"]);
            //var_dump($ocena);
            OceneDB::insert($ocena["ocena"], $ocena["iid"]);
            ViewHelper::redirect(BASE_URL . "izdelek");
       
    }

    public static function index() {
        ViewHelper::render("view/izdelek-list.php", [
            "izdelek" => IzdelekDB::getAll(), 
            "loggedIn" => User::isLoggedIn()
        ]);
    }


    // Function can be called without providing arguments. In such case,
    // $data and $errors paramateres are initialized as empty arrays
    public static function addForm($data = [], $errors = []) {
        // If $data is an empty array, let's set some default values
        if (empty($data)) {
            $data = [
                "ime" => "",
                "opis" => "",
                "lastnik" => "",
                "cena" => ""
                
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
        ViewHelper::render("view/izdelek-add.php", $vars);
    }

    public static function add() {
        $rules = [
            "ime" => FILTER_UNSAFE_RAW,
            "opis" => FILTER_UNSAFE_RAW,
            "lastnik" => FILTER_UNSAFE_RAW,
            "cena" => FILTER_UNSAFE_RAW
            
            
        ];
        
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["ime"] = empty($data["ime"]) ? "Nepravilno ime" : "";
        $errors["opis"] = empty($data["opis"]) ? "Nepravilen opis" : "";
        $errors["lastnik"] = empty($data["lastnik"]) ? "Nepravilen lastnik" : "";
        

        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            
            IzdelekDB::insert($data["ime"], $data["opis"], $data["lastnik"], $data["cena"]);
            ViewHelper::redirect(BASE_URL . "izdelek");
        } else {
            self::showAddForm($data, $errors);
        }
    }

    public static function editForm($data = [], $errors = []) {
        if (empty($data)) {
            $data = IzdelekDB::get($_GET["id"]);
        }

        if (empty($errors)) {
            foreach ($data as $key => $value) {
                $errors[$key] = "";
            }
        }
        
        ViewHelper::render("view/izdelek-edit.php", ["izdelek" => $data, "errors" => $errors]);
    }    

    public static function edit() {
        $rules = [
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ],
            "ime" => FILTER_UNSAFE_RAW,
            "opis" => FILTER_UNSAFE_RAW,
            "lastnik" => FILTER_UNSAFE_RAW,
            "cena" => FILTER_UNSAFE_RAW
            
        ];

        $data = filter_input_array(INPUT_POST, $rules);
//print_r($data);
        $errors["ime"] = empty($data["ime"]) ? "Nepravilno ime" : "";
        $errors["opis"] = empty($data["opis"]) ? "Nepravilen opis" : "";
        $errors["lastnik"] = empty($data["lastnik"]) ? "Nepravilen lastnik" : "";
        $errors["id"] = empty($data["id"]) ? "ID is missing." : "";

        // Is there an error?
        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            IzdelekDB::update($data["id"], $data["ime"], $data["opis"], $data["lastnik"], $data["cena"]);
            ViewHelper::redirect(BASE_URL . "izdelek");
        } else {
            self::showEditForm($data, $errors);
        }
    }

    public static function delete() {
        if (!User::isLoggedIn()) {
            throw new Exception("Login required.");
        }

        $rules = [
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ],
            "delete_confirmation" => [
                "filter" => FILTER_VALIDATE_BOOLEAN
            ]
        ];
        $data = filter_input_array(INPUT_GET, $rules);

        $errors["id"] = $data["id"] === null ? "Cannot delete without a valid ID." : "";
        $errors["delete_confirmation"] = $data["delete_confirmation"] === null ? "Forgot to check the delete box?" : "";

        $isDataValid = true;
        foreach ($errors as $error) {
            $isDataValid = $isDataValid && empty($error);
        }

        if ($isDataValid) {
            IzdelekDB::delete($data["id"]);
            $url = BASE_URL . "izdelek";
        } else {
            if ($data["id"] !== null) {
                $url = BASE_URL . "izdelek/edit?id=" . $data["id"];
            } else {
                $url = BASE_URL . "izdelek";
            }
        }

        ViewHelper::redirect($url);
    }
    
    
    
    
    
    
        public static function kosarica() {
        $method = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);
        if($method == "POST") {
            $validationRules = [
                'do' => [
                    'filter' => FILTER_VALIDATE_REGEXP,
                    'options' => [
                        "regexp" => "/^(add_into_cart|purge_cart|updt)$/"
                    ]
                ],
                'id' => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 0]
                ],
                'kolicina' => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 0]
                ]
            ];
        }
        $post = filter_input_array(INPUT_POST, $validationRules);
        //var_dump($post);
        
        switch ($post["do"]) {
            case "add_into_cart":
                try {
                    if(isset($_SESSION["cart"][$post["id"]])) {
                       
                        $_SESSION["cart"][$post["id"]]++;
                    }else {
                        
                        $_SESSION["cart"][$post["id"]] = 1;
                    }
                    ViewHelper::redirect(BASE_URL . "izdelek");
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
                break;
            case "purge_cart":
                try {
                    unset($_SESSION["cart"]);
                    ViewHelper::redirect(BASE_URL . "izdelek");
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
            case "updt":
                try {
                    var_dump($post["kolicina"]);
                        if ($post["kolicina"] < 1) {
                            unset($_SESSION["cart"][$post["id"]]);
                        }else {
                            $_SESSION["cart"][$post["id"]] = $post["kolicina"];
                        }
                        ViewHelper::redirect(BASE_URL . "izdelek");
                    
                } catch (Exception $ex) {
                    die($ex->getMessage());
                }
            default:
                break;
        }
    }
    
    
    
    
    
    

    
    

    
    
    
        public static function predracun() {
        
            $izdelki = IzdelekDB::getAll();
        
            $vsota = 0;
            $predracun["izdelki"] = array();
            while ($x = current($_SESSION["cart"])) {
                foreach ($izdelki as $izdelek):
                    if($izdelek["id"] == key($_SESSION["cart"])) {
                        $vsota = $vsota + $x * $izdelek["cena"];
                        $trenutni["ime"] = $izdelek["ime"];
                        $trenutni["cena"] = $izdelek["cena"];
                        $trenutni["kolicina"] = $x;
                        $trenutni["lastnik"] = $izdelek["lastnik"];
                        
                        array_push($predracun["izdelki"], $trenutni);
                        break;
                    }
                endforeach;

                next($_SESSION["cart"]);
            }

            $predracun["vsota"] = $vsota;
            echo ViewHelper::render("view/predracun.php", [
                    "predracun" => $predracun
                ]);
        
    }
    
    

    
    
    
        public static function oddaj() {

            $izdelki = IzdelekDB::getAll();
            //var_dump($izdelki);
            
    
        }
    
    
    
    
}
 
