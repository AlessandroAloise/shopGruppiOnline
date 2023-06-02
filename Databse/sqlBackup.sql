DROP TABLE IF EXISTS carts;

CREATE TABLE carts (
  id int(11) NOT NULL AUTO_INCREMENT,
  idUser int(11) DEFAULT NULL,
  idProduct int(11) DEFAULT NULL,
  quantity int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY idUser (idUser),
  KEY idProduct (idProduct),
  CONSTRAINT carts_ibfk_1 FOREIGN KEY (idUser) REFERENCES users (id),
  CONSTRAINT carts_ibfk_2 FOREIGN KEY (idProduct) REFERENCES products (id)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE failed_jobs (
  id int(11) NOT NULL AUTO_INCREMENT,
  uuid varchar(255) DEFAULT NULL,
  connection text DEFAULT NULL,
  queue text DEFAULT NULL,
  payload longtext DEFAULT NULL,
  exception longtext DEFAULT NULL,
  failed_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id),
  UNIQUE KEY uuid (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE groups (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) DEFAULT NULL,
  deadline1 date DEFAULT NULL,
  deadline2 date DEFAULT NULL,
  idGroupLeader int(11) DEFAULT NULL,
  approved tinyint(4) DEFAULT NULL,
  sendEmail1 tinyint(4) DEFAULT NULL,
  sendEmail2 tinyint(4) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY idGroupLeader (idGroupLeader),
  CONSTRAINT groups_ibfk_1 FOREIGN KEY (idGroupLeader) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


DROP TABLE IF EXISTS participations;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE participations (
  id int(11) NOT NULL AUTO_INCREMENT,
  request tinyint(4) DEFAULT NULL,
  idUser int(11) DEFAULT NULL,
  idGroup int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY idUser (idUser),
  KEY idGroup (idGroup),
  CONSTRAINT participations_ibfk_1 FOREIGN KEY (idUser) REFERENCES users (id),
  CONSTRAINT participations_ibfk_2 FOREIGN KEY (idGroup) REFERENCES groups (id)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




DROP TABLE IF EXISTS password_resets;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE password_resets (
  email varchar(320) DEFAULT NULL,
  token varchar(255) DEFAULT NULL,
  created_at timestamp NULL DEFAULT NULL,
  KEY password_resets_email_index (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


DROP TABLE IF EXISTS personal_access_tokens;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE personal_access_tokens (
  id int(11) NOT NULL AUTO_INCREMENT,
  tokenable_id int(11) DEFAULT NULL,
  tokenable_type varchar(255) DEFAULT NULL,
  name varchar(255) DEFAULT NULL,
  token varchar(64) DEFAULT NULL,
  abilities text DEFAULT NULL,
  last_used_at timestamp NULL DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  UNIQUE KEY token (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
;



DROP TABLE IF EXISTS products;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE products (
  id int(11) NOT NULL AUTO_INCREMENT,
  code varchar(255) DEFAULT NULL,
  name varchar(255) DEFAULT NULL,
  description varchar(255) DEFAULT NULL,
  image longblob DEFAULT NULL,
  price decimal(10,2) DEFAULT NULL,
  quantityMin int(11) DEFAULT NULL,
  multiple int(11) DEFAULT NULL,
  idGroup int(11) DEFAULT NULL,
  visible tinyint(4) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY idGroup (idGroup),
  CONSTRAINT products_ibfk_1 FOREIGN KEY (idGroup) REFERENCES groups (id)
) ENGINE=InnoDB AUTO_INCREMENT=356 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


DROP TABLE IF EXISTS users;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) DEFAULT NULL,
  surname varchar(255) DEFAULT NULL,
  email varchar(320) DEFAULT NULL,
  password varchar(255) DEFAULT NULL,
  email_verified_at timestamp NULL DEFAULT NULL,
  remember_token varchar(100) DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



