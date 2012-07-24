SET FOREIGN_KEY_CHECKS=0;


DROP TABLE IF EXISTS `pannonia`.`user`;
DROP TABLE IF EXISTS `pannonia`.`group`;
DROP TABLE IF EXISTS `pannonia`.`news`;


CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `flags` char(1) NOT NULL DEFAULT '0',
  `digest` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_news_user` (`created_by`),
  KEY `fk_news_user1` (`modified_by`),
  CONSTRAINT `fk_news_user` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_news_user1` FOREIGN KEY (`modified_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `rehersals` varchar(45) NOT NULL,
  `leader1` int(11) NOT NULL,
  `leader2` int(11) DEFAULT NULL,
  `image` varchar(15) DEFAULT 'nopic.jpg',
  PRIMARY KEY (`id`),
  KEY `fk_group_user1` (`leader1`),
  KEY `fk_group_user2` (`leader2`),
  CONSTRAINT `fk_group_user1` FOREIGN KEY (`leader1`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_group_user2` FOREIGN KEY (`leader2`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `group` int(11) DEFAULT NULL,
  `nick` varchar(10) NOT NULL,
  `bday` date DEFAULT NULL,
  `rights` char(1) NOT NULL DEFAULT '0',
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_group1` (`group`),
  CONSTRAINT `fk_user_group1` FOREIGN KEY (`group`) REFERENCES `group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


INSERT INTO `pannonia`.`user`
(`name`,
`email`,
`created_at`,
`group`)
VALUES
('sysadmin', 'bibok.andor@gmail.com', NOW(), null),
('Szengyel István', null, NOW(), 4),
('Vadász Dániel', null, NOW(), 4),
('Vadász-Bibók Anett', null, NOW(), 4),
('Urbán Barbara', null, NOW(), 4),
('Greguss Gergő', null, NOW(), 6),
('Liska Zsófia', null, NOW(), 4),
('Szilágyi Zsolt ', null, NOW(), 5);

INSERT INTO `pannonia`.`group`
(`name`,
`description`,
`rehersals`,
`leader1`,
`leader2`)
VALUES
(
'Pöttöm',
'A megalakulásától Liska Gyuláné vezette csoportunk irányítását 2010 szeptemberében lánya vette át. Így óvodásaink szárnypróbálgatásait Liska Zsófia terelgeti. Népi játékok tanulása mellett a néptánc alapjaival ismerkednek.',
'???',
7, null),
(
'Kisgyerek',
'A 2008 óta Vadász-Bibók Anett és Vadász Dániel vezetése alatt táncoló csoportunk tagjai közül sokan a Pöttöm csoportban kezdték meg a néptánc elsajátítását. A Kistarcsáról és a környékről hozzájuk csatlakozó kis táncosokkal együtt létszámuk, lelkesedésük annyira gyarapodott, hogy kinőtték a Civil ház falait. Öröm látni, ahogy évről évre ügyesedve, egyre nagyobb repertoárral állnak nagy sikerrel közönség elé. Így készült már sárközi, somogyi, rábaközi, illetve kalocsai koreográfiájuk is. Láthattuk már őket többször itt, a Görhöny fesztiválon, a folklórtalálkozón, de rendszeresen szerepelnek a Kistarcsai Kiscsillagok elnevezésű rendezvényen is, a Kistarcsai Napokon vagy az együttes évfordulós műsorán, illetve Csömörön is megmutathatták tudásukat. Az idei évben már ők is nagy létszámban vettek részt nyári táborunkban, ahol az új táncanyag (a Galga menti Bag település táncai) alapjait sajátíthatták el. Táncaik: kalocsai, somogyi, rábaközi, bagi táncok. ',
'kedd, péntek 17:30-19:00; Csigaház ',
4, 3),
(
'Ifjúsági',
'A Pannónia Néptáncegyüttes ifjúsági csoportja fiatal alakulat, habár vannak olyan tagjai, akik már 10 éve táncolnak az együttesben. Sőt, ebben a formában, mostani tanáraikkal, Urbán Barbarával és Szengyel Istvánnal is már hat éve dolgoznak együtt. Mégis 2010-ben kinőtték a gyermek kategóriát, és az ifjúsági csoportok közé léptek. Sok sikert könyvelhettek el az eltelt évek alatt, a közös munka meghozta gyümölcsét: 2009-ben az Örökség Gyermek népművészeti szövetség által szervezett gyermek néptánc fesztiválon az ország legjobb gyermekcsoportjai közé jutottak. Így a Mesterségek Ünnepén a budai várban mutathatták be tudásukat. A tavalyi évben –még gyermek korosztályosként – a csepeli Authentica Fesztiválon szerepelek sikeresen. 2010 szeptemberében Érsekújvárott mutatkoztak be egy nemzetközi fesztiválon. Az eltelt évek alatt nagyon sok vidék táncaival megismerkedtek. Kedvenc koreográfiájuk a „Táncolj, kecske!” volt, amely most az „Én országom, Moldova” című moldvai csángó műsorunk része. Emellett dél-alföldi, mezőföldi, mezőségi, szatmári táncok szerepelnek repertoárjukon. Lelkesedésük töretlen, újabb és újabb táncanyagokkal ismerkednek, idén például nyírségi táncokat tanultak.',
'hétfõ, szerda 17:30-19:30; Csigaház ',
5, 2),
(
'Felnőtt',
'Az együttes elsőként megalakult csoportja a 19 éves fennállás alatt nagyon sok helyen szerepelt már. Mind hazai, mind nemzetközi fesztiválokon megmutatták tudásukat. Jártak már Olaszországban, Törökországban, illetve több környező országban is. A hazai seregszemlék közül a Néptáncosok Országos Bemutató Színpadán, közismertebb nevén a minősítő fesztiválon az elmúlt nyolc év során négy alkalommal értek el minősült együttes címet. Emellett több más fesztiválon is megjelentek már. Legutóbb Csepelen szerepeltek sikerrel, ahol a II. Authentica Fesztiválon első helyezést értek el Szengyel István „Isaszegi táncok” című koreográfiájával. Repertoárjukon a Kárpát-medence nagy részének táncai szerepelnek (a teljesség igénye nélkül: bonchidai, illetve kalotaszegi román, magyarszováti, vajdaszentiványi, Kistarcsa környéki szlovák, sárközi, mezőföldi, domaházi, isaszegi), legújabb műsoruk pedig a moldvai csángók világába kalauzolja a nézőt. Tanáruk, koreográfusok Szengyel István. A csoport fontosnak tartja azt is, hogy a néphagyományokat a táncpróbákon kívül is ápolja, a jeles napokat a néphagyományoknak megfelelően ünnepelje meg. ',
'kedd, péntek 19:00-21:30; Csigaház ',
2, null),
(
'Hagyományőrző',
'???',
'???',
8, null),
(
'Szüvellő',
'Csoportjaink között üde színfolt ez a társaság. Olyan lelkes, táncolni vágyó szülőkből alakult, akik gyermekük táncos pályafutását látva szintén kedvet kaptak a tánctanuláshoz. Próbáikon, táncalkalmaikon nem készülnek színpadi bemutatókra, csak a táncolás öröméért járnak össze. A tagok buzgó résztvevői táncházainknak, ahol ők is megmutatják, milyen táncokkal is ismerkedtek már meg. ',
'csütörtök 19:00-21:00; Civil-ház ',
6, null);

SET FOREIGN_KEY_CHECKS=1;
