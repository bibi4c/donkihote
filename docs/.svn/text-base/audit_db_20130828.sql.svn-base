-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2013 年 8 月 28 日 06:34
-- サーバのバージョン: 5.6.13-log
-- PHP のバージョン: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `audit_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(6) CHARACTER SET utf8 NOT NULL COMMENT 'ID',
  `password` varchar(12) CHARACTER SET utf8 NOT NULL COMMENT 'パスワード',
  `authority` int(1) NOT NULL COMMENT '権限',
  `male_address` varchar(30) NOT NULL COMMENT 'メールアドレス',
  `ｓｔatus` int(1) NOT NULL COMMENT '状態',
  `register_datetime` datetime DEFAULT NULL,
  `register_user` varchar(30) DEFAULT NULL,
  `register_process` varchar(30) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `update_user` varchar(30) DEFAULT NULL,
  `update_process` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `id_3` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `password`, `authority`, `male_address`, `ｓｔatus`, `register_datetime`, `register_user`, `register_process`, `update_datetime`, `update_user`, `update_process`) VALUES
('000001', 'password', 1, 'aaa@bbb.co.jp', 1, '2013-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL),
('000002', '1qaz2wsx', 2, 'aaa@bbb.co.jp', 1, '2013-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL),
('000003', '1qaz2wsx', 3, 'aaa@bbb.co.jp', 1, '2013-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL),
('000004', '1qaz2wsx', 1, 'aaa@bbb.co.jp', 1, '2013-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL),
('000005', '1qaz2wsx', 2, 'aaa@bbb.co.jp', 1, '2013-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL),
('000006', '1qaz2wsx', 3, 'aaa@bbb.co.jp', 1, '2013-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL),
('000007', '1qaz2wsx', 1, 'aaa@bbb.co.jp', 1, '2013-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL),
('000008', '1qaz2wsx', 2, 'aaa@bbb.co.jp', 1, '2013-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL),
('000009', '1qaz2wsx', 2, 'aaa@bbb.co.jp', 1, '2013-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL),
('000010', '1qaz2wsx', 2, 'aaa@bbb.co.jp', 0, '2013-08-01 00:00:00', NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

Fatal error: Allowed memory size of 134217728 bytes exhausted (tried to allocate 12096825 bytes) in Unknown on line 0
