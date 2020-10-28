<?php

namespace Project\Model;

use Project\Banco\Sql;
use Project\Model;

class Notification extends Model {
    public static function listAllNotification($page = 1, $itemsPerPage = 4) {
        $start = ($page - 1 ) * $itemsPerPage;

        $userLogged = (int)getUserId();
        $sql = new Sql();
        $results = $sql -> select("SELECT SQL_CALC_FOUND_ROWS * FROM tb_notification WHERE iduser = :iduser ORDER BY description LIMIT $start, $itemsPerPage", [
            ':iduser' => $userLogged
        ]);

        $resultsTotal = $sql -> select("SELECT FOUND_ROWS() AS nrTotal");

        return [
            'data' => $results,
            'total' => (int)$resultsTotal[0]["nrTotal"],
            'pages' => ceil($resultsTotal[0]["nrTotal"] / $itemsPerPage)
        ];
    }

    public function getNotificationById($idnotification) {
        $sql = new Sql();

        $userLogged = (int)getUserId();

        $results = $sql -> select("SELECT * FROM tb_notification WHERE idnotification = :idnotification AND iduser = :iduser", array(
            ":idnotification" => $idnotification,
            ':iduser' => $userLogged
        ));

        $this -> setData($results[0]);
    }

    public static function createNotification($comment, $idpost) {
        $sql = new Sql();

        $sql -> select("INSERT INTO tb_notification (description, iduser) VALUES(:description, :iduser)", array(
            ":description" => $comment,
            ":iduser" => $idpost,
        ));
    }

    public function deleteNotification($idnotif) {
        $userLogged = getUserId();

        $sql = new Sql();
        $sql -> query("DELETE FROM tb_notification WHERE idnotification = :idnotification AND iduser = :iduser", array(
            ":idnotification" => $idnotif,
            ':iduser' => $userLogged
        ));
    }
}