<?php

require_once "DBInit.php";

class UserDB {


    public static function getUser($username, $password) {
        
        $dbh = DBInit::getInstance();
        
        $stmt = $dbh->prepare("SELECT id, username, password FROM users 
            WHERE username = :username");
       
        $stmt->bindValue(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch();
# if (!empty($user) && $password === $user["password"])
        $hash = password_hash($user["password"], PASSWORD_DEFAULT);
        if (!empty($user) && password_verify($password, $hash)) { 
            unset($user["password"]);
            return $user;
        } else {
            return false;
        }
    }
        public static function getID() {
            return  $_SESSION["user"]["id"];
        }
        

    public static function get($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, username, password, ime, priimek, email, naslov FROM users
            WHERE id =:id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
    
    
    public static function insert($username, $password, $ime, $priimek, $email, $naslov) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO users (username, password, ime, priimek, email, naslov)
            VALUES (:username, :password, :ime, :priimek, :email, :naslov)");
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":priimek", $priimek);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":naslov", $naslov);
        $statement->execute();
    }
        public static function insertP($username, $password, $ime, $priimek, $email) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO users (username, password, ime, priimek, email, status)
            VALUES (:username, :password, :ime, :priimek, :email, 'prodajalec')");
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":priimek", $priimek);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);
        $statement->bindParam(":email", $email);
        $statement->execute();
    }
        public static function update($id, $username, $password, $ime, $priimek, $email) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE users SET ime = :ime, priimek = :priimek, "
                . "email = :email, username = :username, password = :password WHERE id =:id");
        $statement->bindParam(":ime", $ime);
        $statement->bindParam(":priimek", $priimek);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
}
