-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 mars 2025 à 19:39
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `new-food-order`
--

-- --------------------------------------------------------

--
-- Structure de la table `aamarpay`
--

CREATE TABLE `aamarpay` (
  `id` int(100) NOT NULL,
  `cus_name` text NOT NULL,
  `amount` int(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `pay_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `transaction_id` varchar(100) NOT NULL,
  `card_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `aamarpay`
--

INSERT INTO `aamarpay` (`id`, `cus_name`, `amount`, `status`, `pay_time`, `transaction_id`, `card_type`) VALUES
(3, 'Karim Molla', 600, 'Successful', '2022-01-25 06:29:16', 'ONL-PAY-R969U0935P', 'DBBL-MASTERDEBIT'),
(5, 'Hamza Hasan', 180, 'Successful', '2022-01-25 09:32:31', 'ONL-PAY-VLIBNZG666', 'DBBL-MobileBanking'),
(6, 'Montu Mia', 470, 'Successful', '2022-01-25 10:10:05', 'ONL-PAY-MTL9PG98XZ', 'DBBL-NEXUS'),
(7, 'Tarik Ali', 100, 'Successful', '2022-01-26 13:55:05', 'ONL-PAY-GC37DRKBNJ', 'DBBL-NEXUS'),
(8, 'Nazrul Islam', 470, 'Successful', '2021-05-05 15:21:03', 'ONL-PAY-20XSKIEKLF', 'DBBL-NEXUS'),
(9, 'Maheosy Haque', 170, 'Successful', '2022-01-27 06:47:59', 'ONL-PAY-QM7XFUQYHR', 'DBBL-NEXUS'),
(10, 'Maheosy Haque', 170, 'Successful', '2022-01-27 07:16:19', 'ONL-PAY-QM7XFUQYHR', 'DBBL-NEXUS'),
(11, 'Mohammad Wasikuzzaman', 270, 'Successful', '2022-01-27 07:17:01', 'ONL-PAY-COBQ6KWJSQ', 'DBBL-NEXUS'),
(12, 'my full name', 150, 'Successful', '2022-01-27 07:18:51', 'ONL-PAY-LJIBHV3TK8', 'DBBL-NEXUS'),
(14, 'my full name', 100, 'Successful', '2022-01-27 07:20:27', 'ONL-PAY-TFWV0J5REO', 'DBBL-NEXUS'),
(15, 'my full name', 130, 'Successful', '2022-01-27 01:24:44', 'ONL-PAY-GY1UBIG5RX', 'DBBL-NEXUS'),
(16, 'my full name', 270, 'Successful', '2020-12-16 07:29:40', 'ONL-PAY-FYCCSXTQHX', 'DBBL-NEXUS'),
(17, 'my full name', 150, 'Successful', '2022-01-27 07:32:11', 'ONL-PAY-DRV44CERAQ', 'DBBL-NEXUS'),
(18, 'my full name', 230, 'Successful', '2022-01-27 07:33:30', 'ONL-PAY-UXZ7UIZ402', 'DBBL-NEXUS'),
(19, 'This is a Test', 270, 'Successful', '2022-08-04 07:35:31', 'ONL-PAY-SSRRW2IYZE', 'DBBL-NEXUS'),
(20, 'my full name', 230, 'Successful', '2021-09-20 07:36:35', 'ONL-PAY-68N704WBI7', 'DBBL-NEXUS'),
(21, 'my full name', 280, 'Successful', '2021-07-16 07:38:12', 'ONL-PAY-PI6P46TMJS', 'DBBL-NEXUS'),
(22, 'my full name', 100, 'Successful', '2022-04-15 07:39:04', 'ONL-PAY-3M2UBMTZ01', 'DBBL-NEXUS'),
(23, 'Asad Ali', 1310, 'Successful', '2022-03-21 03:04:14', 'ONL-PAY-6V6RYWX24Z', 'DBBL-NEXUS'),
(24, 'Tamin Ahmed', 420, 'Successful', '2021-04-22 09:30:52', 'ONL-PAY-WVQRSZGWMW', 'DBBL-NEXUS'),
(25, 'my full name', 940, 'Successful', '2022-01-30 03:23:46', 'ONL-PAY-LDFBBO3TJW', 'DBBL-NEXUS'),
(26, 'Wasikuzzaman', 460, 'Successful', '2022-06-24 03:26:44', 'ONL-PAY-7UBFJLE87H', 'DBBL-NEXUS'),
(27, 'Eureka', 750, 'Successful', '2022-01-30 04:14:40', 'ONL-PAY-GWBLBMSVB8', 'DBBL-NEXUS'),
(28, 'Seems like This is working', 880, 'Successful', '2021-10-15 04:21:37', 'ONL-PAY-VHMONRPXA1', 'DBBL-NEXUS'),
(29, 'Maheosy Haque', 1080, 'Successful', '2021-11-06 12:51:10', 'ONL-PAY-C67X5PHHX4', 'DBBL-NEXUS'),
(30, 'Shoriful Islam', 300, 'Successful', '2022-02-01 15:03:50', 'ONL-PAY-OSKZYF7J42', 'bKash-bKash'),
(31, 'Farook Ahmed', 250, 'Successful', '2022-02-01 15:06:38', 'ONL-PAY-X3U8QMX9UG', 'DBBL-NEXUS'),
(32, 'my full name', 240, 'Successful', '2022-02-02 07:09:31', 'ONL-PAY-GDGUVQOCL3', 'bKash-bKash'),
(33, 'Monir Ali', 360, 'Successful', '2022-02-08 02:51:53', 'ONL-PAY-IRDBF59HGR', 'bKash-bKash'),
(34, 'Jalal Molla', 160, 'Successful', '2022-02-08 03:31:42', 'ONL-PAY-9U0IWYR96U', 'DBBL-NEXUS'),
(35, 'Kobita Begum', 110, 'Successful', '2022-02-08 04:25:22', 'ONL-PAY-FSSWV66LPV', 'DBBL-NEXUS'),
(36, 'Tashin', 590, 'Successful', '2022-02-08 04:43:46', 'ONL-PAY-KR8K8ZYVGM', 'DBBL-NEXUS'),
(37, 'Xasha Rahman', 450, 'Successful', '2022-02-08 04:45:48', 'ONL-PAY-Y7OP0RYLOB', 'DBBL-NEXUS'),
(38, 'Numna', 110, 'Successful', '2022-02-08 04:58:47', 'ONL-PAY-CF0ZZ553WD', 'DBBL-NEXUS'),
(39, 'Sultan', 300, 'Successful', '2022-02-08 05:02:26', 'ONL-PAY-EWEJN2ZP7P', 'DBBL-NEXUS'),
(40, 'Jamila Jameel', 120, 'Successful', '2022-02-08 05:33:03', 'ONL-PAY-C1HFESV819', 'DBBL-NEXUS'),
(41, 'Tom Hanks', 390, 'Successful', '2022-02-08 05:34:13', 'ONL-PAY-G7PB7WULEF', 'DBBL-NEXUS'),
(42, 'Sumona Akter', 540, 'Successful', '2022-02-08 05:38:05', 'ONL-PAY-H8GFL3LYB7', 'DBBL-NEXUS'),
(43, 'Sabir Ahmed', 200, 'Successful', '2022-02-08 05:40:34', 'ONL-PAY-3XF146V92Q', 'DBBL-NEXUS'),
(44, 'Jahangir Alom', 320, 'Successful', '2022-02-08 05:42:15', 'ONL-PAY-6EF97NAH6Y', 'DBBL-MASTERDEBIT'),
(45, 'Muhtasim Mubassir', 660, 'Successful', '2022-02-08 05:44:15', 'ONL-PAY-17FUFJJVGE', 'DBBL-NEXUS'),
(46, 'Shanto Islam', 480, 'Successful', '2022-02-08 05:51:03', 'ONL-PAY-W4VHG5CDC4', 'bKash-bKash'),
(47, 'Abir Ahmed', 200, 'Successful', '2022-02-08 05:55:07', 'ONL-PAY-RVDHMHT7Z8', 'DBBL-NEXUS'),
(48, 'Maheosy Haque', 1700, 'Successful', '2022-02-08 05:56:53', 'ONL-PAY-RA3OFS3JAG', 'DBBL-MASTERDEBIT'),
(49, 'Mohammad Wasikuzzaman', 660, 'Successful', '2022-02-08 05:59:08', 'ONL-PAY-V5AA6J9NHX', 'bKash-bKash'),
(50, 'Robin', 480, 'Successful', '2022-02-09 08:46:14', 'ONL-PAY-CUGZZYPKXL', 'DBBL-NEXUS'),
(51, 'Maheosy Haque', 300, 'Successful', '2022-02-09 15:46:28', 'ONL-PAY-03OZKBZ163', 'DBBL-NEXUS'),
(52, 'Jay ', 100, 'Successful', '2022-02-09 16:19:15', 'ONL-PAY-J1VSWT7Y36', 'DBBL-NEXUS'),
(53, 'Abdul ', 350, 'Successful', '2022-02-10 10:30:24', 'ONL-PAY-VU2GQSCWIE', 'DBBL-NEXUS'),
(54, 'Rahi', 100, 'Successful', '2022-02-10 10:32:44', 'ONL-PAY-GWG4PRVRS6', 'bKash-bKash'),
(55, 'Bashar', 320, 'Successful', '2022-02-10 10:34:16', 'ONL-PAY-DTYI65WPX7', 'DBBL-MobileBanking'),
(56, 'Kamal Khan', 300, 'Successful', '2022-02-10 10:40:19', 'ONL-PAY-9M8MHK5ROM', 'DBBL-MASTERDEBIT'),
(57, 'Mohammad Wasikuzzaman', 100, 'Successful', '2022-02-14 08:37:40', 'ONL-PAY-KI6TWT6P0S', 'DBBL-NEXUS'),
(58, 'Mohammad Wasikuzzaman', 380, 'Successful', '2022-02-14 08:40:16', 'ONL-PAY-6NW73HW7WR', 'bKash-bKash'),
(59, 'Mohammad Wasikuzzaman', 120, 'Successful', '2022-02-14 08:45:16', 'ONL-PAY-SK7IM5U84G', 'bKash-bKash'),
(60, 'Wasikuzzaman', 300, 'Successful', '2022-02-14 11:15:10', 'ONL-PAY-8E5L7NIWAE', 'DBBL-NEXUS'),
(61, 'Wasikuzzaman', 450, 'Successful', '2022-02-14 11:25:34', 'ONL-PAY-VPE49B581W', 'bKash-bKash');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `phone` int(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` longtext NOT NULL,
  `message_status` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `name`, `phone`, `subject`, `message`, `message_status`, `date`) VALUES
(22, 'durane', 693481655, 'info sur le restaurant', 'les génies sont rares ', 'read', '2025-03-13 01:02:51');

-- --------------------------------------------------------

--
-- Structure de la table `online_orders_new`
--

CREATE TABLE `online_orders_new` (
  `order_id` int(100) NOT NULL,
  `Item_Name` varchar(100) NOT NULL,
  `Price` int(100) NOT NULL,
  `Quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `online_orders_new`
--

INSERT INTO `online_orders_new` (`order_id`, `Item_Name`, `Price`, `Quantity`) VALUES
(36, 'French Fries', 80, 1),
(37, 'Beef Burger', 150, 1),
(38, 'Beef Burger', 150, 3),
(38, 'Pizza', 250, 1),
(39, 'French Fries', 80, 1),
(40, 'Beef Burger', 150, 4),
(41, 'Beef Burger', 150, 1),
(42, 'Margherita Pizza', 200, 1),
(42, 'Regular French Fries', 100, 2),
(43, 'Beef Burger', 150, 1),
(44, 'Beef Burger', 150, 1),
(45, 'Vegetarian Pizza', 180, 1),
(46, 'Mexican Pizza', 250, 1),
(47, 'Vegetarian Pizza', 180, 1),
(48, 'Beef Burger', 150, 1),
(1, 'Mexican Pizza', 250, 1),
(1, 'Buffalo Wings', 250, 1),
(1, 'Regular French Fries', 100, 2),
(2, 'Pepperoni Pizza', 220, 1),
(3, 'Mexican Pizza', 250, 1),
(3, 'Beef Burger', 150, 1),
(3, 'Regular French Fries', 100, 2),
(4, 'Vegetarian Pizza', 180, 1),
(5, 'Buffalo Wings', 250, 1),
(6, 'Buffalo Wings', 250, 1),
(7, 'Vegetarian Pizza', 180, 1),
(8, 'Beef Burger', 150, 1),
(9, 'Buffalo Wings', 250, 1),
(9, 'Pepperoni Pizza', 220, 1),
(10, 'Regular French Fries', 100, 1),
(11, 'Regular French Fries', 100, 1),
(12, 'Mexican Pizza', 250, 1),
(12, 'Pepperoni Pizza', 220, 1),
(13, 'Cheese Burger', 170, 1),
(14, 'Hone Glazed Chicken', 270, 1),
(15, 'Popcorn Chicken', 150, 1),
(16, 'Samoosa ', 100, 1),
(17, 'French Fries ', 130, 1),
(18, 'Pepperoni Pizza ', 270, 1),
(19, 'Popcorn Chicken', 150, 1),
(20, 'BBQ Wings', 230, 1),
(21, 'Hone Glazed Chicken', 270, 1),
(22, 'BBQ Wings', 230, 1),
(23, 'Mushroom Pizza', 280, 1),
(24, 'Samoosa ', 100, 1),
(25, 'Vegetarian Pizza', 300, 1),
(26, 'Crispy Wings', 250, 1),
(27, 'Hone Glazed Chicken', 270, 1),
(28, 'Cheese Pizza', 290, 1),
(29, 'Crispy Wings', 250, 2),
(29, 'Hone Glazed Chicken', 270, 2),
(29, 'Pepperoni Pizza ', 270, 1),
(30, 'Chicken Kiev Balls', 200, 1),
(30, 'Chicken Burger', 120, 1),
(30, 'Onion Rings', 100, 1),
(31, 'Deluxe Pizza ', 490, 1),
(31, 'Beef Burger', 150, 3),
(32, 'Beef Burger', 150, 2),
(32, 'Hamburger', 160, 1),
(33, 'Beef Burger', 150, 5),
(34, 'Red Hot', 120, 1),
(34, 'Beef Burger', 150, 4),
(34, 'Hamburger', 160, 1),
(35, 'Deluxe Pizza ', 490, 2),
(35, 'Shingara', 100, 1),
(36, 'Cheese Burger', 100, 1),
(36, 'Samoosa', 100, 2),
(37, 'Chicken Nuggets', 150, 1),
(37, 'Onion Rings', 100, 1),
(38, 'Deluxe Pizza ', 490, 1),
(39, 'Chicken Burger', 120, 2),
(40, 'French Fries', 120, 3),
(41, 'Hamburger', 160, 1),
(42, 'Hamburger', 160, 1),
(43, 'Hamburger', 160, 1),
(44, 'Hamburger', 160, 1),
(45, 'Hamburger', 160, 1),
(46, 'Hamburger', 160, 1),
(47, 'Hamburger', 160, 1),
(48, 'Hamburger', 160, 1),
(49, 'Hamburger', 160, 1),
(50, 'Cheese Dog', 110, 1),
(51, 'Cheese Dog', 110, 1),
(52, 'Cheese Dog', 110, 1),
(53, 'Cheese Dog', 110, 1),
(54, 'Cheese Dog', 110, 1),
(55, 'Cheese Dog', 110, 1),
(56, 'Cheese Dog', 110, 1),
(57, 'Cheese Dog', 110, 1),
(58, 'Cheese Dog', 110, 1),
(59, 'Cheese Dog', 110, 1),
(60, 'Cheese Dog', 110, 1),
(61, 'Deluxe Pizza ', 490, 1),
(61, 'Samoosa', 100, 1),
(62, 'Deluxe Pizza ', 490, 1),
(62, 'Samoosa', 100, 1),
(63, 'Deluxe Pizza ', 490, 1),
(63, 'Samoosa', 100, 1),
(64, 'Deluxe Pizza ', 490, 1),
(64, 'Samoosa', 100, 1),
(65, 'Deluxe Pizza ', 490, 1),
(65, 'Samoosa', 100, 1),
(66, 'Deluxe Pizza ', 490, 1),
(66, 'Samoosa', 100, 1),
(67, 'Supreme Pizza', 450, 1),
(68, 'Red Hot', 120, 1),
(69, 'Red Hot', 120, 1),
(70, 'Red Hot', 120, 1),
(71, 'Red Hot', 120, 1),
(72, 'Red Hot', 120, 1),
(73, 'Cheese Dog', 110, 1),
(74, 'Cheese Dog', 110, 1),
(75, 'Chicken Nuggets', 150, 2),
(76, 'Chicken Burger', 120, 1),
(77, 'Chicken Burger', 120, 2),
(77, 'Beef Burger', 150, 1),
(78, 'Chicken Burger', 120, 2),
(78, 'Beef Burger', 150, 2),
(79, 'Chicken Burger', 120, 2),
(79, 'Beef Burger', 150, 2),
(80, 'Chicken Kiev Balls', 200, 1),
(81, 'Chicken Kiev Balls', 200, 1),
(82, 'Hamburger', 160, 2),
(83, 'Chicken Burger', 120, 3),
(83, 'Beef Burger', 150, 2),
(84, 'Chicken Burger', 120, 4),
(85, 'Cheese Burger', 100, 2),
(86, 'Cheese Burger', 100, 3),
(86, 'Cheese Pizza', 350, 4),
(87, 'Chicken Burger', 120, 3),
(87, 'Beef Burger', 150, 2),
(88, 'French Fries', 120, 4),
(89, 'Vegetarian Pizza', 300, 1),
(90, 'Hot Onion Dog', 100, 1),
(91, 'Shingara', 100, 2),
(91, 'Chicken Nuggets', 150, 1),
(92, 'Onion Rings', 100, 1),
(93, 'Chili Hot Dog', 80, 4),
(94, 'Vegetarian Pizza', 300, 1),
(95, 'Cheese Burger', 100, 1),
(96, 'Vegetarian Pizza', 300, 1),
(96, 'Chili Hot Dog', 80, 1),
(97, 'Red Hot', 120, 1),
(98, 'Vegetarian Pizza', 300, 1),
(99, 'Supreme Pizza', 450, 1),
(100, 'Cheese Burger', 100, 1),
(100, 'Beef Burger', 150, 1),
(101, 'Supreme Pizza', 450, 1),
(102, 'Cheese Pizza', 350, 1),
(104, 'Samoosa', 100, 3),
(104, 'Chicken Burger', 120, 2),
(104, 'Popcorn Chicken', 250, 1),
(104, 'French Fries', 120, 1333),
(105, 'Cheese Burger', 100, 3),
(106, 'Cheese Burger', 100, 1),
(107, 'Beef Burger', 150, 1),
(108, 'Beef Burger', 150, 1),
(111, 'Beef Burger', 150, 1),
(113, 'Supreme Pizza', 450, 1),
(114, 'Cheese Dog', 110, 1),
(114, 'Cheese Burger', 100, 1),
(115, 'Supreme Pizza', 450, 1),
(116, 'French Fries', 120, 222),
(117, 'Cheese Dog', 110, 3),
(118, 'Beef Burger', 150, 1),
(119, 'Cheese Burger', 100, 1),
(120, 'Cheese Dog', 110, 1),
(121, 'Cheese Dog', 110, 1),
(122, 'Cheese Burger', 100, 1),
(123, 'Cheese Burger', 100, 1),
(124, 'Cheese Burger', 100, 1),
(125, 'Cheese Burger', 100, 1),
(126, 'Cheese Burger', 100, 1),
(126, 'Beef Burger', 150, 1),
(127, 'Cheese Burger', 100, 1),
(127, 'Beef Burger', 150, 1),
(128, 'Cheese Pizza', 350, 1),
(128, 'French Fries', 120, 1),
(128, 'Supreme Pizza', 450, 1);

-- --------------------------------------------------------

--
-- Structure de la table `order_manager`
--

CREATE TABLE `order_manager` (
  `order_id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `cus_name` text NOT NULL,
  `cus_email` varchar(100) NOT NULL,
  `cus_add1` varchar(100) NOT NULL,
  `cus_city` text NOT NULL,
  `cus_phone` bigint(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `order_date` datetime NOT NULL,
  `total_amount` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `order_status` varchar(100) NOT NULL,
  `payment_mode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `order_manager`
--

INSERT INTO `order_manager` (`order_id`, `username`, `cus_name`, `cus_email`, `cus_add1`, `cus_city`, `cus_phone`, `payment_status`, `order_date`, `total_amount`, `transaction_id`, `order_status`, `payment_mode`) VALUES
(127, 'alone', 'alone', 'dan@gmail.com', 'Malangur', 'Douala', 655555, '', '2025-03-12 19:29:36', 250, '', 'Pending', 'sur_place'),
(128, 'alone', 'alone', 'dan@gmail.com', 'Malangur', 'Douala', 655555, '', '2025-03-12 19:33:34', 920, '', 'Pending', 'carte');

-- --------------------------------------------------------

--
-- Structure de la table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `table_number` varchar(50) NOT NULL,
  `status` enum('Libre','Occupé') NOT NULL DEFAULT 'Libre',
  `client_name` varchar(100) DEFAULT NULL,
  `reservation_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tables`
--

INSERT INTO `tables` (`id`, `table_number`, `status`, `client_name`, `reservation_time`) VALUES
(1, '1', 'Libre', NULL, NULL),
(2, '2', 'Libre', NULL, NULL),
(3, 'T011', 'Libre', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrateur','Serveurs','Cuisiniers','Caissier') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`, `role`) VALUES
(41, 'alone', 'alone', 'c42bbd90740264d115048a82c9a10214', 'Administrateur'),
(42, 'aline', 'aline', '8d3152ebd103cea3509c7dcfad8f8c10', 'Caissier'),
(43, 'styve', 'styve', '7c7b671e3799c8d94a509daebf2e9620', 'Serveurs');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(41, 'Burger', 'Food_Category_81005.jpg', 'Yes', 'Yes'),
(42, 'Pizza', 'Food_Category_13196.jpg', 'Yes', 'Yes'),
(43, 'Hot Dogs', 'Food_Category_76472.jpg', 'Yes', 'Yes'),
(44, 'Sides', 'Food_Category_39435.jpg', 'Yes', 'Yes'),
(48, 'Bengali', 'Food_Category_94135.png', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_eipay`
--

CREATE TABLE `tbl_eipay` (
  `id` int(10) UNSIGNED NOT NULL,
  `table_id` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `tran_id` varchar(50) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_status` varchar(50) NOT NULL,
  `order_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `tbl_eipay`
--

INSERT INTO `tbl_eipay` (`id`, `table_id`, `amount`, `tran_id`, `order_date`, `payment_status`, `order_status`) VALUES
(415, 'Table 3', 763.00, 'EI-PAY-GKKQXXZ42C', '2022-02-09 09:36:18', 'Successful', 'Delivered'),
(416, 'Table 2', 460.00, 'EI-PAY-5SA6TNEO29', '2022-02-09 11:14:30', 'Successful', 'Delivered'),
(418, 'Table 4', 450.00, 'EI-PAY-65IYLWUW2S', '2022-02-09 13:11:26', 'Successful', 'Pending'),
(420, 'Table 4', 678.00, 'EI-PAY-245XLV2144', '2022-02-09 15:41:41', 'Successful', 'Delivered');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_food`
--

CREATE TABLE `tbl_food` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL,
  `stock` int(100) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `tbl_food`
--

INSERT INTO `tbl_food` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`, `stock`) VALUES
(34, 'Chicken Burger', 'Chicken Burger', 120.00, 'Food-Name-7394.jpg', 41, 'No', 'Yes', 70),
(35, 'Beef Burger', 'Beef Burger', 150.00, 'Food-Name-251.jpg', 41, 'No', 'Yes', 53),
(36, 'Cheese Burger', 'Cheese Burger', 100.00, 'Food-Name-1511.jpg', 41, 'No', 'Yes', 71),
(37, 'Hamburger', 'Hamburger', 160.00, 'Food-Name-8238.jpg', 41, 'Yes', 'Yes', 90),
(38, 'Supreme Pizza', 'Supreme Pizza', 450.00, 'Food-Name-3657.jpg', 42, 'Yes', 'Yes', 65),
(39, 'Deluxe Pizza ', 'Deluxe Pizza ', 490.00, 'Food-Name-4854.jpg', 42, 'No', 'Yes', 50),
(40, 'Cheese Pizza', 'Cheese Pizza', 350.00, 'Food-Name-926.jpg', 42, 'No', 'Yes', 58),
(41, 'Vegetarian Pizza', 'Vegetarian Pizza', 300.00, 'Food-Name-6428.jpg', 42, 'No', 'Yes', 86),
(42, 'Chili Hot Dog', 'Chili Hot Dog', 80.00, 'Food-Name-1499.jpg', 43, 'No', 'Yes', 145),
(43, 'Hot Onion Dog', 'Hot Onion Dog', 100.00, 'Food-Name-5049.jpg', 43, 'No', 'Yes', 159),
(44, 'Cheese Dog', 'Cheese Dog', 110.00, 'Food-Name-3512.jpg', 43, 'Yes', 'Yes', 54),
(45, 'Red Hot', 'Red Hot\r\n', 120.00, 'Food-Name-5500.jpg', 43, 'No', 'Yes', 139),
(46, 'Popcorn Chicken', 'Popcorn Chicken', 250.00, 'Food-Name-9143.jpg', 44, 'No', 'Yes', 499),
(47, 'Samoosa', 'Samoosa', 100.00, 'Food-Name-1669.jpg', 44, 'No', 'Yes', 297),
(48, 'Shingara', 'Shingara', 100.00, 'Food-Name-937.jpg', 44, 'Yes', 'Yes', 596),
(49, 'Spring Roll', 'Spring Roll', 130.00, 'Food-Name-5356.jpg', 44, 'Yes', 'Yes', 78),
(50, 'Chicken Nuggets', 'Chicken Nuggets', 150.00, 'Food-Name-5725.jpg', 44, 'No', 'Yes', 595),
(51, 'Chicken Kiev Balls', 'Chicken Kiev Balls', 200.00, 'Food-Name-5497.jpg', 44, 'Yes', 'Yes', 40),
(52, 'French Fries', 'French Fries', 120.00, 'Food-Name-2893.jpg', 44, 'Yes', 'Yes', 371),
(53, 'Onion Rings', 'Onion Rings', 100.00, 'Food-Name-8745.jpg', 44, 'Yes', 'Yes', 597);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(150) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_contact` varchar(20) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `customer_address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `transaction_id`, `total`, `order_date`, `status`, `customer_name`, `customer_contact`, `customer_email`, `customer_address`) VALUES
(1, 'Pepperoni Pizza', 220.00, '2022-01-16 06:47:44', 'Ordered', 'my full name', 'country name', 'me@mydomain.com', ''),
(2, 'Pepperoni Pizza', 220.00, '2022-01-16 06:50:46', 'Delivered', 'my full name', 'country name', 'me@mydomain.com', ''),
(3, 'Beef Burger', 150.00, '2022-01-16 08:09:49', 'Cancelled', 'my full name', 'country name', 'me@mydomain.com', ''),
(4, 'Mexican Pizza', 750.00, '2022-01-16 08:10:16', 'Ordered', 'my full name', 'country name', 'me@mydomain.com', ''),
(5, 'Buffalo Wings', 250.00, '2022-01-16 08:35:55', 'On Delivery', 'Maheosy Haque', '01717731002', 'me@mydomain.com', ''),
(6, 'Pepperoni Pizza', 220.00, '2022-01-17 07:10:28', 'Ordered', 'my full name', 'country name', 'me@mydomain.com', ''),
(7, 'Buffalo Wings', 250.00, '2022-01-17 07:11:00', 'Ordered', 'my full name', 'country name', 'me@mydomain.com', ''),
(8, 'Mexican Pizza', 250.00, '2022-01-17 07:11:56', 'Ordered', 'my full name', 'country name', 'me@mydomain.com', ''),
(9, '', 200.00, '2022-01-21 21:29:42', 'Successful', 'Maheosy Haque', '01717731002', 'maheosy.sristy@gmail.com', ''),
(10, '', 220.00, '2022-01-21 21:31:46', 'Successful', 'Maheosy Haque', '01717731002', 'me@mydomain.com', ''),
(11, '', 250.00, '2022-01-21 21:32:43', 'Successful', 'Maheosy Haque', '01717731002', 'maheosy.sristy@gmail.com', ''),
(12, 'HF141T', 220.00, '2022-01-21 21:38:46', 'Successful', 'Forest Gump', '01717731002', 'forest@gmail.com', ''),
(13, 'IVVOP1', 250.00, '2022-01-21 21:40:30', 'Successful', 'Maheosy Haque', '9', 'me@mydomain.com', ''),
(14, 'ROBO-CAFEMP5J31', 250.00, '2022-01-21 21:42:27', 'Successful', 'Maheosy Haque', '23', 'maheosy.sristy@gmail.com', ''),
(15, 'ROBO-CAFE-K0WPJ8', 150.00, '2022-01-21 21:49:59', 'Successful', 'Maheosy Haque', '2', 'maheosy.sristy@gmail.com', ''),
(16, 'ROBO-CAFE-7XS507', 680.00, '2022-01-21 23:18:36', 'Successful', 'Maheosy Haque', '01717732432', 'maheosy.sristy@gmail.com', ''),
(17, 'ROBO-CAFE-0GI4JT', 180.00, '2022-01-21 23:21:39', 'Successful', 'Maheosy Haque', '45345345', 'maheosy.sristy@gmail.com', ''),
(18, '', 0.00, '2022-01-22 02:05:57', '', '', '', '', ''),
(19, '', 0.00, '2022-01-22 02:14:44', '', '', '', '', ''),
(20, '', 0.00, '2022-01-22 02:15:44', '', '', '', '', ''),
(21, '', 0.00, '2022-01-22 02:17:10', '', '', '', '', 'Array'),
(22, 'Array', 0.00, '2022-01-22 02:18:24', '', '', '', '', 'cus_add1'),
(23, 'Array', 0.00, '2022-01-22 02:22:21', '', '', '', '', ''),
(24, 'Array', 0.00, '2022-01-22 02:23:30', '', '', '', '', ''),
(25, 'ROBO-CAFE-MML336', 250.00, '2022-01-22 02:27:11', '', 'my full name', '34534', 'me@mydomain.com', '01'),
(26, 'ROBO-CAFE-MML336', 250.00, '2022-01-22 02:28:40', '', 'my full name', '34534', 'me@mydomain.com', '01'),
(27, 'ROBO-CAFE-A1DFRQ', 250.00, '2022-01-22 02:29:22', '', 'my full name', '45', 'me@mydomain.com', '01'),
(28, 'ROBO-CAFE-S4B37V', 250.00, '2022-01-22 02:30:25', '', 'my full name', '45', 'me@mydomain.com', '01'),
(29, 'ROBO-CAFE-F7Y4XU', 250.00, '2022-01-22 02:31:15', '', 'my full name', '56', 'me@mydomain.com', '01'),
(30, 'ROBO-CAFE-F7Y4XU', 250.00, '2022-01-22 02:32:19', '', 'my full name', '56', 'me@mydomain.com', '01'),
(31, 'ROBO-CAFE-PQZ46L', 250.00, '2022-01-22 02:32:26', '', 'my full name', '4', 'me@mydomain.com', '01'),
(32, 'ROBO-CAFE-9F5EG7', 250.00, '2022-01-22 02:57:56', '', 'my full name', '345', 'me@mydomain.com', '01'),
(33, 'ROBO-CAFE-9F5EG7', 250.00, '2022-01-22 02:57:59', '', 'my full name', '345', 'me@mydomain.com', '01'),
(34, 'ROBO-CAFE-3N4U4N', 250.00, '2022-01-22 02:58:04', '', 'my full name', '234', 'me@mydomain.com', '01'),
(35, 'ROBO-CAFE-3N4U4N', 250.00, '2022-01-22 02:58:52', '', 'my full name', '234', 'me@mydomain.com', '01'),
(36, 'ROBO-CAFE-51G6DI', 100.00, '2022-01-22 05:52:14', '', 'Mohammad Wasikuzzaman', '01717731002', 'wasik@gmail.com', 'Banani, Dhaka'),
(37, 'ROBO-CAFE-CJAJIH', 250.00, '2022-01-22 05:54:56', '', 'my full name', '4', 'me@mydomain.com', '01'),
(38, 'ROBO-CAFE-MH9P87', 150.00, '2022-01-22 17:56:12', 'Successful', 'my full name', '8', 'me@mydomain.com', '');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_reservations`
--

CREATE TABLE `tbl_reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `nomcl` varchar(400) NOT NULL,
  `telcl` varchar(500) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `number_of_people` int(11) NOT NULL,
  `status` enum('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_reservations`
--

INSERT INTO `tbl_reservations` (`id`, `user_id`, `table_id`, `nomcl`, `telcl`, `reservation_date`, `reservation_time`, `number_of_people`, `status`) VALUES
(31, 1, 8, 'nahomie', '694231655', '2025-03-12', '21:15:00', 1, 'pending'),
(32, 1, 7, 'darline', '694261155', '2025-03-12', '19:30:00', 1, 'pending'),
(33, 1, 13, 'durane', '693481655', '2025-03-13', '19:30:00', 5, 'pending');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_tables`
--

CREATE TABLE `tbl_tables` (
  `id` int(11) NOT NULL,
  `table_number` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `status` enum('available','reserved','occupied') NOT NULL DEFAULT 'available',
  `latitude` float NOT NULL DEFAULT 0,
  `longitude` float NOT NULL DEFAULT 0,
  `seats_taken` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_tables`
--

INSERT INTO `tbl_tables` (`id`, `table_number`, `capacity`, `status`, `latitude`, `longitude`, `seats_taken`) VALUES
(2, 'T002', 2, 'reserved', 3.8481, 11.5022, 1),
(3, 'T003', 6, 'occupied', 3.8482, 11.5023, 6),
(4, 'T004', 4, 'reserved', 3.8483, 11.5024, 0),
(5, 'T005', 8, 'reserved', 3.8484, 11.5025, 6),
(6, 'T006', 2, 'reserved', 3.8485, 11.5026, 2),
(7, 'T007', 10, 'available', 3.8486, 11.5027, 3),
(8, 'T008', 6, 'available', 3.8487, 11.5028, 4),
(9, 'T009', 4, 'available', 3.8488, 11.5029, 2),
(10, 'T010', 2, 'reserved', 3.8489, 11.503, 2),
(12, 'T011', 20, 'available', 0, 0, 0),
(13, 'T012', 20, 'available', 0, 0, 5);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `add1` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phone` bigint(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `email`, `add1`, `city`, `phone`, `username`, `password`) VALUES
(1, 'Wasikuzzaman', 'wasik0003@gmail.com', 'Bhaluka Municipality, Bhaluka, Mymensingh.', 'Mymensingh', 1717731002, 'wasik0003', 'e0f7a4d0ef9b84b83b693bbf3feb8e6e'),
(8, 'alone', 'dan@gmail.com', 'Malangur', 'Douala', 655555, 'alone', 'c42bbd90740264d115048a82c9a10214');

-- --------------------------------------------------------

--
-- Structure de la table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `avatar` varchar(255) DEFAULT 'default-avatar.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `aamarpay`
--
ALTER TABLE `aamarpay`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order_manager`
--
ALTER TABLE `order_manager`
  ADD PRIMARY KEY (`order_id`);

--
-- Index pour la table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_eipay`
--
ALTER TABLE `tbl_eipay`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `table_id` (`table_id`);

--
-- Index pour la table `tbl_tables`
--
ALTER TABLE `tbl_tables`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `aamarpay`
--
ALTER TABLE `aamarpay`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `order_manager`
--
ALTER TABLE `order_manager`
  MODIFY `order_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT pour la table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `tbl_eipay`
--
ALTER TABLE `tbl_eipay`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;

--
-- AUTO_INCREMENT pour la table `tbl_food`
--
ALTER TABLE `tbl_food`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `tbl_tables`
--
ALTER TABLE `tbl_tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  ADD CONSTRAINT `tbl_reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`),
  ADD CONSTRAINT `tbl_reservations_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `tbl_tables` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
