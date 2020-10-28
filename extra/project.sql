CREATE DATABASE  IF NOT EXISTS db_project /*!40100 DEFAULT CHARACTER SET utf8 */;
USE db_project;

CREATE TABLE tb_users (
  iduser int(11) NOT NULL AUTO_INCREMENT,
  desname varchar(255) NOT NULL,
  deslogin varchar(64) NOT NULL,
  despassword varchar(256) NOT NULL,
  balance int(10),
  signature tinyint(1),
  PRIMARY KEY (iduser)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO tb_users(desname, deslogin, despassword, balance, signature) VALUES ('Admin', 'admin', '$2y$12$YlooCyNvyTji8bPRcrfNfOKnVMmZA9ViM2A3IpFjmrpIbp5ovNmga', 10000, 1);

CREATE TABLE tb_posts (
    idpost int(11) NOT NULL AUTO_INCREMENT,
    description varchar(255) NOT NULL,
    type tinyint(1) NOT NULL,
    iduser int(11) NOT NULL,
    PRIMARY KEY (idpost)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

CREATE TABLE tb_comments (
    idcomment int(11) NOT NULL AUTO_INCREMENT,
    commentvalue varchar(255) NOT NULL,
    destaquecomment tinyint(1) DEFAULT '0',
    valuedestaque int(10),
    dtcommnet timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    idpost int(11) NOT NULL,
    iduser int(11) NOT NULL,
    PRIMARY KEY (idcomment)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

CREATE TABLE tb_transaction (
    idtransaction int(11) NOT NULL AUTO_INCREMENT,
    description varchar(255) NOT NULL,
    value int(11) NOT NULL,
    iduser int(11) NOT NULL,
    PRIMARY KEY (idtransaction)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

CREATE TABLE tb_notification (
    idnotification int(11) NOT NULL AUTO_INCREMENT,
    description varchar(255) NOT NULL,
    iduser int(11) NOT NULL,
    PRIMARY KEY (idnotification)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE sp_users_save (
pdesname VARCHAR(255),
pdeslogin VARCHAR(64),
pdespassword VARCHAR(256),
pbalance INT,
passinature TINYINT
)
BEGIN

  INSERT INTO tb_users (desname, deslogin, despassword, balance, signature)
        VALUES(pdesname, pdeslogin, pdespassword, pbalance, passinature);

  SELECT * FROM tb_users  WHERE iduser = LAST_INSERT_ID();

END ;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE sp_usersupdate_save(
piduser INT,
pdesname VARCHAR(255),
pdeslogin VARCHAR(64),
pdespassword VARCHAR(256),
pbalance INT,
psignature TINYINT
)
BEGIN

    UPDATE tb_users
    SET
        desname = pdesname,
        deslogin = pdeslogin,
        despassword = pdespassword,
        balance = pbalance,
        signature = psignature
  WHERE iduser = piduser;

    SELECT * FROM tb_users WHERE iduser = piduser;

END ;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE sp_post_save (
pdescription VARCHAR(255),
ptype TINYINT,
piduser INT
)
BEGIN

  INSERT INTO tb_posts (description, type, iduser)
        VALUES(pdescription, ptype, piduser);

  SELECT * FROM tb_posts  WHERE idpost = LAST_INSERT_ID();

END ;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE sp_post_update (
pidpost INT,
pdescription VARCHAR(255),
ptype TINYINT,
piduser INT
)
BEGIN

  UPDATE tb_posts
      SET description = pdescription,
          type = ptype,
          iduser = piduser
    WHERE idpost = pidpost;

  SELECT * FROM tb_posts  WHERE idpost = pidpost;

END ;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE sp_comment_save (
pcomment VARCHAR(255),
pdestaque TINYINT,
pdestaquevalue INT,
pidpost INT,
piduser INT
)
BEGIN

  INSERT INTO tb_comments (commentvalue, destaquecomment, valuedestaque, idpost, iduser)
        VALUES(pcomment, pdestaque, pdestaquevalue, pidpost, piduser);

  SELECT * FROM tb_comments  WHERE idcomment = LAST_INSERT_ID();

END ;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE sp_comment_update (
pidcomment INT,
pcomment VARCHAR(255),
pdestaque TINYINT,
pdestaquevalue INT,
pidpost INT,
piduser INT
)
BEGIN

  UPDATE tb_comments
      SET commentvalue = pcomment,
          destaquecomment = pdestaque,
          valuedestaque = pdestaquevalue,
          idpost = pidpost,
          iduser = piduser
    WHERE idcomment = pidcomment;

  SELECT * FROM tb_comments  WHERE idcomment = pidcomment;

END ;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE sp_notification_save (
pcomment VARCHAR(255),
piduser INT
)
BEGIN

  INSERT INTO tb_notification (description, iduser)
        VALUES(pcomment, piduser);

  SELECT * FROM tb_notification  WHERE idnotification = LAST_INSERT_ID();

END ;;
DELIMITER ;