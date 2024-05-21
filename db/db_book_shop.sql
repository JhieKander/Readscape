-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 03:43 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_book_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addimage`
--

CREATE TABLE `tbl_addimage` (
  `bookcode` varchar(300) NOT NULL,
  `images` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `middle_name` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name_user_add` varchar(300) NOT NULL,
  `date_register` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `access` varchar(50) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `firstname`, `middle_name`, `lastname`, `email`, `password`, `name_user_add`, `date_register`, `status`, `access`) VALUES
(1, 'Joana Tovi', 'T.', 'Taduran', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 'owner', '0000-00-00 00:00:00.000000', 'active', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `encoded_by` varchar(200) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'view'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`, `date_add`, `encoded_by`, `status`) VALUES
(1, 'Fantasy', '2024-04-28 14:25:43', 'Joana Tovi Taduran ', 'view'),
(2, 'Science  Fiction', '2024-04-28 14:25:50', 'Joana Tovi Taduran ', 'view'),
(3, 'Romance', '2024-04-28 14:25:57', 'Joana Tovi Taduran ', 'view'),
(4, 'Action', '2024-04-28 14:26:04', 'Joana Tovi Taduran ', 'view');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_live_chat`
--

CREATE TABLE `tbl_live_chat` (
  `chat_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `message` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `transaction` varchar(300) NOT NULL,
  `item` varchar(200) NOT NULL,
  `qty` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `date_time_order` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `bookcode` varchar(255) NOT NULL,
  `book_name` varchar(250) NOT NULL,
  `book_author` varchar(200) NOT NULL,
  `year` varchar(200) NOT NULL,
  `story_summary` longtext NOT NULL,
  `categories` varchar(200) NOT NULL,
  `type_book` varchar(250) NOT NULL,
  `product_discription` longtext NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(300) NOT NULL,
  `added_by` varchar(250) NOT NULL,
  `update_by` varchar(250) DEFAULT NULL,
  `date_added` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `status` varchar(50) NOT NULL DEFAULT 'view'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `bookcode`, `book_name`, `book_author`, `year`, `story_summary`, `categories`, `type_book`, `product_discription`, `price`, `image`, `added_by`, `update_by`, `date_added`, `status`) VALUES
(1, 'TmfZMoyP', 'Barbie', '', '', '0', '1', 'trending', ' Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.                         ', 300, 'barbie.png', 'Joana Tovi Taduran ', NULL, '2024-05-03 11:27:29.265914', 'view'),
(2, '4kDNL3TG', 'Bardugo', '', '', '0', '1', 'trending', 'Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n     proident, sunt in culpa qui officia deserunt mollit anim id est laborum.                          ', 900, 'bardugo.png', 'Joana Tovi Taduran ', NULL, '2024-05-03 11:28:19.009350', 'view'),
(3, '0xdk3pSC', 'Tailor', '', '', '0', '1', 'trending', 'Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.                  ', 300, 'tailor.png', 'Joana Tovi Taduran ', NULL, '2024-05-03 11:28:52.972890', 'view'),
(4, 'oR8VPL70', 'Baghaman', '', '', '0', '1', 'NA', '  sdsajdasdjlsdjol                        ', 900, '0008565607-M.jpg', 'Joana Tovi Taduran ', NULL, '2024-05-03 11:40:29.904743', 'view'),
(5, 'I6J3Fgx0', 'season2', '', '', '0', '1', 'NA', 'sample decription', 900, 'parker.png', 'Joana Tovi Taduran ', NULL, '2024-05-03 11:41:33.147903', 'view');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_review`
--

CREATE TABLE `tbl_review` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `feedback` varchar(250) NOT NULL,
  `rate` varchar(200) NOT NULL,
  `date_review` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `birth_date` varchar(200) NOT NULL,
  `phone_number` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `address` longtext NOT NULL,
  `profile` varchar(300) NOT NULL,
  `password` varchar(250) NOT NULL,
  `date_time_register` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `status` varchar(50) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_live_chat`
--
ALTER TABLE `tbl_live_chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tbl_review`
--
ALTER TABLE `tbl_review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_live_chat`
--
ALTER TABLE `tbl_live_chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
