-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2013 at 09:55 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `photoshine`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_comments`
--

CREATE TABLE IF NOT EXISTS `tb_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `text` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `photo_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=95 ;

--
-- Dumping data for table `tb_comments`
--

INSERT INTO `tb_comments` (`id`, `created_time`, `text`, `user_id`, `photo_id`) VALUES
(58, '2013-03-30 18:38:31', 'test cái xem nào\n', 3, 55),
(59, '2013-03-30 18:48:19', 'cũng ổn đấy', 3, 55),
(60, '2013-03-30 19:00:28', 'sosad', 3, 55),
(61, '2013-03-30 19:00:57', 'mình làm được rồi', 3, 55),
(62, '2013-03-30 19:06:01', 'hahah', 3, 55),
(63, '2013-03-30 19:07:59', 'đã làm xong', 3, 55),
(64, '2013-03-30 19:14:10', 'chưa được đi ngủ', 3, 55),
(65, '2013-03-30 19:36:54', 'thôi tạm ổn\n', 3, 55),
(66, '2013-04-01 14:56:35', 'haha', 3, 55),
(67, '2013-04-01 14:57:33', 'haha', 3, 55),
(68, '2013-04-01 14:58:44', 'hô hô', 3, 55),
(69, '2013-04-01 15:40:52', 'xem cái nào', 3, 55),
(70, '2013-04-01 15:49:01', 'hèm', 3, 55),
(71, '2013-04-01 16:00:42', '#football', 3, 55),
(72, '2013-04-01 16:03:29', '@successdt', 3, 55),
(73, '2013-04-01 16:03:44', 'www.thanhdd.com', 3, 55),
(74, '2013-04-01 16:11:05', 'http://facebook.com', 3, 55),
(75, '2013-04-01 16:11:46', '#travel', 3, 55),
(76, '2013-04-01 17:52:15', 'Đẹp quá :d', 3, 53),
(77, '2013-04-06 14:14:36', 'hi everybody', 3, 49),
(78, '2013-04-06 16:30:22', 'woa', 3, 63),
(79, '2013-04-06 16:30:51', 'ổn đấy', 16, 63),
(80, '2013-04-07 05:55:21', 'whow', 20, 60),
(81, '2013-04-09 09:37:06', 'con vẹt xinh thế ', 1, 67),
(82, '2013-04-09 10:47:53', 'Đẹp quá', 1, 66),
(83, '2013-04-09 13:32:13', '@thanhdd xem này', 3, 50),
(84, '2013-04-09 13:32:47', 'ok', 3, 55),
(85, '2013-04-09 13:34:00', '@duythanh', 3, 51),
(86, '2013-04-09 13:35:16', 'hê nhô', 3, 50),
(87, '2013-04-09 13:44:57', 'ổn ko nhỉ', 3, 50),
(88, '2013-04-09 13:46:12', 'hê', 3, 50),
(89, '2013-04-09 13:47:25', 'ok', 3, 50),
(90, '2013-04-09 13:50:51', 'ngon cực :v', 3, 72),
(91, '2013-04-09 17:33:52', 'hợ', 1, 39),
(92, '2013-04-10 14:02:49', 'được', 3, 71),
(93, '2013-04-10 14:57:10', 'hi', 3, 68),
(94, '2013-04-10 14:58:02', 'woa, đẹp quá', 3, 69);

-- --------------------------------------------------------

--
-- Table structure for table `tb_follows`
--

CREATE TABLE IF NOT EXISTS `tb_follows` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_user_id` int(10) unsigned DEFAULT NULL,
  `to_user_id` int(10) unsigned DEFAULT NULL,
  `user_had_accepted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tb_follows`
--

INSERT INTO `tb_follows` (`id`, `from_user_id`, `to_user_id`, `user_had_accepted`) VALUES
(8, 17, 3, 1),
(9, 3, 16, 1),
(16, 3, 1, 1),
(18, 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_likes`
--

CREATE TABLE IF NOT EXISTS `tb_likes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(10) unsigned DEFAULT NULL,
  `photo_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=108 ;

--
-- Dumping data for table `tb_likes`
--

INSERT INTO `tb_likes` (`id`, `created_time`, `user_id`, `photo_id`) VALUES
(63, '2013-04-02 14:32:42', 3, 55),
(64, '2013-04-02 14:32:59', 3, 53),
(81, '2013-04-06 03:24:34', 3, 60),
(82, '2013-04-06 15:44:22', 3, 49),
(84, '2013-04-06 15:44:25', 3, 52),
(85, '2013-04-06 15:44:26', 3, 54),
(86, '2013-04-06 15:44:29', 3, 56),
(87, '2013-04-06 15:44:30', 3, 57),
(88, '2013-04-06 15:44:31', 3, 61),
(89, '2013-04-06 15:44:33', 3, 59),
(90, '2013-04-06 15:44:34', 3, 62),
(91, '2013-04-06 16:36:43', 16, 60),
(92, '2013-04-07 05:55:11', 20, 60),
(93, '2013-04-07 06:00:49', 20, 50),
(94, '2013-04-07 06:00:52', 20, 52),
(95, '2013-04-09 10:47:15', 1, 69),
(96, '2013-04-09 10:47:39', 1, 68),
(97, '2013-04-09 10:47:40', 1, 67),
(98, '2013-04-09 10:47:43', 1, 70),
(99, '2013-04-09 10:47:45', 1, 66),
(100, '2013-04-09 13:50:58', 3, 72),
(101, '2013-04-09 17:10:51', 3, 51),
(102, '2013-04-10 14:02:52', 3, 71),
(106, '2013-04-10 14:27:50', 3, 41),
(107, '2013-04-10 14:58:10', 3, 69);

-- --------------------------------------------------------

--
-- Table structure for table `tb_locations`
--

CREATE TABLE IF NOT EXISTS `tb_locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_id` bigint(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=69 ;

--
-- Dumping data for table `tb_locations`
--

INSERT INTO `tb_locations` (`id`, `latitude`, `longitude`, `name`, `facebook_id`) VALUES
(34, 21.005954425802, 105.84413719177, NULL, 339633429436708),
(35, 21.030748887484, 105.78441361712, NULL, 186367458057539),
(36, 21.005407192461, 105.84426139961, NULL, 105913366139476),
(37, 21.174954017976, 106.05757012299, NULL, 183152851720859),
(38, 53.35694, -6.2564, NULL, 137859686237383),
(39, 21.03068700167, 105.78471267131, NULL, 422715807768927),
(40, 21.030673984142, 105.78446908607, NULL, 114711341945284),
(41, 21.030103135489, 105.7843669387, NULL, 454604644608832),
(42, 21.031470792839, 105.78359749361, NULL, 371661102898627),
(43, 21.015738875743, 105.83288055154, NULL, 266101640165705),
(44, 21.007360449082, 105.79377088581, NULL, 293040364050786),
(45, 21.018664561479, 105.85552844467, NULL, 205749932860124),
(46, 20.979587994586, 105.83180258864, NULL, 457584600943566),
(47, 21.002232, 105.826534, NULL, 485334348176406),
(48, 21.029774360988, 105.84414702941, NULL, 271234749647188),
(49, 21.0415583327, 105.84687605336, NULL, 245079025596133),
(50, 21.032103924179, 105.84938046298, NULL, 324578624237089),
(51, 21.0033059, 105.83031176667, NULL, 381996981823136),
(52, 20.997557295079, 105.84064071171, NULL, 306303196133147),
(53, 20.83407513669, 106.69712306227, NULL, 360307617365230),
(54, 21.030605916555, 105.7847381664, NULL, 207021572758793),
(55, 20.951179694866, 107.08152561459, NULL, 220959121252323),
(56, 20.960205013725, 107.06090209137, NULL, 205958839440406),
(57, 21.02275629108, 105.86086213867, NULL, 262299767125580),
(58, 21.033261610331, 105.85013481515, NULL, 206379816124620),
(59, 21.01503899936, 105.85712488716, NULL, 109204165896114),
(60, 20.982000815044, 105.83190119915, NULL, 303418766397965),
(61, 50.00453893, 14.47708165, NULL, 393438730725011),
(62, 21.03304957, 105.84853399, NULL, 498420166863788),
(63, 21.016133744466, 105.80360766054, NULL, 172874602807309),
(64, 21.019908940843, 105.80507311064, NULL, 451169308249988),
(65, 21.040339630667, 105.78759378602, NULL, 353546708069090),
(66, 21.030637476431, 105.7847629939, NULL, 280104828770252),
(67, 21.01900218867, 105.84666751078, NULL, 317011781742324),
(68, 21.036108568022, 105.85553104152, NULL, 200257296777490);

-- --------------------------------------------------------

--
-- Table structure for table `tb_notifications`
--

CREATE TABLE IF NOT EXISTS `tb_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `text` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_had_read` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_photos`
--

CREATE TABLE IF NOT EXISTS `tb_photos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tags` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(11) unsigned DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `low_resolution_url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `standard_resolution` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caption` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `report` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=74 ;

--
-- Dumping data for table `tb_photos`
--

INSERT INTO `tb_photos` (`id`, `tags`, `location_id`, `created_time`, `low_resolution_url`, `thumbnail`, `standard_resolution`, `caption`, `user_id`, `report`) VALUES
(39, '#baby,', 41, '2013-03-22 15:23:47', 'upload/39_low.jpg', 'upload/39_thumb.jpg', 'upload/39.jpg', 'hehe', 3, 0),
(40, ',', 42, '2013-03-22 15:44:35', 'upload/40_low.jpg', 'upload/40_thumb.jpg', 'upload/40.jpg', 'Hà Nội', 3, 0),
(41, '#leg,', NULL, '2013-03-22 15:57:10', 'upload/41_low.jpg', 'upload/41_thumb.jpg', 'upload/41.jpg', 'Cũng được', 3, 0),
(43, '#bridge,', NULL, '2013-03-22 16:33:42', 'upload/43_low.jpg', 'upload/43_thumb.jpg', 'upload/43.jpg', 'Cầu Long Biên', 3, 0),
(45, '#lights,', NULL, '2013-03-26 08:28:13', 'upload/45_low.jpg', 'upload/45_thumb.jpg', 'upload/45.jpg', 'Đẹp quá', 3, 0),
(46, NULL, NULL, '2013-03-26 08:42:01', 'upload/46_low.jpg', 'upload/46_thumb.jpg', 'upload/46.jpg', '', 3, 0),
(47, NULL, 45, '2013-03-26 16:15:09', 'upload/47_low.jpg', 'upload/47_thumb.jpg', 'upload/47.jpg', '', 3, 0),
(49, '#travel,#food', 46, '2013-03-30 05:47:55', 'upload/49_low.jpg', 'upload/49_thumb.jpg', 'upload/49.jpg', '', 3, 0),
(50, '#travel,#tech', 47, '2013-03-30 05:54:59', 'upload/50_low.jpg', 'upload/50_thumb.jpg', 'upload/50.jpg', 'Công viên thống nhất', 3, 0),
(51, '#hanoi,#travel', 48, '2013-03-30 06:07:07', 'upload/51_low.jpg', 'upload/51_thumb.jpg', 'upload/51.jpg', 'Bách Khoa Hà Nội', 3, 0),
(52, '#travel,#hospital', 49, '2013-03-30 06:09:09', 'upload/52_low.jpg', 'upload/52_thumb.jpg', 'upload/52.jpg', 'Bạch mai hospital', 3, 0),
(53, '#travel,#tech', 50, '2013-03-30 06:21:50', 'upload/53_low.jpg', 'upload/53_thumb.jpg', 'upload/53.jpg', 'Bách Khoa', 3, 0),
(54, '#travel,#tech', 51, '2013-03-30 06:25:28', 'upload/54_low.jpg', 'upload/54_thumb.jpg', 'upload/54.jpg', '', 3, 0),
(55, '#travel,#sport', 52, '2013-03-30 06:35:16', 'upload/55_low.jpg', 'upload/55_thumb.jpg', 'upload/55.jpg', '<div> đẹp quá', 3, 0),
(56, '#travel,#art', 53, '2013-03-30 08:06:33', 'upload/56_low.jpg', 'upload/56_thumb.jpg', 'upload/56.jpg', '', 3, 0),
(57, '#travel,#gift', 54, '2013-04-04 16:23:02', 'upload/57_low.jpg', 'upload/57_thumb.jpg', 'upload/57.jpg', 'gấu toshiba gửi tặng', 3, 0),
(59, '#halong,#travel', 56, '2013-04-06 02:41:17', 'upload/59_low.jpg', 'upload/59_thumb.jpg', 'upload/59.jpg', '', 3, 0),
(60, '#travel,#hanoi', 57, '2013-04-06 03:19:14', 'upload/60_low.jpg', 'upload/60_thumb.jpg', 'upload/60.jpg', 'đẹp đấy', 3, 0),
(61, '#travel,#hanoi', 58, '2013-04-06 03:25:21', 'upload/61_low.jpg', 'upload/61_thumb.jpg', 'upload/61.jpg', '', 3, 0),
(62, '#travel,#food', 59, '2013-04-06 03:31:57', 'upload/62_low.jpg', 'upload/62_thumb.jpg', 'upload/62.jpg', 'Cũng dc mà', 3, 0),
(63, '#travel,#hanoi', 62, '2013-04-06 16:29:30', 'upload/63_low.jpg', 'upload/63_thumb.jpg', 'upload/63.jpg', 'sâu ciu', 16, 0),
(64, '#travel,#food', 63, '2013-04-07 15:53:05', 'upload/64_low.jpg', 'upload/64_thumb.jpg', 'upload/64.jpg', 'Nguyễn Khang', 3, 0),
(65, '#travel,#food', 64, '2013-04-07 15:53:51', 'upload/65_low.jpg', 'upload/65_thumb.jpg', 'upload/65.jpg', '', 1, 0),
(66, '#travel,#art', 63, '2013-04-07 15:59:24', 'upload/66_low.jpg', 'upload/66_thumb.jpg', 'upload/66.jpg', 'Ok', 3, 0),
(67, '#travel,#tech', 35, '2013-04-09 08:02:00', 'upload/67_low.jpg', 'upload/67_thumb.jpg', 'upload/67.jpg', 'Vẹt', 1, 0),
(68, '#travel,#food', 48, '2013-04-09 08:52:44', 'upload/68_low.jpg', 'upload/68_thumb.jpg', 'upload/68.jpg', '', 1, 0),
(69, '#travel,#sport', 65, '2013-04-09 09:07:57', 'upload/69_low.jpg', 'upload/69_thumb.jpg', 'upload/69.jpg', '', 1, 0),
(70, '#travel,#gift', 66, '2013-04-09 09:30:49', 'upload/70_low.jpg', 'upload/70_thumb.jpg', 'upload/70.jpg', '', 1, 0),
(71, '#travel,#baby', NULL, '2013-04-09 10:43:55', 'upload/71_low.jpg', 'upload/71_thumb.jpg', 'upload/71.jpg', 'Baby', 1, 0),
(72, '#travel,#food', 67, '2013-04-09 13:31:02', 'upload/72_low.jpg', 'upload/72_thumb.jpg', 'upload/72.jpg', 'Ngon quá', 3, 0),
(73, '#travel,#natural', 68, '2013-04-10 14:20:17', 'upload/73_low.jpg', 'upload/73_thumb.jpg', 'upload/73.jpg', 'Cũng đẹp mà', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE IF NOT EXISTS `tb_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `bio` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `report` int(10) unsigned DEFAULT NULL,
  `facebook_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_token` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_token` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_secret` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tumblr_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tumblr_token` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tumblr_secret` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flickr_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flickr_token` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `password`, `email`, `bio`, `gender`, `website`, `profile_picture`, `first_name`, `last_name`, `city`, `country`, `report`, `facebook_id`, `facebook_token`, `twitter_id`, `twitter_token`, `twitter_secret`, `tumblr_id`, `tumblr_token`, `tumblr_secret`, `flickr_id`, `flickr_token`) VALUES
(1, 'duythanh', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1, 'http://lifetimetech.vn', 'profile/1.jpg', 'Thành', 'Đào Duy', 'hanoi', 'Vietnam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'thanhdd', 'e10adc3949ba59abbe56e057f20f883e', 'thanhdd@lifetimetech.vn', 'PHP developer at Lifetime technologies co,.Ltd', 1, 'http://facebook.com/successdt', 'profile/3.jpg', 'Duy Thanh', 'Dao', 'Hanoi', 'Vietnam', NULL, '100000102092930', 'AAAFyyjCyQooBACygJ0P0gcytZBZCMIP4wh3QdelXJe5aZAAZBLZCzkoZCteqipxeOzb08QClE7ASHXZAnFoSwYgQqnuUAKNVzAgdSlnZBRKevQZDZD', '723755342', '723755342-323cWhvS8yhgiy2ErihgVzYi5Cr8DD7sz19A4ubE', '6YzVmc8ekmVi9Y2IPx2il0CeNn68HXGvpDr0PRE37I', NULL, NULL, NULL, '85894007@N04', '72157633057724575-3ba5f3d2efe6a978'),
(8, 'adminx', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, NULL, 'profile/default_avatar.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'adminxx', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, NULL, 'profile/default_avatar.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'admin123', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, NULL, 'profile/default_avatar.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'admin123', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, NULL, 'profile/default_avatar.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'admin1234', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, NULL, 'profile/default_avatar.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'thanhddd', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0, NULL, 'profile/default_avatar.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'thanhddt', 'e10adc3949ba59abbe56e057f20f883e', 'thanhdd@lifetimetech.vn', '', 0, NULL, 'profile/default_avatar.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'successdt', 'e10adc3949ba59abbe56e057f20f883e', 'success_dt@yahoo.com.vn', '', 0, NULL, 'profile/default_avatar.png', NULL, NULL, NULL, NULL, NULL, '100001710105757', 'AAAFyyjCyQooBAHsYpInOXw1cZApXi3Rqu8OvwUDqF7OMFXvgEwTegPnojI1N0Nj2eqGWFZBaVZCDE9MJ2HVZBkjZAyD7XgyHskpPZC2h32KwZDZD', '1314531990', '1314531990-EHTXR2rLRfqmZNUQKjuw7Q0vrQGTwj4QpNAOTfJ', '86BpeopSXAMMEhpLaVK5zjRdyiUHL1LhI9UZZY', NULL, NULL, NULL, NULL, NULL),
(17, 'barcelona', 'e10adc3949ba59abbe56e057f20f883e', 'thanhdd@lifetimetech.vn', '', 0, NULL, 'profile/default_avatar.png', NULL, NULL, NULL, NULL, NULL, '100000102092930', 'AAAFyyjCyQooBACygJ0P0gcytZBZCMIP4wh3QdelXJe5aZAAZBLZCzkoZCteqipxeOzb08QClE7ASHXZAnFoSwYgQqnuUAKNVzAgdSlnZBRKevQZDZD', '723755342', '723755342-323cWhvS8yhgiy2ErihgVzYi5Cr8DD7sz19A4ubE', '6YzVmc8ekmVi9Y2IPx2il0CeNn68HXGvpDr0PRE37I', NULL, NULL, NULL, NULL, NULL),
(18, 'dhbkhn', 'e10adc3949ba59abbe56e057f20f883e', 'thanhdd@lifetimetech.vn', '', 1, 'http://facebook.com/successdt', 'profile/18.jpg', 'bach khoa', 'ha noi', 'hanoi', 'Vietnam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'mrzero', 'e10adc3949ba59abbe56e057f20f883e', 'thanhdd@lifetimetech.vn', '', 0, NULL, 'profile/default_avatar.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'admin1', 'e10adc3949ba59abbe56e057f20f883e', 'thanhdd@lifetimetech.vn', '', 1, '', 'profile/20.jpg', 'thanh', 'dao duy', '', '', NULL, '100000102092930', 'AAAFyyjCyQooBACygJ0P0gcytZBZCMIP4wh3QdelXJe5aZAAZBLZCzkoZCteqipxeOzb08QClE7ASHXZAnFoSwYgQqnuUAKNVzAgdSlnZBRKevQZDZD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
