
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databank: `webwinkel`
--

-- DROP DATABASE IF EXISTS `webwinkel`;
-- CREATE DATABASE IF NOT EXISTS `webwinkel`;
-- USE `webwinkel`;
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--
DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `productnummer` 	INT(10) NOT NULL,
  `productnaam` 	varchar(30) NOT NULL,
  `prijs` 			DECIMAL(5,2) NOT NULL,
  `beschrijving` 	varchar(9999) NOT NULL,  
  `leverbaar`		ENUM('ja', 'nee'),
  `voorraad` 		INT(5),  
  PRIMARY KEY (`productnummer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `product`
--
INSERT INTO `product` (`productnummer`, `productnaam`, `beschrijving`, `prijs`, `leverbaar`, `voorraad`) VALUES
('111', 'Telefoon 1', 'Hier de beschrijving van dit product.', '299.95', 'ja', '12'),
('222', 'Telefoon 2', 'Hier de beschrijving van dit product.', '399.95', 'ja', '24'),
('333', 'Telefoon 3', 'Hier de beschrijving van dit product.', '249.95', 'ja', '124'),
('444', 'Telefoon 4', 'Hier de beschrijving van dit product.', '89.95', 'nee', '14'),
('555', 'Telefoon 5', 'Hier de beschrijving van dit product.', '189.95', 'ja', '11'),
('666', 'Telefoon 6', 'Hier de beschrijving van dit product.', '289.95', 'ja', '34'),
('777', 'Telefoon 7', 'Hier de beschrijving van dit product.', '249.95', 'ja', '23'),
('888', 'Telefoon 8', 'Hier de beschrijving van dit product.', '529.95', 'ja', '56'),
('999', 'Telefoon 9', 'Hier de beschrijving van dit product.', '339.95', 'nee', '2');

DROP TABLE IF EXISTS `klant`;
CREATE TABLE klant (
	klantnr 	INT UNSIGNED NOT NULL AUTO_INCREMENT,
	naam 		VARCHAR(50) NOT NULL,
	adres 		VARCHAR(40) NOT NULL,
	postcode 	VARCHAR(7) NOT NULL,
	plaats		VARCHAR(40) NOT NULL,
	emailadres	VARCHAR(60) NOT NULL,
	password 	CHAR(40) NOT NULL,
	KEY(klantnr),
	PRIMARY KEY (emailadres)
);

INSERT INTO `klant` (`naam`, `adres`, `postcode`, `plaats`, `emailadres`, `password`) VALUES
('Marieke Dillenburg', 'Koningsweg 34', '2351GF', 'Durgerdam', 'm.dillenburg@mail.nl', SHA1('mypass')),
('Mark Dijkman', 'Koningsweg 34', '2351GF', 'Durgerdam', 'mark.dijkman@mail.nl', SHA1('mypass')),
('Sjaak van Dam', 'Koningsweg 34', '2351GF', 'Durgerdam', 'svd@mail.nl', SHA1('mypass')),
('Testgebruiker', 'Koningsweg 34', '2351GF', 'Test', 'test@test.nl', SHA1('test'));

--
-- Tabelstructuur voor tabel `bestelling`
--
DROP TABLE IF EXISTS `bestelling`;
CREATE TABLE IF NOT EXISTS `bestelling` (
  `bestelnummer` 	INT(10) NOT NULL AUTO_INCREMENT,
  `klantnummer` 	INT(6) NOT NULL,
  `besteldatum` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
  `status`			ENUM('open', 'betaald', 'verzonden' ) DEFAULT 'open',
  `totaalprijs` 	DECIMAL(5,2) NOT NULL,
  PRIMARY KEY (`bestelnummer`, `klantnummer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tabelstructuur voor tabel `bestelregel`
--

DROP TABLE IF EXISTS `bestelregel`;
CREATE TABLE IF NOT EXISTS `bestelregel` (
  `bestelnummer` 	INT(10) NOT NULL,
  `productnummer` 	INT(10) NOT NULL,
  `productprijs` 	DECIMAL(5,2) NOT NULL,
  `aantal_besteld` 	INT(3) NOT NULL,
  PRIMARY KEY (`bestelnummer`, `productnummer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `afbeelding`;
CREATE TABLE afbeelding (
	`image_id` 	tinyint(3) NOT NULL AUTO_INCREMENT,
	`image_type` 	varchar(25) NOT NULL,
	`image` 		longblob NOT NULL,
	`image_size` 	varchar(25) NOT NULL,
	`image_ctgy` 	varchar(25) NOT NULL,
	`image_name` 	varchar(50) NOT NULL,
	KEY image_id (`image_id`)
);

DROP TABLE IF EXISTS `product_afbeelding`;
CREATE TABLE product_afbeelding (
  `productnummer` 	INT(10) NOT NULL,
  `image_id` 		tinyint(3) NOT NULL,
  PRIMARY KEY image_id (`productnummer`, `image_id`)
);
ALTER TABLE `product_afbeelding` 
ADD  FOREIGN KEY fk_afbeelding (`image_id`) 
REFERENCES `afbeelding` (`image_id`) 
ON UPDATE CASCADE
ON DELETE RESTRICT;

INSERT INTO `product_afbeelding` (`productnummer`, `image_id`) VALUES 
('111', '1'),
('222', '2'),
('333', '3'),
('444', '4'),
('555', '6'),
('666', '5'),
('777', '7'),
('888', '8'),
('999', '2');
