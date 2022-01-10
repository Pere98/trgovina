drop database if exists uporabniki;
create database uporabniki;
use uporabniki;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE `users` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  `ime` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `priimek` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `naslov` varchar(155) COLLATE utf8_slovenian_ci,
  `status` varchar(45) COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

INSERT INTO `users` (id, username, password, ime, priimek, email, status) VALUES 
(1,'admin', 'ep', 'ime1', 'priimek1', 'nek.mail@mail.com', 'admin');
INSERT INTO `users` (id, username, password, ime, priimek, email, status) VALUES 
(2,'prodajalec', 'ep', 'ime2', 'priimek2', 'nek.mail2@mail.com', 'prodajalec');
INSERT INTO `users` (id, username, password, ime, priimek, email, status) VALUES 
(3,'stranka', 'ep', 'ime3', 'priimek3', 'nek.mail3@mail.com', 'stranka');


CREATE TABLE `izdelki` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `opis` varchar(145) COLLATE utf8_slovenian_ci NOT NULL,
  `lastnik` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `cena` varchar(45) ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- vnosi v tabelo
INSERT INTO `izdelki`  VALUES (1,'aa','aa','aa',1990);
INSERT INTO `izdelki`  VALUES (2,'bb','bb','bb',1990);
INSERT INTO `izdelki`  VALUES (3,'cc','cc','cc',1990);



CREATE TABLE `narocila` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kupec` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `prodajalec` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `predmet` varchar(45) COLLATE utf8_slovenian_ci NOT NULL,
  `cena` varchar(45) ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `ocene` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `izdelek_id` int(11) NOT NULL,
  `ocena` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into ocene (id, izdelek_id, ocena) values (1, 1, 5);
insert into ocene (id, izdelek_id, ocena) values (2, 1, 1);
