-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 19 يونيو 2025 الساعة 16:06
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meroy`
--

-- --------------------------------------------------------

--
-- بنية الجدول `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `key_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `accounts`
--

INSERT INTO `accounts` (`id`, `key_id`, `email`, `pass`, `created_at`) VALUES
(31, 192, 'asdfga@gmail.com', 'asdasfsdafsd', '2025-06-19 12:39:44'),
(32, 195, 'asdfga@gmail.com', 'asdasfsdafsd', '2025-06-19 12:48:46');

-- --------------------------------------------------------

--
-- بنية الجدول `license_keys`
--

CREATE TABLE `license_keys` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `used` tinyint(1) NOT NULL,
  `activated_at` datetime DEFAULT NULL,
  `duration_days` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `store_slug` varchar(80) DEFAULT NULL,
  `folder_path` varchar(255) DEFAULT NULL,
  `imap_email` varchar(255) DEFAULT NULL,
  `imap_pass_enc` text DEFAULT NULL,
  `expires_in_days` int(11) DEFAULT 30,
  `key_type` varchar(50) DEFAULT NULL,
  `service_type` varchar(50) DEFAULT NULL,
  `gpt_email` varchar(255) DEFAULT NULL,
  `gpt_pass_enc` text DEFAULT NULL,
  `accounts` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `license_keys`
--

INSERT INTO `license_keys` (`id`, `key`, `used`, `activated_at`, `duration_days`, `store_id`, `store_slug`, `folder_path`, `imap_email`, `imap_pass_enc`, `expires_in_days`, `key_type`, `service_type`, `gpt_email`, `gpt_pass_enc`, `accounts`) VALUES
(21, '1c4c01912a2c7742', 1, '2025-06-13 10:20:50', 500, NULL, NULL, NULL, NULL, NULL, 30, 'single', 'steam', NULL, NULL, 1),
(114, 'b631410178d2a812', 1, '2024-06-13 10:19:28', 1, NULL, '234sd', 'users/234sd', NULL, 'JuRm81UO6+VgRMJK0NEOvw==', 30, 'single', 'gpt', 'vv1245vvvvvvvvv23v@gmail.com', 'vvvvvvvv', 0),
(177, 'e0539b9e5bdc3940', 0, NULL, 30, NULL, NULL, NULL, NULL, NULL, 30, 'single', 'all', NULL, NULL, 1),
(178, '2cee0af0596b66c3', 0, NULL, 30, NULL, NULL, NULL, NULL, NULL, 30, 'single', 'all', NULL, NULL, 1),
(179, '6831d400300ffad7', 1, '2025-06-14 20:17:39', 30, NULL, NULL, NULL, NULL, NULL, 30, 'single', 'all', NULL, NULL, 0),
(185, '4f153f25d9fff1b0', 1, '2025-06-02 15:23:22', 30, NULL, NULL, NULL, NULL, NULL, 30, 'single', 'steam', NULL, NULL, 2),
(186, 'c72e0dd589354818', 1, '2025-06-15 15:30:22', 30, NULL, NULL, NULL, NULL, NULL, 30, 'single', 'steam', NULL, NULL, 1),
(187, '95ddb45d95cd52e0', 1, '2025-06-15 16:04:55', 30, NULL, NULL, NULL, NULL, NULL, 30, 'single', 'steam', NULL, NULL, 0),
(188, '2ddade721df2d131', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 30, NULL, NULL, NULL, NULL, 2),
(189, '2b337ea53508b07d', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 30, NULL, 'add', NULL, NULL, 0),
(190, '873d16eac9fe313b', 1, '2025-06-15 22:39:04', 30, NULL, NULL, NULL, NULL, NULL, 30, 'single', 'steam', NULL, NULL, 1),
(191, '6141cac47329b8bf', 1, '2025-06-19 14:21:48', 30, NULL, NULL, NULL, NULL, NULL, 30, 'single', 'gpt', NULL, NULL, 0),
(192, 'f3480c07a5df75c8', 1, '2025-06-19 14:26:26', NULL, NULL, NULL, NULL, NULL, NULL, 30, NULL, 'add', NULL, NULL, 2),
(193, '7cd2408231f0ee24', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 30, NULL, 'add', NULL, NULL, 1),
(194, 'a9076ad2d18a6373', 1, '2025-06-19 15:00:54', NULL, NULL, NULL, NULL, NULL, NULL, 30, NULL, 'add', NULL, NULL, 1),
(195, 'ce5b2d8fcff1456f', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 30, NULL, 'add', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `imap_email` varchar(255) DEFAULT NULL,
  `imap_pass_enc` text NOT NULL,
  `license_key_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gpt_email` varchar(255) DEFAULT '',
  `gpt_pass_enc` varchar(255) DEFAULT '',
  `osn_email` varchar(255) DEFAULT '',
  `osn_pass_enc` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `key_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `user`, `pass`, `created_at`, `is_admin`, `key_id`) VALUES
(1, 'dito', 'Aaqq112233', '2025-06-10 05:07:15', 1, 21),
(21, '', '', '2025-06-15 17:04:55', 0, 187),
(22, '', '', '2025-06-19 15:21:48', 0, 191),
(23, '', '', '2025-06-19 15:26:26', 0, 192),
(24, '', '', '2025-06-19 16:00:54', 0, 194);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`key_id`);

--
-- Indexes for table `license_keys`
--
ALTER TABLE `license_keys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_store_id` (`store_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `license_key_id` (`license_key_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key` (`key_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `license_keys`
--
ALTER TABLE `license_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`key_id`) REFERENCES `license_keys` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`license_key_id`) REFERENCES `license_keys` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- قيود الجداول `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `key` FOREIGN KEY (`key_id`) REFERENCES `license_keys` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
