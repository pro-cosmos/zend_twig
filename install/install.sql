-- Adminer 4.0.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+04:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `moneybook_category`;
CREATE TABLE `moneybook_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `moneybook_category` (`id`, `title`) VALUES
(1,	'Продукты питания'),
(2,	'Лекарства'),
(3,	'Транспортные расходы');

DROP TABLE IF EXISTS `moneybook_records`;
CREATE TABLE `moneybook_records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` float(9,2) NOT NULL,
  `category` int(11) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `moneybook_records` (`id`, `amount`, `category`, `date_create`) VALUES
(1,	1111.00,	1,	'2014-04-30 11:52:16'),
(2,	2222.00,	3,	'2014-05-30 00:00:00'),
(3,	333.00,	3,	'2014-05-09 18:34:15'),
(4,	10000000.00,	1,	'2014-05-08 09:24:28'),
(13,	1231232.00,	2,	'2014-05-11 14:47:32');

-- 2014-05-11 14:50:50
