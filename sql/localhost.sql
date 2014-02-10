-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 10, 2014 at 02:19 PM
-- Server version: 5.5.34-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tweb`
--

USE `dbmattiavinci146`;

-- --------------------------------------------------------

--
-- Table structure for table `aggiornamenti`
--

CREATE TABLE IF NOT EXISTS `aggiornamenti` (
  `id_agg` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `id` varchar(23) NOT NULL,
  PRIMARY KEY (`id_agg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `amicizie`
--

CREATE TABLE IF NOT EXISTS `amicizie` (
  `utente_1` int(11) NOT NULL,
  `utente_2` int(11) NOT NULL,
  `data` datetime NOT NULL,
  UNIQUE KEY `utente_1` (`utente_1`,`utente_2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `amicizie`
--

INSERT INTO `amicizie` (`utente_1`, `utente_2`, `data`) VALUES
(11, 12, '2014-02-09 16:42:45'),
(11, 18, '2014-02-09 16:40:46'),
(18, 20, '2014-02-10 12:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `commenti`
--

CREATE TABLE IF NOT EXISTS `commenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entita` int(11) NOT NULL,
  `tipo_entita` varchar(255) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `data` date NOT NULL,
  `testo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `commenti`
--

INSERT INTO `commenti` (`id`, `id_entita`, `tipo_entita`, `id_utente`, `data`, `testo`) VALUES
(1, 11, 'utente', 11, '2014-01-02', 'wow'),
(3, 11, 'utente', 11, '2014-01-02', 'terzxo~!!!'),
(4, 6, 'opera', 11, '2014-01-02', 'commento a tom sawyer'),
(5, 6, 'opera', 11, '2014-01-02', 'commento a tom sawyer'),
(6, 6, 'opera', 11, '2014-01-02', 'commento a tom sawyer'),
(7, 5, 'commento', 11, '2014-01-02', 'Commento al commento!!!'),
(8, 7, 'commento', 11, '2014-01-02', 'commento al commento al commento!!'),
(9, 7, 'commento', 11, '2014-01-02', 'commento nested 2'),
(10, 9, 'commento', 11, '2014-01-02', 'commento terzo livello'),
(11, 1, 'commento', 11, '2014-01-02', 'ckasjddkasjdasd'),
(12, 11, 'commento', 11, '2014-01-02', 'eersad asd s asd af adf d fa fadf d'),
(13, 8, 'commento', 11, '2014-01-03', 'tipo a questo?'),
(16, 7, 'opera', 11, '2014-01-03', 'commento di mat a huck finn'),
(17, 16, 'commento', 11, '2014-01-03', 'commento di mat a mat a huck finn con redirect'),
(18, 12, 'utente', 11, '2014-01-03', 'sd;ada'),
(20, 3, 'luogo', 11, '2014-01-03', 'commento a via del campo'),
(21, 20, 'commento', 11, '2014-01-03', 'commento a commento di via del campo'),
(22, 3, 'luogo', 11, '2014-01-03', 'altro commento a via del campo'),
(23, 8, 'opera', 11, '2014-01-05', 'commento a proust'),
(24, 23, 'commento', 11, '2014-01-05', 'commento nested a proust'),
(25, 11, 'utente', 11, '2014-02-09', 'mi inserisco un commento da solo!'),
(26, 11, 'utente', 11, '2014-02-09', ''),
(27, 18, '18', 0, '2014-02-09', 'sono test e mi sto scrivendo un commento da solo'),
(28, 18, '18', 0, '2014-02-09', 'asdasdada'),
(30, 18, 'utente', 18, '2014-02-09', 'Commento a test da test'),
(31, 30, 'commento', 18, '2014-02-09', 'commento a Commento a test da test'),
(33, 32, 'commento', 20, '2014-02-10', 'ale commenta il com');

-- --------------------------------------------------------

--
-- Table structure for table `email_codes`
--

CREATE TABLE IF NOT EXISTS `email_codes` (
  `nick` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_codes`
--

INSERT INTO `email_codes` (`nick`, `code`) VALUES
('mat2', '498f0520698f54ec5f840bf9005b91b2'),
('mattia', 'cba7ad058dcb10f5c1ed9b9e02a7b579'),
('ruggo', 'af34549a637b7d2a3169188f4d32c946'),
('mattia2', 'dbf800497ad5d1f18d7815988459bbaa'),
('ale', '19632e1706fbb216388f1a09516120b4');

-- --------------------------------------------------------

--
-- Table structure for table `luoghi`
--

CREATE TABLE IF NOT EXISTS `luoghi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `id_entita` int(11) DEFAULT NULL,
  `tipo_entita` varchar(255) DEFAULT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `data` datetime NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `citta` varchar(255) NOT NULL,
  `prov` varchar(255) NOT NULL,
  `stato` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `luoghi`
--

INSERT INTO `luoghi` (`id`, `id_utente`, `id_entita`, `tipo_entita`, `lat`, `lng`, `data`, `indirizzo`, `citta`, `prov`, `stato`) VALUES
(3, 11, NULL, NULL, 44.4123706, 8.928511699999945, '2014-01-03 15:51:20', 'via del campo', 'genova', 'ge', 'italia'),
(4, 12, NULL, NULL, 34.2031662, -86.1520969, '2014-01-03 17:06:02', '', 'boaz', 'alabama,', 'usa'),
(7, 12, 0, '0', 44.9320823, 8.625183500000048, '2014-01-20 21:36:10', 'via della chiatta', 'Alessandria', 'al', 'italia'),
(8, 11, 0, '0', 45.0897427, 7.658100900000022, '2014-01-28 16:30:31', 'via pessineto', 'torino', 'to', 'italia'),
(9, 11, 0, '0', 43.4815698, 12.22082279999995, '2014-02-09 16:48:12', '', 'Citta''', 'Provincia', 'Stato'),
(10, 11, 0, '0', 44.8998778, 8.621703799999977, '2014-02-09 16:52:34', 'via de gasperi 3', 'alessandria', 'al', 'italia');

-- --------------------------------------------------------

--
-- Table structure for table `notifiche`
--

CREATE TABLE IF NOT EXISTS `notifiche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `id_elemento` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `visualizzata` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `opere`
--

CREATE TABLE IF NOT EXISTS `opere` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `autore` varchar(255) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `opere`
--

INSERT INTO `opere` (`id`, `id_utente`, `data`, `isbn`, `autore`, `titolo`) VALUES
(6, 11, '2013-12-30 15:31:31', '8874173040', 'Mark Twain', 'Le avventure di Tom Sawyer'),
(7, 13, '2013-12-30 20:41:53', '8854134147', 'Mark Twain', 'Le avventure di Huckleberry Finn'),
(9, 11, '2014-01-05 15:34:32', '8854129437', 'Lao-Tzu', 'Il libro del Tao'),
(10, 11, '2014-01-10 03:06:39', '9781111352455', 'Carla Riga', 'Ciao!, Enhanced'),
(11, 11, '2014-01-20 21:46:45', '9788874171941', 'Robert Louis Stevenson', 'L''isola del tesoro'),
(12, 11, '2014-01-20 21:47:55', '9788874171941', 'Robert Louis Stevenson', 'L''isola del tesoro'),
(13, 11, '2014-01-20 21:48:04', '9788874171941', 'Robert Louis Stevenson', 'L''isola del tesoro');

-- --------------------------------------------------------

--
-- Table structure for table `richieste`
--

CREATE TABLE IF NOT EXISTS `richieste` (
  `id_from` int(11) NOT NULL,
  `id_to` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `richieste`
--

INSERT INTO `richieste` (`id_from`, `id_to`, `data`) VALUES
(11, 13, '2014-01-18 19:40:22'),
(11, 14, '2014-02-05 09:50:22');

-- --------------------------------------------------------

--
-- Table structure for table `sessioni`
--

CREATE TABLE IF NOT EXISTS `sessioni` (
  `id_sessione` varchar(23) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  PRIMARY KEY (`id_sessione`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessioni`
--

INSERT INTO `sessioni` (`id_sessione`, `id_utente`, `secret`, `start`) VALUES
('52bc38d5848598.46838642', 10, '13bdb647b6ba778d5e9135c3af6dfb86 ', '2013-12-26 16:06:28'),
('52f8b74ed5e710.22387004', 12, '6e688376b3df345fc180b1d3100ff75f ', '2014-02-10 13:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `stati`
--

CREATE TABLE IF NOT EXISTS `stati` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `stato` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `valido` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `stati`
--

INSERT INTO `stati` (`id`, `id_utente`, `stato`, `data`, `valido`) VALUES
(1, 12, 'stato admin', '2014-01-03 17:35:18', 0),
(13, 11, 'dasdad', '2014-02-05 21:02:32', 0),
(15, 11, 'stato di mat', '2014-02-09 17:05:26', 0),
(16, 11, 'stato due di mat', '2014-02-09 17:05:42', 0),
(17, 11, 'stato mat con redirect', '2014-02-09 17:07:22', 0),
(18, 11, 'prova stato mat con redirect', '2014-02-09 17:08:08', 0),
(19, 18, 'test non aveva stato fino a un attimo fa', '2014-02-09 18:41:01', 0),
(21, 18, 'test ora ha un po'' di stati', '2014-02-09 18:43:16', 0),
(22, 20, 'Stato di ale uno', '2014-02-10 12:23:37', 1),
(23, 12, 'admin scrive un altro stato', '2014-02-10 12:43:12', 0),
(24, 12, 'stato', '2014-02-10 13:32:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(2) NOT NULL DEFAULT '-1',
  `nick` varchar(50) NOT NULL,
  `pass_hash` varchar(255) NOT NULL,
  `rand` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `personale` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='max nick size: 50' AUTO_INCREMENT=21 ;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`id`, `type`, `nick`, `pass_hash`, `rand`, `email`, `foto`, `personale`) VALUES
(11, 0, 'mat ', '1a1dc91c907325c69271ddf0c944bc72', '', 'sowdust@gmail.com', '52e7cc83da60e1.06797701.jpg', 'cambiatissimo!!! aggiunta oggi 5 feb\r\n\r\n\r\nadmin ha aggiunto questo di nascosto'),
(12, 1, 'admin ', '1a1dc91c907325c69271ddf0c944bc72 ', '', 'mattia.vinci.1@gmail.com', '52bc4ac3a12e46.48145748.gif', 'cambiato da admin'),
(18, 0, 'test ', '1a1dc91c907325c69271ddf0c944bc72 ', '', 'aaaa@aaaa.it', '52f3cd08e04c55.08462510.jpg', 'Questo amore\r\nCosi violento\r\nCosi fragile\r\nCosi tenero\r\nCosi disperato\r\nQuesto amore\r\nBello come il giorno\r\nE cattivo come il tempo\r\nQuando il tempo Ã¨ cattivo\r\nQuesto amore cosi vero\r\nQuesto amore cosi bello\r\nCosi felice\r\nCosi gaio\r\nE cosi beffardo\r\nTremante di paura come un bambino al buio\r\nE cosi sicuro di sÃ©\r\nCome un uomo tranquillo nel cuore della notte\r\nQuesto amore che impauriva gli altri\r\nChe li faceva parlare\r\nChe li faceva impallidire\r\nQuesto amore spiato\r\nPerchÃ© noi lo spiavamo\r\nPerseguitato ferito calpestato ucciso negato dimenticato\r\nPerchÃ© noi l''abbiamo perseguitato ferito calpestato ucciso negato dimenticato\r\nQuesto amore tutto intero\r\nAncora cosi vivo\r\nE tutto soleggiato\r\nE tuo\r\nE mio\r\nE stato quel che Ã¨ stato\r\nQuesta cosa sempre nuova\r\nE che non Ã¨ mai cambiata\r\nVera come una pianta\r\nTremante come un uccello\r\nCalda e viva come l''estate\r\nNoi possiamo tutti e due\r\nAndare e ritornare\r\nNoi possiamo dimenticare\r\nE quindi riaddormentarci\r\nRisvegliarci soffrire invecchiare\r\nAddormentarci ancora\r\nSognare la morte\r\nSvegliarci sorridere e ridere\r\nE ringiovanire\r\nIl nostro amore Ã¨ lÃ \r\nTestardo come un asino\r\nVivo come il desiderio\r\nCrudele come la memoria\r\nSciocco come i rimpianti\r\nTenero come il ricordo\r\nFreddo come il marmo\r\nBello come il giorno\r\nFragile come un bambino\r\nCi guarda sorridendo\r\nE ci parla senza dir nulla\r\nE io tremante l''ascolto\r\nE grido\r\nGrido per te\r\nGrido per me\r\nTi supplico\r\nPer te per me per tutti coloro che si amano\r\nE che si sono amati\r\nSÃ¬ io gli grido\r\nPer te per me e per tutti gli altri\r\nChe non conosco\r\nFermati lÃ \r\nLÃ  dove sei\r\nLÃ  dove sei stato altre volte\r\nFermati\r\nNon muoverti\r\nNon andartene\r\nNoi che siamo amati\r\nNoi ti abbiamo dimenticato\r\nTu non dimenticarci\r\nNon avevamo che te sulla terra\r\nNon lasciarci diventare gelidi\r\nAnche se molto lontano sempre\r\nE non importa dove\r\nDacci un segno di vita\r\nMolto piÃ¹ tardi ai margini di un bosco\r\nNella foresta della memoria\r\nAlzati subito\r\nTendici la mano\r\nE salvaci.'),
(20, 0, 'alee ', '1a1dc91c907325c69271ddf0c944bc72 ', '', 'sdflknsdfs@alfja.it', '52f8b2a9555975.56836094.jpg', '<?php\r\n\r\nrequire_once(''entita.php'');\r\n\r\nclass commento extends entita {\r\n\r\n	public $tipo_entita;\r\n	protected $db;\r\n	public $id;\r\n	// si riferiscono al padre\r\n	protected $id_entita_padre;\r\n	protected $tipo_entita_padre;\r\n\r\n	public $data;\r\n	public $testo;\r\n	public $id_utente;\r\n\r\n	function __construct($db,$id)\r\n	{	//TODO forse da fare con dati entita'' e non id commento\r\n		$this->tipo_entita = ''commento'';\r\n		$this->db = ( ''database'' == get_class($db) ) ? $db->mysqli : $db;\r\n		$this->id = $id;\r\n		$this->get_data_from_db();\r\n		\r\n	}\r\n\r\n	\r\n\r\n	function get_data()\r\n	{\r\n		return $this->data;\r\n	}\r\n\r\n	function get_uid()\r\n	{\r\n		return $this->id_utente;\r\n	}\r\n\r\n\r\n	function get_data_from_db()\r\n	{\r\n		$q = $this->db->prepare(''SELECT id_utente, id_entita, tipo_entita, date_format(data,"%d/%m/%Y") as data, testo FROM commenti WHERE id = (?)'');\r\n		$q->bind_param(''i'',$this->id);\r\n		$q->execute() or die(''er 42'');\r\n		$q->bind_result($this->id_utente,$this->id_entita,$this->tipo_entita,$this->data,$this->testo);\r\n		$q->fetch();\r\n		$q->close();\r\n		unset($q);\r\n	}\r\n\r\n	function get_children()\r\n	{\r\n		$q = $this->db->prepare(''SELECT id FROM commenti WHERE id_entita = (?) AND tipo_entita = "commento" order by data asc'');\r\n		$q->bind_param(''i'',$this->id);\r\n		$t = null;\r\n		$count = 0;\r\n		$chil = array();\r\n		$q->execute() or die(''56'');\r\n		$q->bind_result($t);\r\n		while($q->fetch())\r\n		{\r\n			$chil[$count++] = $t;\r\n		}\r\n		return $chil;\r\n	}\r\n\r\n	function stampa()\r\n	{\r\n		$o = ''<div id="commento_''.$this->id.''" class="commento">''\r\n			.''Il ''.$this->data.'' ''.$this->id_utente.'' ha scritto:''\r\n			.''<div id="contenuto_commento_''.$this->id.''">''\r\n			.htmlentities($this->testo). ''<br />''\r\n			//.''<a href="aggiungi_commento.php?id_entita=''.$this->id.''&tipo_entita=commento">commenta</a>'';\r\n			.''<a href="#" onclick="comment_form(''.$this->id.'');return false;">Commenta</a>''\r\n			.''</div>'';\r\n		$count = 0;\r\n\r\n		if(sizeof($this->get_children()))\r\n		{\r\n			$o.='' | <a id="more_''.$this->id.''" title="Mostra gli altri commenti a questo" href="#"''\r\n				.''	onmouseover="get_commenti(''.$this->id.'');return false;">More</a>'';\r\n			$o.='' | <a id="less_''.$this->id.''" title="Nascondi gli altri commenti a questo" href="#"''\r\n				.''	onmouseover="less(''.$this->id.'');return false;">Less</a>'';\r\n\r\n		}\r\n		$o.=''<script type="text/javascript">window.showing[''.$this->id.'']=true;</script>'';\r\n		$o .= ''</div>'';\r\n\r\n		return $o;\r\n	}\r\n}\r\n\r\n?>\r\n');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
