-- phpMyAdmin SQL Dump
-- version 4.0.10.1
-- http://www.phpmyadmin.net
--
-- Računalo: localhost
-- Vrijeme generiranja: Lis 18, 2016 u 11:04 PM
-- Verzija poslužitelja: 5.5.53
-- PHP verzija: 5.6.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza podataka: `zadmin_gp`
--

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `status` text NOT NULL,
  `signature` text CHARACTER SET latin1 NOT NULL,
  `lastactivity` text CHARACTER SET latin1 NOT NULL,
  `boja` text CHARACTER SET latin1 NOT NULL,
  `login_session` text CHARACTER SET latin1 NOT NULL,
  `avatar` varchar(999) CHARACTER SET latin1 DEFAULT 'nema_avatar.png',
  `lastactivityname` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Izbacivanje podataka za tablicu `admin`
--

INSERT INTO `admin` (`id`, `fname`, `lname`, `username`, `password`, `email`, `status`, `signature`, `lastactivity`, `boja`, `login_session`, `avatar`, `lastactivityname`) VALUES
(1, 'Alen', 'Morenja', 'morenja', '7fe029bfa73529ba489782dc05230939a40fe5d3', 'morenja@hotmail.com', 'admin', '', '1476824161', '', '', 'nema_avatar.png', 'Pregled strane - Početna'),
(2, 'Tomislav', '', 'Tomislav', '0500dfffeb46867a86245181d7866cbadf23258c', 'tomica@tomica.com', 'admin', '', '1476824188', 'red', '', 'no_avatar.png', 'Pregled strane - Početna');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `banovi`
--

CREATE TABLE IF NOT EXISTS `banovi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klijentid` int(11) DEFAULT NULL,
  `vreme` int(11) DEFAULT NULL,
  `razlog` text,
  `trajanje` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `billing`
--

CREATE TABLE IF NOT EXISTS `billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klijentid` int(11) DEFAULT NULL,
  `iznos` double NOT NULL DEFAULT '0',
  `datum` text,
  `status` varchar(16) DEFAULT 'Na cekanju',
  `vreme` text NOT NULL,
  `invoice` varchar(60) NOT NULL DEFAULT '0',
  `transactionid` varchar(60) NOT NULL DEFAULT '0',
  `currency` int(2) NOT NULL DEFAULT '1',
  `description` varchar(60) NOT NULL DEFAULT '0',
  `paytype` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `billing_currency`
--

CREATE TABLE IF NOT EXISTS `billing_currency` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `multiply` double NOT NULL DEFAULT '1',
  `name` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `sign` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `zemlja` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Izbacivanje podataka za tablicu `billing_currency`
--

INSERT INTO `billing_currency` (`cid`, `multiply`, `name`, `sign`, `zemlja`) VALUES
(1, 1, 'Euro', '€', 'cg'),
(2, 123.34, 'Dinar', 'din', 'srb'),
(3, 1.96, 'Konvertabilna marka', 'km', 'bih'),
(4, 7.67, 'Kuna', 'kn', 'hr'),
(5, 61.67, 'Makedonski denar', 'den', 'mk');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `billing_log`
--

CREATE TABLE IF NOT EXISTS `billing_log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `clientid` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `adminid` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `billing_sms`
--

CREATE TABLE IF NOT EXISTS `billing_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text,
  `time` varchar(164) NOT NULL,
  `message` varchar(64) NOT NULL,
  `sender` varchar(64) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `price` varchar(64) DEFAULT NULL,
  `currency` varchar(64) DEFAULT NULL,
  `service_id` varchar(64) DEFAULT NULL,
  `message_id` varchar(64) DEFAULT NULL,
  `keyword` varchar(64) DEFAULT NULL,
  `shortcode` varchar(64) DEFAULT NULL,
  `operator` varchar(64) DEFAULT NULL,
  `billing_type` varchar(64) DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  `sig` varchar(64) DEFAULT NULL,
  `revenue` double(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `billing_smszemlje`
--

CREATE TABLE IF NOT EXISTS `billing_smszemlje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poruka` text NOT NULL,
  `broj` text NOT NULL,
  `cijena` text NOT NULL,
  `status` text NOT NULL,
  `zemlja` text NOT NULL,
  `currency` text NOT NULL,
  `dodatno` text NOT NULL,
  `disclaimer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Izbacivanje podataka za tablicu `billing_smszemlje`
--

INSERT INTO `billing_smszemlje` (`id`, `poruka`, `broj`, `cijena`, `status`, `zemlja`, `currency`, `dodatno`, `disclaimer`) VALUES
(1, 'TXT MHOST', '091810700', '2.34', 'Da', 'Bosna i Hercegovina', 'KM', '', 'Cena: 2.34 KM Podrška: morenja@hotmail.com Mobilna Naplata: fortumo.com'),
(2, 'TAP MHOST', '141951', '106.20', 'Da', 'Macedonia', 'MKD', '', 'Цена: 106.20 MKD Подршка: morenja@hotmail.com Мобилно плаќање нa fortumo.com'),
(3, '	FOR MHOST', '14741', '1.02', 'Da', 'Montenegro', '€', '', 'Price: 1.02 € Support: morenja@hotmail.com Mobile Payment by Fortumo.com'),
(4, 'TXT15 MHOST', '866866', '15.00', 'Da', 'Croatia', 'HRK', '', 'Cijena: 15 HRK Podrška: morenja@hotmail.com Mobilni plaćanja Fortumo.com Tehnička podrška(davatelj usluge): Telekomunikacijske usluge d.o.o., Međimurska 28, 42000 Varaždin, MB: 070096612, OIB 12385860076. Tel: 042 500 871.'),
(5, '150 MHOST', '1310', '180.00', 'Da', 'Serbia', 'RSD', '+ 1 Standard SMS', '	Price: 180.00 RSD + 1 Standard SMS Support: morenja@hotmail.com Mobile Payment by Fortumo.com'),
(6, 'FOR MHOST', '89000', '0.99', 'Da', 'Germany', 'EUR', '', 'Preis: 0.99 EUR Support: morenja@hotmail.com Powered by fortumo.de');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `box`
--

CREATE TABLE IF NOT EXISTS `box` (
  `boxid` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ip` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `routeip` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `login` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `password` blob NOT NULL,
  `sshport` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `ftpport` int(11) NOT NULL DEFAULT '21',
  `maxsrv` int(11) NOT NULL,
  `cache` blob,
  `box_load_5min` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `box_load` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`boxid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Izbacivanje podataka za tablicu `box`
--

INSERT INTO `box` (`boxid`, `name`, `ip`, `routeip`, `login`, `password`, `sshport`, `ftpport`, `maxsrv`, `cache`, `box_load_5min`, `box_load`) VALUES
(1, ' -  - Lite - Morenja', '176.31.207.211', '', 'root', 0xbbe129cc6b68e538b72ef5ed93eb0f22, '22', 21, 3, 0x785e6d534d6fd43010fd2b564e7068f0776cef05095041428050ab72abbc89d98dc826abd8a1db56fbdf197b936cb6c597689e67e6bdf1bc5843cc736dc8ca1ac2ccb33785c9f68d7d74bdcf22f612aa0d5e1dbdd1265bdbb67aa8abb08d793ce62993f587fbc1db8dcb56313141e1350459a10bb6b9cc5a40c0c04c56ee87d83bc9e220abefca0c7a7290f8a50dae79f3f32dfae5ba367e3ffcb845e773c704c508bd473497c5f5e7a75826a061d73b182b8e9be2516a65649c09187bbb9ba781fb5991605215026315e9639dab621b2a0b4125e1fc04ffee5d1a9c4acdb85232c24b16ae7345f5e240c4a52e38e3a41085d042308d35c33152848aa80a866d3a5bd9bf9be53e6628e9c13965594c86e7de763eb4760742c6ed5d601ec4c587b5ad6bf2a76eb7aedd55aca8db4d5e36c33a75a126ebcedb1fa3b4f3eb6fb7efbed6ed704879c05cd970669a636801ac378343dfcb8088424418a18d28d0a78f37886222533d28f9e37a50326b5d20de102084fde58c5e614e7db06b82597e2a052adb97c97ac9a2739cba1e94bc977ce218f6a15ebc07dc4fc8e93530aaeca347146dbba1f78811b4831183f3689ad23fd8fd7f7d112dbef0c3184e3e88e172ffe9cf01976d2b70cff8cfbc7219d684e2177d09935861a1d4e8bf89405046255582117a41551bb63a1e8fff002a751d13, '', '');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `boxdata`
--

CREATE TABLE IF NOT EXISTS `boxdata` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cache` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `boxip`
--

CREATE TABLE IF NOT EXISTS `boxip` (
  `ipid` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `boxid` int(8) unsigned NOT NULL,
  `ip` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `route` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`ipid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Izbacivanje podataka za tablicu `boxip`
--

INSERT INTO `boxip` (`ipid`, `boxid`, `ip`, `route`) VALUES
(1, 1, '176.31.207.211', '0');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `bug`
--

CREATE TABLE IF NOT EXISTS `bug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klijentid` int(11) DEFAULT NULL,
  `naslov` text,
  `text` text,
  `vrsta` int(11) DEFAULT NULL,
  `vreme` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `chat_messages`
--

CREATE TABLE IF NOT EXISTS `chat_messages` (
  `Text` text,
  `Autor` text NOT NULL,
  `Datum` text NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(9999) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Izbacivanje podataka za tablicu `chat_messages`
--

INSERT INTO `chat_messages` (`Text`, `Autor`, `Datum`, `ID`, `admin_id`) VALUES
(' hahah', '<span style="color: red" >Tomislav </span>', '18 Oct 2016, 22:1:45', 1, '2'),
('Novi tiket <a href="tiket.php?id=1">aafdfgdf</a>', '<font color="silver">test testic</font>', '18 Oct 2016, 22:17:45', 2, 'klijent_2');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `setting` varchar(255) NOT NULL,
  `value` text NOT NULL,
  KEY `setting` (`setting`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `error_log`
--

CREATE TABLE IF NOT EXISTS `error_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT NULL,
  `string` varchar(255) DEFAULT NULL,
  `file` mediumtext,
  `line` int(11) DEFAULT NULL,
  `datum` mediumtext,
  `vrsta` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `friends_list`
--

CREATE TABLE IF NOT EXISTS `friends_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `friends_request`
--

CREATE TABLE IF NOT EXISTS `friends_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `invoice_status_id` tinyint(2) NOT NULL DEFAULT '1',
  `invoice_date_created` date NOT NULL,
  `invoice_date_modified` datetime NOT NULL,
  `invoice_date_due` date NOT NULL,
  `invoice_number` varchar(20) NOT NULL,
  `invoice_terms` longtext NOT NULL,
  `invoice_url_key` char(32) NOT NULL,
  PRIMARY KEY (`invoice_id`),
  UNIQUE KEY `invoice_url_key` (`invoice_url_key`),
  KEY `user_id` (`client_id`,`invoice_date_created`,`invoice_date_due`,`invoice_number`),
  KEY `invoice_status_id` (`invoice_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `invoice_items`
--

CREATE TABLE IF NOT EXISTS `invoice_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `item_tax_rate_id` int(11) NOT NULL DEFAULT '0',
  `item_date_added` date NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_description` longtext NOT NULL,
  `item_quantity` decimal(10,2) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_order` int(2) NOT NULL DEFAULT '0',
  `item_popust` varchar(20) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `invoice_id` (`invoice_id`,`item_tax_rate_id`,`item_date_added`,`item_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `klijenti`
--

CREATE TABLE IF NOT EXISTS `klijenti` (
  `klijentid` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `sifra` text NOT NULL,
  `ime` text,
  `prezime` text,
  `email` text NOT NULL,
  `beleske` text,
  `novac` double NOT NULL DEFAULT '0',
  `currency` int(2) NOT NULL DEFAULT '1',
  `status` text NOT NULL,
  `lastlogin` datetime NOT NULL,
  `lastactivity` text NOT NULL,
  `lastip` text NOT NULL,
  `lasthost` text NOT NULL,
  `kreiran` date NOT NULL,
  `zemlja` text NOT NULL,
  `avatar` text NOT NULL,
  `cover` varchar(11) NOT NULL DEFAULT 'cover.jpg',
  `banovan` int(2) NOT NULL DEFAULT '0',
  `sigkod` int(11) NOT NULL,
  `token` text,
  `mail` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`klijentid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Izbacivanje podataka za tablicu `klijenti`
--

INSERT INTO `klijenti` (`klijentid`, `username`, `sifra`, `ime`, `prezime`, `email`, `beleske`, `novac`, `currency`, `status`, `lastlogin`, `lastactivity`, `lastip`, `lasthost`, `kreiran`, `zemlja`, `avatar`, `cover`, `banovan`, `sigkod`, `token`, `mail`) VALUES
(1, 'demo_nalog', '3a19ed530948e936ff4d25e9352b393ae6f63ce00770f93ffd74c428bd18e0faa489166b363759ba6bb26fbb7cb1bc361cd4c939c828e1260adbb8ff14b1ed29', 'Demo', 'Nalog', 'demo@demo.com', NULL, 0, 1, 'Aktivan', '0000-00-00 00:00:00', '1476823855', '~', '~', '2016-10-18', 'bih', 'default.png', 'cover.jpg', 0, 32660, '', 1),
(2, 'test', '906744e480626a76d526444f427e24f0da462d7fda27c5565a008e5de2668497c5f6e2da68b23df97c1b6805aeeb164cecb0829693e052cf052ec787dda3361e', 'test', 'testic', 'test@test.com', NULL, 0, 1, 'Aktivan', '2016-10-18 23:02:25', '1476824679', '24.135.180.87', 'cable-24-135-180-87.dynamic.sbb.rs', '2016-10-18', 'bih', 'default.png', 'cover.jpg', 0, 46171, '26ro2i9nta6von37nm9u66hvu4', 1);

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `klijenti_komentari`
--

CREATE TABLE IF NOT EXISTS `klijenti_komentari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klijentid` int(11) DEFAULT NULL,
  `profilid` int(11) DEFAULT NULL,
  `komentar` text,
  `vreme` text,
  `novo` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `komentari`
--

CREATE TABLE IF NOT EXISTS `komentari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) NOT NULL,
  `profilid` int(11) DEFAULT NULL,
  `komentar` text CHARACTER SET latin1,
  `vreme` text CHARACTER SET latin1,
  `novo` varchar(11) CHARACTER SET latin1 NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `lgsl`
--

CREATE TABLE IF NOT EXISTS `lgsl` (
  `id` int(11) unsigned NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `c_port` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `q_port` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `s_port` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `zone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `cache` text COLLATE utf8_unicode_ci NOT NULL,
  `cache_time` text COLLATE utf8_unicode_ci NOT NULL,
  `igraci` text COLLATE utf8_unicode_ci NOT NULL,
  `igraci_5min` text COLLATE utf8_unicode_ci NOT NULL,
  `rank_bodovi` float NOT NULL DEFAULT '0',
  `idu` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idu`),
  KEY `rank_bodovi` (`rank_bodovi`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Izbacivanje podataka za tablicu `lgsl`
--

INSERT INTO `lgsl` (`id`, `type`, `ip`, `c_port`, `q_port`, `s_port`, `zone`, `disabled`, `comment`, `status`, `cache`, `cache_time`, `igraci`, `igraci_5min`, `rank_bodovi`, `idu`) VALUES
(1, 'samp', '176.31.207.211', '7787', '7787', '0', '0', 0, 'testic', 1, 'a:5:{s:1:"b";a:7:{s:4:"type";s:4:"samp";s:2:"ip";s:14:"176.31.207.211";s:6:"c_port";s:4:"7787";s:6:"q_port";s:4:"7787";s:6:"s_port";s:1:"0";s:6:"status";s:1:"1";s:7:"pending";i:0;}s:1:"o";a:3:{s:7:"request";s:3:"sep";s:2:"id";s:1:"1";s:8:"location";s:0:"";}s:1:"s";a:6:{s:4:"game";s:4:"samp";s:4:"name";s:16:"SA-MP 0.3 Server";s:3:"map";s:1:"-";s:7:"players";s:1:"0";s:10:"playersmax";s:2:"20";s:8:"password";s:1:"0";}s:1:"e";a:7:{s:8:"gamemode";s:13:"Grand Larceny";s:7:"lagcomp";s:2:"On";s:7:"mapname";s:11:"San Andreas";s:7:"version";s:8:"0.3.7-R2";s:7:"weather";s:1:"2";s:6:"weburl";s:13:"www.sa-mp.com";s:9:"worldtime";s:5:"17:00";}s:1:"p";a:0:{}}', '1476824620_1476824620_1476824620', '', '', 0, 1);

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `logovi`
--

CREATE TABLE IF NOT EXISTS `logovi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientid` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `vreme` varchar(255) DEFAULT NULL,
  `adminid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Izbacivanje podataka za tablicu `logovi`
--

INSERT INTO `logovi` (`id`, `clientid`, `message`, `name`, `ip`, `vreme`, `adminid`) VALUES
(1, NULL, 'Uspešan login.', 'Alen Morenja', '31.176.204.142', '1476818699', 1),
(2, NULL, 'Promena svog profila', 'Alen Morenja', '31.176.204.142', '1476818725', 1),
(3, NULL, 'Dodao mod #', 'Alen Morenja', '31.176.204.142', '1476819099', 1),
(4, NULL, 'Dodao mašinu <m>#1 - 176.31.207.211</m>', 'Alen Morenja', '31.176.204.142', '1476819148', 1),
(5, NULL, 'Dodao ip adresu #176.31.207.211', 'Alen Morenja', '31.176.204.142', '1476819158', 1),
(6, NULL, 'Dodao klijenta <m>Demo Nalog</m>', 'Alen Morenja', '31.176.204.142', '1476819196', 1),
(7, 1, 'Logout', 'Demo Nalog', '31.176.204.142', '1476819333', NULL),
(8, NULL, 'Dodao klijenta <m>test testic</m>', 'Alen Morenja', '31.176.204.142', '1476819371', 1),
(9, 2, 'Uspešan login.', 'test testic', '31.176.204.142', '1476819380', NULL),
(10, NULL, 'Promenio mašinu <m>#1 - 176.31.207.211</m>', 'Alen Morenja', '31.176.204.142', '1476819429', 1),
(11, 2, 'Startovao <a href=''gp-server.php?id=1''><z>testic</z></a> server', 'test testic', '31.176.204.142', '1476819539', NULL),
(12, NULL, 'Promenio mašinu <m>#1 - 176.31.207.211</m>', 'Alen Morenja', '31.176.204.142', '1476820791', 1),
(13, NULL, 'Dodao admina <m>Tomislav </m>', 'Alen Morenja', '31.176.204.142', '1476820873', 1),
(14, NULL, 'Uspešan login.', 'Tomislav ', '46.128.27.180', '1476820891', 2),
(15, 1, 'Logout', 'Demo Nalog', '46.128.27.180', '1476821330', NULL),
(16, 1, 'Logout', 'Demo Nalog', '46.128.27.180', '1476821452', NULL),
(17, NULL, 'Promenio klijenta <m>test testic</m>', 'Tomislav ', '46.128.27.180', '1476821526', 2),
(18, 2, 'Uspešan login.', 'test testic', '46.128.27.180', '1476821535', NULL),
(19, 2, 'Logout', 'test testic', '46.128.27.180', '1476822011', NULL),
(20, 2, 'Uspešan login.', 'test testic', '24.135.180.87', '1476822013', NULL),
(21, NULL, 'Uspešan login.', 'Alen Morenja', '24.135.180.87', '1476822311', 1),
(22, 2, 'Uspešan login.', 'test testic', '93.86.203.176', '1476822625', NULL),
(23, 1, 'Logout', 'Demo Nalog', '46.128.27.180', '1476823915', NULL),
(24, 2, 'Logout', 'test testic', '24.135.180.87', '1476823941', NULL),
(25, 2, 'Uspešan login.', 'test testic', '46.128.27.180', '1476823945', NULL),
(26, 2, 'Uspešan login.', 'test testic', '24.135.180.87', '1476824546', NULL);

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `modovi`
--

CREATE TABLE IF NOT EXISTS `modovi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `putanja` text NOT NULL,
  `ime` text NOT NULL,
  `opis` mediumtext NOT NULL,
  `igra` text NOT NULL,
  `komanda` text NOT NULL,
  `sakriven` int(11) NOT NULL DEFAULT '1',
  `mapa` mediumtext,
  `cena` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Izbacivanje podataka za tablicu `modovi`
--

INSERT INTO `modovi` (`id`, `putanja`, `ime`, `opis`, `igra`, `komanda`, `sakriven`, `mapa`, `cena`) VALUES
(1, '/home/gamefiles/samp', 'Default', 'Uskoro opis dodan ce biti', '2', './samp03svr', 0, 'San Andreas', '||||');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `obavestenja`
--

CREATE TABLE IF NOT EXISTS `obavestenja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` text,
  `poruka` text,
  `datum` text,
  `vrsta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `online` varchar(2) DEFAULT NULL,
  `poruka` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `paypal_ipn`
--

CREATE TABLE IF NOT EXISTS `paypal_ipn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientid` int(11) NOT NULL,
  `raw` mediumtext NOT NULL,
  `time` int(11) NOT NULL,
  `invoice` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` text,
  `deskripcija` text,
  `prikaz` text,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Izbacivanje podataka za tablicu `plugins`
--

INSERT INTO `plugins` (`id`, `ime`, `deskripcija`, `prikaz`, `text`) VALUES
(1, 'xRedirekt', 'Ovaj plugin služi za redirektovanje igrača sa ovoga na drugi željeni server.\r\n\r\nViše info o podešavanju: http://pastebin.com/gAWe4xwj', 'plugins-xredi.ini', 'xredirect.amxx');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `reputacija`
--

CREATE TABLE IF NOT EXISTS `reputacija` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klijentid` int(11) DEFAULT NULL,
  `adminid` int(11) DEFAULT NULL,
  `tiketid` int(11) DEFAULT NULL,
  `rep` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Izbacivanje podataka za tablicu `reputacija`
--

INSERT INTO `reputacija` (`id`, `klijentid`, `adminid`, `tiketid`, `rep`) VALUES
(1, 2, 2, 1, 1);

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `serveri`
--

CREATE TABLE IF NOT EXISTS `serveri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `box_id` int(11) NOT NULL,
  `ip_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `rank` int(12) NOT NULL DEFAULT '99999',
  `mod` mediumtext NOT NULL,
  `map` text NOT NULL,
  `port` mediumtext NOT NULL,
  `fps` int(11) NOT NULL DEFAULT '300',
  `slotovi` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `istice` mediumtext NOT NULL,
  `status` text NOT NULL,
  `startovan` int(11) NOT NULL DEFAULT '0',
  `free` mediumtext,
  `uplatnica` mediumtext,
  `igra` mediumtext,
  `komanda` mediumtext NOT NULL,
  `cena` mediumtext NOT NULL,
  `boost` mediumtext NOT NULL,
  `cache` blob NOT NULL,
  `reinstaliran` int(11) NOT NULL,
  `backup` varchar(12) NOT NULL DEFAULT '0',
  `napomena` text NOT NULL,
  `autorestart` varchar(11) DEFAULT '-1',
  `backupstatus` varchar(30) NOT NULL DEFAULT '0',
  `aid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rank` (`rank`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Izbacivanje podataka za tablicu `serveri`
--

INSERT INTO `serveri` (`id`, `user_id`, `box_id`, `ip_id`, `name`, `rank`, `mod`, `map`, `port`, `fps`, `slotovi`, `username`, `password`, `istice`, `status`, `startovan`, `free`, `uplatnica`, `igra`, `komanda`, `cena`, `boost`, `cache`, `reinstaliran`, `backup`, `napomena`, `autorestart`, `backupstatus`, `aid`) VALUES
(1, 2, 1, 1, 'testic', 99999, '1', 'San Andreas', '7787', 300, 20, 'srv_2_1', 'TMfhyxaR', '2016-11-18', 'Aktivan', 1, 'Ne', NULL, '2', './samp03svr', '0', '', '', 0, '0', '', '1', '0', 0);

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `serveri_naruceni`
--

CREATE TABLE IF NOT EXISTS `serveri_naruceni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klijentid` int(11) DEFAULT NULL,
  `igra` int(2) DEFAULT NULL,
  `lokacija` int(2) DEFAULT NULL,
  `slotovi` int(4) DEFAULT NULL,
  `meseci` int(3) DEFAULT NULL,
  `cena` varchar(8) DEFAULT NULL,
  `status` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `server_backup`
--

CREATE TABLE IF NOT EXISTS `server_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `srvid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(40) NOT NULL DEFAULT '0',
  `size` varchar(20) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `slajdovi`
--

CREATE TABLE IF NOT EXISTS `slajdovi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` text,
  `text` text,
  `slika` text,
  `datum` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Izbacivanje podataka za tablicu `slajdovi`
--

INSERT INTO `slajdovi` (`id`, `naslov`, `text`, `slika`, `datum`) VALUES
(5, 'Uplata putem SMS-a', 'Samo kod nas možete uplatiti putem SMS-a bez provizije\r\nVaš Morenja.info', '/assets/img/slider/2.png', '18.09.2016');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `smslog`
--

CREATE TABLE IF NOT EXISTS `smslog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientid` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `message` varchar(64) NOT NULL,
  `sender` varchar(64) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `price` varchar(64) DEFAULT NULL,
  `revenue` varchar(11) NOT NULL DEFAULT '0',
  `currency` varchar(64) DEFAULT NULL,
  `service_id` varchar(64) DEFAULT NULL,
  `message_id` varchar(64) DEFAULT NULL,
  `keyword` varchar(64) DEFAULT NULL,
  `shortcode` varchar(64) DEFAULT NULL,
  `operator` varchar(64) DEFAULT NULL,
  `billing_type` varchar(64) DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `tiketi`
--

CREATE TABLE IF NOT EXISTS `tiketi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` text,
  `prioritet` int(11) NOT NULL,
  `vrsta` int(11) NOT NULL,
  `datum` text,
  `naslov` text,
  `billing` int(11) NOT NULL DEFAULT '0',
  `admin` int(11) NOT NULL,
  `otvoren` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Izbacivanje podataka za tablicu `tiketi`
--

INSERT INTO `tiketi` (`id`, `admin_id`, `server_id`, `user_id`, `status`, `prioritet`, `vrsta`, `datum`, `naslov`, `billing`, `admin`, `otvoren`) VALUES
(1, NULL, 1, 2, '10', 2, 1, '1476821865', 'aafdfgdf', 0, 1, '2016-10-18');

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `tiketi_odgovori`
--

CREATE TABLE IF NOT EXISTS `tiketi_odgovori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tiket_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `odgovor` text NOT NULL,
  `vreme_odgovora` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Izbacivanje podataka za tablicu `tiketi_odgovori`
--

INSERT INTO `tiketi_odgovori` (`id`, `tiket_id`, `user_id`, `admin_id`, `odgovor`, `vreme_odgovora`) VALUES
(1, 1, 2, NULL, 'asfdadas asfdadas asfdadas asfdadas asfdadas asfdadas asfdadas asfdadas asfdadas asfdadas asfdadas asfdadas asfdadas asfdadas ', '1476821865'),
(2, 1, NULL, 2, 'sta', '1476821885');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
