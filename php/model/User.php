<?php

class User {
	public function login($user) {
		$_SESSION["user"] = $user;
	}

	public function logout() {
		session_destroy();
	}

	public function isLoggedIn() {
		return isset($_SESSION["user"]);
	}
        public function isAdmin() {
            $dbh = DBInit::getInstance();
        
            $stmt = $dbh->prepare("SELECT id FROM users 
            WHERE username = :username AND status = 'admin' ");
            
            $stmt->bindValue(":username", $_SESSION["user"]["username"]);
            $stmt->execute();
            $user = $stmt->fetch();

            if (!empty($user)) {
                return true;
            }
            else {
                return false;
            }
	}
                public function isProdajalec() {
            $dbh = DBInit::getInstance();
        
            $stmt = $dbh->prepare("SELECT id FROM users 
            WHERE username = :username AND status = 'prodajalec' ");
            
            $stmt->bindValue(":username", $_SESSION["user"]["username"]);
            $stmt->execute();
            $user = $stmt->fetch();

            if (!empty($user)) {
                return true;
            }
            else {
                return false;
            }
	}
                public function isStranka() {
            $dbh = DBInit::getInstance();
        
            $stmt = $dbh->prepare("SELECT id FROM users 
            WHERE username = :username AND status = 'stranka' ");
            
            $stmt->bindValue(":username", $_SESSION["user"]["username"]);
            $stmt->execute();
            $user = $stmt->fetch();

            if (!empty($user)) {
                return true;
            }
            else {
                return false;
            }
	}

	public function getUsername() {
		return $_SESSION["user"]["username"];
	}
}
