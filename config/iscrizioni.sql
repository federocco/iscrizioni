# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.29)
# Database: iscrizioni
# Generation Time: 2014-12-09 22:15:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table anagrafica
# ------------------------------------------------------------

CREATE TABLE `anagrafica` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cognome` varchar(100) NOT NULL DEFAULT '',
  `nome` varchar(100) NOT NULL DEFAULT '',
  `data_nascita` date DEFAULT NULL,
  `indirizzo` varchar(200) DEFAULT NULL,
  `civico` varchar(10) DEFAULT NULL,
  `cap` varchar(20) DEFAULT NULL,
  `comune` varchar(100) DEFAULT NULL,
  `prov` varchar(100) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  `user_op` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table annuale
# ------------------------------------------------------------

CREATE TABLE `annuale` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_idiscritto` int(11) unsigned DEFAULT NULL,
  `tessera` varchar(30) DEFAULT NULL,
  `anno` year(4) NOT NULL,
  `pagato` int(11) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `modify_datetime` datetime DEFAULT NULL,
  `user_op` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tessera` (`tessera`,`fk_idiscritto`,`anno`),
  KEY `fk_idiscritto` (`fk_idiscritto`),
  CONSTRAINT `annuale_ibfk_1` FOREIGN KEY (`fk_idiscritto`) REFERENCES `anagrafica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table utenti
# ------------------------------------------------------------

CREATE TABLE `utenti` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
