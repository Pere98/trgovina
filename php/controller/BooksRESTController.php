<?php

require_once("model/IzdelekDB.php");
require_once("controller/IzdelekController.php");
require_once("ViewHelper.php");

class BooksRESTController {

    public static function get($id) {
        try {
            echo ViewHelper::renderJSON(IzdelekDB::get($id));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function index() {
        $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
                . $_SERVER["REQUEST_URI"];
        echo ViewHelper::renderJSON(IzdelekDB::getAll(["prefix" => $prefix]));
    }

    
}

