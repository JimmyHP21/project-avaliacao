<?php

namespace Project\Model;

use \Project\Model;
use \Project\Banco\Sql;

class Posts extends Model {

    public static function listAllPosts() {
        $sql = new Sql();
        return $sql -> select("SELECT * FROM tb_posts ORDER BY description");
    }

    public static function getPostsPage($page = 1, $itemsPerPage = 2) {
        $start = ($page - 1 ) * $itemsPerPage;

        $sql = new Sql();
        $results = $sql -> select("SELECT SQL_CALC_FOUND_ROWS * FROM tb_posts LIMIT $start, $itemsPerPage");

        $resultsTotal = $sql -> select("SELECT FOUND_ROWS() AS nrTotal");

        return [
            'data' => $results,
            'total' => (int)$resultsTotal[0]["nrTotal"],
            'pages' => ceil($resultsTotal[0]["nrTotal"] / $itemsPerPage)
        ];
    }

    public function getPostById($idpost) {
        $sql = new Sql();
        $results = $sql -> select("SELECT * FROM tb_posts WHERE idpost = :idpost", array(
            ":idpost" => $idpost
        ));

        $this -> setData($results[0]);
    }

    public function updatePost() {
        $sql = new Sql();
        $userLogged = User::getUserId();
        $results = $sql -> select("CALL sp_post_update(:idpost, :description, :type,  :iduser)", array(
            ":idpost" => $this -> getidpost(),
            ":description" => $this -> getdescription(),
            ":type" => $this -> gettype(),
            ":iduser" => (int)$userLogged
        ));

        $this -> setData($results[0]);
    }

    public function savePost() {
        $sql = new Sql();
        $userLogged = User::getUserId();
        $results = $sql -> select("CALL sp_post_save(:description, :type,  :iduser)", array(
            ":description" => $this -> getdescription(),
            ":type" => $this -> gettype(),
            ":iduser" => (int)$userLogged
        ));

        $this -> setData($results[0]);
    }

    public function deletePost() {
        $sql = new Sql();
        $idpost = $this -> getidpost();
        $sql -> query("DELETE FROM tb_posts WHERE idpost = :idpost", array (
            ":idpost" => (int)$idpost
        ));
        Posts::deleteAllCommentsByPost($idpost);

    }

    public static function deleteAllCommentsByPost($idpost) {
        $sql = new Sql();
        $sql -> query("DELETE FROM tb_comments WHERE idpost = :idpost", [
            ':idpost' => $idpost
        ]);
    }
}