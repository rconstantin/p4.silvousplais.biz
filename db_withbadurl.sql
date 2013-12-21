-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 20, 2013 at 05:35 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `silvousp_p4_silvousplais_biz`
--

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `yt_video_id` varchar(255) NOT NULL,
  `yt_title` varchar(255) NOT NULL,
  `thumbnail_url` varchar(255) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `last_played` int(11) NOT NULL,
  PRIMARY KEY (`video_id`),
  KEY `videos_ibfk_1` (`user_id`),
  KEY `videos_ibfk_2` (`playlist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=138 ;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`video_id`, `yt_video_id`, `yt_title`, `thumbnail_url`, `playlist_id`, `user_id`, `created`, `last_played`) VALUES
(94, 'dc4rTARzx6I', 'Pink Panther Cartoons Non Stop HD', 'http://i1.ytimg.com/vi/dc4rTARzx6I/default.jpg', 6, 13, 1387202072, 1387336796),
(194, 'dc4rTARzx6I', 'Pink Panther Cartoons Non Stop HD', 'http://i1.ytimg.com/vi/dc4rTARzx6I/default.jpg', 6, 12, 1387202072, 1387336796),
(294, 'dc4rTARzx6I', 'Pink Panther Cartoons Non Stop HD', 'http://i1.ytimg.com/vi/dc4rTARzx6I/default.jpg', 6, 14, 1387202072, 1387336796)
;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `videos_ibfk_2` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`playlist_id`) ON DELETE CASCADE ON UPDATE CASCADE;
