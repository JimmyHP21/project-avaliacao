<?php

namespace Project\Model;

use \Project\Model;
use \Project\Banco\Sql;

class User extends Model {
    const SESSION = "User";

    public static function getFromSession() {
        $data = [];
        $user = new User();

        if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['iduser'] > 0) {

            $user->setData($_SESSION[User::SESSION]);

        }

        return $user;
    }

    public static function getUserName() {
        $user = User::getFromSession();
        return $user -> getdesname();
    }

    public static function getUserId() {
        $user = User::getFromSession();
        return $user -> getiduser();
    }

    public static function login($login, $password) {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :login", array(
            ":login" => $login
        ));

        if (count($results) === 0) {
            throw new \Exception("Usuario inexistente");
        }

        $data = $results[0];

        if (password_verify($password, $data["despassword"]) === true) {
            $user = new User();
            $user -> setData($data);

            $_SESSION[User::SESSION] = $user-> getValues();
            return $user;
        } else {
            throw new \Exception("senha invalida");
        }
    }

    public static function listAll($page = 1, $itemsPerPage = 4) {
        $start = ($page - 1 ) * $itemsPerPage;

        $sql = new Sql();
        $results = $sql -> select("SELECT * FROM tb_users  ORDER BY desname LIMIT $start, $itemsPerPage");
        $resultsTotal = $sql -> select("SELECT FOUND_ROWS() AS nrTotal");

        return [
            'data' => $results,
            'total' => (int)$resultsTotal[0]["nrTotal"],
            'pages' => ceil($resultsTotal[0]["nrTotal"] / $itemsPerPage)
        ];
    }

    public function get($iduser) {
        $sql = new Sql();
        $results = $sql -> select("SELECT * FROM tb_users WHERE iduser = :iduser", array(
           ":iduser" => $iduser
        ));

        $this -> setData($results[0]);
    }

    public function update() {
        $sql = new Sql();

        $password = $this -> getdespassword();
        $cripPass = password_hash($password, PASSWORD_DEFAULT);

        $results = $sql -> select("CALL sp_user_update(:iduser, :desname, :deslogin, :despassword, :balance, :signature)", array(
            ":iduser" => $this -> getiduser(),
            ":desname" => $this -> getdesname(),
            ":deslogin" => $this -> getdeslogin(),
            ":despassword" => $cripPass,
            ":balance" => $this -> getbalance(),
            ":signature" => $this -> getsignature()
        ));

        $this -> setData($results[0]);
    }

    public function save() {
        $sql = new Sql();

        $password = $this -> getdespassword();
        $cripPass = password_hash($password, PASSWORD_DEFAULT);

        $results = $sql -> select("CALL sp_user_save(:desname, :deslogin, :despassword, :balance, :signature)", array(
            ":desname" => $this -> getdesname(),
            ":deslogin" => $this -> getdeslogin(),
            ":despassword" => $cripPass,
            ":balance" => $this -> getbalance(),
            ":signature" => $this -> getsignature()
        ));

       $this -> setData($results[0]);
    }

    public function delete() {
        $sql = new Sql();
        $sql -> query("DELETE FROM tb_users WHERE iduser = :iduser", array(
            ":iduser" => $this -> getiduser()
        ));
    }

    public static function verifyLogin() {
        if (!isset($_SESSION[User::SESSION]) ||
            !$_SESSION[User::SESSION] ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0 ) {

            header("Location: /login");
            exit;
        }
    }

    public static function logout() {
        $_SESSION[User::SESSION] = null;
    }
}