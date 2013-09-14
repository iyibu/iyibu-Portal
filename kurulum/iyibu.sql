-- --------------------------------------------------------
-- iyibu!Portal v1.0 Kurulum Dosyası iyibu.sql
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- tablo yapısı dökülüyor iyibu.aktif_uye
DROP TABLE IF EXISTS `aktif_uye`;
CREATE TABLE IF NOT EXISTS `aktif_uye` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isim` char(255) NOT NULL,
  `session` char(255) NOT NULL,
  `yer` char(255) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time` char(255) NOT NULL,
  `ip` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

-- Dumping data for table iyibu.aktif_uye: 0 rows
DELETE FROM `aktif_uye`;
/*!40000 ALTER TABLE `aktif_uye` DISABLE KEYS */;
/*!40000 ALTER TABLE `aktif_uye` ENABLE KEYS */;


-- tablo yapısı dökülüyor iyibu.ayarlar
DROP TABLE IF EXISTS `ayarlar`;
CREATE TABLE IF NOT EXISTS `ayarlar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isim` tinytext NOT NULL,
  `deger` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin5;

-- Dumping data for table iyibu.ayarlar: 1 rows
DELETE FROM `ayarlar`;
/*!40000 ALTER TABLE `ayarlar` DISABLE KEYS */;
INSERT INTO `ayarlar` (`id`, `isim`, `deger`) VALUES
	(1, 'tema_klasik', '|');
/*!40000 ALTER TABLE `ayarlar` ENABLE KEYS */;


-- tablo yapısı dökülüyor iyibu.menu
DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isim` char(255) NOT NULL,
  `resim` char(255) NOT NULL,
  `link` char(255) NOT NULL,
  `yer` char(255) NOT NULL,
  `sira` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin5;

-- Dumping data for table iyibu.menu: 2 rows
DELETE FROM `menu`;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `isim`, `resim`, `link`, `yer`, `sira`) VALUES
	(2, 'ust-menu', '', '', 'iyibu-menu-list', 0),
	(1, 'Anasayfa', '_tema/klasik/img/76.png', 'index.html', 'ust-menu', 1);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;


-- tablo yapısı dökülüyor iyibu.modul
DROP TABLE IF EXISTS `modul`;
CREATE TABLE IF NOT EXISTS `modul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` char(255) NOT NULL,
  `aciklama` char(255) NOT NULL,
  `kelime` char(255) NOT NULL,
  `icon` char(255) NOT NULL,
  `ana_tip` char(50) NOT NULL,
  `oku_tip` char(50) NOT NULL,
  `kat_tip` char(50) NOT NULL,
  `blok_tip` char(50) NOT NULL,
  `gizlilik` tinyint(1) NOT NULL,
  `seo` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

-- Dumping data for table iyibu.modul: 0 rows
DELETE FROM `modul`;
/*!40000 ALTER TABLE `modul` DISABLE KEYS */;
/*!40000 ALTER TABLE `modul` ENABLE KEYS */;


-- tablo yapısı dökülüyor iyibu.modulblok
DROP TABLE IF EXISTS `modulblok`;
CREATE TABLE IF NOT EXISTS `modulblok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bisim` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sira` int(11) NOT NULL,
  `modul` char(255) CHARACTER SET utf8 NOT NULL,
  `tema` char(255) CHARACTER SET utf8 NOT NULL,
  `alt` char(3) CHARACTER SET utf8 NOT NULL,
  `yer` char(10) CHARACTER SET utf8 NOT NULL,
  `fdeger` varchar(1000) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5 ROW_FORMAT=DYNAMIC;

-- Dumping data for table iyibu.modulblok: 0 rows
DELETE FROM `modulblok`;
/*!40000 ALTER TABLE `modulblok` DISABLE KEYS */;
/*!40000 ALTER TABLE `modulblok` ENABLE KEYS */;


-- tablo yapısı dökülüyor iyibu.modulicerik
DROP TABLE IF EXISTS `modulicerik`;
CREATE TABLE IF NOT EXISTS `modulicerik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` char(255) NOT NULL,
  `icerik` text NOT NULL,
  `resim` char(255) NOT NULL,
  `etiket` char(255) NOT NULL,
  `seo` char(255) NOT NULL,
  `modul` char(50) NOT NULL,
  `ekleyen` char(50) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kategori` char(50) NOT NULL,
  `puan` mediumint(9) NOT NULL,
  `oy_verenler` text NOT NULL,
  `kod` tinyint(1) NOT NULL,
  `onay` tinyint(1) NOT NULL DEFAULT '0',
  `sayac` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

-- Dumping data for table iyibu.modulicerik: 0 rows
DELETE FROM `modulicerik`;
/*!40000 ALTER TABLE `modulicerik` DISABLE KEYS */;
/*!40000 ALTER TABLE `modulicerik` ENABLE KEYS */;


-- tablo yapısı dökülüyor iyibu.modulkategori
DROP TABLE IF EXISTS `modulkategori`;
CREATE TABLE IF NOT EXISTS `modulkategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isim` tinytext NOT NULL,
  `resim` tinytext NOT NULL,
  `kelime` tinytext NOT NULL,
  `aciklama` text NOT NULL,
  `modul` tinytext NOT NULL,
  `seo` tinytext NOT NULL,
  `kayitlar` mediumint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

-- Dumping data for table iyibu.modulkategori: 0 rows
DELETE FROM `modulkategori`;
/*!40000 ALTER TABLE `modulkategori` DISABLE KEYS */;
/*!40000 ALTER TABLE `modulkategori` ENABLE KEYS */;


-- tablo yapısı dökülüyor iyibu.uyeler
DROP TABLE IF EXISTS `uyeler`;
CREATE TABLE IF NOT EXISTS `uyeler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `kullaniciadi` longtext CHARACTER SET utf8 NOT NULL,
  `Adi` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Soyadi` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Dogum` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Parola` longtext CHARACTER SET utf8 NOT NULL,
  `Meslek` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Sehir` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Web` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Imza` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Kayittarihi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `songiris` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Yetki` int(11) NOT NULL DEFAULT '0',
  `facebook` int(11) NOT NULL DEFAULT '0',
  `onay` varchar(11) CHARACTER SET utf8 NOT NULL,
  `Ip` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=857 DEFAULT CHARSET=latin5 ROW_FORMAT=DYNAMIC;

-- Dumping data for table iyibu.uyeler: 1 rows
DELETE FROM `uyeler`;
/*!40000 ALTER TABLE `uyeler` DISABLE KEYS */;
INSERT INTO `uyeler` (`ID`, `kullaniciadi`, `Adi`, `Soyadi`, `Dogum`, `Parola`, `Meslek`, `Sehir`, `Web`, `Imza`, `Kayittarihi`, `songiris`, `Email`, `Yetki`, `facebook`, `onay`, `Ip`) VALUES
	(1, 'admin', 'Admin', 'Administrator', '03.05.1996', '21232f297a57a5a743894a0e4a801fc3', 'Site Kurucusu', 'Türkiye', '', 'admin', NOW(), NOW(), 'tetadamim@gmail.com', 2, 0, '', '');
/*!40000 ALTER TABLE `uyeler` ENABLE KEYS */;


-- tablo yapısı dökülüyor iyibu.yetki
DROP TABLE IF EXISTS `yetki`;
CREATE TABLE IF NOT EXISTS `yetki` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isim` text NOT NULL,
  `yetkiler` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin5;

-- Dumping data for table iyibu.yetki: 2 rows
DELETE FROM `yetki`;
/*!40000 ALTER TABLE `yetki` DISABLE KEYS */;
INSERT INTO `yetki` (`id`, `isim`, `yetkiler`, `tarih`) VALUES
	(1, 'Üye', '', '2013-09-13 00:12:04'),
	(2, 'Yönetici', 'site,s_ist,s_ayr,s_blg,s_bynt,s_mynt,s_adzn,modul,m_Haberler,tum_modul,yeni_modul,tema,t_ayr,uye,u_ist,u_uye,u_yetki,u_pst,u_yni,vt,vt_sql,vt_ydk', '2013-09-12 23:40:35');
/*!40000 ALTER TABLE `yetki` ENABLE KEYS */;


-- tablo yapısı dökülüyor iyibu.yorumlar
DROP TABLE IF EXISTS `yorumlar`;
CREATE TABLE IF NOT EXISTS `yorumlar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yorum` text NOT NULL,
  `ekleyen` char(50) NOT NULL,
  `modul` varchar(100) NOT NULL,
  `icerik` varchar(100) NOT NULL,
  `alt` int(11) NOT NULL DEFAULT '0',
  `puan` int(11) NOT NULL DEFAULT '0',
  `oy_verenler` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `onay` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin5;

-- Dumping data for table iyibu.yorumlar: 0 rows
DELETE FROM `yorumlar`;
/*!40000 ALTER TABLE `yorumlar` DISABLE KEYS */;
/*!40000 ALTER TABLE `yorumlar` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
