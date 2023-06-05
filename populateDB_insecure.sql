-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 05, 2023 at 09:17 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatmessage`
--

CREATE TABLE `chatmessage` (
  `id` int(11) NOT NULL,
  `text` varchar(5000) NOT NULL,
  `date` datetime NOT NULL,
  `recieverUserID` int(11) NOT NULL,
  `senderUserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` float NOT NULL,
  `imgLink` varchar(250) NOT NULL,
  `creatorUserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `imgLink`, `creatorUserID`) VALUES
(1, 'race bikecycle', 250.5, 'https://images.unsplash.com/photo-1589556264800-08ae9e129a8c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80', 5),
(2, 'vintage table', 70, 'https://images.unsplash.com/photo-1577926103605-f426874bee28?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80', 6),
(3, 'macbook air M2', 1520, 'https://images.unsplash.com/photo-1514342959091-2bffd8a7c4ba?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80', 8),
(4, 'yellow-gray running shoes', 170, 'https://images.unsplash.com/photo-1610969770059-7084269fa3be?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80', 9),
(5, 'quietcomfort 45', 400, 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1165&q=80', 10),
(6, 'elastic bands', 8.5, 'https://images.unsplash.com/photo-1593714967758-8810365b6b69?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1172&q=80', 11),
(7, 'smart watch', 180, 'https://images.unsplash.com/photo-1544117519-31a4b719223d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1352&q=80', 12),
(8, 'repair kit', 30.5, 'https://images.unsplash.com/photo-1674503535026-a8f6ea1e3a30?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1287&q=80', 13),
(9, 'colorful notebooks', 5.5, 'https://images.unsplash.com/photo-1615502731978-f9d0c593d6c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80', 14),
(10, 'red scooter', 4000, 'https://images.unsplash.com/photo-1519750292352-c9fc17322ed7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1285&q=80', 10),
(11, 'desk', 220, 'https://images.unsplash.com/photo-1519219788971-8d9797e0928e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1444&q=80', 14),
(12, 'skin products', 56, 'https://images.unsplash.com/photo-1656147962576-613e7b936c31?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1285&q=80', 13),
(13, 'fresh bread', 1.5, 'https://images.unsplash.com/photo-1681766864796-f29d9bbad741?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1348&q=80', 12),
(14, 'hand art', 240, 'https://images.unsplash.com/photo-1681484357464-a9c81326c04b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1328&q=80', 11),
(15, 'soap container', 7.2, 'https://images.unsplash.com/photo-1614806686974-4d53169a47cd?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1287&q=80', 1),
(16, 'donuts', 10, 'https://images.unsplash.com/photo-1514517521153-1be72277b32f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1287&q=80', 1),
(17, 'love sign, ideal for couples', 6.2, 'https://images.unsplash.com/photo-1518414881329-0f96c8f2a924?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1189&q=80', 1),
(18, 'chocolate eggs for easter', 3.75, 'https://plus.unsplash.com/premium_photo-1676813808814-38617c86c419?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1335&q=80', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchasedby`
--

CREATE TABLE `purchasedby` (
  `id` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `buyDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `purchasedby`
--

INSERT INTO `purchasedby` (`id`, `productID`, `userID`, `buyDate`) VALUES
(1, 1, 1, '2023-04-25'),
(2, 2, 3, '2023-05-25'),
(3, 3, 5, '2023-06-25'),
(4, 4, 7, '2023-07-25'),
(5, 5, 9, '2023-08-25'),
(6, 6, 11, '2023-09-25'),
(7, 7, 13, '2023-10-25'),
(8, 8, 2, '2023-11-25'),
(9, 9, 4, '2023-12-25'),
(10, 10, 6, '2024-01-25'),
(11, 11, 8, '2024-02-25'),
(12, 12, 10, '2024-03-25'),
(13, 13, 12, '2024-04-25'),
(14, 14, 14, '2024-05-25'),
(15, 15, 1, '2024-06-25'),
(16, 16, 3, '2024-07-25'),
(17, 1, 5, '2024-08-25'),
(18, 2, 7, '2024-09-25'),
(19, 3, 9, '2024-10-25'),
(20, 4, 11, '2024-11-25'),
(21, 7, 12, '2025-01-05'),
(22, 4, 9, '2025-02-10'),
(23, 2, 3, '2025-03-15'),
(24, 10, 7, '2025-04-20'),
(25, 13, 11, '2025-05-25'),
(26, 16, 14, '2025-06-30'),
(27, 5, 8, '2025-07-05'),
(28, 3, 6, '2025-08-10'),
(29, 1, 1, '2025-09-15'),
(30, 12, 10, '2025-10-20'),
(31, 6, 5, '2025-11-25'),
(32, 8, 13, '2025-12-30'),
(33, 14, 2, '2026-01-05'),
(34, 15, 14, '2026-02-10'),
(35, 11, 4, '2026-03-15'),
(36, 9, 7, '2026-04-20'),
(37, 7, 12, '2026-05-25'),
(38, 4, 9, '2026-06-30'),
(39, 2, 3, '2026-07-05'),
(40, 10, 7, '2026-08-10');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `replyOfReviewID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(500) NOT NULL,
  `name` varchar(250) NOT NULL,
  `isVendor` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `isVendor`) VALUES
(1, 'carlo@gmail.com', 'psw_carlo', 'carlo', 0),
(2, 'alex@gmail.com', 'psw_alex', 'alex', 0),
(3, 'maria@gmail.com', 'psw_maria', 'maria', 0),
(4, 'giancarlo@gmail.com', 'psw_giancarlo', 'giancarlo', 0),
(5, 'filippo@gmail.com', 'psw_filippo', 'filippo', 1),
(6, 'irma@gmail.com', 'psw_irma', 'irma', 1),
(7, 'mariene@gmail.com', 'psw_mariene', 'mariene', 1),
(8, 'manuel@gmail.com', 'psw_manuel', 'manuel', 1),
(9, 'andrea@gmail.com', 'psw_andrea', 'andrea', 1),
(10, 'matilde@gmail.com', 'psw_matilde', 'matilde', 1),
(11, 'iacopo@gmail.com', 'psw_iacopo', 'iacopo', 1),
(12, 'goffredo@gmail.com', 'psw_goffredo', 'goffredo', 1),
(13, 'clio@gmail.com', 'psw_clio', 'clio', 1),
(14, 'adelaide@gmail.com', 'psw_adelaide', 'adelaide', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatmessage`
--
ALTER TABLE `chatmessage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchasedby`
--
ALTER TABLE `purchasedby`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatmessage`
--
ALTER TABLE `chatmessage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `purchasedby`
--
ALTER TABLE `purchasedby`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
