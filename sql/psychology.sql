-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- 主机： localhost:3306
-- 生成日期： 2020-07-27 23:30:30
-- 服务器版本： 5.6.37-log
-- PHP 版本： 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `app`
--

-- --------------------------------------------------------

--
-- 表的结构 `psychology`
--

CREATE TABLE `psychology` (
  `sid` int(10) UNSIGNED NOT NULL COMMENT '系统ID',
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户易班ID',
  `name` varchar(20) DEFAULT NULL COMMENT '用户姓名',
  `phone` varchar(11) DEFAULT NULL COMMENT '手机号码',
  `class` varchar(30) NOT NULL COMMENT '专业和班级',
  `type` varchar(16) NOT NULL COMMENT '咨询类型',
  `campus` int(1) NOT NULL COMMENT '校区 2为老校区 1为新校区',
  `state` int(11) NOT NULL DEFAULT '-1' COMMENT '预约状态',
  `CreateTime` datetime NOT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `psychology`
--

INSERT INTO `psychology` (`sid`, `uid`, `name`, `phone`, `class`, `type`, `campus`, `state`, `CreateTime`) VALUES
(1012, 15716133, '郑松影', '15885573770', '广告', '学习压力', 1, -1, '2018-03-28 18:27:10'),
(1017, 15492393, '曹科虎', '1315809593', '应用心理学', '情感受挫', 2, 1, '2018-03-28 20:13:13'),

--
-- 转储表的索引
--

--
-- 表的索引 `psychology`
--
ALTER TABLE `psychology`
  ADD PRIMARY KEY (`sid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `psychology`
--
ALTER TABLE `psychology`
  MODIFY `sid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '系统ID', AUTO_INCREMENT=1019;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
