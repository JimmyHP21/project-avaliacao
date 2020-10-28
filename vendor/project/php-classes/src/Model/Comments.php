<?php

namespace Project\Model;

use \Project\Model;
use \Project\Banco\Sql;

class Comments extends Model {

    public static function listAllCommentsByPost($idPost, $page = 1, $itemsPerPage = 4) {
        $start = ($page - 1 ) * $itemsPerPage;

        $sql = new Sql();
        $results = $sql -> select("SELECT SQL_CALC_FOUND_ROWS * FROM tb_comments a
                                            inner join  tb_users b USING (iduser)
                                            inner join tb_posts c USING (idpost)
                                        WHERE c.idpost = :idpost
                                        ORDER BY a.valuedestaque AND a.dtcommnet AND a.destaquecomment LIMIT $start, $itemsPerPage", [
                                            ':idpost' => $idPost
        ]);

        $resultsTotal = $sql -> select("SELECT FOUND_ROWS() AS nrTotal");

        return [
            'data' => $results,
            'total' => (int)$resultsTotal[0]["nrTotal"],
            'pages' => ceil($resultsTotal[0]["nrTotal"] / $itemsPerPage)
        ];
    }

    public function getCommentById($idcomment) {
        $sql = new Sql();
        $results = $sql -> select("SELECT * FROM tb_comments WHERE idcomment = :idcomment", [
            ':idcomment' => (int)$idcomment
        ]);

        $this -> setData($results[0]);
    }

    public function saveComment($idpost) {
        $sql = new Sql();
        $userBalance = getBalance();
        $userLogged = getUserId();
        $isSignature = getIsSignature();

        $postResult = $sql -> select("SELECT * FROM tb_posts WHERE idpost = :idpost", [':idpost' => $idpost]);
        $post = $postResult[0];

        $postBalance = $this -> getvaluedestaque();
        $isSpotlight = $this -> getdestaquecomment();

        if ($isSignature !== 1 || $isSpotlight) {
            if ($isSpotlight) {
                if ( (float)$postBalance > (float)$userBalance) {
                    echo "balance insufficient";
                    exit;
                } else {
                    Notification::createNotification('Commentario feito com um destaque no valor de '.$postBalance, $post['iduser']);
                    Transaction::createTransaction('Transacao realizada para criar um commentario', $postBalance, $post['iduser']);
                }
            } else {
                echo "precisar ser assinante";
                exit;
            }
        }


        $results = $sql -> select("CALL sp_comment_save(:commentvalue, :destaquecomment, :valuedestaque, :idpost, :iduser)", array(
            ":commentvalue" => $this -> getcommentvalue(),
            ":destaquecomment" => $this -> getdestaquecomment(),
            ":valuedestaque" => (int)$postBalance,
            ":idpost" => (int)$idpost,
            ":iduser" => (int)$userLogged
        ));

        $this -> setData($results[0]);

        Notification::createNotification('Commentario feito em uma publicacao sua', $post['iduser']);
    }

    public function updateComment($idpost) {
        $sql = new Sql();
        $userLogged = User::getUserId();

        $results = $sql -> select("CALL sp_comment_update(:idcomment, :commentvalue, :destaquecomment, :valuedestaque, :idpost, :iduser)", array(
            ":idcomment" => $this -> getidcomment(),
            ":commentvalue" => $this -> getcommentvalue(),
            ":destaquecomment" => $this -> getdestaquecomment(),
            ":valuedestaque" => $this -> getvaluedestaque(),
            ":idpost" => (int)$idpost,
            ":iduser" => (int)$userLogged,
        ));

        $this -> setData($results[0]);
    }

    public function deleteComment($idpost) {
        $sql = new Sql();

        $post = new Posts();
        $post -> getPostById((int)$idpost);
        $postValues = $post -> getvalues();

        $iduser = getUserId();
        $idcomment = $this -> getidcomment();
        $idusercomment = $this -> getiduser();

        if ($iduser !== $idusercomment && $postValues['iduser'] !== $iduser ) {
            echo 'nao pode';
            exit;
        }

        if ((int)$postValues['iduser'] === (int)$iduser || (int)$idusercomment === (int)$iduser) {
            $sql -> query("DELETE FROM tb_comments WHERE idcomment = :idcomment", array(
                ":idcomment" => (int)$idcomment
            ));
        }

    }
}