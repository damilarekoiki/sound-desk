-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2020 at 05:59 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sound_desk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `profile_pix` text NOT NULL,
  `date_registered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `advert`
--

CREATE TABLE `advert` (
  `id` int(11) NOT NULL,
  `advert_id` int(11) NOT NULL,
  `company_name` text NOT NULL,
  `company_website` text NOT NULL,
  `advert_type` int(11) DEFAULT NULL COMMENT '0 for others 1 for audios on channel',
  `advert_cover_pix` text NOT NULL,
  `audios_on_channel` text NOT NULL,
  `channel_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `audio_file_path` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advert`
--

INSERT INTO `advert` (`id`, `advert_id`, `company_name`, `company_website`, `advert_type`, `advert_cover_pix`, `audios_on_channel`, `channel_id`, `owner_id`, `audio_file_path`, `date_created`) VALUES
(2, 2, 'Mounzion', 'mzfm.com', 1, 'assets/advert_cover_pix/1/220190215215603.jfif', '[\"2\"]', 1, 1, 'assets/adverts/1/220190215215603.mp3', '2019-02-15 21:56:03'),
(3, 3, 'Techno', 'www.technoit.com', 0, 'assets/advert_cover_pix/1/320190216150900.png', '', 1, 1, 'assets/adverts/1/320190216150900.mp3', '2019-02-16 15:09:00'),
(4, 4, 'Indomie', 'indomie.ng', 0, 'assets/advert_cover_pix/5/420190227000524.png', '', 5, 2, 'assets/adverts/5/420190227000524.mp3', '2019-02-27 00:05:24'),
(5, 5, 'jumia', 'jumia.com.ng', 0, 'assets/advert_cover_pix/6/520190227012121.png', '', 6, 3, 'assets/adverts/6/520190227012121.mp3', '2019-02-27 01:21:21'),
(6, 6, 'Peak milk', 'peak milk.com.ng', 0, 'assets/advert_cover_pix/9/620190227024359.png', '', 9, 4, 'assets/adverts/9/620190227024359.mp3', '2019-02-27 02:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `audios_promotion`
--

CREATE TABLE `audios_promotion` (
  `id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `promoted_audios` text NOT NULL COMMENT 'json encode of ids of audios to be promoted',
  `audios_to_get` text NOT NULL COMMENT 'json encode of ids of audios to get',
  `num_audios_to_get` int(11) DEFAULT '0',
  `promo_type` int(11) DEFAULT NULL COMMENT '1- Get audios on discount, 2 - Buy audios get others for free, 3 - Buy audios get others on discount',
  `discount` float DEFAULT NULL,
  `audios_to_get_is_free` int(11) DEFAULT NULL,
  `audios_to_get_decider` int(11) DEFAULT NULL COMMENT '1- I decide, 2- Customer decides',
  `promo_code` varchar(10) NOT NULL,
  `end_date` date NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audios_promotion`
--

INSERT INTO `audios_promotion` (`id`, `promo_id`, `channel_id`, `owner_id`, `promoted_audios`, `audios_to_get`, `num_audios_to_get`, `promo_type`, `discount`, `audios_to_get_is_free`, `audios_to_get_decider`, `promo_code`, `end_date`, `date_created`) VALUES
(1, 1, 1, 1, '[\"1\"]', '[\"2\"]', 1, 2, NULL, 1, 1, 'SD4698a094', '2019-07-08', '2019-02-15 16:53:41');

-- --------------------------------------------------------

--
-- Table structure for table `audio_category_available`
--

CREATE TABLE `audio_category_available` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audio_category_available`
--

INSERT INTO `audio_category_available` (`id`, `category_id`, `category_name`) VALUES
(1, 1, 'Gospel Music'),
(2, 2, 'Audio book'),
(3, 3, 'Classical'),
(4, 4, 'Rock'),
(5, 5, 'Jazz'),
(6, 6, 'Reggae'),
(7, 7, 'Blues'),
(8, 8, 'Dance Music'),
(9, 9, 'Instrumental'),
(10, 10, 'Soul Music'),
(11, 11, 'Sermon'),
(12, 12, 'House Music'),
(13, 13, 'Comedy'),
(14, 14, 'Hip Hop'),
(15, 15, 'Rhythm and Blues'),
(16, 16, 'Orchestra'),
(17, 17, 'Opera'),
(18, 18, 'Disco'),
(19, 19, 'Industrial Music'),
(20, 20, 'Chant');

-- --------------------------------------------------------

--
-- Table structure for table `audio_category_views`
--

CREATE TABLE `audio_category_views` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_played` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audio_category_views`
--

INSERT INTO `audio_category_views` (`id`, `category_id`, `user_id`, `date_played`) VALUES
(1, 1, 1, '2019-02-25 15:36:19'),
(2, 1, 2, '2019-02-26 22:57:22'),
(3, 1, 3, '2019-02-27 01:12:09'),
(4, 1, 4, '2019-02-27 01:58:29'),
(5, 0, 4, '2019-02-27 08:37:37'),
(6, 0, 1, '2019-03-08 15:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `audio_cover_picture`
--

CREATE TABLE `audio_cover_picture` (
  `id` int(11) NOT NULL,
  `audio_id` int(11) NOT NULL,
  `picture_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audio_cover_picture`
--

INSERT INTO `audio_cover_picture` (`id`, `audio_id`, `picture_path`) VALUES
(1, 1, 'assets/audio_cover_photos/1/120190215124835.jfif'),
(2, 2, 'assets/audio_cover_photos/1/220190215164639.jfif'),
(4, 4, 'assets/audio_cover_photos/1/420190216142105.png'),
(5, 5, 'assets/audio_cover_photos/1/520190216144409.png');

-- --------------------------------------------------------

--
-- Table structure for table `audio_payment_mode`
--

CREATE TABLE `audio_payment_mode` (
  `id` int(11) NOT NULL,
  `audio_id` int(11) NOT NULL,
  `payment_mode` int(11) DEFAULT NULL COMMENT '0 for recharge my wallet, 1 for pay to me'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audio_payment_mode`
--

INSERT INTO `audio_payment_mode` (`id`, `audio_id`, `payment_mode`) VALUES
(1, 1, 1),
(2, 2, 0),
(28, 4, 0),
(29, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `audio_preview_file`
--

CREATE TABLE `audio_preview_file` (
  `id` int(11) NOT NULL,
  `audio_id` int(11) NOT NULL,
  `audio_preview_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audio_preview_file`
--

INSERT INTO `audio_preview_file` (`id`, `audio_id`, `audio_preview_path`) VALUES
(1, 1, 'assets/audio_productions_preview/1/120190215124834.mp3'),
(2, 2, 'assets/audio_productions_preview/1/220190215164639.mp3'),
(4, 4, 'assets/audio_productions_preview/1/420190216142104.mp3'),
(5, 5, 'assets/audio_productions_preview/1/520190216144409.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `audio_production`
--

CREATE TABLE `audio_production` (
  `id` int(11) NOT NULL,
  `audio_id` int(11) NOT NULL,
  `audio_name` text NOT NULL,
  `channel_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `description` text NOT NULL,
  `duration` float NOT NULL COMMENT 'In seconds',
  `artistes` text NOT NULL,
  `restricted_age_min` int(11) DEFAULT NULL,
  `restricted_age_max` int(11) DEFAULT NULL,
  `audio_file_path` text NOT NULL,
  `is_free` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `date_uploaded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audio_production`
--

INSERT INTO `audio_production` (`id`, `audio_id`, `audio_name`, `channel_id`, `owner_id`, `category`, `price`, `description`, `duration`, `artistes`, `restricted_age_min`, `restricted_age_max`, `audio_file_path`, `is_free`, `deleted`, `date_uploaded`) VALUES
(1, 1, 'Talebale', 1, 1, 1, '20', 'A gospel song talking about eternity', 292.116, 'JayMikee', 0, 0, 'assets/audio_productions/1/120190215124834.mp3', 0, 0, '2019-02-15 12:48:34'),
(2, 2, 'A new man', 1, 1, 1, '50', 'A new man in Christ', 341.606, 'JayMikee', 0, 0, 'assets/audio_productions/1/220190215164639.mp3', 0, 0, '2019-02-15 16:46:39'),
(4, 4, 'By my side', 1, 1, 1, NULL, 'Powerful', 266.265, 'Nosa', NULL, NULL, 'assets/audio_productions/1/420190216142104.mp3', 1, 0, '2019-02-16 14:21:04'),
(5, 5, 'Breaking point', 1, 1, 1, NULL, 'Gods love for humanity', 235.929, 'JayMikee', NULL, NULL, 'assets/audio_productions/1/520190216144409.mp3', 1, 1, '2019-02-16 14:44:09');

-- --------------------------------------------------------

--
-- Table structure for table `audio_rating`
--

CREATE TABLE `audio_rating` (
  `id` int(11) NOT NULL,
  `audio_id` int(11) NOT NULL,
  `rater_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_rated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audio_rating`
--

INSERT INTO `audio_rating` (`id`, `audio_id`, `rater_id`, `rate`, `comment`, `date_rated`) VALUES
(1, 5, 1, 4, 'I love this audio', '2019-02-19 00:46:01'),
(3, 1, 1, 5, 'Great music', '2019-02-19 02:16:16');

-- --------------------------------------------------------

--
-- Table structure for table `audio_views`
--

CREATE TABLE `audio_views` (
  `id` int(11) NOT NULL,
  `audio_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_played` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audio_views`
--

INSERT INTO `audio_views` (`id`, `audio_id`, `user_id`, `date_played`) VALUES
(1, 1, 1, '2019-02-25 15:36:19'),
(3, 4, 1, '2019-02-26 10:36:50'),
(4, 2, 1, '2019-02-26 13:20:14');

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--

CREATE TABLE `channel` (
  `id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `channel_name` varchar(70) NOT NULL,
  `brand_location` int(11) NOT NULL,
  `description` text NOT NULL,
  `logo` text NOT NULL,
  `cover_pix` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel`
--

INSERT INTO `channel` (`id`, `channel_id`, `owner_id`, `channel_name`, `brand_location`, `description`, `logo`, `cover_pix`, `date_created`) VALUES
(1, 1, 1, 'Koiki Music Channel', 173, 'For all audio uploads\r\n', 'assets/img/logo_avatar.png', 'assets/img/background9.jpg', '2019-02-10 17:56:04'),
(2, 2, 1, 'Supreme Light', 173, '', 'assets/img/logo_avatar.png', 'assets/img/background9.jpg', '2019-02-25 16:27:55'),
(3, 3, 1, 'Glorious band', 245, '', 'assets/img/logo_avatar.png', 'assets/img/background9.jpg', '2019-02-26 22:08:36'),
(4, 4, 2, 'wonderful wonder', 245, '', 'assets/img/logo_avatar.png', 'assets/img/background9.jpg', '2019-02-26 22:40:59'),
(5, 5, 2, 'Big World', 173, '', 'assets/img/logo_avatar.png', 'assets/img/background9.jpg', '2019-02-26 23:53:54'),
(6, 6, 3, 'Lives Good', 247, '', 'assets/img/logo_avatar.png', 'assets/img/background9.jpg', '2019-02-27 00:51:08'),
(7, 7, 3, 'Greater Than', 173, '', 'assets/img/logo_avatar.png', 'assets/img/background9.jpg', '2019-02-27 01:23:22'),
(8, 8, 4, 'Meaning of Life', 245, '', 'assets/img/logo_avatar.png', 'assets/img/background9.jpg', '2019-02-27 01:47:03'),
(9, 9, 4, 'unlimited one', 173, '', 'assets/img/logo_avatar.png', 'assets/img/background9.jpg', '2019-02-27 02:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `channel_subscriptions`
--

CREATE TABLE `channel_subscriptions` (
  `id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `subscriber_id` int(11) NOT NULL,
  `date_subscribed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel_subscriptions`
--

INSERT INTO `channel_subscriptions` (`id`, `channel_id`, `owner_id`, `subscriber_id`, `date_subscribed`) VALUES
(5, 1, 0, 1, '2019-02-26 13:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `channel_visits`
--

CREATE TABLE `channel_visits` (
  `id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_visited` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel_visits`
--

INSERT INTO `channel_visits` (`id`, `channel_id`, `user_id`, `date_visited`) VALUES
(1, 1, 1, '2019-02-25 15:36:19'),
(2, 3, 1, '2019-02-26 22:27:18'),
(3, 1, 2, '2019-02-26 22:57:22'),
(4, 4, 2, '2019-02-26 23:49:28'),
(5, 5, 2, '2019-02-27 00:14:18'),
(6, 6, 3, '2019-02-27 01:12:09'),
(7, 8, 4, '2019-02-27 01:58:29'),
(8, 9, 4, '2019-02-27 02:11:33'),
(9, 4, 4, '2019-02-27 08:36:51'),
(10, 7, 4, '2019-02-27 09:01:04'),
(11, 6, 4, '2019-02-27 11:00:15'),
(12, 4, 1, '2019-02-28 10:13:08'),
(13, 7, 1, '2019-02-28 11:52:03'),
(14, 9, 1, '2019-03-04 01:06:32'),
(15, 6, 1, '2019-03-04 01:07:20'),
(16, 5, 1, '2019-03-08 15:19:55'),
(17, 8, 1, '2019-03-08 15:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `cc_fips` varchar(2) NOT NULL,
  `cc_iso` varchar(2) NOT NULL,
  `tld` varchar(3) NOT NULL,
  `country_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `cc_fips`, `cc_iso`, `tld`, `country_name`) VALUES
(1, 'AA', 'AW', '.aw', 'Aruba\r'),
(2, 'AC', 'AG', '.ag', 'Antigua and Barbuda\r'),
(3, 'AE', 'AE', '.ae', 'United Arab Emirates\r'),
(4, 'AF', 'AF', '.af', 'Afghanistan\r'),
(5, 'AG', 'DZ', '.dz', 'Algeria\r'),
(6, 'AJ', 'AZ', '.az', 'Azerbaijan\r'),
(7, 'AL', 'AL', '.al', 'Albania\r'),
(8, 'AM', 'AM', '.am', 'Armenia\r'),
(9, 'AN', 'AD', '.ad', 'Andorra\r'),
(10, 'AO', 'AO', '.ao', 'Angola\r'),
(11, 'AQ', 'AS', '.as', 'American Samoa\r'),
(12, 'AR', 'AR', '.ar', 'Argentina\r'),
(13, 'AS', 'AU', '.au', 'Australia\r'),
(14, 'AT', '-', '-', 'Ashmore and Cartier Islands\r'),
(15, 'AU', 'AT', '.at', 'Austria\r'),
(16, 'AV', 'AI', '.ai', 'Anguilla\r'),
(17, '-', 'AX', '.ax', 'Ã…land Islands\r'),
(18, 'AY', 'AQ', '.aq', 'Antarctica\r'),
(19, 'BA', 'BH', '.bh', 'Bahrain\r'),
(20, 'BB', 'BB', '.bb', 'Barbados\r'),
(21, 'BC', 'BW', '.bw', 'Botswana\r'),
(22, 'BD', 'BM', '.bm', 'Bermuda\r'),
(23, 'BE', 'BE', '.be', 'Belgium\r'),
(24, 'BF', 'BS', '.bs', 'Bahamas, The\r'),
(25, 'BG', 'BD', '.bd', 'Bangladesh\r'),
(26, 'BH', 'BZ', '.bz', 'Belize\r'),
(27, 'BK', 'BA', '.ba', 'Bosnia and Herzegovina\r'),
(28, 'BL', 'BO', '.bo', 'Bolivia\r'),
(29, 'TB', 'BL', '.bl', 'Saint Barthelemy\r'),
(30, 'BM', 'MM', '.mm', 'Myanmar\r'),
(31, 'BN', 'BJ', '.bj', 'Benin\r'),
(32, 'BO', 'BY', '.by', 'Belarus\r'),
(33, 'BP', 'SB', '.sb', 'Solomon Islands\r'),
(34, 'BQ', '-', '-', 'Navassa Island\r'),
(35, 'BR', 'BR', '.br', 'Brazil\r'),
(36, 'BS', '-', '-', 'Bassas da India\r'),
(37, 'BT', 'BT', '.bt', 'Bhutan\r'),
(38, 'BU', 'BG', '.bg', 'Bulgaria\r'),
(39, 'BV', 'BV', '.bv', 'Bouvet Island\r'),
(40, 'BX', 'BN', '.bn', 'Brunei\r'),
(41, 'BY', 'BI', '.bi', 'Burundi\r'),
(42, 'CA', 'CA', '.ca', 'Canada\r'),
(43, 'CB', 'KH', '.kh', 'Cambodia\r'),
(44, 'CD', 'TD', '.td', 'Chad\r'),
(45, 'CE', 'LK', '.lk', 'Sri Lanka\r'),
(46, 'CF', 'CG', '.cg', 'Congo, Republic of the\r'),
(47, 'CG', 'CD', '.cd', 'Congo, Democratic Republic of the\r'),
(48, 'CH', 'CN', '.cn', 'China\r'),
(49, 'CI', 'CL', '.cl', 'Chile\r'),
(50, 'CJ', 'KY', '.ky', 'Cayman Islands\r'),
(51, 'CK', 'CC', '.cc', 'Cocos (Keeling) Islands\r'),
(52, 'CM', 'CM', '.cm', 'Cameroon\r'),
(53, 'CN', 'KM', '.km', 'Comoros\r'),
(54, 'CO', 'CO', '.co', 'Colombia\r'),
(55, 'CQ', 'MP', '.mp', 'Northern Mariana Islands\r'),
(56, 'CR', '-', '-', 'Coral Sea Islands\r'),
(57, 'CS', 'CR', '.cr', 'Costa Rica\r'),
(58, 'CT', 'CF', '.cf', 'Central African Republic\r'),
(59, 'CU', 'CU', '.cu', 'Cuba\r'),
(60, 'CV', 'CV', '.cv', 'Cape Verde\r'),
(61, 'CW', 'CK', '.ck', 'Cook Islands\r'),
(62, 'CY', 'CY', '.cy', 'Cyprus\r'),
(63, 'DA', 'DK', '.dk', 'Denmark\r'),
(64, 'DJ', 'DJ', '.dj', 'Djibouti\r'),
(65, 'DO', 'DM', '.dm', 'Dominica\r'),
(66, 'DR', 'DO', '.do', 'Dominican Republic\r'),
(67, 'DX', '-', '-', 'Dhekelia Sovereign Base Area\r'),
(68, 'EC', 'EC', '.ec', 'Ecuador\r'),
(69, 'EG', 'EG', '.eg', 'Egypt\r'),
(70, 'EI', 'IE', '.ie', 'Ireland\r'),
(71, 'EK', 'GQ', '.gq', 'Equatorial Guinea\r'),
(72, 'EN', 'EE', '.ee', 'Estonia\r'),
(73, 'ER', 'ER', '.er', 'Eritrea\r'),
(74, 'ES', 'SV', '.sv', 'El Salvador\r'),
(75, 'ET', 'ET', '.et', 'Ethiopia\r'),
(76, 'EU', '-', '-', 'Europa Island\r'),
(77, 'EZ', 'CZ', '.cz', 'Czech Republic\r'),
(78, 'FG', 'GF', '.gf', 'French Guiana\r'),
(79, 'FI', 'FI', '.fi', 'Finland\r'),
(80, 'FJ', 'FJ', '.fj', 'Fiji\r'),
(81, 'FK', 'FK', '.fk', 'Falkland Islands (Islas Malvinas)\r'),
(82, 'FM', 'FM', '.fm', 'Micronesia, Federated States of\r'),
(83, 'FO', 'FO', '.fo', 'Faroe Islands\r'),
(84, 'FP', 'PF', '.pf', 'French Polynesia\r'),
(85, 'FR', 'FR', '.fr', 'France\r'),
(86, 'FS', 'TF', '.tf', 'French Southern and Antarctic Lands\r'),
(87, 'GA', 'GM', '.gm', 'Gambia, The\r'),
(88, 'GB', 'GA', '.ga', 'Gabon\r'),
(89, 'GG', 'GE', '.ge', 'Georgia\r'),
(90, 'GH', 'GH', '.gh', 'Ghana\r'),
(91, 'GI', 'GI', '.gi', 'Gibraltar\r'),
(92, 'GJ', 'GD', '.gd', 'Grenada\r'),
(93, 'GK', 'GG', '.gg', 'Guernsey\r'),
(94, 'GL', 'GL', '.gl', 'Greenland\r'),
(95, 'GM', 'DE', '.de', 'Germany\r'),
(96, 'GO', '-', '-', 'Glorioso Islands\r'),
(97, 'GP', 'GP', '.gp', 'Guadeloupe\r'),
(98, 'GQ', 'GU', '.gu', 'Guam\r'),
(99, 'GR', 'GR', '.gr', 'Greece\r'),
(100, 'GT', 'GT', '.gt', 'Guatemala\r'),
(101, 'GV', 'GN', '.gn', 'Guinea\r'),
(102, 'GY', 'GY', '.gy', 'Guyana\r'),
(103, 'GZ', '-', '-', 'Gaza Strip\r'),
(104, 'HA', 'HT', '.ht', 'Haiti\r'),
(105, 'HK', 'HK', '.hk', 'Hong Kong\r'),
(106, 'HM', 'HM', '.hm', 'Heard Island and McDonald Islands\r'),
(107, 'HO', 'HN', '.hn', 'Honduras\r'),
(108, 'HR', 'HR', '.hr', 'Croatia\r'),
(109, 'HU', 'HU', '.hu', 'Hungary\r'),
(110, 'IC', 'IS', '.is', 'Iceland\r'),
(111, 'ID', 'ID', '.id', 'Indonesia\r'),
(112, 'IM', 'IM', '.im', 'Isle of Man\r'),
(113, 'IN', 'IN', '.in', 'India\r'),
(114, 'IO', 'IO', '.io', 'British Indian Ocean Territory\r'),
(115, 'IP', '-', '-', 'Clipperton Island\r'),
(116, 'IR', 'IR', '.ir', 'Iran\r'),
(117, 'IS', 'IL', '.il', 'Israel\r'),
(118, 'IT', 'IT', '.it', 'Italy\r'),
(119, 'IV', 'CI', '.ci', 'Cote d\'Ivoire\r'),
(120, 'IZ', 'IQ', '.iq', 'Iraq\r'),
(121, 'JA', 'JP', '.jp', 'Japan\r'),
(122, 'JE', 'JE', '.je', 'Jersey\r'),
(123, 'JM', 'JM', '.jm', 'Jamaica\r'),
(124, 'JN', 'SJ', '-', 'Jan Mayen\r'),
(125, 'JO', 'JO', '.jo', 'Jordan\r'),
(126, 'JU', '-', '-', 'Juan de Nova Island\r'),
(127, 'KE', 'KE', '.ke', 'Kenya\r'),
(128, 'KG', 'KG', '.kg', 'Kyrgyzstan\r'),
(129, 'KN', 'KP', '.kp', 'Korea, North\r'),
(130, 'KR', 'KI', '.ki', 'Kiribati\r'),
(131, 'KS', 'KR', '.kr', 'Korea, South\r'),
(132, 'KT', 'CX', '.cx', 'Christmas Island\r'),
(133, 'KU', 'KW', '.kw', 'Kuwait\r'),
(134, 'KV', 'XK', '-', 'Kosovo\r'),
(135, 'KZ', 'KZ', '.kz', 'Kazakhstan\r'),
(136, 'LA', 'LA', '.la', 'Laos\r'),
(137, 'LE', 'LB', '.lb', 'Lebanon\r'),
(138, 'LG', 'LV', '.lv', 'Latvia\r'),
(139, 'LH', 'LT', '.lt', 'Lithuania\r'),
(140, 'LI', 'LR', '.lr', 'Liberia\r'),
(141, 'LO', 'SK', '.sk', 'Slovakia\r'),
(142, '-', 'UM', '.us', 'United States Minor Outlying Islands\r'),
(143, 'LS', 'LI', '.li', 'Liechtenstein\r'),
(144, 'LT', 'LS', '.ls', 'Lesotho\r'),
(145, 'LU', 'LU', '.lu', 'Luxembourg\r'),
(146, 'LY', 'LY', '.ly', 'Libya\r'),
(147, 'MA', 'MG', '.mg', 'Madagascar\r'),
(148, 'MB', 'MQ', '.mq', 'Martinique\r'),
(149, 'MC', 'MO', '.mo', 'Macau\r'),
(150, 'MD', 'MD', '.md', 'Moldova, Republic of\r'),
(151, 'MF', 'YT', '.yt', 'Mayotte\r'),
(152, 'MG', 'MN', '.mn', 'Mongolia\r'),
(153, 'MH', 'MS', '.ms', 'Montserrat\r'),
(154, 'MI', 'MW', '.mw', 'Malawi\r'),
(155, 'MJ', 'ME', '.me', 'Montenegro\r'),
(156, 'MK', 'MK', '.mk', 'The Former Yugoslav Republic of Macedonia\r'),
(157, 'ML', 'ML', '.ml', 'Mali\r'),
(158, 'MN', 'MC', '.mc', 'Monaco\r'),
(159, 'MO', 'MA', '.ma', 'Morocco\r'),
(160, 'MP', 'MU', '.mu', 'Mauritius\r'),
(161, 'MR', 'MR', '.mr', 'Mauritania\r'),
(162, 'MT', 'MT', '.mt', 'Malta\r'),
(163, 'MU', 'OM', '.om', 'Oman\r'),
(164, 'MV', 'MV', '.mv', 'Maldives\r'),
(165, 'MX', 'MX', '.mx', 'Mexico\r'),
(166, 'MY', 'MY', '.my', 'Malaysia\r'),
(167, 'MZ', 'MZ', '.mz', 'Mozambique\r'),
(168, 'NC', 'NC', '.nc', 'New Caledonia\r'),
(169, 'NE', 'NU', '.nu', 'Niue\r'),
(170, 'NF', 'NF', '.nf', 'Norfolk Island\r'),
(171, 'NG', 'NE', '.ne', 'Niger\r'),
(172, 'NH', 'VU', '.vu', 'Vanuatu\r'),
(173, 'NI', 'NG', '.ng', 'Nigeria\r'),
(174, 'NL', 'NL', '.nl', 'Netherlands\r'),
(175, 'NM', '', '', 'No Man\'s Land\r'),
(176, 'NO', 'NO', '.no', 'Norway\r'),
(177, 'NP', 'NP', '.np', 'Nepal\r'),
(178, 'NR', 'NR', '.nr', 'Nauru\r'),
(179, 'NS', 'SR', '.sr', 'Suriname\r'),
(180, '-', 'BQ', '.bq', 'Bonaire, Sint Eustatius and Saba\r'),
(181, 'NU', 'NI', '.ni', 'Nicaragua\r'),
(182, 'NZ', 'NZ', '.nz', 'New Zealand\r'),
(183, 'PA', 'PY', '.py', 'Paraguay\r'),
(184, 'PC', 'PN', '.pn', 'Pitcairn Islands\r'),
(185, 'PE', 'PE', '.pe', 'Peru\r'),
(186, 'PF', '-', '-', 'Paracel Islands\r'),
(187, 'PG', '-', '-', 'Spratly Islands\r'),
(188, 'PK', 'PK', '.pk', 'Pakistan\r'),
(189, 'PL', 'PL', '.pl', 'Poland\r'),
(190, 'PM', 'PA', '.pa', 'Panama\r'),
(191, 'PO', 'PT', '.pt', 'Portugal\r'),
(192, 'PP', 'PG', '.pg', 'Papua New Guinea\r'),
(193, 'PS', 'PW', '.pw', 'Palau\r'),
(194, 'PU', 'GW', '.gw', 'Guinea-Bissau\r'),
(195, 'QA', 'QA', '.qa', 'Qatar\r'),
(196, 'RE', 'RE', '.re', 'Reunion\r'),
(197, 'RI', 'RS', '.rs', 'Serbia\r'),
(198, 'RM', 'MH', '.mh', 'Marshall Islands\r'),
(199, 'RN', 'MF', '-', 'Saint Martin\r'),
(200, 'RO', 'RO', '.ro', 'Romania\r'),
(201, 'RP', 'PH', '.ph', 'Philippines\r'),
(202, 'RQ', 'PR', '.pr', 'Puerto Rico\r'),
(203, 'RS', 'RU', '.ru', 'Russia\r'),
(204, 'RW', 'RW', '.rw', 'Rwanda\r'),
(205, 'SA', 'SA', '.sa', 'Saudi Arabia\r'),
(206, 'SB', 'PM', '.pm', 'Saint Pierre and Miquelon\r'),
(207, 'SC', 'KN', '.kn', 'Saint Kitts and Nevis\r'),
(208, 'SE', 'SC', '.sc', 'Seychelles\r'),
(209, 'SF', 'ZA', '.za', 'South Africa\r'),
(210, 'SG', 'SN', '.sn', 'Senegal\r'),
(211, 'SH', 'SH', '.sh', 'Saint Helena\r'),
(212, 'SI', 'SI', '.si', 'Slovenia\r'),
(213, 'SL', 'SL', '.sl', 'Sierra Leone\r'),
(214, 'SM', 'SM', '.sm', 'San Marino\r'),
(215, 'SN', 'SG', '.sg', 'Singapore\r'),
(216, 'SO', 'SO', '.so', 'Somalia\r'),
(217, 'SP', 'ES', '.es', 'Spain\r'),
(218, '-', 'SS', '.ss', 'South Sudan\r'),
(219, 'ST', 'LC', '.lc', 'Saint Lucia\r'),
(220, 'SU', 'SD', '.sd', 'Sudan\r'),
(221, 'SV', 'SJ', '.sj', 'Svalbard\r'),
(222, 'SW', 'SE', '.se', 'Sweden\r'),
(223, 'SX', 'GS', '.gs', 'South Georgia and the Islands\r'),
(224, 'NN', 'SX', '.sx', 'Sint Maarten\r'),
(225, 'SY', 'SY', '.sy', 'Syrian Arab Republic\r'),
(226, 'SZ', 'CH', '.ch', 'Switzerland\r'),
(227, 'TD', 'TT', '.tt', 'Trinidad and Tobago\r'),
(228, 'TE', '-', '-', 'Tromelin Island\r'),
(229, 'TH', 'TH', '.th', 'Thailand\r'),
(230, 'TI', 'TJ', '.tj', 'Tajikistan\r'),
(231, 'TK', 'TC', '.tc', 'Turks and Caicos Islands\r'),
(232, 'TL', 'TK', '.tk', 'Tokelau\r'),
(233, 'TN', 'TO', '.to', 'Tonga\r'),
(234, 'TO', 'TG', '.tg', 'Togo\r'),
(235, 'TP', 'ST', '.st', 'Sao Tome and Principe\r'),
(236, 'TS', 'TN', '.tn', 'Tunisia\r'),
(237, 'TT', 'TL', '.tl', 'East Timor\r'),
(238, 'TU', 'TR', '.tr', 'Turkey\r'),
(239, 'TV', 'TV', '.tv', 'Tuvalu\r'),
(240, 'TW', 'TW', '.tw', 'Taiwan\r'),
(241, 'TX', 'TM', '.tm', 'Turkmenistan\r'),
(242, 'TZ', 'TZ', '.tz', 'Tanzania, United Republic of\r'),
(243, 'UC', 'CW', '.cw', 'Curacao\r'),
(244, 'UG', 'UG', '.ug', 'Uganda\r'),
(245, 'UK', 'GB', '.uk', 'United Kingdom\r'),
(246, 'UP', 'UA', '.ua', 'Ukraine\r'),
(247, 'US', 'US', '.us', 'United States\r'),
(248, 'UV', 'BF', '.bf', 'Burkina Faso\r'),
(249, 'UY', 'UY', '.uy', 'Uruguay\r'),
(250, 'UZ', 'UZ', '.uz', 'Uzbekistan\r'),
(251, 'VC', 'VC', '.vc', 'Saint Vincent and the Grenadines\r'),
(252, 'VE', 'VE', '.ve', 'Venezuela\r'),
(253, 'VI', 'VG', '.vg', 'British Virgin Islands\r'),
(254, 'VM', 'VN', '.vn', 'Vietnam\r'),
(255, 'VQ', 'VI', '.vi', 'Virgin Islands (US)\r'),
(256, 'VT', 'VA', '.va', 'Holy See (Vatican City)\r'),
(257, 'WA', 'NA', '.na', 'Namibia\r'),
(258, 'WE', 'PS', '.ps', 'Palestine, State of\r'),
(259, 'WF', 'WF', '.wf', 'Wallis and Futuna\r'),
(260, 'WI', 'EH', '.eh', 'Western Sahara\r'),
(261, 'WS', 'WS', '.ws', 'Samoa\r'),
(262, 'WZ', 'SZ', '.sz', 'Swaziland\r'),
(263, 'YI', 'CS', '.yu', 'Serbia and Montenegro\r'),
(264, 'YM', 'YE', '.ye', 'Yemen\r'),
(265, 'ZA', 'ZM', '.zm', 'Zambia\r'),
(266, 'ZI', 'ZW', '.zw', 'Zimbabwe\r');

-- --------------------------------------------------------

--
-- Table structure for table `promo_checks`
--

CREATE TABLE `promo_checks` (
  `id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_checked` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promo_checks`
--

INSERT INTO `promo_checks` (`id`, `promo_id`, `user_id`, `date_checked`) VALUES
(1, 2, 1, '2019-02-26 13:20:49'),
(2, 3, 1, '2019-02-26 22:32:25'),
(3, 4, 2, '2019-02-26 23:49:28'),
(4, 5, 4, '2019-02-27 08:36:51'),
(5, 14, 4, '2019-02-27 08:37:37'),
(6, 11, 4, '2019-02-27 08:40:37'),
(7, 9, 4, '2019-02-27 09:17:54'),
(8, 4, 4, '2019-02-27 09:18:06'),
(9, 12, 4, '2019-02-27 09:18:13'),
(10, 13, 4, '2019-02-27 11:00:07'),
(11, 7, 4, '2019-02-27 11:00:15'),
(12, 15, 1, '2019-02-28 10:50:01'),
(13, 1, 1, '2019-02-28 11:26:33'),
(14, 4, 1, '2019-02-28 11:36:06');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `audio_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `downloaded` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `date_purchased` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `profile_pix` text NOT NULL,
  `has_channel` int(11) NOT NULL DEFAULT '0',
  `activation_code` text NOT NULL,
  `activation_code_validity` text NOT NULL,
  `account_status` int(11) NOT NULL DEFAULT '1',
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `nationality` text,
  `wallet_amount` decimal(10,0) NOT NULL DEFAULT '0',
  `date_registered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_id`, `first_name`, `last_name`, `username`, `email`, `password`, `profile_pix`, `has_channel`, `activation_code`, `activation_code_validity`, `account_status`, `date_of_birth`, `gender`, `nationality`, `wallet_amount`, `date_registered`) VALUES
(1, 1, 'Damilare', 'Koiki', 'damilare_koiki', 'koikidamilare@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'assets/img/user_avatar.png', 0, '19395355725c5ed21065aba', '1549794459', 1, '1992-05-05', 'M', '173', '1', '2019-02-09 11:27:39'),
(2, 2, 'Adebayo', 'Ephraim', 'adebayoephraim@gmail', 'adebayoephraim@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'assets/img/user_avatar.png', 0, '733616325c75b18d2c489', '1551303437', 1, '1982-02-11', 'M', '173', '3', '2019-02-26 22:37:17'),
(3, 3, 'Tope', 'Akintola', 'topeakintola@gmail.c', 'topeakintola@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'assets/img/user_avatar.png', 0, '2560998685c75cfa4c37e3', '1551311140', 1, '1999-06-16', 'M', '247', '0', '2019-02-27 00:45:40'),
(4, 4, 'Adetunji', 'Godwin', 'adetunjigodwin@gmail', 'adetunjigodwin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'assets/img/user_avatar.png', 0, '7399342425c75ddc6368cd', '1551314758', 1, '2018-11-19', 'F', '245', '3', '2019-02-27 01:45:58');

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_info`
--

CREATE TABLE `user_payment_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_number` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_payment_info`
--

INSERT INTO `user_payment_info` (`id`, `user_id`, `account_number`) VALUES
(1, 1, '3097083378');

-- --------------------------------------------------------

--
-- Table structure for table `user_promos`
--

CREATE TABLE `user_promos` (
  `id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `audio_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_free` int(11) NOT NULL DEFAULT '0',
  `price` int(11) DEFAULT NULL,
  `enjoyed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advert`
--
ALTER TABLE `advert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audios_promotion`
--
ALTER TABLE `audios_promotion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio_category_available`
--
ALTER TABLE `audio_category_available`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio_category_views`
--
ALTER TABLE `audio_category_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio_cover_picture`
--
ALTER TABLE `audio_cover_picture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio_payment_mode`
--
ALTER TABLE `audio_payment_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio_preview_file`
--
ALTER TABLE `audio_preview_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio_production`
--
ALTER TABLE `audio_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio_rating`
--
ALTER TABLE `audio_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio_views`
--
ALTER TABLE `audio_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `channel`
--
ALTER TABLE `channel`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `channel_subscriptions`
--
ALTER TABLE `channel_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `channel_visits`
--
ALTER TABLE `channel_visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo_checks`
--
ALTER TABLE `promo_checks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`,`username`);

--
-- Indexes for table `user_payment_info`
--
ALTER TABLE `user_payment_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_promos`
--
ALTER TABLE `user_promos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `advert`
--
ALTER TABLE `advert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `audios_promotion`
--
ALTER TABLE `audios_promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `audio_category_available`
--
ALTER TABLE `audio_category_available`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `audio_category_views`
--
ALTER TABLE `audio_category_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `audio_cover_picture`
--
ALTER TABLE `audio_cover_picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `audio_payment_mode`
--
ALTER TABLE `audio_payment_mode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `audio_preview_file`
--
ALTER TABLE `audio_preview_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `audio_production`
--
ALTER TABLE `audio_production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `audio_rating`
--
ALTER TABLE `audio_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `audio_views`
--
ALTER TABLE `audio_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `channel`
--
ALTER TABLE `channel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `channel_subscriptions`
--
ALTER TABLE `channel_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `channel_visits`
--
ALTER TABLE `channel_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;
--
-- AUTO_INCREMENT for table `promo_checks`
--
ALTER TABLE `promo_checks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_payment_info`
--
ALTER TABLE `user_payment_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_promos`
--
ALTER TABLE `user_promos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
