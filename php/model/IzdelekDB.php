<?php

require_once "DBInit.php";

class IzdelekDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, title, description, author, price FROM izdelki");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM izdelki WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function get($id) {
        $db = DBInit::getInstance();
        //var_dump($id);
        $statement = $db->prepare("SELECT id, title, description, author, price FROM izdelki WHERE id=:id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        //var_dump($statement->fetch());

        return $statement->fetch();
    }

    public static function insert($ime, $opis, $lastnik, $cena) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO izdelki (title, description, author, price)
            VALUES (:ime, :opis, :lastnik, :cena)");
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":opis", $opis);
        $statement->bindParam(":lastnik", $lastnik);
        $statement->bindParam(":cena", $cena);
        $statement->execute();
    }

    public static function update($id, $ime, $opis, $lastnik, $cena) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE izdelki SET title = :ime, description = :opis, "
                . "author = :lastnik, price = :cena WHERE id =:id");
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":opis", $opis);
        $statement->bindParam(":lastnik", $lastnik);
        $statement->bindParam(":cena", $cena);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
    
    public static function getAllwithURI(array $prefix) {
        return getAll();
    }

}
