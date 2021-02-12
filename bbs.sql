-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-02-12 16:10:49
-- 服务器版本： 5.6.49-log
-- PHP 版本： 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `bbs`
--

-- --------------------------------------------------------

--
-- 表的结构 `bbs_post`
--

CREATE TABLE `bbs_post` (
  `bbs_postid` int(8) UNSIGNED NOT NULL,
  `bbs_postuser` int(8) UNSIGNED NOT NULL COMMENT '发帖人uid',
  `bbs_posttitle` varchar(100) NOT NULL,
  `bbs_postcontent` varchar(400) NOT NULL,
  `bbs_posttime` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bbs_user`
--

CREATE TABLE `bbs_user` (
  `bbs_userid` int(8) UNSIGNED NOT NULL,
  `bbs_username` varchar(22) NOT NULL,
  `bbs_useremail` varchar(32) NOT NULL,
  `bbs_userpasswd` varchar(40) NOT NULL,
  `bbs_usertime` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `bbs_post`
--
ALTER TABLE `bbs_post`
  ADD PRIMARY KEY (`bbs_postid`);

--
-- 表的索引 `bbs_user`
--
ALTER TABLE `bbs_user`
  ADD PRIMARY KEY (`bbs_userid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `bbs_post`
--
ALTER TABLE `bbs_post`
  MODIFY `bbs_postid` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `bbs_user`
--
ALTER TABLE `bbs_user`
  MODIFY `bbs_userid` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
