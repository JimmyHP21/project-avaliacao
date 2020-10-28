<?php

namespace Project\Model;

use Project\Banco\Sql;
use Project\Model;

class Transaction extends Model {
    public static function listAllTransaction($page = 1, $itemsPerPage = 4) {
        $start = ($page - 1 ) * $itemsPerPage;

        $sql = new Sql();
        $results = $sql -> select("SELECT * FROM tb_transaction ORDER BY description LIMIT $start, $itemsPerPage");

        $resultsTotal = $sql -> select("SELECT FOUND_ROWS() AS nrTotal");

        return [
            'data' => $results,
            'total' => (int)$resultsTotal[0]["nrTotal"],
            'pages' => ceil($resultsTotal[0]["nrTotal"] / $itemsPerPage)
        ];
    }

    public static function createTransaction($comment, $value, $idpost) {
        $sql = new Sql();

        $sql -> select("INSERT INTO tb_transaction (description, value, iduser) VALUES(:description, :value, :iduser)", array(
            ":description" => $comment,
            ":value" => $value,
            ":iduser" => $idpost,
        ));
    }
    public function deleteTransaction($idtransaction) {
        $sql = new Sql();
        $sql -> query("DELETE FROM tb_transaction WHERE idtransaction = :idtransaction", array(
            ":idtransaction" => $idtransaction
        ));
    }
}