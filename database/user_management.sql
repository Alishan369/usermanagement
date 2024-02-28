-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2024 at 04:34 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `number` varchar(100) NOT NULL,
  `rand_id` varchar(100) NOT NULL,
  `is_forgot_password` int(11) NOT NULL DEFAULT 0,
  `is_verify` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `role` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `number`, `rand_id`, `is_forgot_password`, `is_verify`, `status`, `role`, `created_at`, `updated_at`) VALUES
(1, 'alishan', 'alishanshaikh81@gmail.com', 'eyJpdiI6IjVEWi80Tnd3L2xwd01LK01XRCtPc0E9PSIsInZhbHVlIjoiWE9RSG43aDZuSkpsWndiR28ydkpCQT09IiwibWFjIjoiYTliODhlOTE1OTIxOGFjYjAxMzBmYTZiM2I1YzFjMTQ3NTI0YmI0ZjI4YjUxODk3NGY0NGM5ZTEwMjQ1YjlmZiIsInRhZyI6IiJ9', '932433095', '', 0, 1, 1, 1, '2024-02-27 00:15:33', '2024-02-27 20:52:38'),
(12, 'alishan', 'alishansk77@gmail.com', 'eyJpdiI6IjVEWi80Tnd3L2xwd01LK01XRCtPc0E9PSIsInZhbHVlIjoiWE9RSG43aDZuSkpsWndiR28ydkpCQT09IiwibWFjIjoiYTliODhlOTE1OTIxOGFjYjAxMzBmYTZiM2I1YzFjMTQ3NTI0YmI0ZjI4YjUxODk3NGY0NGM5ZTEwMjQ1YjlmZiIsInRhZyI6IiJ9', '9324330956', '', 0, 0, 1, 0, '2024-02-28 01:55:13', '2024-02-27 21:20:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
