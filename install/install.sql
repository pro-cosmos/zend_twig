-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 14, 2010 at 10:36 PM
-- Server version: 5.1.50
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `docs`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` tinytext NOT NULL,
  `m_name` tinytext NOT NULL,
  `l_name` tinytext NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `f_name`, `m_name`, `l_name`, `organization_id`) VALUES
(1, 'Дмитрий', 'Николаевич', 'Душкин', NULL),
(2, 'Иван', 'П', 'Иванов', NULL),
(3, 'Роман', 'Владимирович', 'Рублёв', NULL),
(4, 'Анастасия', '', 'Паршакова', NULL),
(5, 'Д', 'Н', 'Душкин', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE IF NOT EXISTS `organizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`) VALUES
(1, 'ИПУ РАН');

-- --------------------------------------------------------

--
-- Table structure for table `papers`
--

CREATE TABLE IF NOT EXISTS `papers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` mediumtext,
  `title` mediumtext NOT NULL,
  `title_en` mediumtext,
  `source` mediumtext,
  `publisher` mediumtext,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `papers`
--

INSERT INTO `papers` (`id`, `file`, `title`, `title_en`, `source`, `publisher`, `date`) VALUES
(1, '/media/papers/primenenie_sistemi_raspoznavaniya_rechi_v_tehnologicheskih.pdf', 'Применение системы распознавания речи в технологических системах производства автомобилей', 'primenenie_sistemi_raspoznavaniya_rechi_v_tehnologicheskih', 'Международный научный симпозиум, посвященный 140-летию МГТУ МАМИ', 'М.:МАМИ', '2010-07-27'),
(2, '/media/papers/7325419123b6e0624b94d08b2e0f99f0.pdf', 'Разработка интернет портала «Сурдосервер» с ресурсами русского жестового языка', NULL, 'Четвертый междисциплинарный семинар «Анализ разговорной русской речи»', '', '2010-07-27'),
(5, '/media/papers/the_first_voice_recognition_applications_in.pdf', 'The First Voice Recognition Applications in Russian Language for Use in the Interactive Information Systems', 'the_first_voice_recognition_applications_in', 'SPECOM''2004: 9th Conference  Speech and Computer', '', '2010-08-24');

-- --------------------------------------------------------

--
-- Table structure for table `papers2authors`
--

CREATE TABLE IF NOT EXISTS `papers2authors` (
  `paper_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  UNIQUE KEY `paper_id_2` (`paper_id`,`author_id`),
  KEY `paper_id` (`paper_id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `papers2authors`
--

INSERT INTO `papers2authors` (`paper_id`, `author_id`) VALUES
(1, 3),
(1, 4),
(1, 5);
