-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 30, 2014 at 09:50 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zf1_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `path`, `active`) VALUES
(1, '/img/banners/banner01.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Clothing'),
(2, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(124) NOT NULL,
  `rgb` varchar(8) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `code`, `rgb`, `sort`) VALUES
(1, 'Black', '', '', 0),
(2, 'White', '', '', 0),
(3, 'Blue', '', '', 0),
(4, 'Red', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dogo_dollars`
--

CREATE TABLE IF NOT EXISTS `dogo_dollars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_id` int(11) NOT NULL,
  `order` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `expires` date NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `dogo_dollars`
--

INSERT INTO `dogo_dollars` (`id`, `reg_id`, `order`, `amount`, `expires`, `created`, `updated`) VALUES
(1, 1, '25125', 100, '2014-07-30', '2014-05-15 00:00:00', '2014-05-16 07:48:04'),
(2, 1, '2615', 25, '2014-06-17', '2014-05-11 00:00:00', '2014-05-16 06:17:31'),
(3, 1, '789456', 15, '2014-07-17', '2014-05-16 04:09:49', '2014-05-16 06:16:27'),
(5, 6, '1234', 10, '2014-10-12', '2014-05-16 04:17:23', '0000-00-00 00:00:00'),
(7, 1, '123', 10, '2014-09-13', '2014-05-16 07:47:13', '0000-00-00 00:00:00'),
(8, 6, '32121', 50, '2014-09-30', '2014-05-16 08:25:26', '0000-00-00 00:00:00'),
(9, 1, '321321', 250, '2014-09-17', '2014-05-20 06:18:15', '0000-00-00 00:00:00'),
(10, 10, '3111', 120, '2014-09-25', '2014-05-28 08:43:57', '0000-00-00 00:00:00'),
(11, 8, '65464', 225, '2014-09-25', '2014-05-28 08:44:40', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `procolorsizes`
--

CREATE TABLE IF NOT EXISTS `procolorsizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `sub_id` varchar(255) NOT NULL,
  `r_price` double NOT NULL DEFAULT '0',
  `w_price` double NOT NULL DEFAULT '0',
  `o_price` double NOT NULL DEFAULT '0',
  `inventory` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `procolorsizes`
--

INSERT INTO `procolorsizes` (`id`, `p_id`, `c_id`, `s_id`, `sub_id`, `r_price`, `w_price`, `o_price`, `inventory`, `created`, `updated`) VALUES
(1, 1, 4, 2, 'aaaaaaa', 10, 11.55, 10, 10, '2014-05-23 00:00:00', '2014-05-28 07:00:01'),
(8, 2, 1, 1, '0', 1, 1, 1, 1, '2014-05-23 09:51:34', '2014-05-23 01:51:34'),
(10, 1, 1, 1, 'fffffffff', 11, 10, 10, 10, '2014-05-26 01:05:13', '2014-05-28 07:01:30'),
(11, 1, 4, 3, 'eeeeeee', 12, 12.5, 10, 10, '2014-05-26 03:09:35', '2014-05-29 07:31:24'),
(15, 1, 1, 1, 'dddddd', 1, 1, 1, 1, '2014-05-26 06:19:16', '2014-05-28 07:01:20'),
(16, 1, 3, 3, 'ccccccc', 21, 2, 10, 2, '2014-05-26 06:19:25', '2014-05-28 07:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `v_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `r_price` double NOT NULL,
  `w_price` double NOT NULL,
  `o_price` double NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `new` int(11) NOT NULL DEFAULT '0',
  `pre_order` int(11) NOT NULL DEFAULT '0',
  `on_sale` int(11) NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `v_id`, `name`, `description`, `r_price`, `w_price`, `o_price`, `active`, `new`, `pre_order`, `on_sale`, `updated`, `created`) VALUES
(1, '125b', 'Product One', '<p>this description was editted using ckeditor</p>\r\n', 2.2, 0.21, 0.2, 0, 1, 1, 1, '2014-05-21 03:24:08', '2014-05-21 06:26:37'),
(2, '321a', 'Product Two', 'Description of Product two', 12.5, 12.45, 12.3, 0, 0, 1, 1, '2014-05-20 19:30:02', '2014-05-21 03:30:02'),
(3, '213a', 'Product Three', '<p>This is the description of the third<strong> product</strong></p>\r\n', 125.55, 125.1, 120, 0, 1, 0, 1, '2014-05-20 20:12:29', '2014-05-21 04:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `pro_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  PRIMARY KEY (`pro_id`,`subcat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`pro_id`, `subcat_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 8),
(1, 9),
(1, 21),
(1, 25),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(4, 1),
(4, 2),
(4, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE IF NOT EXISTS `product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=151 ;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `p_id`, `c_id`, `name`, `sort`, `created`, `updated`) VALUES
(67, 2, 4, 'Desert.jpg', 0, '2014-05-27 09:45:40', '0000-00-00 00:00:00'),
(72, 2, 2, 'timthumb (3).png', 0, '2014-05-28 04:14:45', '0000-00-00 00:00:00'),
(146, 1, 4, '021240PK-1.jpg', 0, '2014-05-30 09:01:20', '2014-05-30 09:47:01'),
(149, 1, 0, '37010-1.jpg', 0, '2014-05-30 09:44:58', '0000-00-00 00:00:00'),
(150, 1, 0, '37020-1.jpg', 1, '2014-05-30 09:44:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE IF NOT EXISTS `register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(255) NOT NULL,
  `company_type` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(12) NOT NULL,
  `country` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `tax_id` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `spam` int(11) NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `company`, `company_type`, `first_name`, `last_name`, `title`, `address`, `city`, `state`, `zip`, `country`, `email`, `phone`, `fax`, `website`, `tax_id`, `status`, `spam`, `updated`, `created`) VALUES
(1, '1-distance', 'Design', 'Mac', 'Lin', 'Sfd', 'sdfsdf', 'Sdf', 'Sf', 'sdf', 'Sdf', 'mac@0-distance.com', 'sdf', 'sdf', 'sdf', 'dsf', 'disabled', 0, '2014-05-29 07:07:49', '2014-05-09 08:47:20'),
(6, 'Chimei Hospital', 'factory', 'Chin', 'Zin', 'Secretary', 'Tainan', 'Tin', 'sdf', 'sdf', 'sf', 'sdf@fsd.com', 'sdf', 'dfs', 'www.0-distance.com', 'sdf', 'active', 0, '2014-05-14 06:46:18', '0000-00-00 00:00:00'),
(8, 'nicaraodev', 'progra', 'Ronald', 'Garcia', 'programmer', 'tainan', 'Tainan', 'Yongkang', '12541', 'Taiwan', 'rgbetanco@hotmail.com', '06465512131', '313131', 'www.nicaraodev.com', '315441', 'active', 0, '2014-05-20 09:36:15', '0000-00-00 00:00:00'),
(10, 'Toyota', 'Manufacturer', 'Toyo', 'Ta', 'Bar tender', 'Japan', 'japan', 'japan', '234234', 'japan', 'toyota@hotmail.com', '3213', '321231', 'toyota@hotmail.com', '31321', 'disabled', 0, '2014-05-26 01:24:58', '2014-05-14 06:37:38'),
(11, 'zero distance', 'trading', 'Ronald ', 'Garcia', 'CEO', 'Tainan', 'Tainan', 'Tainan', '092585', 'Taiwan', 'rgbetanco@gmail.com', '0985807279', '0985807279', 'www.0-distance.com', '099989', 'disabled', 0, '2014-05-20 09:36:00', '2014-05-20 03:10:02'),
(13, 'Coca Cola', 'Beverage', 'Lin ', 'Sanity', 'Sales Person', 'United States', 'sdfsdf', 'sdfsf', '31112', 'United States', 'rgbetanco@gmail.com', '31212', '32131', 'www.domain.com', 'dsdfdsfd', 'disabled', 1, '2014-05-29 05:53:05', '2014-05-29 05:53:05'),
(15, 'nicafutbol', 'design', 'Nickolas', 'something', 'programmer', 'Nebraska', 'sdf', 'sdf', 'sf', 'sdf', 'nicolas@nicafutbol.com', '321231', '3132132', 'www.nicaraodev.com', '31545', 'disabled', 1, '2014-05-30 01:37:03', '2014-05-30 01:37:02'),
(16, 'dgdfg', 'dfgdg', 'fgdgf', 'khkjh', 'kh', 'kjh', 'kh', 'khj', 'kjh', 'kjh', 'kjh@lj.com', '321321', '32132123', 'www.0-distance.com', 'kh', 'disabled', 1, '2014-05-30 01:48:32', '2014-05-30 01:48:32'),
(17, 'ljxx', 'ljl', 'lkj', 'lkj', 'lkj', 'lkj', 'lkj', 'lkj', 'lkj', 'lj', 'sdf@ljk.com', '321', '321', 'www.0-distance.com', '31', 'disabled', 1, '2014-05-30 04:19:37', '2014-05-30 01:50:23'),
(19, 'lkjlkjssdf', 'lkjsdflkjsd', 'slfksdlfj', 'lkjsdflsdjf', 'sldfkjsdlfj', 'sldkfjslfj', 'sdlfksdf', 'sldkfjslkfj', 'slkjsf', 'slfjslfj', 'sdf@fsd.com', 'sdflk', 'sldkfj', 'www.0-distance.com', '321sdf', 'disabled', 1, '2014-05-30 02:03:27', '2014-05-30 02:03:27'),
(20, 'msdfhk', 'dfsdflkj', 'sdfjslfdj', 'sldfkjsdf', 'sldfjslfj', 'sdlfjsfj', 'sdfslfdj', 'sdlfjsdlfj', 'sldfjdsfj', 'sdlfjsdfj', 'zzzz@hotmail.com', 'sdlfkjlj', 'sldfkjslkjf', 'www.0-distance.com', 'sfdkjlj', 'disabled', 1, '2014-05-30 02:28:55', '2014-05-30 02:28:55'),
(21, 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdsdf', 'sdfsdf', 'wwww@hotmail.com', 'sdfsdf', 'sdfsf', 'www.0-distance.com', 'sfdsf', 'disabled', 1, '2014-05-30 02:34:00', '2014-05-30 02:34:00'),
(22, 'sdfsf', 'sdfsf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsf', 'sdfsf', 'sdfsdf', 'sdfsdf', 'sdfsdfs', 'xxx@hotmail.com', '231sdf', 'sdf31sdf', 'www.0-distance.com', '21sdf', 'disabled', 1, '2014-05-30 02:36:57', '2014-05-30 02:36:57');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addr`
--

CREATE TABLE IF NOT EXISTS `shipping_addr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `shipping_addr`
--

INSERT INTO `shipping_addr` (`id`, `reg_id`, `address`, `city`, `state`, `zip`, `country`, `created`, `updated`) VALUES
(4, 1, 'sdfsdfsfdsfsd', 'sdfsdfdsfsd', 'sdfsdfdsfsfd', '7777', 'sdfdsfdsf', '2014-05-15 00:00:00', '2014-05-15 05:35:06'),
(7, 1, 'new address', 'Tainan', 'Yongkang', '9999', 'Taiwan', '2014-05-15 06:58:24', '2014-05-15 06:58:24'),
(8, 1, 'next new address in tainan', 'Tainan', 'Yongkang', '0000', 'Taiwan', '2014-05-15 06:59:54', '2014-05-15 06:59:54'),
(9, 6, 'Contiguo donde fue el deposito de la tona', 'Tainan', 'Yongkang', '9999', 'Nicaragua', '2014-05-15 07:00:50', '2014-05-15 07:00:50');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE IF NOT EXISTS `sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `sort`) VALUES
(1, 'XL', 0),
(2, 'L', 0),
(3, 'M', 0),
(4, 'S', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE IF NOT EXISTS `subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `cat_id`, `name`, `sort`) VALUES
(1, 1, 'Tanks & Shirts', 1),
(2, 1, 'Winter Dresses', 2),
(3, 1, 'Dresses', 3),
(4, 1, 'Sweatshirt & Jumper', 4),
(5, 1, 'Raincoats', 5),
(6, 1, 'Winter Coats', 7),
(7, 1, 'Harness Vest', 8),
(8, 1, 'Special FUN Wear', 9),
(9, 1, 'Sweaters', 6),
(21, 2, 'Bowties & Flowers', 1),
(22, 2, 'EasyGO Harness', 2),
(23, 2, 'SuperGO Harness', 3),
(24, 2, 'ActiveGO Harness', 4),
(25, 2, 'PAWer Squeaky', 5),
(26, 2, 'iCool Collection', 6),
(27, 2, 'Travel Accessories', 7),
(28, 2, 'Carriers', 8),
(29, 2, 'Collar.Harness.Lead', 9),
(30, 2, 'Hats & Scarf', 10),
(33, 2, 'Beds', 11),
(34, 2, 'Rhinestones', 12),
(35, 2, 'Charms', 13),
(36, 2, 'Boots', 14);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `type`) VALUES
('jrgbetanco@htomai.com', '8130fd1ff9d782da9f53b91c38b00a05', 'guest'),
('kjh@lj.com', '10c7cdddd95f889540f22a49c996b65e', 'guest'),
('nicolas@nicafutbol.com', '693284b1e031dda8715ce457c2832461', 'guest'),
('rgbetanco', '04ae879f2be340afee5f5fd00adb724c', 'admin'),
('ronald', '04ae879f2be340afee5f5fd00adb724c', 'member'),
('sdf@fsd.com', '7ac2075f8bbe72a2333e38375fba544c', 'guest'),
('sdf@ljk.com', '9ad45792c6aa4c8bc94c24a1f0e079cc', 'guest'),
('wwww@hotmail.com', '86fed4c1206ff8070f8d3fd61c3c26f0', 'guest'),
('xxx@hotmail.com', '7c00b4a099bd13233cb4600292c358a3', 'member'),
('zzzz@hotmail.com', '34ccddd96cc04d55d30e6fa50aabf072', 'guest');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
