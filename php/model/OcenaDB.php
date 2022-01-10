<?php

require_once 'model/DBInit.php';

class OceneDB {

    
    public static function getPovprecna($id) {
                $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT AVG(ocena) FROM ocene WHERE izdelek_id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }
    
    public static function insert($ocena, $id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO ocene (izdelek_id, ocena) VALUES (:id, :ocena)");
        $statement->bindParam(":ocena", $ocena);
        $statement->bindParam(":id", $id);
        $statement->execute();
        return $statement->fetch();
    }
    
}
