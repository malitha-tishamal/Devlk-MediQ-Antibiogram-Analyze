-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql113.infinityfree.com
-- Generation Time: Jun 27, 2025 at 09:10 AM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38329700_mediq`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','approved','disabled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT 'default.jpg',
  `last_login` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `nic`, `name`, `email`, `mobile`, `password`, `status`, `created_at`, `profile_picture`, `last_login`) VALUES
(1, '200202202615', 'Malitha Tishamal', 'malithatishamal@gmail.com', '785530992', '$2y$10$e3yU/.35yCf9ZbkWhUHm8u9IkKvyaO3ZuO/0K2ALLHa/JRWR.5asm', 'approved', '2025-02-10 12:21:20', '67d9756470279-411001152_1557287805017611_3900716309730349802_n.jpg', '2025-06-27 17:01:52'),
(2, '200202226777', 'admin user', 'admin@gmail.com', '710000000', '$2y$10$FWwvXaoYAFTWI0hrO0RpAOV6eN3qN0PX2nGQy9h/qCsDwNiDutcgm', 'disabled', '2025-02-15 22:38:05', 'default.jpg', '2025-06-16 06:17:56'),
(3, '200378711255', 'Nishara De Silva', 'admin.nishara@gmail.com', '743397871', '$2y$10$.RD5PosaRSPVVV4nBkBhXeG851xTeWJtjbuaWTzqvviirwntaZlDm', 'approved', '2025-05-28 15:30:20', '684d16807083d-WhatsApp Image 2025-06-10 at 13.00.54_a5511895.jpg', '2025-06-18 18:59:09'),
(4, '200315813452', 'Malith Sandeepa', 'admin.sandeepa@gmail.com', '763279285', '$2y$10$LOTgvaN3G4b10pJnp0Bf/u2s8dnNWTK3rGJwPYmSxDOtOJT36vxNC', 'approved', '2025-05-31 13:47:49', '684c0f6c943c6-1.jpg', '2025-06-27 14:36:51'),
(5, '200354711748', 'Ewni Akithma', 'admin.ewniakithma@gmail.com', '772072026', '$2y$10$4y8XH41IWFXC9CBsZv0fCOUvv0boc6o.9Ejsd8GT32r4jfE/5k65u', 'approved', '2025-06-14 03:12:12', '684ec318d719e-pic1.jpg', '2025-06-16 06:29:11'),
(6, '200334400893', 'Tharindu Sampath', 'admin.vgtharindu165@gmail.com', '772010733', '$2y$10$BiZNGEtQwFJRuottJwTG1eao6kb1zbGaLO5YGrxBpmXu5G3dZVqou', 'approved', '2025-06-14 07:33:21', '684d263313a40-IMG-20231121-WA0160.jpg', '2025-06-14 13:04:39'),
(14, '200370912329', 'Amandi Kaushalya', 'admin.kaushalya@gmail.com', '788167038', '$2y$10$shwt5S.ZLyz3l8VJd/XxOuzdxiQL.msKjTJSjm5.C/hc7vFNBk7dG', 'approved', '2025-06-15 12:39:47', '684ec063afdd7-6849af19d3bb4-67d53d2856fc3-amandi.jpg', '2025-06-25 20:19:44'),
(15, '199952310740', 'Harshani', 'harshanimadushika40@gmail.com', '740629049', '$2y$10$gcJSgtUfz/.RG1g1LWl3xO7RyhtWA9W4OaOPeXnlfmo2DloCoqNbq', 'approved', '2025-06-15 13:02:20', 'default.jpg', '2025-06-15 18:35:25'),
(16, '200374300868', 'Matheesha Nihari', 'admin.matheenihari13@gmail.com', '775751107', '$2y$10$KmdOzCTdvX/tkmkC0X2rtOPx.Hu7iYLfmmAy4fViU5OfYLZ2GbCEq', 'disabled', '2025-06-21 03:48:07', 'default.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `antibiotics`
--

CREATE TABLE `antibiotics` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `antibiotics`
--

INSERT INTO `antibiotics` (`id`, `name`, `category`) VALUES
(1, 'Amikacin', 'Watch'),
(2, 'Amoxicillin', 'Access'),
(3, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', 'Access'),
(4, 'Ampicillin', 'Access'),
(6, 'Benzathine penicillin', 'Access'),
(7, 'Benzylpenicillin', 'Access'),
(8, 'Cefalexin', 'Access'),
(9, 'Cefepime', 'Reserve'),
(11, 'Cefotaxime', 'Watch'),
(12, 'Ceftazidime', 'Watch'),
(13, 'Ceftriaxone', 'Watch'),
(22, 'Flucloxacillin', 'Access'),
(23, 'Gentamicin', 'Access'),
(24, 'Imipenem/cilastatin', 'Watch'),
(25, 'Levofloxacin', 'Reserve'),
(26, 'Linezolid', 'Reserve'),
(27, 'Meropenem', 'Watch'),
(28, 'Metronidazole', 'Access'),
(29, 'Nitrofurantoin', 'Access'),
(30, 'Norfloxacin', 'Access'),
(31, 'Ofloxacin', 'Watch'),
(32, 'Phenoxymethylpenicillin', 'Access'),
(33, 'Piperacillin/tazobactam', 'Watch'),
(34, 'Sulbactam + Cefoperazone', 'Reserve'),
(35, 'Teicoplanin', 'Watch'),
(36, 'Ticarcillin/Clavulan', 'Watch'),
(37, 'Tigecycline', 'Reserve'),
(38, 'Vancomycin', 'Watch'),
(39, 'MDT-PB Adult', 'Other'),
(40, 'MDT-PB Pediatric', 'Other'),
(41, 'MDT-MB Adult', 'Other'),
(42, 'MDT-MB Pediatric', 'Other'),
(43, 'Ciprofloxacin', 'Watch'),
(44, 'Clarithromycin', 'Access'),
(45, 'Clindamycin', 'Access'),
(46, 'Clofazimine', 'Other'),
(47, 'Co-Trimoxazole', 'Access'),
(48, 'Doxycycline', 'Access'),
(49, 'Erythromycin', 'Access'),
(52, 'Cefuroxime', 'Access'),
(53, 'Azithromycin', 'Watch');

-- --------------------------------------------------------

--
-- Table structure for table `book_transactions`
--

CREATE TABLE `book_transactions` (
  `id` int(11) NOT NULL,
  `book_number` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','completed') DEFAULT 'active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `book_transactions`
--

INSERT INTO `book_transactions` (`id`, `book_number`, `created_at`, `status`) VALUES
(2, '001', '2025-05-26 13:14:45', 'completed'),
(5, '004', '2025-06-18 14:28:12', 'active'),
(4, '002', '2025-06-18 14:26:15', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `dosages`
--

CREATE TABLE `dosages` (
  `id` int(11) NOT NULL,
  `antibiotic_id` int(11) DEFAULT NULL,
  `stv_number` varchar(20) NOT NULL,
  `dosage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosages`
--

INSERT INTO `dosages` (`id`, `antibiotic_id`, `stv_number`, `dosage`) VALUES
(1, 1, '00102603', '500 mg IV'),
(2, 2, '00100101', '250 mg Oral'),
(3, 2, '00100102', '500 mg Oral'),
(4, 2, '00100104', '125 mg/5 ml Syrup'),
(5, 2, '00100103', '125 mg Oral'),
(6, 3, '00100904', '0.51g (510mg) IV'),
(7, 3, '00100905', '1.2g (1200mg) IV'),
(8, 3, '00100901', '375 mg Oral'),
(9, 3, '00100902', '625 mg Oral'),
(10, 3, '00100903', '125 mg/31 mg/5 ml, 100 ml Syrup'),
(11, 4, '00100603', '1g (1000mg) IV'),
(12, 4, '00100601', '250 mg IV'),
(16, 6, '00100301', '1.2 million units IV'),
(17, 7, '00100201', '1 million units IV'),
(18, 8, '00101301', '250 mg Oral'),
(19, 8, '00101303', '125 mg (dispersible tab.) Oral'),
(20, 8, '00101302', '125 mg/5 ml Syrup'),
(21, 9, '00101902', '1g (1000mg) IV'),
(23, 11, '00101502', '1g (1000mg) IV'),
(24, 11, '00101503', '500 mg IV'),
(25, 12, '00101602', '1g (1000mg) IV'),
(26, 13, '00101704', '1g (1000mg) IV'),
(31, 22, '00100805', '250 mg Oral'),
(32, 22, '00100801', '500 mg Oral'),
(33, 22, '00100804', '125 mg/5 ml, 100 ml Syrup'),
(34, 22, '00100802', '500 mg IV'),
(35, 23, '00102502', '80 mg/2 ml IV'),
(36, 24, '00102001', '500 mg/500 mg IV'),
(37, 25, '00105801', '500 mg Oral'),
(38, 25, '00105802', '500 mg IV'),
(39, 26, '00108302', '600 mg Oral'),
(40, 26, '00108301', '600 mg IV'),
(41, 27, '00102102', '1g (1000mg) IV'),
(42, 28, '00105203', '500 mg IV'),
(43, 28, '00105202', '400 mg Oral'),
(44, 28, '00105201', '200 mg Oral'),
(45, 29, '00105901', '50 mg Oral'),
(46, 30, '00105601', '400 mg Oral'),
(47, 31, '00105701', '200 mg Oral'),
(48, 32, '00100402', '250 mg Oral'),
(49, 33, '00101001', '4.5g (4500mg) IV'),
(50, 34, '00101102', '2g (2000mg) IV'),
(51, 35, '00103602', '400 mg IV'),
(52, 36, '00101202', '3g (3000mg) IV'),
(53, 37, '00102304', '500 mg IV'),
(54, 38, '00103502', '1g (1000mg) IV'),
(55, 39, '00105002', ''),
(56, 40, '00105001', ''),
(57, 41, '00104902', ''),
(58, 42, '00104901', ''),
(59, 43, '00105401', '250 mg  oral'),
(60, 43, '00105402', '500 mg  oral'),
(61, 43, '00105403', '200 mg  iv'),
(62, 44, '00103001', '250 mg  oral'),
(63, 44, '00103006', '500 mg  oral'),
(64, 44, '00103003', '125 mg/5 ml, 100 ml  Syrup'),
(65, 44, '00103002', '500 mg   Iv'),
(66, 45, '00103201', '150 mg  oral'),
(67, 45, '00103202', '300 mg  oral'),
(68, 45, '00103203', '300 mg  Iv'),
(69, 46, '00105103', '50 mg  oral'),
(70, 46, '00105101', '100 mg  oral'),
(71, 47, '00103702', '480 mg  oral'),
(72, 47, '00103703', '50 mg  Syrup'),
(73, 48, '00102301', '100 mg  oral'),
(74, 49, '00102901', '250 mg  oral'),
(75, 49, '00102903', '125 mg/5 ml, 100 ml (oral suspension)  Syrup'),
(79, 52, '00101403', '500 mg Oral'),
(80, 52, '00101406', '750 mg IV'),
(81, 52, '00101404', '125 mg/5 ml Syrup'),
(82, 53, '00103101', '250 mg  oral'),
(83, 53, '00103102', '200 mg/ 5 ml, 15 ml Syrup');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expire_time` int(11) NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`, `created_at`) VALUES
(3, 'malithatishamal@gmail.com', 'f89019b043733b9ecf435d6641dc07ac7cc2b97e9180331bcbf2c07cccdbffe1c2a61d4cc616eb180a40c47eb7ddaf6f7ba6', '2025-05-13 08:05:49', '2025-05-13 11:05:50'),
(4, 'malithatishamal2003@gmail.com', '99675b1a3cb347606f5548a96a27b71147a8f1c6a2f8e7be504c0a8f85b6f1474006eee7045e76627b57f4ee98bcf65bc01e', '2025-05-15 09:18:15', '2025-05-15 12:18:15');

-- --------------------------------------------------------

--
-- Table structure for table `releases`
--

CREATE TABLE `releases` (
  `id` int(11) NOT NULL,
  `antibiotic_name` varchar(255) NOT NULL,
  `dosage` varchar(100) DEFAULT NULL,
  `item_count` int(11) NOT NULL,
  `ward_name` varchar(100) NOT NULL,
  `release_time` datetime NOT NULL,
  `type` enum('msd','lp') NOT NULL,
  `ant_type` varchar(255) NOT NULL,
  `ward_category` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `book_number` varchar(50) DEFAULT NULL,
  `page_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `releases`
--

INSERT INTO `releases` (`id`, `antibiotic_name`, `dosage`, `item_count`, `ward_name`, `release_time`, `type`, `ant_type`, `ward_category`, `category`, `system_name`, `book_number`, `page_number`) VALUES
(1, 'Amikacin', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 19:49:38', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(2, 'Amoxicillin', '250 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 19:50:09', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(3, 'Amoxicillin', '500 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 19:50:30', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(4, 'Amoxicillin', '125 mg/5 ml Syrup', 200, '3 - Surgical Prof - Female', '2025-06-02 19:51:36', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(5, 'Amoxicillin', '125 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 19:51:57', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(6, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '0.51g (510mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 19:52:19', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(7, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '1.2g (1200mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 19:52:47', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(8, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '625 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 19:53:20', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(9, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '125 mg/31 mg/5 ml, 100 ml Syrup', 200, '3 - Surgical Prof - Female', '2025-06-02 19:53:44', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(10, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '375 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 19:54:07', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(11, 'Ampicillin', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 19:54:33', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(12, 'Ampicillin', '250 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 19:54:54', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(13, 'Benzathine penicillin', '1.2 million units IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:07:01', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(14, 'Benzylpenicillin', '1 million units IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:07:19', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(15, 'Cefalexin', '250 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:07:38', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(16, 'Cefalexin', '125 mg (dispersible tab.) Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:07:59', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(17, 'Cefalexin', '125 mg/5 ml Syrup', 200, '3 - Surgical Prof - Female', '2025-06-02 20:08:22', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(18, 'Cefepime', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:08:44', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '001', '01'),
(19, 'Cefotaxime', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:09:44', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(20, 'Cefotaxime', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:10:10', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(21, 'Ceftazidime', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:10:36', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(22, 'Ceftriaxone', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:10:59', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(23, 'Cefuroxime', '500 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:11:24', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(24, 'Cefuroxime', '125 mg/5 ml Syrup', 200, '3 - Surgical Prof - Female', '2025-06-02 20:11:49', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(25, 'Cefuroxime', '750 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:12:08', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(26, 'Ciprofloxacin', '500 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:12:30', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(27, 'Ciprofloxacin', '200 mg  iv', 200, '3 - Surgical Prof - Female', '2025-06-02 20:12:52', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(28, 'Ciprofloxacin', '250 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:13:14', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(29, 'Clarithromycin', '500 mg   Iv', 200, '3 - Surgical Prof - Female', '2025-06-02 20:14:06', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(30, 'Clarithromycin', '250 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:14:37', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(31, 'Clarithromycin', '500 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:15:03', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(32, 'Clarithromycin', '125 mg/5 ml, 100 ml  Syrup', 200, '3 - Surgical Prof - Female', '2025-06-02 20:15:28', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(33, 'Clindamycin', '150 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:15:53', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(34, 'Clindamycin', '300 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:16:13', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(35, 'Clindamycin', '300 mg  Iv', 200, '3 - Surgical Prof - Female', '2025-06-02 20:16:34', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(36, 'Flucloxacillin', '250 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:21:11', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(37, 'Doxycycline', '100 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:21:41', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(38, 'Doxycycline', '100 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:39:54', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(39, 'Erythromycin', '250 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:40:32', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(40, 'Erythromycin', '250 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:42:59', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(41, 'Erythromycin', '125 mg/5 ml, 100 ml (oral suspension)  Syrup', 200, '3 - Surgical Prof - Female', '2025-06-02 20:43:21', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(42, 'Flucloxacillin', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:43:47', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(43, 'Flucloxacillin', '250 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:44:45', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(44, 'Flucloxacillin', '500 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:45:09', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(45, 'Flucloxacillin', '125 mg/5 ml, 100 ml Syrup', 200, '3 - Surgical Prof - Female', '2025-06-02 20:45:35', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(46, 'Gentamicin', '80 mg/2 ml IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:46:03', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(47, 'Imipenem/cilastatin', '500 mg/500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:46:24', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(48, 'Levofloxacin', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:46:47', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '001', '01'),
(49, 'Levofloxacin', '500 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:47:03', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '001', '01'),
(50, 'Linezolid', '600 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:47:29', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '001', '01'),
(51, 'Linezolid', '600 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:47:53', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '001', '01'),
(52, 'Meropenem', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:48:13', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(53, 'Metronidazole', '400 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:48:38', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(54, 'Metronidazole', '200 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:49:00', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(55, 'Metronidazole', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:49:21', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(56, 'Nitrofurantoin', '50 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:49:48', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(57, 'Norfloxacin', '400 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:50:08', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(58, 'Ofloxacin', '200 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:50:33', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(59, 'Phenoxymethylpenicillin', '250 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-02 20:50:52', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '01'),
(60, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:51:08', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(61, 'Sulbactam + Cefoperazone', '2g (2000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:51:27', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '001', '01'),
(62, 'Teicoplanin', '400 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:51:44', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(63, 'Tigecycline', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:54:05', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '001', '01'),
(64, 'Vancomycin', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-02 20:54:21', 'msd', 'oral', 'Surgery', 'Watch', NULL, '001', '01'),
(65, 'Amoxicillin', '125 mg/5 ml Syrup', 100, '6 - Surgery - Combined', '2025-06-04 10:10:54', 'lp', 'oral', 'Surgery', 'Access', NULL, '001', '11'),
(66, 'Amoxicillin', '125 mg Oral', 100, '3 - Surgical Prof - Female', '2025-06-04 10:11:33', 'msd', 'intravenous', 'Surgery', 'Access', NULL, '001', '11'),
(67, 'Benzylpenicillin', '1 million units IV', 100, '3 - Surgical Prof - Female', '2025-06-04 10:13:29', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '12'),
(68, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 100, '29 - Oncology - Female', '2025-06-04 10:14:04', 'lp', 'topical', 'Medicine Subspecialty', 'Watch', NULL, '001', '13'),
(69, 'Sulbactam + Cefoperazone', '2g (2000mg) IV', 100, '36 (Pediatrics) - Combined', '2025-06-04 10:14:38', 'msd', 'topical', 'Pediatrics', 'Reserve', NULL, '001', '14'),
(70, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '1.2g (1200mg) IV', 100, '8 - Neuro-Surgery - Female', '2025-06-04 10:21:41', 'lp', 'topical', 'Surgery Subspecialty', 'Access', NULL, '001', '15'),
(71, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '375 mg Oral', 100, '4 - Surgery - Male', '2025-06-04 10:22:19', 'lp', 'topical', 'Surgery', 'Access', NULL, '001', '15'),
(72, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '375 mg Oral', 100, '5 - Surgical Prof - Male', '2025-06-04 10:22:48', 'lp', 'topical', 'Surgery', 'Access', NULL, '001', '12'),
(73, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '625 mg Oral', 100, '60 - ETC Pead - Combined', '2025-06-04 10:23:21', 'msd', 'intravenous', 'Surgery', 'Access', NULL, '001', '17'),
(74, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '125 mg/31 mg/5 ml, 100 ml Syrup', 100, '45 - Cardio-Thoracic - Male', '2025-06-04 10:24:01', 'msd', 'oral', 'Surgery Subspecialty', 'Access', NULL, '001', '15'),
(75, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '375 mg Oral', 100, '4 - Surgery - Male', '2025-06-04 10:27:18', 'lp', 'oral', 'Surgery', 'Access', NULL, '001', '15'),
(76, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '625 mg Oral', 100, '3 - Surgical Prof - Female', '2025-06-04 10:28:42', 'msd', 'intravenous', 'Surgery', 'Access', NULL, '001', '15'),
(77, 'Cefalexin', '125 mg (dispersible tab.) Oral', 100, '4 - Surgery - Male', '2025-06-04 10:41:03', 'msd', 'intravenous', 'Surgery', 'Access', NULL, '001', '17'),
(78, 'Cefalexin', '125 mg/5 ml Syrup', 100, '5 - Surgical Prof - Male', '2025-06-04 10:43:43', 'lp', 'topical', 'Surgery', 'Access', NULL, '001', '18'),
(79, 'Cefepime', '1g (1000mg) IV', 100, '3 - Surgical Prof - Female', '2025-06-04 10:54:21', 'msd', 'topical', 'Surgery', 'Reserve', NULL, '001', '19'),
(80, 'Cefotaxime', '1g (1000mg) IV', 100, '3 - Surgical Prof - Female', '2025-06-04 10:54:54', 'msd', 'topical', 'Surgery', 'Watch', NULL, '001', '19'),
(81, 'Cefotaxime', '1g (1000mg) IV', 100, '3 - Surgical Prof - Female', '2025-06-04 10:56:38', 'msd', 'topical', 'Surgery', 'Watch', NULL, '001', '20'),
(82, 'Cefotaxime', '500 mg IV', 100, '1 & 2 - Pediatrics - Combined', '2025-06-04 10:57:10', 'msd', 'intravenous', 'Pediatrics', 'Watch', NULL, '001', '20'),
(83, 'Cefuroxime', '500 mg Oral', 100, '3 - Surgical Prof - Female', '2025-06-04 11:34:06', 'msd', 'oral', 'Surgery', 'Access', NULL, '001', '22'),
(84, 'Amikacin', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:07:51', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(85, 'Amoxicillin', '250 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:08:13', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(86, 'Amoxicillin', '500 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:08:40', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(87, 'Amoxicillin', '500 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:08:40', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(88, 'Amoxicillin', '125 mg/5 ml Syrup', 200, '3 - Surgical Prof - Female', '2025-06-04 20:11:00', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(89, 'Amoxicillin', '125 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:11:37', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(90, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '0.51g (510mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:12:01', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(91, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '1.2g (1200mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:12:24', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(92, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '625 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:12:53', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(93, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '125 mg/31 mg/5 ml, 100 ml Syrup', 200, '3 - Surgical Prof - Female', '2025-06-04 20:13:16', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(94, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '375 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:13:40', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(95, 'Ampicillin', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:14:03', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(96, 'Ampicillin', '250 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:14:24', 'msd', '--Select Route--', 'Surgery', 'Access', NULL, '3', '01'),
(97, 'Benzathine penicillin', '1.2 million units IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:16:17', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(98, 'Benzylpenicillin', '1 million units IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:16:36', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(99, 'Cefalexin', '250 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:16:56', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(100, 'Cefalexin', '125 mg (dispersible tab.) Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:17:19', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(101, 'Cefalexin', '125 mg/5 ml Syrup', 200, '3 - Surgical Prof - Female', '2025-06-04 20:17:52', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(102, 'Cefepime', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:18:19', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '3', '01'),
(103, 'Cefotaxime', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:18:59', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(104, 'Cefotaxime', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:19:38', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(105, 'Ceftazidime', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:20:07', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(106, 'Ceftriaxone', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:20:32', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(107, 'Cefuroxime', '500 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:21:05', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(108, 'Cefuroxime', '125 mg/5 ml Syrup', 200, '3 - Surgical Prof - Female', '2025-06-04 20:21:26', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(109, 'Cefuroxime', '750 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:21:45', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(110, 'Ciprofloxacin', '500 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:22:13', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(111, 'Ciprofloxacin', '200 mg  iv', 200, '3 - Surgical Prof - Female', '2025-06-04 20:23:21', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(112, 'Ciprofloxacin', '250 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:23:41', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(113, 'Clarithromycin', '500 mg   Iv', 200, '3 - Surgical Prof - Female', '2025-06-04 20:24:26', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(114, 'Clarithromycin', '250 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:24:47', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(115, 'Clarithromycin', '500 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:25:14', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(116, 'Clarithromycin', '125 mg/5 ml, 100 ml  Syrup', 200, '3 - Surgical Prof - Female', '2025-06-04 20:26:17', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(117, 'Clindamycin', '150 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:26:45', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(118, 'Clindamycin', '300 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:27:02', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(119, 'Clindamycin', '300 mg  Iv', 200, '3 - Surgical Prof - Female', '2025-06-04 20:27:18', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(120, 'Doxycycline', '100 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:28:41', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(121, 'Erythromycin', '250 mg  oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:29:08', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(122, 'Erythromycin', '125 mg/5 ml, 100 ml (oral suspension)  Syrup', 200, '3 - Surgical Prof - Female', '2025-06-04 20:29:29', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(123, 'Flucloxacillin', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:30:06', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(124, 'Flucloxacillin', '250 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:30:32', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(125, 'Flucloxacillin', '500 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:30:58', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(126, 'Flucloxacillin', '125 mg/5 ml, 100 ml Syrup', 200, '3 - Surgical Prof - Female', '2025-06-04 20:31:18', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(127, 'Gentamicin', '80 mg/2 ml IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:31:41', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(128, 'Imipenem/cilastatin', '500 mg/500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:32:15', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(129, 'Levofloxacin', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:32:42', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '3', '01'),
(130, 'Levofloxacin', '500 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:33:36', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '3', '01'),
(131, 'Linezolid', '600 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:34:05', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '3', '01'),
(132, 'Linezolid', '600 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:34:43', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '3', '01'),
(133, 'Meropenem', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:36:43', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(134, 'Metronidazole', '400 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:37:03', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(135, 'Metronidazole', '200 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:37:20', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(136, 'Metronidazole', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:37:38', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(137, 'Nitrofurantoin', '50 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:38:02', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(138, 'Metronidazole', '200 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:39:37', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(139, 'Metronidazole', '500 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:39:55', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(140, 'Nitrofurantoin', '50 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:40:15', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(141, 'Norfloxacin', '400 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:40:33', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(142, 'Ofloxacin', '200 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:40:49', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(143, 'Phenoxymethylpenicillin', '250 mg Oral', 200, '3 - Surgical Prof - Female', '2025-06-04 20:41:07', 'msd', 'oral', 'Surgery', 'Access', NULL, '3', '01'),
(144, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:41:31', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(145, 'Sulbactam + Cefoperazone', '2g (2000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:41:52', 'msd', 'oral', 'Surgery', 'Reserve', NULL, '3', '01'),
(146, 'Teicoplanin', '400 mg IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:42:09', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(147, 'Vancomycin', '1g (1000mg) IV', 200, '3 - Surgical Prof - Female', '2025-06-04 20:42:51', 'msd', 'oral', 'Surgery', 'Watch', NULL, '3', '01'),
(148, 'Amikacin', '500 mg IV', 3, '12 - Medicine Prof - Male', '2023-03-02 14:02:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '3', '01'),
(149, 'Amikacin', '500 mg IV', 3, '46 & 47 - GU Surgery - Male', '2023-03-02 14:04:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(150, 'Amikacin', '500 mg IV', 3, '7 - Surgical Prof - Female', '2023-03-02 14:07:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(151, 'Amikacin', '500 mg IV', 6, '46 & 47 - GU Surgery - Male', '2024-02-04 14:18:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(152, 'Amikacin', '500 mg IV', 3, '9 - Surgery - Combined', '2023-05-02 14:31:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(153, 'Amikacin', '500 mg IV', 6, '15 - Medicine - Female', '2023-05-02 14:38:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '3', '01'),
(154, 'Amikacin', '500 mg IV', 3, '8 - Neuro-Surgery - Female', '2023-05-02 15:00:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(155, 'Amikacin', '500 mg IV', 6, '1 & 2 - Pediatrics - Combined', '2023-05-02 15:36:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(156, 'Amikacin', '500 mg IV', 9, '48 - Onco-Surgery - Female', '2023-06-02 15:37:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(157, 'Amikacin', '500 mg IV', 3, '46 & 47 - GU Surgery - Male', '2023-06-02 15:38:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(158, 'Amikacin', '500 mg IV', 3, '7 - Surgical Prof - Female', '2023-06-02 15:40:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(159, 'Amikacin', '500 mg IV', 6, '22 - Orthopedic - Male', '2023-06-02 15:51:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(160, 'Amikacin', '500 mg IV', 3, '12 - Medicine Prof - Male', '2023-06-02 15:52:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '3', '01'),
(161, 'Amikacin', '500 mg IV', 6, '46 & 47 - GU Surgery - Male', '2023-07-02 15:53:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(162, 'Amikacin', '500 mg IV', 3, '1 & 2 - Pediatrics - Combined', '2023-07-02 15:53:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(163, 'Amikacin', '500 mg IV', 1, '9 - Surgery - Combined', '2023-08-02 15:54:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(164, 'Amikacin', '500 mg IV', 1, '8 - Neuro-Surgery - Female', '2023-08-02 15:55:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(165, 'Amikacin', '500 mg IV', 3, '48 - Onco-Surgery - Female', '2023-08-02 15:56:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(166, 'Amikacin', '500 mg IV', 2, '1 & 2 - Pediatrics - Combined', '2023-08-02 15:56:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(167, 'Amikacin', '500 mg IV', 6, '7 - Surgical Prof - Female', '2023-09-02 15:57:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(168, 'Amikacin', '500 mg IV', 2, '9 - Surgery - Combined', '2023-09-02 15:58:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(169, 'Amikacin', '500 mg IV', 3, '46 & 47 - GU Surgery - Male', '2023-09-02 15:58:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(170, 'Amikacin', '500 mg IV', 6, '48 - Onco-Surgery - Female', '2023-10-02 15:59:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(171, 'Amikacin', '500 mg IV', 1, '73 - Nephrology - Female', '2023-10-02 16:00:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '3', '01'),
(172, 'Amikacin', '500 mg IV', 6, '22 - Orthopedic - Male', '2023-10-02 16:01:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(173, 'Amikacin', '500 mg IV', 6, '36 - Pediatrics - Combined', '2023-11-02 16:01:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(174, 'Amikacin', '500 mg IV', 9, '8 - Neuro-Surgery - Female', '2023-11-02 16:04:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(175, 'Amikacin', '500 mg IV', 6, '7 - Surgical Prof - Female', '2023-11-02 16:05:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(176, 'Amikacin', '500 mg IV', 3, '9 - Surgery - Combined', '2023-11-02 16:05:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(177, 'Amikacin', '500 mg IV', 3, '1 & 2 - Pediatrics - Combined', '2023-11-02 16:06:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(178, 'Amikacin', '500 mg IV', 9, '48 - Onco-Surgery - Female', '2023-12-02 16:07:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(179, 'Amikacin', '500 mg IV', 6, '22 - Orthopedic - Male', '2023-12-02 16:08:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(180, 'Amikacin', '500 mg IV', 6, '7 - Surgical Prof - Female', '2023-12-02 16:09:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(181, 'Amikacin', '500 mg IV', 6, '46 & 47 - GU Surgery - Male', '2023-12-02 16:09:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(182, 'Amikacin', '500 mg IV', 1, '70 - Nephrology', '2023-12-02 16:10:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '3', '01'),
(183, 'Amikacin', '500 mg IV', 6, '16 - Medicine - Male', '2023-12-02 16:11:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '3', '01'),
(184, 'Cefotaxime', '1g (1000mg) IV', 6, '1 & 2 - Pediatrics - Combined', '2023-01-05 16:23:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(185, 'Cefotaxime', '1g (1000mg) IV', 18, '36 - Pediatrics - Combined', '2023-01-05 16:24:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(186, 'Cefotaxime', '1g (1000mg) IV', 12, '1 & 2 - Pediatrics - Combined', '2023-01-05 16:24:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(187, 'Cefotaxime', '1g (1000mg) IV', 14, '36 - Pediatrics - Combined', '2023-01-07 16:25:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(188, 'Cefotaxime', '1g (1000mg) IV', 2, '36 - Pediatrics - Combined', '2023-01-08 16:26:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(189, 'Cefotaxime', '1g (1000mg) IV', 6, '1 & 2 - Pediatrics - Combined', '2023-01-08 16:27:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(190, 'Cefotaxime', '1g (1000mg) IV', 9, '1 & 2 - Pediatrics - Combined', '2023-01-06 16:27:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(191, 'Cefotaxime', '1g (1000mg) IV', 3, '36 - Pediatrics - Combined', '2023-01-12 16:28:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(192, 'Cefotaxime', '1g (1000mg) IV', 5, '1 & 2 - Pediatrics - Combined', '2023-01-15 16:30:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(193, 'Cefotaxime', '1g (1000mg) IV', 3, '36 - Pediatrics - Combined', '2023-01-16 16:31:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(194, 'Cefotaxime', '1g (1000mg) IV', 3, '36 - Pediatrics - Combined', '2023-01-17 16:32:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(195, 'Cefotaxime', '1g (1000mg) IV', 4, '1 & 2 - Pediatrics - Combined', '2023-01-18 16:35:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(196, 'Cefotaxime', '1g (1000mg) IV', 5, '1 & 2 - Pediatrics - Combined', '2023-01-18 16:35:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(197, 'Ciprofloxacin', '500 mg  oral', 20, 'Adult ICU (CTC ICU)', '2023-01-20 16:43:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(198, 'Cefotaxime', '1g (1000mg) IV', 2, 'Children ICU (Neonatal ICU)', '2023-01-05 08:07:00', 'msd', 'other', 'ICU', 'Watch', NULL, '3', ''),
(199, 'Cefotaxime', '1g (1000mg) IV', 6, '1 & 2 - Pediatrics - Combined', '2023-01-05 08:07:00', 'msd', 'other', 'Pediatrics', 'Watch', NULL, '3', ''),
(200, 'Cefotaxime', '1g (1000mg) IV', 18, '36 - Pediatrics - Combined', '2023-01-05 08:07:00', 'msd', 'other', 'Pediatrics', 'Watch', NULL, '3', ''),
(201, 'Cefotaxime', '1g (1000mg) IV', 12, '1 & 2 - Pediatrics - Combined', '2023-01-05 08:07:00', 'msd', 'other', 'Pediatrics', 'Watch', NULL, '3', ''),
(202, 'Cefotaxime', '1g (1000mg) IV', 5, 'Adult ICU (ETC ICU)', '2023-01-05 08:07:00', 'msd', 'other', 'ICU', 'Watch', NULL, '3', ''),
(203, 'Cefotaxime', '1g (1000mg) IV', 9, 'Children ICU (Neonatal ICU)', '2025-06-07 17:57:47', 'msd', 'other', 'ICU', 'Watch', NULL, '3', ''),
(204, 'Cefotaxime', '1g (1000mg) IV', 14, '36 - Pediatrics - Combined', '2023-01-07 08:08:00', 'msd', 'other', 'Pediatrics', 'Watch', NULL, '3', ''),
(205, 'Cefotaxime', '1g (1000mg) IV', 2, '36 - Pediatrics - Combined', '2023-01-08 08:08:00', 'msd', 'other', 'Pediatrics', 'Watch', NULL, '3', ''),
(206, 'Cefotaxime', '1g (1000mg) IV', 6, '1 & 2 - Pediatrics - Combined', '2023-01-08 08:08:00', 'msd', 'other', 'Pediatrics', 'Watch', NULL, '3', ''),
(207, 'Cefotaxime', '1g (1000mg) IV', 6, 'Children ICU (Pediatric ICU)', '2023-01-08 08:08:00', 'msd', 'other', 'ICU', 'Watch', NULL, '3', ''),
(208, 'Cefotaxime', '1g (1000mg) IV', 9, '1 & 2 - Pediatrics - Combined', '2023-01-06 08:08:00', 'msd', 'other', 'Pediatrics', 'Watch', NULL, '3', ''),
(209, 'Cefotaxime', '1g (1000mg) IV', 3, '36 - Pediatrics - Combined', '2023-01-12 08:08:00', 'msd', 'other', 'Pediatrics', 'Watch', NULL, '3', ''),
(210, 'Cefotaxime', '1g (1000mg) IV', 5, 'Adult ICU (ETC ICU)', '2023-01-12 08:08:00', 'msd', 'other', 'ICU', 'Watch', NULL, '3', ''),
(211, 'Cefotaxime', '1g (1000mg) IV', 5, '1 & 2 - Pediatrics - Combined', '2025-02-07 08:08:00', 'msd', 'other', 'Pediatrics', 'Watch', NULL, '3', ''),
(212, 'Metronidazole', '500 mg IV', 100, '7 - Surgical Prof - Female', '2023-01-23 07:01:00', 'msd', 'other', 'Surgery', 'Access', 'h.g.m.nihari868', '3', ''),
(213, 'Metronidazole', '500 mg IV', 10, 'Adult ICU (ETC ICU)', '2023-01-23 07:01:00', 'msd', 'other', 'ICU', 'Access', 'h.g.m.nihari868', '3', ''),
(214, 'Metronidazole', '500 mg IV', 20, '12 - Medicine Prof - Male', '2023-01-23 07:01:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(215, 'Metronidazole', '500 mg IV', 20, '48 - Onco-Surgery - Female', '2023-01-23 07:02:00', 'msd', 'other', 'Surgery Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(216, 'Metronidazole', '500 mg IV', 20, '35 - Medicine - Female', '2023-01-24 07:02:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(217, 'Metronidazole', '500 mg IV', 10, 'Adult ICU (Main ICU)', '2023-01-24 07:02:00', 'msd', 'other', 'ICU', 'Access', 'h.g.m.nihari868', '3', ''),
(218, 'Metronidazole', '500 mg IV', 100, '3 - Surgical Prof - Female', '2023-01-24 07:02:00', 'msd', 'other', 'Surgery', 'Access', 'h.g.m.nihari868', '3', ''),
(219, 'Metronidazole', '500 mg IV', 100, '6 - Surgery - Combined', '2023-01-24 07:02:00', 'msd', 'other', 'Surgery', 'Access', 'h.g.m.nihari868', '3', ''),
(220, 'Metronidazole', '500 mg IV', 50, '70 - Nephrology', '2023-01-25 07:02:00', 'msd', 'other', 'Medicine Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(221, 'Metronidazole', '500 mg IV', 100, '8 - Neuro-Surgery - Female', '2023-01-25 07:02:00', 'msd', 'other', 'Surgery Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(222, 'Metronidazole', '500 mg IV', 50, '4 - Surgery - Male', '2023-01-25 07:02:00', 'msd', 'other', 'Surgery', 'Access', 'h.g.m.nihari868', '3', ''),
(223, 'Metronidazole', '500 mg IV', 20, '14 - Medicine - Male', '2023-01-25 07:02:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(224, 'Metronidazole', '500 mg IV', 20, '17 - Medicine - Female', '2023-01-25 07:03:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(225, 'Metronidazole', '500 mg IV', 40, '24 - Neurology - Combined', '2023-01-25 07:03:00', 'msd', 'other', 'Medicine Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(226, 'Metronidazole', '500 mg IV', 20, '34 - Medicine - Male', '2023-01-25 07:03:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(227, 'Metronidazole', '500 mg IV', 20, '30 - ENT - Male', '2023-01-25 07:03:00', 'msd', 'other', 'Surgery Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(228, 'Metronidazole', '500 mg IV', 100, '12 - Medicine Prof - Male', '2023-01-25 07:03:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(229, 'Metronidazole', '500 mg IV', 100, '58 - Emergency/ETC - Male', '2023-01-25 07:03:00', 'msd', 'other', 'Surgery', 'Access', 'h.g.m.nihari868', '3', ''),
(230, 'Metronidazole', '500 mg IV', 40, '24 - Neurology - Combined', '2023-01-26 07:03:00', 'msd', 'other', 'Medicine Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(231, 'Metronidazole', '500 mg IV', 40, '9 - Surgery - Combined', '2023-01-26 07:04:00', 'msd', 'other', 'Surgery', 'Access', 'h.g.m.nihari868', '3', ''),
(232, 'Metronidazole', '500 mg IV', 20, 'Adult ICU (ETC ICU)', '2023-01-26 07:04:00', 'msd', 'other', 'ICU', 'Access', 'h.g.m.nihari868', '3', ''),
(233, 'Metronidazole', '500 mg IV', 20, '46 & 47 - GU Surgery - Male', '2023-01-26 07:04:00', 'msd', 'other', 'Surgery Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(234, 'Metronidazole', '500 mg IV', 20, '34 - Medicine - Male', '2023-01-26 07:05:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(235, 'Metronidazole', '500 mg IV', 10, 'Adult ICU (Onco ICU)', '2023-01-27 07:05:00', 'msd', 'other', 'ICU', 'Access', 'h.g.m.nihari868', '3', ''),
(236, 'Metronidazole', '500 mg IV', 16, 'Children ICU (Neonatal ICU)', '2023-01-27 07:05:00', 'msd', 'other', 'ICU', 'Access', 'h.g.m.nihari868', '3', ''),
(237, 'Metronidazole', '500 mg IV', 10, '35 - Medicine - Female', '2023-01-27 07:07:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(238, 'Metronidazole', '500 mg IV', 20, '30 - ENT - Male', '2023-01-29 07:07:00', 'msd', 'other', 'Surgery Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(239, 'Metronidazole', '500 mg IV', 20, '34 - Medicine - Male', '2023-01-29 07:07:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(240, 'Metronidazole', '500 mg IV', 100, '11 - Medicine Prof - Female', '2023-01-29 07:07:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(241, 'Metronidazole', '500 mg IV', 30, '19 - Medicine - Male', '2023-01-29 07:07:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(242, 'Metronidazole', '500 mg IV', 20, 'Adult ICU (ETC ICU)', '2023-01-29 07:07:00', 'msd', 'other', 'ICU', 'Access', 'h.g.m.nihari868', '3', ''),
(243, 'Metronidazole', '500 mg IV', 20, '35 - Medicine - Female', '2023-01-29 07:07:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(244, 'Metronidazole', '500 mg IV', 20, '24 - Neurology - Combined', '2023-01-29 07:07:00', 'msd', 'other', 'Medicine Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(245, 'Metronidazole', '500 mg IV', 100, '24 - Neurology - Combined', '2023-01-29 07:07:00', 'msd', 'other', 'Medicine Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(246, 'Metronidazole', '500 mg IV', 20, '14 - Medicine - Male', '2023-01-29 07:07:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(247, 'Metronidazole', '500 mg IV', 10, '22 - Orthopedic - Male', '2023-01-30 07:08:00', 'msd', 'other', 'Surgery Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(248, 'Metronidazole', '500 mg IV', 10, '22 - Orthopedic - Male', '2023-01-30 07:08:00', 'msd', 'other', 'Surgery Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(249, 'Metronidazole', '500 mg IV', 20, 'Adult ICU (ETC ICU)', '2023-01-30 07:08:00', 'msd', 'other', 'ICU', 'Access', 'h.g.m.nihari868', '3', ''),
(250, 'Metronidazole', '500 mg IV', 20, '46 & 47 - GU Surgery - Male', '2023-01-30 07:08:00', 'msd', 'other', 'Surgery Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(251, 'Metronidazole', '500 mg IV', 20, '48 - Onco-Surgery - Female', '2023-01-30 07:08:00', 'msd', 'other', 'Surgery Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(252, 'Amikacin', '500 mg IV', 6, 'Adult ICU (CTC ICU)', '2023-02-03 08:22:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(253, 'Amikacin', '500 mg IV', 6, 'Adult ICU (ETC ICU)', '2023-02-03 08:23:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(254, 'Amikacin', '500 mg IV', 3, '12 - Medicine Prof - Male', '2023-02-03 08:24:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '3', '01'),
(255, 'Amikacin', '500 mg IV', 3, '46 & 47 - GU Surgery - Male', '2023-02-03 08:24:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(256, 'Amikacin', '500 mg IV', 12, 'Adult ICU (ETC ICU)', '2023-02-03 08:26:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(257, 'Amikacin', '500 mg IV', 3, '7 - Surgical Prof - Female', '2023-02-03 08:26:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(258, 'Amikacin', '500 mg IV', 30, 'Adult ICU (ETC ICU)', '2023-02-03 08:27:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(259, 'Amikacin', '500 mg IV', 6, 'Adult ICU (ETC ICU)', '2023-02-04 08:28:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(260, 'Amikacin', '500 mg IV', 6, 'Adult ICU (CTC ICU)', '2023-02-04 08:28:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(261, 'Metronidazole', '500 mg IV', 20, '24 - Neurology - Combined', '2023-01-31 07:09:00', 'msd', 'other', 'Medicine Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(262, 'Amikacin', '500 mg IV', 6, '46 & 47 - GU Surgery - Male', '2023-02-04 08:29:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(263, 'Metronidazole', '500 mg IV', 100, '9 - Surgery - Combined', '2023-01-31 07:09:00', 'msd', 'other', 'Surgery', 'Access', 'h.g.m.nihari868', '3', ''),
(264, 'Amikacin', '500 mg IV', 3, '9 - Surgery - Combined', '2023-02-05 08:30:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(265, 'Amikacin', '500 mg IV', 6, '15 - Medicine - Female', '2023-02-05 08:30:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '3', '01'),
(266, 'Amikacin', '500 mg IV', 3, '8 - Neuro-Surgery - Female', '2023-02-05 08:31:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(267, 'Amikacin', '500 mg IV', 6, '1 & 2 - Pediatrics - Combined', '2023-02-05 08:32:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(268, 'Amikacin', '500 mg IV', 18, 'Adult ICU (ETC ICU)', '2023-02-06 08:32:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(269, 'Amikacin', '500 mg IV', 9, '48 - Onco-Surgery - Female', '2023-02-06 08:33:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(270, 'Amikacin', '500 mg IV', 3, '46 & 47 - GU Surgery - Male', '2023-02-06 08:34:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(271, 'Amikacin', '500 mg IV', 18, 'Adult ICU (ETC ICU)', '2023-02-06 08:35:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(272, 'Amikacin', '500 mg IV', 3, '7 - Surgical Prof - Female', '2023-02-06 08:35:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(273, 'Amikacin', '500 mg IV', 6, '22 - Orthopedic - Male', '2023-02-06 08:36:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(274, 'Amikacin', '500 mg IV', 3, '12 - Medicine Prof - Male', '2023-02-06 08:37:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '3', '01'),
(275, 'Amikacin', '500 mg IV', 6, 'Adult ICU (ETC ICU)', '2023-02-07 08:38:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(276, 'Amikacin', '500 mg IV', 6, '46 & 47 - GU Surgery - Male', '2023-02-07 08:38:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(277, 'Amikacin', '500 mg IV', 3, '1 & 2 - Pediatrics - Combined', '2023-02-07 08:39:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(278, 'Amikacin', '500 mg IV', 1, '9 - Surgery - Combined', '2023-02-08 08:40:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(279, 'Amikacin', '500 mg IV', 1, '8 - Neuro-Surgery - Female', '2023-02-08 08:40:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(280, 'Amikacin', '500 mg IV', 3, '48 - Onco-Surgery - Female', '2023-02-08 08:41:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(281, 'Amikacin', '500 mg IV', 2, '1 & 2 - Pediatrics - Combined', '2023-02-08 08:41:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(282, 'Amikacin', '500 mg IV', 2, 'Adult ICU (ETC ICU)', '2023-02-08 08:42:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(283, 'Amikacin', '500 mg IV', 12, 'Adult ICU (ETC ICU)', '2023-02-09 08:43:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(284, 'Amikacin', '500 mg IV', 6, 'Adult ICU (Onco ICU)', '2023-02-09 08:44:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(285, 'Amikacin', '500 mg IV', 3, 'Adult ICU (ETC ICU)', '2023-02-09 08:44:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(286, 'Amikacin', '500 mg IV', 6, '7 - Surgical Prof - Female', '2023-02-09 08:45:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(287, 'Amikacin', '500 mg IV', 2, '9 - Surgery - Combined', '2023-02-09 08:46:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(288, 'Amikacin', '500 mg IV', 3, '46 & 47 - GU Surgery - Male', '2023-02-09 08:46:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(289, 'Amikacin', '500 mg IV', 6, '48 - Onco-Surgery - Female', '2023-02-10 08:47:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(290, 'Amikacin', '500 mg IV', 1, '73 - Nephrology - Female', '2023-02-10 08:48:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '3', '01'),
(291, 'Amikacin', '500 mg IV', 6, 'Adult ICU (CTC ICU)', '2023-02-06 08:49:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(292, 'Amikacin', '500 mg IV', 6, '22 - Orthopedic - Male', '2023-02-10 08:49:00', 'msd', 'intravenous', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(293, 'Amikacin', '500 mg IV', 6, 'Adult ICU (ETC ICU)', '2023-02-10 08:50:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(294, 'Amikacin', '500 mg IV', 6, 'Adult ICU (Onco ICU)', '2023-02-11 08:51:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '3', '01'),
(295, 'Amikacin', '500 mg IV', 6, '36 - Pediatrics - Combined', '2023-02-11 08:52:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(296, 'Amikacin', '500 mg IV', 9, '8 - Neuro-Surgery - Female', '2023-02-11 08:52:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(297, 'Amikacin', '500 mg IV', 6, '7 - Surgical Prof - Female', '2023-02-11 08:53:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(298, 'Amikacin', '500 mg IV', 3, '9 - Surgery - Combined', '2023-02-11 08:54:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '3', '01'),
(299, 'Amikacin', '500 mg IV', 3, '1 & 2 - Pediatrics - Combined', '2023-02-11 08:55:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(300, 'Cefotaxime', '1g (1000mg) IV', 2, '1 & 2 - Pediatrics - Combined', '2023-01-05 09:01:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(301, 'Cefotaxime', '1g (1000mg) IV', 18, '36 - Pediatrics - Combined', '2023-01-05 09:02:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(302, 'Cefotaxime', '1g (1000mg) IV', 12, '1 & 2 - Pediatrics - Combined', '2023-01-05 09:02:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(303, 'Cefotaxime', '1g (1000mg) IV', 14, '36 - Pediatrics - Combined', '2023-01-07 09:03:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(304, 'Cefotaxime', '1g (1000mg) IV', 2, '36 - Pediatrics - Combined', '2023-01-08 09:04:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(305, 'Cefotaxime', '1g (1000mg) IV', 6, '1 & 2 - Pediatrics - Combined', '2023-01-08 09:05:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '', '01'),
(306, 'Cefotaxime', '1g (1000mg) IV', 9, '1 & 2 - Pediatrics - Combined', '2023-01-06 09:06:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(307, 'Cefotaxime', '1g (1000mg) IV', 3, '36 - Pediatrics - Combined', '2023-01-12 09:09:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(308, 'Cefotaxime', '1g (1000mg) IV', 2, '1 & 2 - Pediatrics - Combined', '2023-01-15 09:10:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(309, 'Cefotaxime', '1g (1000mg) IV', 3, '36 - Pediatrics - Combined', '2023-01-16 09:14:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(310, 'Metronidazole', '500 mg IV', 40, '16 - Medicine - Male', '2023-01-31 07:09:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(311, 'Metronidazole', '500 mg IV', 40, '16 - Medicine - Male', '2023-01-31 07:09:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(312, 'Metronidazole', '500 mg IV', 100, '16 - Medicine - Male', '2023-01-31 07:09:00', 'msd', 'other', 'Medicine', 'Access', 'h.g.m.nihari868', '3', ''),
(313, 'Metronidazole', '500 mg IV', 100, '5 - Surgical Prof - Male', '2023-02-01 07:09:00', 'msd', 'other', 'Surgery', 'Access', 'h.g.m.nihari868', '3', ''),
(314, 'Metronidazole', '500 mg IV', 100, '58 - Emergency/ETC - Male', '2023-02-01 07:10:00', 'msd', 'other', 'Surgery', 'Access', 'h.g.m.nihari868', '3', ''),
(315, 'Cefotaxime', '1g (1000mg) IV', 4, '1 & 2 - Pediatrics - Combined', '2023-01-18 09:25:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(316, 'Cefotaxime', '1g (1000mg) IV', 5, '1 & 2 - Pediatrics - Combined', '2023-01-18 09:26:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(317, 'Cefotaxime', '1g (1000mg) IV', 2, '1 & 2 - Pediatrics - Combined', '2023-01-19 09:28:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(318, 'Cefotaxime', '1g (1000mg) IV', 5, '1 & 2 - Pediatrics - Combined', '2023-01-19 09:28:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(319, 'Cefotaxime', '1g (1000mg) IV', 9, '1 & 2 - Pediatrics - Combined', '2023-01-21 09:29:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(320, 'Cefotaxime', '1g (1000mg) IV', 3, '36 - Pediatrics - Combined', '2023-01-22 09:30:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(321, 'Cefotaxime', '1g (1000mg) IV', 30, '1 & 2 - Pediatrics - Combined', '2023-01-23 09:31:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(322, 'Metronidazole', '500 mg IV', 20, '30 - ENT - Male', '2025-06-10 07:10:00', 'msd', 'other', 'Surgery Subspecialty', 'Access', 'h.g.m.nihari868', '3', ''),
(323, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, 'Adult ICU (ETC ICU)', '2023-01-01 08:42:00', 'msd', 'other', 'ICU', 'Watch', 'h.g.m.nihari868', '3', ''),
(324, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, '11 - Medicine Prof - Female', '2023-01-01 08:42:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '3', '');
INSERT INTO `releases` (`id`, `antibiotic_name`, `dosage`, `item_count`, `ward_name`, `release_time`, `type`, `ant_type`, `ward_category`, `category`, `system_name`, `book_number`, `page_number`) VALUES
(325, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 2, '71 - Nephrology - Male', '2025-06-10 08:42:00', 'msd', 'other', 'Medicine Subspecialty', 'Watch', 'h.g.m.nihari868', '3', ''),
(326, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '46 & 47 - GU Surgery - Male', '2023-01-01 08:42:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '3', ''),
(327, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 3, '6 - Surgery - Combined', '2023-01-01 08:42:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '3', ''),
(328, 'Cefotaxime', '1g (1000mg) IV', 7, '1 & 2 - Pediatrics - Combined', '2023-01-23 10:38:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(329, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, 'Adult ICU (CTC ICU)', '2023-01-01 08:42:00', 'msd', 'other', 'ICU', 'Watch', 'h.g.m.nihari868', '3', ''),
(330, 'Cefotaxime', '1g (1000mg) IV', 8, '36 - Pediatrics - Combined', '2023-01-24 10:46:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(331, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '30 - ENT - Male', '2023-01-01 08:42:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '3', ''),
(332, 'Cefotaxime', '1g (1000mg) IV', 2, '8 - Neuro-Surgery - Female', '2023-01-24 10:47:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '3', '01'),
(333, 'Cefotaxime', '1g (1000mg) IV', 2, '36 - Pediatrics - Combined', '2023-01-24 10:48:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(334, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '5 - Surgical Prof - Male', '2023-01-01 08:42:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '3', ''),
(335, 'Cefotaxime', '1g (1000mg) IV', 4, '1 & 2 - Pediatrics - Combined', '2023-01-24 10:49:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(336, 'Cefotaxime', '1g (1000mg) IV', 10, '1 & 2 - Pediatrics - Combined', '2023-01-26 10:49:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(337, 'Cefotaxime', '1g (1000mg) IV', 2, '36 - Pediatrics - Combined', '2023-01-26 10:50:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(338, 'Cefotaxime', '1g (1000mg) IV', 14, '1 & 2 - Pediatrics - Combined', '2023-01-26 10:51:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '3', '01'),
(339, 'Cefotaxime', '1g (1000mg) IV', 8, '1 & 2 - Pediatrics - Combined', '2023-01-26 10:52:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(340, 'Cefotaxime', '1g (1000mg) IV', 11, '36 - Pediatrics - Combined', '2023-01-27 10:53:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(341, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '5 - Surgical Prof - Male', '2023-01-01 08:42:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '3', ''),
(342, 'Cefotaxime', '1g (1000mg) IV', 11, '1 & 2 - Pediatrics - Combined', '2023-01-27 10:54:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(343, 'Cefotaxime', '1g (1000mg) IV', 20, '1 & 2 - Pediatrics - Combined', '2023-01-27 10:55:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(344, 'Cefotaxime', '1g (1000mg) IV', 7, '1 & 2 - Pediatrics - Combined', '2023-01-28 10:55:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(345, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 24, '34 - Medicine - Male', '2023-01-01 08:43:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(346, 'Cefotaxime', '1g (1000mg) IV', 9, '36 - Pediatrics - Combined', '2023-01-29 10:57:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(347, 'Cefotaxime', '1g (1000mg) IV', 13, '1 & 2 - Pediatrics - Combined', '2023-01-29 10:58:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(348, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '17 - Medicine - Female', '2023-01-01 08:43:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(349, 'Cefotaxime', '1g (1000mg) IV', 6, '1 & 2 - Pediatrics - Combined', '2023-01-30 10:59:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(350, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '15 - Medicine - Female', '2023-01-01 08:43:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(351, 'Cefotaxime', '1g (1000mg) IV', 2, '1 & 2 - Pediatrics - Combined', '2023-02-14 10:59:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(352, 'Cefotaxime', '1g (1000mg) IV', 9, '1 & 2 - Pediatrics - Combined', '2023-02-15 11:00:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(353, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, '34 - Medicine - Male', '2023-01-01 08:43:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(354, 'Cefotaxime', '1g (1000mg) IV', 3, '36 - Pediatrics - Combined', '2023-02-15 11:01:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(355, 'Cefotaxime', '1g (1000mg) IV', 28, '36 - Pediatrics - Combined', '2023-03-16 11:01:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(356, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, '8 - Neuro-Surgery - Female', '2023-01-01 08:45:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(357, 'Cefotaxime', '1g (1000mg) IV', 10, '9 - Surgery - Combined', '2023-03-16 11:02:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(358, 'Cefotaxime', '1g (1000mg) IV', 3, '8 - Neuro-Surgery - Female', '2023-03-16 11:03:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(359, 'Cefotaxime', '1g (1000mg) IV', 12, '1 & 2 - Pediatrics - Combined', '2023-03-16 11:03:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(360, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 4, '71 - Nephrology - Male', '2023-01-01 08:43:00', 'msd', 'other', 'Medicine Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(361, 'Cefotaxime', '1g (1000mg) IV', 12, '48 - Onco-Surgery - Female', '2023-03-16 11:04:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(362, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, '36 - Pediatrics - Combined', '2023-01-01 08:43:00', 'msd', 'other', 'Pediatrics', 'Watch', 'h.g.m.nihari868', '003', ''),
(363, 'Cefotaxime', '1g (1000mg) IV', 30, '1 & 2 - Pediatrics - Combined', '2023-03-16 11:05:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(364, 'Cefotaxime', '1g (1000mg) IV', 8, '1 & 2 - Pediatrics - Combined', '2023-03-16 11:05:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(365, 'Cefotaxime', '1g (1000mg) IV', 95, '1 & 2 - Pediatrics - Combined', '2023-03-08 11:06:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(366, 'Cefotaxime', '1g (1000mg) IV', 20, '36 - Pediatrics - Combined', '2023-03-17 11:09:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(367, 'Cefotaxime', '1g (1000mg) IV', 8, '8 - Neuro-Surgery - Female', '2023-03-17 11:10:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(368, 'Cefotaxime', '1g (1000mg) IV', 20, '1 & 2 - Pediatrics - Combined', '2023-03-17 11:11:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(369, 'Cefotaxime', '1g (1000mg) IV', 50, '1 & 2 - Pediatrics - Combined', '2023-03-18 11:11:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(370, 'Cefotaxime', '1g (1000mg) IV', 12, '8 - Neuro-Surgery - Female', '2023-03-18 11:12:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(371, 'Cefotaxime', '1g (1000mg) IV', 50, '19 - Medicine - Male', '2023-03-19 11:13:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(372, 'Cefotaxime', '1g (1000mg) IV', 30, '9 - Surgery - Combined', '2023-03-19 11:14:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(373, 'Cefotaxime', '1g (1000mg) IV', 50, '11 - Medicine Prof - Female', '2023-03-19 11:15:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(374, 'Cefotaxime', '1g (1000mg) IV', 50, '12 - Medicine Prof - Male', '2023-03-19 11:16:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(375, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '20 - Orthopedic - Female', '2023-01-01 08:43:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(376, 'Cefotaxime', '1g (1000mg) IV', 20, '36 - Pediatrics - Combined', '2023-03-20 11:17:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(377, 'Cefotaxime', '1g (1000mg) IV', 6, '8 - Neuro-Surgery - Female', '2023-03-20 11:17:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(378, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '6 - Surgery - Combined', '2023-01-02 08:43:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '003', ''),
(379, 'Cefotaxime', '1g (1000mg) IV', 20, '21 - Medicine - Female', '2023-03-20 11:18:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(380, 'Ciprofloxacin', '500 mg  oral', 12, '9 - Surgery - Combined', '2023-01-18 11:26:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(381, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 18, '73 - Nephrology - Female', '2023-01-02 08:43:00', 'msd', 'other', 'Medicine Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(382, 'Ciprofloxacin', '500 mg  oral', 18, '36 - Pediatrics - Combined', '2023-01-18 11:27:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(383, 'Ciprofloxacin', '500 mg  oral', 100, '5 - Surgical Prof - Male', '2023-01-19 11:28:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(384, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, '7 - Surgical Prof - Female', '2023-01-02 08:43:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '003', ''),
(385, 'Ciprofloxacin', '500 mg  oral', 100, '16 - Medicine - Male', '2023-01-20 11:29:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(386, 'Ciprofloxacin', '500 mg  oral', 20, 'Adult ICU (CTC ICU)', '2023-01-20 11:29:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '003', '01'),
(387, 'Ciprofloxacin', '500 mg  oral', 10, '1 & 2 - Pediatrics - Combined', '2023-01-20 11:30:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(388, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, '21 - Medicine - Female', '2023-01-02 08:43:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(389, 'Ciprofloxacin', '500 mg  oral', 20, '46 & 47 - GU Surgery - Male', '2023-01-20 11:31:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(390, 'Ciprofloxacin', '250 mg  oral', 200, '28 - Oncology - Male', '2023-01-20 11:31:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '003', '01'),
(391, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 21, '34 - Medicine - Male', '2023-01-02 08:44:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(392, 'Ciprofloxacin', '500 mg  oral', 50, '37 - Neuro-Surgery - Male', '2023-01-21 11:32:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(393, 'Ciprofloxacin', '500 mg  oral', 12, '9 - Surgery - Combined', '2023-01-21 11:32:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(394, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 18, '28 - Oncology - Male', '2023-01-02 08:44:00', 'msd', 'other', 'Medicine Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(395, 'Ciprofloxacin', '500 mg  oral', 10, '1 & 2 - Pediatrics - Combined', '2023-01-22 11:33:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(396, 'Ciprofloxacin', '500 mg  oral', 20, '65 - Palliative', '2023-01-22 11:34:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '003', '01'),
(397, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '72 - Vascular Surgery - Combined', '2023-01-02 08:45:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(398, 'Ciprofloxacin', '500 mg  oral', 100, '37 - Neuro-Surgery - Male', '2023-01-23 11:34:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(399, 'Ciprofloxacin', '500 mg  oral', 20, '46 & 47 - GU Surgery - Male', '2023-01-23 11:35:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(400, 'Ciprofloxacin', '500 mg  oral', 20, '1 & 2 - Pediatrics - Combined', '2023-01-23 11:36:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(401, 'Ciprofloxacin', '500 mg  oral', 9, '36 - Pediatrics - Combined', '2023-01-23 11:38:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(402, 'Ciprofloxacin', '500 mg  oral', 100, '4 - Surgery - Male', '2023-01-24 11:39:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(403, 'Ciprofloxacin', '500 mg  oral', 9, '36 - Pediatrics - Combined', '2023-01-24 11:39:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(404, 'Ciprofloxacin', '500 mg  oral', 100, '8 - Neuro-Surgery - Female', '2023-01-24 11:40:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(405, 'Ciprofloxacin', '500 mg  oral', 100, '3 - Surgical Prof - Female', '2023-01-24 11:41:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(406, 'Ciprofloxacin', '500 mg  oral', 20, '10 - Surgery', '2023-01-25 11:41:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(407, 'Ciprofloxacin', '500 mg  oral', 20, '46 & 47 - GU Surgery - Male', '2023-01-26 11:42:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(408, 'Ciprofloxacin', '500 mg  oral', 9, '36 - Pediatrics - Combined', '2023-01-26 11:42:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(409, 'Ciprofloxacin', '500 mg  oral', 20, '1 & 2 - Pediatrics - Combined', '2023-01-27 11:43:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(410, 'Ciprofloxacin', '500 mg  oral', 100, 'Adult ICU (CTC ICU)', '2023-01-30 11:43:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '003', '01'),
(411, 'Ciprofloxacin', '500 mg  oral', 9, '36 - Pediatrics - Combined', '2023-01-31 11:44:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(412, 'Ciprofloxacin', '500 mg  oral', 20, '1 & 2 - Pediatrics - Combined', '2023-01-31 11:44:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(413, 'Ciprofloxacin', '500 mg  oral', 200, '28 - Oncology - Male', '2023-02-01 11:45:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '003', '01'),
(414, 'Ciprofloxacin', '500 mg  oral', 12, '9 - Surgery - Combined', '2023-02-01 11:46:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(415, 'Ciprofloxacin', '500 mg  oral', 12, '9 - Surgery - Combined', '2023-02-02 11:50:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(416, 'Ciprofloxacin', '500 mg  oral', 100, 'Adult ICU (ETC ICU)', '2023-02-02 11:51:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '003', '01'),
(417, 'Ciprofloxacin', '500 mg  oral', 12, '9 - Surgery - Combined', '2023-02-03 11:51:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(418, 'Ciprofloxacin', '500 mg  oral', 100, '7 - Surgical Prof - Female', '2023-02-06 11:52:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(419, 'Ciprofloxacin', '500 mg  oral', 200, '28 - Oncology - Male', '2023-02-06 11:53:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '003', '01'),
(420, 'Ciprofloxacin', '500 mg  oral', 100, '58 - Emergency/ETC - Male', '2023-02-06 11:53:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(421, 'Ciprofloxacin', '500 mg  oral', 20, '35 - Medicine - Female', '2023-02-06 11:55:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(422, 'Ciprofloxacin', '500 mg  oral', 100, '19 - Medicine - Male', '2023-02-07 11:56:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(423, 'Ciprofloxacin', '500 mg  oral', 100, '19 - Medicine - Male', '2023-02-07 11:56:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(424, 'Ciprofloxacin', '500 mg  oral', 100, '19 - Medicine - Male', '2023-02-07 11:57:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(425, 'Ciprofloxacin', '500 mg  oral', 4, '9 - Surgery - Combined', '2023-02-09 11:58:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(426, 'Ciprofloxacin', '500 mg  oral', 12, '9 - Surgery - Combined', '2023-02-09 11:58:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(427, 'Ciprofloxacin', '500 mg  oral', 20, '9 - Surgery - Combined', '2023-02-09 11:59:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(428, 'Ciprofloxacin', '500 mg  oral', 100, '6 - Surgery - Combined', '2023-02-09 11:59:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(429, 'Ciprofloxacin', '500 mg  oral', 20, '24 - Neurology - Combined', '2023-02-09 12:00:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '003', '01'),
(430, 'Ciprofloxacin', '500 mg  oral', 20, '46 & 47 - GU Surgery - Male', '2023-02-10 12:01:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(431, 'Ciprofloxacin', '500 mg  oral', 100, 'Adult ICU (ETC ICU)', '2023-02-10 12:02:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '003', '01'),
(432, 'Ciprofloxacin', '500 mg  oral', 10, '46 & 47 - GU Surgery - Male', '2023-02-11 12:02:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(433, 'Ciprofloxacin', '500 mg  oral', 100, '12 - Medicine Prof - Male', '2023-02-11 12:03:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(434, 'Ciprofloxacin', '500 mg  oral', 30, '46 & 47 - GU Surgery - Male', '2023-02-12 12:03:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(435, 'Ciprofloxacin', '500 mg  oral', 20, '65 - Palliative', '2023-02-13 12:04:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '003', '01'),
(436, 'Ciprofloxacin', '500 mg  oral', 100, 'Adult ICU (CTC ICU)', '2023-02-13 12:04:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '003', '01'),
(437, 'Ciprofloxacin', '500 mg  oral', 10, '46 & 47 - GU Surgery - Male', '2023-02-14 12:05:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(438, 'Ciprofloxacin', '500 mg  oral', 200, '28 - Oncology - Male', '2023-02-14 12:05:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '003', '01'),
(439, 'Ciprofloxacin', '500 mg  oral', 12, '9 - Surgery - Combined', '2023-02-15 12:06:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(440, 'Ciprofloxacin', '500 mg  oral', 20, '1 & 2 - Pediatrics - Combined', '2023-02-15 12:06:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(441, 'Ciprofloxacin', '500 mg  oral', 10, '30 - ENT - Male', '2023-02-15 12:07:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(442, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 24, '34 - Medicine - Male', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(443, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '10 - Surgery', '2023-01-03 08:46:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '003', ''),
(444, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '35 - Medicine - Female', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(445, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 3, '19 - Medicine - Male', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(446, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 10, '70 - Nephrology', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(447, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 6, '9 - Surgery - Combined', '2023-01-02 08:46:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '003', ''),
(448, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 6, '15 - Medicine - Female', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(449, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, '1 & 2 - Pediatrics - Combined', '2023-01-03 08:46:00', 'msd', 'other', 'Pediatrics', 'Watch', 'h.g.m.nihari868', '003', ''),
(450, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '34 - Medicine - Male', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(451, 'Ceftriaxone', '1g (1000mg) IV', 12, 'Adult ICU (ETC ICU)', '2023-06-30 14:01:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '003', '01'),
(452, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '8 - Neuro-Surgery - Female', '2023-01-03 08:46:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(453, 'Ceftriaxone', '1g (1000mg) IV', 12, '9 - Surgery - Combined', '2023-06-30 14:02:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(454, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '46 & 47 - GU Surgery - Male', '2023-01-03 08:46:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(455, 'Ceftriaxone', '1g (1000mg) IV', 6, '20 - Orthopedic - Female', '2023-06-30 14:03:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(456, 'Ceftriaxone', '1g (1000mg) IV', 12, '46 & 47 - GU Surgery - Male', '2023-06-30 14:03:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(457, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 27, '28 - Oncology - Male', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(458, 'Ceftriaxone', '1g (1000mg) IV', 6, '24 - Neurology - Combined', '2023-06-30 14:04:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '003', '01'),
(459, 'Ceftriaxone', '1g (1000mg) IV', 12, '5 - Surgical Prof - Male', '2023-06-30 14:04:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(460, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '15 - Medicine - Female', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(461, 'Ceftriaxone', '1g (1000mg) IV', 16, '37 - Neuro-Surgery - Male', '2023-06-30 14:05:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(462, 'Ceftriaxone', '1g (1000mg) IV', 18, '19 - Medicine - Male', '2023-06-30 14:05:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(463, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '73 - Nephrology - Female', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(464, 'Ceftriaxone', '1g (1000mg) IV', 32, '34 - Medicine - Male', '2023-06-30 14:06:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(465, 'Ceftriaxone', '1g (1000mg) IV', 6, '46 & 47 - GU Surgery - Male', '2023-06-30 14:06:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(466, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, '14 - Medicine - Male', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(467, 'Ceftriaxone', '1g (1000mg) IV', 3, '1 & 2 - Pediatrics - Combined', '2023-06-30 14:07:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(468, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '35 - Medicine - Female', '2023-01-03 08:46:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(469, 'Ceftriaxone', '1g (1000mg) IV', 12, '35 - Medicine - Female', '2023-06-30 14:08:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(470, 'Ceftriaxone', '1g (1000mg) IV', 20, '58 - Emergency/ETC - Male', '2023-06-30 14:08:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(471, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '46 & 47 - GU Surgery - Male', '2023-01-03 08:46:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(472, 'Ceftriaxone', '1g (1000mg) IV', 6, '7 - Surgical Prof - Female', '2023-06-30 14:09:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(473, 'Ceftriaxone', '1g (1000mg) IV', 30, '16 - Medicine - Male', '2023-06-30 14:09:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(474, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, '11 - Medicine Prof - Female', '2023-01-04 08:47:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(475, 'Ceftriaxone', '1g (1000mg) IV', 12, '5 - Surgical Prof - Male', '2023-06-30 14:10:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(476, 'Ceftriaxone', '1g (1000mg) IV', 13, '3 - Surgical Prof - Female', '2023-06-30 14:10:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(477, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 12, '5 - Surgical Prof - Male', '2023-01-04 08:47:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '003', ''),
(478, 'Ceftriaxone', '1g (1000mg) IV', 8, '8 - Neuro-Surgery - Female', '2023-06-30 14:11:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(479, 'Ceftriaxone', '1g (1000mg) IV', 6, '46 & 47 - GU Surgery - Male', '2023-06-30 14:11:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(480, 'Ceftriaxone', '1g (1000mg) IV', 2, '4 - Surgery - Male', '2023-06-30 14:12:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(481, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '35 - Medicine - Female', '2023-01-04 08:47:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(482, 'Ceftriaxone', '1g (1000mg) IV', 8, 'Adult ICU (ETC ICU)', '2023-06-30 14:13:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '003', '01'),
(483, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '30 - ENT - Male', '2023-01-04 08:47:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(484, 'Ceftriaxone', '1g (1000mg) IV', 16, '14 - Medicine - Male', '2023-06-30 14:14:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(485, 'Ceftriaxone', '1g (1000mg) IV', 14, '17 - Medicine - Female', '2023-06-29 14:14:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(486, 'Piperacillin/tazobactam', '4.5g (4500mg) IV', 9, '12 - Medicine Prof - Male', '2023-01-04 08:47:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(487, 'Ceftriaxone', '1g (1000mg) IV', 29, '14 - Medicine - Male', '2023-06-29 14:15:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(488, 'Ceftriaxone', '1g (1000mg) IV', 28, '34 - Medicine - Male', '2023-06-29 14:15:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(489, 'Ceftriaxone', '1g (1000mg) IV', 38, '15 - Medicine - Female', '2023-06-29 14:16:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(490, 'Ceftriaxone', '1g (1000mg) IV', 12, '9 - Surgery - Combined', '2023-06-29 14:17:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(491, 'Ceftriaxone', '1g (1000mg) IV', 20, '58 - Emergency/ETC - Male', '2023-06-29 14:17:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(492, 'Ceftriaxone', '1g (1000mg) IV', 2, 'Adult ICU (CTC ICU)', '2023-06-29 14:18:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '003', '01'),
(493, 'Ceftriaxone', '1g (1000mg) IV', 12, '28 - Oncology - Male', '2023-06-29 14:19:00', 'msd', 'oral', 'Medicine Subspecialty', 'Watch', 'nishara255', '003', '01'),
(494, 'Ceftriaxone', '1g (1000mg) IV', 6, '48 - Onco-Surgery - Female', '2023-06-29 14:19:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(495, 'Ceftriaxone', '1g (1000mg) IV', 13, '35 - Medicine - Female', '2023-06-29 14:20:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(496, 'Ceftriaxone', '1g (1000mg) IV', 22, '16 - Medicine - Male', '2023-06-29 14:20:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(497, 'Ceftriaxone', '1g (1000mg) IV', 4, '1 & 2 - Pediatrics - Combined', '2023-06-29 14:21:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(498, 'Ceftriaxone', '1g (1000mg) IV', 13, '8 - Neuro-Surgery - Female', '2023-06-29 14:21:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(499, 'Ceftriaxone', '1g (1000mg) IV', 42, '19 - Medicine - Male', '2023-06-29 14:22:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(500, 'Ceftriaxone', '1g (1000mg) IV', 2, '9 - Surgery - Combined', '2023-06-29 14:22:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(501, 'Ceftriaxone', '1g (1000mg) IV', 47, '21 - Medicine - Female', '2023-06-29 14:23:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(502, 'Ceftriaxone', '1g (1000mg) IV', 4, 'Adult ICU (ETC ICU)', '2023-06-29 14:24:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '003', '01'),
(503, 'Ceftriaxone', '1g (1000mg) IV', 6, '7 - Surgical Prof - Female', '2023-06-29 14:24:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(504, 'Ceftriaxone', '1g (1000mg) IV', 50, '14 - Medicine - Male', '2023-06-28 14:25:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(505, 'Ceftriaxone', '1g (1000mg) IV', 33, '17 - Medicine - Female', '2023-06-28 14:26:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(506, 'Ceftriaxone', '1g (1000mg) IV', 6, '46 & 47 - GU Surgery - Male', '2023-06-28 14:26:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(507, 'Ceftriaxone', '1g (1000mg) IV', 6, 'Adult ICU (ETC ICU)', '2023-06-28 14:27:00', 'msd', 'oral', 'ICU', 'Watch', 'nishara255', '003', '01'),
(508, 'Ceftriaxone', '1g (1000mg) IV', 20, '12 - Medicine Prof - Male', '2023-06-28 14:27:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(509, 'Ceftriaxone', '1g (1000mg) IV', 16, '16 - Medicine - Male', '2023-06-28 14:28:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(510, 'Ceftriaxone', '1g (1000mg) IV', 24, '37 - Neuro-Surgery - Male', '2023-06-28 14:28:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(511, 'Ceftriaxone', '1g (1000mg) IV', 30, '34 - Medicine - Male', '2023-06-28 14:29:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(512, 'Ceftriaxone', '1g (1000mg) IV', 20, '58 - Emergency/ETC - Male', '2023-06-28 14:29:00', 'msd', 'oral', 'Surgery', 'Watch', 'nishara255', '003', '01'),
(513, 'Ceftriaxone', '1g (1000mg) IV', 27, '36 - Pediatrics - Combined', '2023-06-28 14:30:00', 'msd', 'oral', 'Pediatrics', 'Watch', 'nishara255', '003', '01'),
(514, 'Ceftriaxone', '1g (1000mg) IV', 32, '35 - Medicine - Female', '2023-06-28 14:30:00', 'msd', 'oral', 'Medicine', 'Watch', 'nishara255', '003', '01'),
(515, 'Ceftriaxone', '1g (1000mg) IV', 17, '8 - Neuro-Surgery - Female', '2023-06-28 14:31:00', 'msd', 'oral', 'Surgery Subspecialty', 'Watch', 'nishara255', '003', '01'),
(516, 'Clindamycin', '300 mg  Iv', 21, '5 - Surgical Prof - Male', '2023-02-01 19:21:00', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '01'),
(517, 'Clindamycin', '300 mg  Iv', 12, 'Adult ICU (ETC ICU)', '2023-02-01 19:22:00', 'msd', 'intravenous', 'ICU', 'Access', 'amandi1234', '001', '01'),
(518, 'Clindamycin', '300 mg  Iv', 12, 'Adult ICU (ETC ICU)', '2023-03-01 19:23:00', 'msd', 'intravenous', 'ICU', 'Access', 'amandi1234', '001', '01'),
(519, 'Clindamycin', '300 mg  Iv', 12, 'Adult ICU (ETC ICU)', '2023-04-01 19:25:00', 'msd', 'intravenous', 'ICU', 'Access', 'amandi1234', '001', '01'),
(520, 'Clindamycin', '300 mg  Iv', 12, '72 - Vascular Surgery - Combined', '2023-04-01 19:29:00', 'msd', 'intravenous', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '01'),
(521, 'Clindamycin', '300 mg  Iv', 12, '1 & 2 - Pediatrics - Combined', '2023-05-01 19:31:00', 'msd', 'intravenous', 'Pediatrics', 'Access', 'amandi1234', '001', '01'),
(522, 'Clindamycin', '300 mg  Iv', 8, 'Adult ICU (ETC ICU)', '2025-06-01 19:32:00', 'msd', 'intravenous', 'ICU', 'Access', 'amandi1234', '003', '01'),
(523, 'Clindamycin', '300 mg  Iv', 12, '5 - Surgical Prof - Male', '2023-06-01 19:36:00', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '01'),
(524, 'Clindamycin', '300 mg  Iv', 12, 'Adult ICU (ETC ICU)', '2023-07-01 19:37:00', 'msd', 'intravenous', 'ICU', 'Access', 'amandi1234', '001', '01'),
(525, 'Clindamycin', '300 mg  Iv', 5, '20 - Orthopedic - Female', '2023-07-01 19:39:00', 'msd', 'intravenous', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '002'),
(526, 'Clindamycin', '300 mg  Iv', 12, '72 - Vascular Surgery - Combined', '2023-07-01 19:41:00', 'msd', 'intravenous', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '002'),
(527, 'Clindamycin', '300 mg  Iv', 7, 'Adult ICU (ETC ICU)', '2025-06-10 19:42:49', 'msd', 'intravenous', 'ICU', 'Access', 'amandi1234', '003', '01'),
(528, 'Clindamycin', '300 mg  Iv', 9, '21 - Medicine - Female', '2025-06-10 19:43:23', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(529, 'Clindamycin', '300 mg  Iv', 24, '20 - Orthopedic - Female', '2025-06-10 19:44:12', 'msd', 'intravenous', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '01'),
(530, 'Clindamycin', '300 mg  Iv', 40, '60 - ETC Pead - Combined', '2025-06-10 19:45:16', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '01'),
(531, 'Clindamycin', '300 mg  Iv', 24, '17 - Medicine - Female', '2025-06-10 19:46:09', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(532, 'Clindamycin', '300 mg  Iv', 24, '46 & 47 - GU Surgery - Male', '2025-06-10 19:47:17', 'msd', 'oral', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '01'),
(533, 'Clindamycin', '300 mg  Iv', 10, 'Adult ICU (ETC ICU)', '2025-06-10 19:48:36', 'msd', 'intravenous', 'ICU', 'Access', 'amandi1234', '001', '01'),
(534, 'Clindamycin', '300 mg  Iv', 24, '28 - Oncology - Male', '2025-06-10 19:49:39', 'msd', 'oral', 'Medicine Subspecialty', 'Access', 'amandi1234', '001', '01'),
(535, 'Clindamycin', '300 mg  Iv', 24, '28 - Oncology - Male', '2025-06-10 19:51:56', 'msd', 'intravenous', 'Medicine Subspecialty', 'Access', 'amandi1234', '001', '01'),
(536, 'Clindamycin', '300 mg  Iv', 24, 'Adult ICU (ETC ICU)', '2025-06-10 19:53:03', 'msd', 'oral', 'ICU', 'Access', 'amandi1234', '001', '01'),
(537, 'Clindamycin', '300 mg  Iv', 24, '20 - Orthopedic - Female', '2025-06-10 19:53:33', 'msd', 'intravenous', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '01'),
(538, 'Clindamycin', '300 mg  Iv', 16, '21 - Medicine - Female', '2025-06-10 20:07:37', 'msd', 'oral', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(539, 'Clindamycin', '300 mg  Iv', 12, 'Children ICU (Pediatric ICU)', '2025-06-10 20:11:44', 'msd', 'intravenous', 'ICU', 'Access', 'amandi1234', '001', '01'),
(540, 'Clindamycin', '300 mg  Iv', 18, '5 - Surgical Prof - Male', '2025-06-10 20:12:16', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '01'),
(541, 'Clindamycin', '300 mg  Iv', 24, '9 - Surgery - Combined', '2025-06-10 20:16:49', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '01'),
(542, 'Clindamycin', '300 mg  Iv', 24, 'Adult ICU (CTC ICU)', '2025-06-10 20:18:10', 'msd', 'intravenous', 'ICU', 'Access', 'amandi1234', '001', '01'),
(543, 'Clindamycin', '300 mg  Iv', 16, '58 - Emergency/ETC - Male', '2025-06-10 20:20:36', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '01'),
(544, 'Clindamycin', '300 mg  Iv', 24, '28 - Oncology - Male', '2025-06-10 20:21:19', 'msd', 'intravenous', 'Medicine Subspecialty', 'Access', 'amandi1234', '001', '01'),
(545, 'Clindamycin', '300 mg  Iv', 24, '20 - Orthopedic - Female', '2025-06-10 20:21:59', 'msd', 'intravenous', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '01'),
(546, 'Clindamycin', '300 mg  Iv', 24, '37 - Neuro-Surgery - Male', '2025-06-10 20:22:28', 'msd', 'intravenous', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '01'),
(547, 'Clindamycin', '150 mg  oral', 24, '21 - Medicine - Female', '2025-06-10 20:23:02', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(548, 'Clindamycin', '300 mg  Iv', 24, '73 - Nephrology - Female', '2025-06-10 20:23:31', 'msd', 'intravenous', 'Medicine Subspecialty', 'Access', 'amandi1234', '001', '01'),
(549, 'Clindamycin', '300 mg  Iv', 12, '30 - ENT - Male', '2025-06-10 20:24:19', 'msd', 'intravenous', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '01'),
(550, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '1.2g (1200mg) IV', 1, '3 - Surgical Prof - Female', '2025-06-10 21:33:24', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '01'),
(551, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '0.51g (510mg) IV', 1, '3 - Surgical Prof - Female', '2023-03-02 21:33:00', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '01'),
(552, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '0.51g (510mg) IV', 1, '25 - Dermatology - Female', '2023-05-02 21:35:00', 'msd', 'intravenous', 'Medicine Subspecialty', 'Access', 'amandi1234', '001', '01'),
(553, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '0.51g (510mg) IV', 1, '1 & 2 - Pediatrics - Combined', '2023-06-02 21:36:00', 'msd', 'intravenous', 'Pediatrics', 'Access', 'amandi1234', '001', '01'),
(554, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '1.2g (1200mg) IV', 1, '36 - Pediatrics - Combined', '2025-06-10 21:46:54', 'msd', 'intravenous', 'Pediatrics', 'Access', 'amandi1234', '001', '01'),
(555, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '0.51g (510mg) IV', 2, '3 - Surgical Prof - Female', '2025-06-10 21:48:53', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '002'),
(556, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '1.2g (1200mg) IV', 2, '30 - ENT - Male', '2025-06-10 21:49:49', 'msd', 'intravenous', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '01'),
(557, 'Flucloxacillin', '500 mg IV', 12, '17 - Medicine - Female', '2025-06-11 20:19:05', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(558, 'Flucloxacillin', '500 mg IV', 1, '21 - Medicine - Female', '2025-06-11 20:20:22', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '02'),
(559, 'Flucloxacillin', '500 mg IV', 12, '12 - Medicine Prof - Male', '2025-06-11 20:26:20', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '02'),
(560, 'Flucloxacillin', '500 mg IV', 12, '34 - Medicine - Male', '2025-06-11 20:28:10', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '003', '01'),
(561, 'Flucloxacillin', '500 mg IV', 12, '16 - Medicine - Male', '2025-06-11 20:33:00', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '02'),
(562, 'Flucloxacillin', '500 mg IV', 21, '1 & 2 - Pediatrics - Combined', '2025-06-11 20:37:05', 'msd', 'intravenous', 'Pediatrics', 'Access', 'amandi1234', '001', '02'),
(563, 'Flucloxacillin', '500 mg IV', 50, '5 - Surgical Prof - Male', '2025-06-11 21:30:19', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '02'),
(564, 'Flucloxacillin', '500 mg IV', 12, '34 - Medicine - Male', '2025-06-11 21:31:21', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(565, 'Flucloxacillin', '500 mg IV', 12, '14 - Medicine - Male', '2025-06-11 21:32:01', 'msd', 'oral', 'Medicine', 'Access', 'amandi1234', '003', '1'),
(566, 'Flucloxacillin', '500 mg IV', 12, '11 - Medicine Prof - Female', '2025-06-11 21:34:16', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '02'),
(567, 'Flucloxacillin', '500 mg IV', 11, '14 - Medicine - Male', '2025-06-11 21:34:51', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '003', '01'),
(568, 'Flucloxacillin', '500 mg IV', 12, '22 - Orthopedic - Male', '2025-06-11 21:35:12', 'msd', 'intravenous', 'Surgery Subspecialty', 'Access', 'amandi1234', '001', '02'),
(569, 'Flucloxacillin', '500 mg IV', 13, '35 - Medicine - Female', '2025-06-11 21:35:41', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(570, 'Flucloxacillin', '500 mg IV', 12, '70 - Nephrology', '2025-06-11 21:43:04', 'msd', 'intravenous', 'Medicine Subspecialty', 'Access', 'amandi1234', '001', '01'),
(571, 'Flucloxacillin', '500 mg IV', 2, '17 - Medicine - Female', '2025-06-11 21:44:06', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(572, 'Flucloxacillin', '500 mg IV', 50, '6 - Surgery - Combined', '2025-06-11 21:45:39', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '01'),
(573, 'Flucloxacillin', '500 mg IV', 20, '70 - Nephrology', '2025-06-11 21:46:33', 'msd', 'oral', 'Medicine Subspecialty', 'Access', 'amandi1234', '001', '01'),
(574, 'Flucloxacillin', '500 mg IV', 12, '12 - Medicine Prof - Male', '2025-06-11 21:47:54', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '003', '02'),
(575, 'Flucloxacillin', '500 mg IV', 12, '34 - Medicine - Male', '2025-06-11 21:56:14', 'msd', 'oral', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(576, 'Flucloxacillin', '500 mg IV', 20, '70 - Nephrology', '2025-06-11 21:57:22', 'msd', 'oral', 'Medicine Subspecialty', 'Access', 'amandi1234', '001', '01'),
(577, 'Flucloxacillin', '500 mg IV', 8, '5 - Surgical Prof - Male', '2025-05-01 21:58:00', 'msd', 'intravenous', 'Surgery', 'Access', 'amandi1234', '001', '02'),
(578, 'Flucloxacillin', '500 mg IV', 12, '14 - Medicine - Male', '2025-05-02 21:58:00', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(579, 'Flucloxacillin', '500 mg IV', 12, '17 - Medicine - Female', '2025-05-02 22:01:00', 'msd', 'intravenous', 'Medicine', 'Access', 'amandi1234', '001', '01'),
(580, 'Teicoplanin', '400 mg IV', 6, '6 - Surgery - Combined', '2023-03-05 09:52:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '003', ''),
(581, 'Teicoplanin', '400 mg IV', 3, '6 - Surgery - Combined', '2023-03-11 09:52:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '003', ''),
(582, 'Teicoplanin', '400 mg IV', 3, '6 - Surgery - Combined', '2023-03-17 09:52:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '003', ''),
(583, 'Teicoplanin', '400 mg IV', 9, '20 - Orthopedic - Female', '2023-03-17 09:52:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(584, 'Teicoplanin', '400 mg IV', 3, '6 - Surgery - Combined', '2023-03-14 09:52:00', 'msd', 'other', 'Surgery', 'Watch', 'h.g.m.nihari868', '003', ''),
(585, 'Teicoplanin', '400 mg IV', 6, '20 - Orthopedic - Female', '2023-03-22 09:53:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(586, 'Teicoplanin', '400 mg IV', 3, '20 - Orthopedic - Female', '2023-03-22 09:53:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(587, 'Teicoplanin', '400 mg IV', 3, '15 - Medicine - Female', '2023-03-23 09:53:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(588, 'Teicoplanin', '400 mg IV', 3, '15 - Medicine - Female', '2023-03-26 09:53:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(589, 'Teicoplanin', '400 mg IV', 6, '15 - Medicine - Female', '2023-03-29 09:53:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(590, 'Teicoplanin', '400 mg IV', 6, '16 - Medicine - Male', '2023-03-31 09:53:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(591, 'Teicoplanin', '400 mg IV', 9, '20 - Orthopedic - Female', '2023-04-02 09:53:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(592, 'Teicoplanin', '400 mg IV', 3, '22 - Orthopedic - Male', '0023-04-22 09:53:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(593, 'Teicoplanin', '400 mg IV', 6, '16 - Medicine - Male', '2023-04-03 09:54:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(594, 'Teicoplanin', '400 mg IV', 6, '16 - Medicine - Male', '2023-04-06 09:54:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(595, 'Teicoplanin', '400 mg IV', 6, '16 - Medicine - Male', '2023-04-09 09:54:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(596, 'Teicoplanin', '400 mg IV', 6, '16 - Medicine - Male', '2023-04-13 09:54:00', 'msd', 'other', 'Medicine', 'Watch', 'h.g.m.nihari868', '003', ''),
(597, 'Teicoplanin', '400 mg IV', 1, '22 - Orthopedic - Male', '2023-04-19 09:54:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(598, 'Teicoplanin', '400 mg IV', 3, '20 - Orthopedic - Female', '2023-05-14 09:55:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(599, 'Teicoplanin', '400 mg IV', 6, '22 - Orthopedic - Male', '2023-05-14 09:55:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(600, 'Teicoplanin', '400 mg IV', 1, '20 - Orthopedic - Female', '2023-05-17 09:55:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(601, 'Teicoplanin', '400 mg IV', 1, '20 - Orthopedic - Female', '2023-05-20 09:55:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(602, 'Teicoplanin', '400 mg IV', 2, '20 - Orthopedic - Female', '2023-05-22 09:55:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(603, 'Teicoplanin', '400 mg IV', 1, '22 - Orthopedic - Male', '2023-05-22 09:55:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(604, 'Teicoplanin', '400 mg IV', 6, '22 - Orthopedic - Male', '2023-05-29 09:56:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(605, 'Teicoplanin', '400 mg IV', 3, '22 - Orthopedic - Male', '2023-05-29 09:56:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(606, 'Teicoplanin', '400 mg IV', 3, '22 - Orthopedic - Male', '2023-05-29 09:56:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(607, 'Teicoplanin', '400 mg IV', 1, '20 - Orthopedic - Female', '2023-05-30 09:56:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(608, 'Teicoplanin', '400 mg IV', 3, '20 - Orthopedic - Female', '2023-06-12 09:56:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(609, 'Teicoplanin', '400 mg IV', 6, '20 - Orthopedic - Female', '2023-06-13 09:56:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(610, 'Teicoplanin', '400 mg IV', 1, '20 - Orthopedic - Female', '2023-06-13 09:56:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(611, 'Teicoplanin', '400 mg IV', 12, '20 - Orthopedic - Female', '2023-06-05 09:57:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(612, 'Teicoplanin', '400 mg IV', 1, '20 - Orthopedic - Female', '2023-06-27 09:57:00', 'msd', 'other', 'Surgery Subspecialty', 'Watch', 'h.g.m.nihari868', '003', ''),
(613, 'Gentamicin', '80 mg/2 ml IV', 10, '58 - Emergency/ETC - Male', '2023-01-23 11:16:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(614, 'Gentamicin', '80 mg/2 ml IV', 10, '58 - Emergency/ETC - Male', '2023-01-25 23:18:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(615, 'Gentamicin', '80 mg/2 ml IV', 10, '58 - Emergency/ETC - Male', '2023-01-27 23:20:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(616, 'Gentamicin', '80 mg/2 ml IV', 10, '58 - Emergency/ETC - Male', '2023-03-23 23:21:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(617, 'Gentamicin', '80 mg/2 ml IV', 5, '58 - Emergency/ETC - Male', '2023-06-02 23:23:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(618, 'Gentamicin', '80 mg/2 ml IV', 5, '58 - Emergency/ETC - Male', '2023-08-02 23:24:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(619, 'Gentamicin', '80 mg/2 ml IV', 10, '58 - Emergency/ETC - Male', '2023-09-02 11:25:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(620, 'Gentamicin', '80 mg/2 ml IV', 10, 'Adult ICU (Onco ICU)', '2023-10-02 11:26:00', 'msd', 'oral', 'ICU', 'Access', 'vgtharindu893', '001', '01'),
(621, 'Gentamicin', '80 mg/2 ml IV', 10, '58 - Emergency/ETC - Male', '2023-12-02 23:29:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(622, 'Clofazimine', '100 mg  oral', 200, '1 & 2 - Pediatrics - Combined', '2025-06-15 17:15:48', 'msd', 'oral', 'Pediatrics', 'Other', 'user299', '001', '1'),
(623, 'Clofazimine', '100 mg  oral', 400, '1 & 2 - Pediatrics - Combined', '2025-06-15 17:16:49', 'msd', 'oral', 'Pediatrics', 'Other', 'user299', '001', '1'),
(624, 'Clofazimine', '100 mg  oral', 800, '1 & 2 - Pediatrics - Combined', '2025-06-15 17:17:44', 'msd', 'oral', 'Pediatrics', 'Other', 'user299', '001', '1'),
(625, 'Gentamicin', '80 mg/2 ml IV', 10, '58 - Emergency/ETC - Male', '2023-02-13 08:05:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(626, 'Gentamicin', '80 mg/2 ml IV', 10, '58 - Emergency/ETC - Male', '2023-02-16 08:06:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(627, 'Gentamicin', '80 mg/2 ml IV', 10, '58 - Emergency/ETC - Male', '2023-02-19 08:07:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(628, 'Gentamicin', '80 mg/2 ml IV', 10, '9 - Surgery - Combined', '2023-02-20 08:34:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(629, 'Gentamicin', '80 mg/2 ml IV', 10, '5 - Surgical Prof - Male', '2023-02-21 20:35:00', 'msd', 'oral', 'Surgery', 'Access', 'vgtharindu893', '001', '01'),
(630, 'Amikacin', '500 mg IV', 100, '1 & 2 - Pediatrics - Combined', '2025-06-18 18:02:27', 'msd', 'oral', 'Pediatrics', 'Watch', 'user299', '003', '1');
INSERT INTO `releases` (`id`, `antibiotic_name`, `dosage`, `item_count`, `ward_name`, `release_time`, `type`, `ant_type`, `ward_category`, `category`, `system_name`, `book_number`, `page_number`) VALUES
(631, 'Amikacin', '500 mg IV', 10, '1 & 2 - Pediatrics - Combined', '2025-06-18 18:03:46', 'msd', 'oral', 'Pediatrics', 'Watch', 'user299', '003', '1'),
(632, 'Amikacin', '500 mg IV', 10, '1 & 2 - Pediatrics - Combined', '2025-06-18 18:03:46', 'msd', 'oral', 'Pediatrics', 'Watch', 'user299', '003', '1'),
(633, 'Amikacin', '500 mg IV', 10, '1 & 2 - Pediatrics - Combined', '2025-06-18 18:05:25', 'msd', 'oral', 'Pediatrics', 'Watch', 'user299', '003', '1'),
(634, 'Amoxicillin', '250 mg Oral', 100, '12 - Medicine Prof - Male', '2025-06-18 18:25:43', 'msd', 'topical', 'Medicine', 'Access', 'user299', '003', '10');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `antibiotic_name` varchar(255) NOT NULL,
  `dosage` varchar(100) NOT NULL,
  `item_count` int(11) NOT NULL,
  `return_time` datetime NOT NULL,
  `ward_name` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `ant_type` varchar(50) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `book_number` varchar(100) DEFAULT NULL,
  `page_number` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `antibiotic_name`, `dosage`, `item_count`, `return_time`, `ward_name`, `type`, `ant_type`, `category`, `system_name`, `book_number`, `page_number`, `created_at`) VALUES
(1, 'Amikacin', '500 mg IV', 10, '2025-05-25 15:13:47', '1 & 2 - Pediatrics - Combined', 'msd', 'intravenous', NULL, 'user200', '2', '1', '2025-05-25 09:43:47'),
(2, 'Amoxicillin', '500 mg Oral', 200, '2025-05-26 18:49:57', '12 - Medicine Prof - Male', 'msd', 'oral', 'Access', NULL, '001', '01', '2025-05-26 13:19:57'),
(3, 'Amikacin', '500 mg IV', 100, '2025-06-02 10:43:00', '3 - Surgical Prof - Female', 'msd', 'oral', 'Watch', 'malith452', '001', '01', '2025-06-03 05:13:17'),
(4, 'Amoxicillin', '250 mg Oral', 100, '2025-06-04 10:06:44', '1 & 2 - Pediatrics - Combined', 'msd', 'oral', 'Access', NULL, '001', '09', '2025-06-04 04:36:44'),
(5, 'Clarithromycin', '250 mg  oral', 200, '2025-06-04 10:07:44', '4 - Surgery - Male', 'lp', 'intravenous', 'Access', NULL, '001', '10', '2025-06-04 04:37:44'),
(6, 'Amikacin', '500 mg IV', 100, '2025-06-04 10:09:31', '6 - Surgery - Combined', 'msd', 'oral', 'Watch', NULL, '001', '10', '2025-06-04 04:39:31'),
(7, 'Amoxicillin', '500 mg Oral', 100, '2025-06-04 10:10:19', '1 & 2 - Pediatrics - Combined', 'msd', 'oral', 'Access', NULL, '001', '11', '2025-06-04 04:40:19'),
(8, 'Benzathine penicillin', '1.2 million units IV', 100, '2025-06-04 10:12:56', '20 - Orthopedic - Female', 'msd', 'topical', 'Access', NULL, '001', '11', '2025-06-04 04:42:56'),
(9, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '0.51g (510mg) IV', 100, '2025-06-04 10:20:26', '5 - Surgical Prof - Male', 'msd', 'oral', 'Access', NULL, '001', '14', '2025-06-04 04:50:26'),
(10, 'Cefalexin', '125 mg (dispersible tab.) Oral', 100, '2025-06-04 10:25:25', '4 - Surgery - Male', 'msd', 'topical', 'Access', NULL, '001', '15', '2025-06-04 04:55:25'),
(11, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '0.51g (510mg) IV', 100, '2025-06-04 10:26:04', '3 - Surgical Prof - Female', 'msd', 'topical', 'Access', NULL, '001', '14', '2025-06-04 04:56:04'),
(12, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '1.2g (1200mg) IV', 100, '2025-06-04 10:26:48', '4 - Surgery - Male', 'msd', 'topical', 'Access', NULL, '001', '15', '2025-06-04 04:56:48'),
(13, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '375 mg Oral', 100, '2025-06-04 10:28:16', '3 - Surgical Prof - Female', 'msd', 'oral', 'Access', NULL, '001', '15', '2025-06-04 04:58:16'),
(14, 'Amoxicillin', '125 mg/5 ml Syrup', 100, '2025-06-04 10:29:52', '3 - Surgical Prof - Female', 'msd', 'topical', 'Access', NULL, '001', '15', '2025-06-04 04:59:52'),
(15, 'Amoxicillin', '125 mg/5 ml Syrup', 100, '2025-06-04 10:30:55', '4 - Surgery - Male', 'msd', 'topical', 'Access', NULL, '001', '15', '2025-06-04 05:00:55'),
(16, 'Amoxicillin/clavulanic-acid (Co-amoxiclav)', '375 mg Oral', 100, '2025-06-04 10:31:52', '3 - Surgical Prof - Female', 'lp', 'topical', 'Access', NULL, '001', '15', '2025-06-04 05:01:52'),
(17, 'Cefalexin', '250 mg Oral', 100, '2025-06-04 10:40:36', '3 - Surgical Prof - Female', 'lp', 'oral', 'Access', NULL, '001', '17', '2025-06-04 05:10:36'),
(18, 'Cefalexin', '125 mg (dispersible tab.) Oral', 100, '2025-06-04 10:42:03', '4 - Surgery - Male', 'msd', 'oral', 'Access', NULL, '001', '17', '2025-06-04 05:12:03'),
(19, 'Cefalexin', '125 mg/5 ml Syrup', 100, '2025-06-04 10:43:13', '4 - Surgery - Male', 'msd', 'oral', 'Access', NULL, '001', '18', '2025-06-04 05:13:13'),
(20, 'Cefalexin', '125 mg/5 ml Syrup', 100, '2025-06-04 10:46:11', '3 - Surgical Prof - Female', 'msd', 'topical', 'Access', NULL, '001', '19', '2025-06-04 05:16:11'),
(21, 'Cefalexin', '125 mg/5 ml Syrup', 100, '2025-06-04 10:53:53', '1 & 2 - Pediatrics - Combined', 'lp', 'oral', 'Access', NULL, '001', '19', '2025-06-04 05:23:53'),
(22, 'Cefepime', '1g (1000mg) IV', 100, '2025-06-04 10:56:10', '3 - Surgical Prof - Female', 'msd', 'oral', 'Reserve', NULL, '001', '20', '2025-06-04 05:26:10'),
(23, 'Cefotaxime', '500 mg IV', 100, '2025-06-04 11:07:19', '18 - Psychiatry - Male', 'msd', 'topical', 'Watch', NULL, '001', '20', '2025-06-04 05:37:19'),
(24, 'Cefotaxime', '1g (1000mg) IV', 100, '2025-06-04 11:14:20', '3 - Surgical Prof - Female', 'msd', 'oral', 'Watch', NULL, '001', '21', '2025-06-04 05:44:20'),
(25, 'Ceftazidime', '1g (1000mg) IV', 100, '2025-06-04 11:16:10', '4 - Surgery - Male', 'lp', 'oral', 'Watch', NULL, '001', '21', '2025-06-04 05:46:10'),
(26, 'Ceftriaxone', '1g (1000mg) IV', 100, '2025-06-04 11:18:48', '3 - Surgical Prof - Female', 'lp', 'oral', 'Watch', NULL, '001', '21', '2025-06-04 05:48:48'),
(27, 'Ceftazidime', '1g (1000mg) IV', 100, '2025-06-04 11:21:18', '3 - Surgical Prof - Female', 'msd', 'oral', 'Watch', NULL, '001', '21', '2025-06-04 05:51:18'),
(28, 'Cefotaxime', '500 mg IV', 100, '2025-06-04 11:23:24', '3 - Surgical Prof - Female', 'msd', 'oral', 'Watch', NULL, '001', '21', '2025-06-04 05:53:24'),
(29, 'Ceftriaxone', '1g (1000mg) IV', 100, '2025-06-04 11:31:10', '3 - Surgical Prof - Female', 'msd', 'oral', 'Watch', NULL, '001', '22', '2025-06-04 06:01:10'),
(30, 'Sulbactam + Cefoperazone', '2g (2000mg) IV', 100, '2025-06-04 11:33:05', '3 - Surgical Prof - Female', 'msd', 'oral', 'Reserve', NULL, '001', '22', '2025-06-04 06:03:05'),
(31, 'Cefuroxime', '500 mg Oral', 100, '2025-06-04 11:35:05', '3 - Surgical Prof - Female', 'msd', 'oral', 'Access', NULL, '001', '22', '2025-06-04 06:05:05'),
(32, 'Flucloxacillin', '250 mg Oral', 100, '2025-06-04 12:22:02', '3 - Surgical Prof - Female', 'msd', 'oral', 'Access', NULL, '001', '23', '2025-06-04 06:52:02'),
(33, 'Amikacin', '500 mg IV', 100, '2025-06-04 20:43:32', '3 - Surgical Prof - Female', 'msd', 'oral', 'Watch', NULL, '3', '01', '2025-06-04 15:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stv_number` varchar(50) NOT NULL,
  `antibiotic_id` int(11) NOT NULL,
  `dosage_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stv_number`, `antibiotic_id`, `dosage_id`, `quantity`, `last_updated`) VALUES
('00102603', 1, 1, 99559, '2025-06-18 05:50:28'),
('00100103', 2, 5, 99500, '2025-06-04 07:41:37'),
('00100104', 2, 4, 99700, '2025-06-04 07:41:00'),
('00100904', 3, 6, 99795, '2025-06-10 09:18:53'),
('00100101', 2, 2, 99600, '2025-06-18 05:55:43'),
('00100102', 2, 3, 99500, '2025-06-04 07:38:40'),
('00100905', 3, 7, 99596, '2025-06-10 09:19:49'),
('00100903', 3, 10, 99500, '2025-06-04 07:43:16'),
('00100901', 3, 8, 99500, '2025-06-04 07:43:40'),
('00100902', 3, 9, 99400, '2025-06-04 07:42:53'),
('00100603', 4, 11, 99600, '2025-06-04 07:44:03'),
('00100601', 4, 12, 99600, '2025-06-04 07:44:24'),
('00100301', 6, 16, 99700, '2025-06-04 07:46:17'),
('00100201', 7, 17, 99500, '2025-06-04 07:46:36'),
('00101303', 8, 19, 99700, '2025-06-04 07:47:19'),
('00101302', 8, 20, 99800, '2025-06-04 07:47:52'),
('00101301', 8, 18, 99700, '2025-06-04 07:46:56'),
('00101902', 9, 21, 99600, '2025-06-04 07:48:19'),
('00101502', 11, 23, 98497, '2025-06-09 22:44:36'),
('00101503', 11, 24, 99700, '2025-06-04 07:49:38'),
('00101602', 12, 25, 99800, '2025-06-04 07:50:07'),
('00101704', 13, 26, 98937, '2025-06-10 01:56:50'),
('00101404', 52, 81, 99600, '2025-06-04 07:51:26'),
('00101403', 52, 79, 99600, '2025-06-04 07:51:05'),
('00101406', 52, 80, 99600, '2025-06-04 07:51:45'),
('00105403', 43, 61, 99600, '2025-06-04 07:53:21'),
('00105401', 43, 59, 99400, '2025-06-09 22:57:30'),
('00105402', 43, 60, 96708, '2025-06-09 23:33:23'),
('00103003', 44, 64, 99600, '2025-06-04 07:56:17'),
('00103001', 44, 62, 99800, '2025-06-04 07:54:47'),
('00102301', 48, 73, 99400, '2025-06-04 07:58:41'),
('00103002', 44, 65, 99600, '2025-06-04 07:54:26'),
('00103006', 44, 63, 99600, '2025-06-04 07:55:14'),
('00103201', 45, 66, 99576, '2025-06-10 07:53:02'),
('00103203', 45, 68, 99018, '2025-06-10 07:54:19'),
('00103202', 45, 67, 99600, '2025-06-04 07:57:02'),
('00105101', 46, 70, 98600, '2025-06-15 04:47:44'),
('00105103', 46, 69, 100000, '2025-05-31 08:56:43'),
('00103702', 47, 71, 100000, '2025-05-31 08:56:49'),
('00103703', 47, 72, 100000, '2025-05-31 08:56:57'),
('00102903', 49, 75, 99600, '2025-06-04 07:59:29'),
('00102901', 49, 74, 99400, '2025-06-04 07:59:08'),
('00100804', 22, 33, 99600, '2025-06-04 08:01:18'),
('00100805', 22, 31, 99500, '2025-06-04 08:00:32'),
('00100802', 22, 34, 99248, '2025-06-11 09:31:49'),
('00100801', 22, 32, 99600, '2025-06-04 08:00:58'),
('00102502', 23, 35, 99470, '2025-06-16 08:06:18'),
('00102001', 24, 36, 99600, '2025-06-04 08:02:15'),
('00105802', 25, 38, 99600, '2025-06-04 08:02:42'),
('00105801', 25, 37, 99600, '2025-06-04 08:03:36'),
('00108301', 26, 40, 99600, '2025-06-04 08:04:43'),
('00108302', 26, 39, 99600, '2025-06-04 08:04:05'),
('', 41, 57, 100000, '2025-05-31 09:01:03'),
('00102102', 27, 41, 99600, '2025-06-04 08:06:43'),
('00105201', 28, 44, 99400, '2025-06-04 08:09:37'),
('00105202', 28, 43, 99600, '2025-06-04 08:07:03'),
('00105203', 28, 42, 97374, '2025-06-09 21:03:24'),
('00105901', 29, 45, 99400, '2025-06-04 08:10:15'),
('00105601', 30, 46, 99600, '2025-06-04 08:10:33'),
('00105701', 31, 47, 99600, '2025-06-04 08:10:49'),
('00100402', 32, 48, 99600, '2025-06-04 08:11:07'),
('00101001', 33, 49, 99004, '2025-06-10 01:41:03'),
('00101102', 34, 50, 99600, '2025-06-04 08:11:52'),
('00103602', 35, 51, 99462, '2025-06-12 01:54:50'),
('00101202', 36, 52, 100000, '2025-05-31 09:03:42'),
('00102304', 37, 53, 99800, '2025-06-02 08:24:05'),
('00103502', 38, 54, 99600, '2025-06-04 08:12:51'),
('00103102', 53, 83, 1000, '2025-06-18 08:28:33'),
('00103101', 53, 82, 1000, '2025-06-18 08:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('pending','approved','disabled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT 'default.jpg',
  `system_name` varchar(100) DEFAULT NULL,
  `last_login` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nic`, `name`, `email`, `mobile`, `password`, `status`, `created_at`, `profile_picture`, `system_name`, `last_login`) VALUES
(1, '200202226299', 'user test', 'user@gmail.com', '712222222', '$2y$10$VsfVH9VG3RWyLRBulY6Tr.MKVEMzlUI16kzHTB22LySBaaLuoqJDW', 'approved', '2025-02-15 22:37:20', 'default.jpg', 'user299', '2025-06-20 09:34:28'),
(2, '200515813452', 'Malith Sandeepa', 'malith@gmail.com', '763279285', '$2y$10$XMW2bm/mLEe.bI8645I2B.a5nR10d0RgaNht8ml.v0PLxFxEwhGW2', 'approved', '2025-05-31 13:51:54', '684c0f0cbbca3-1.jpg', 'malith1081', '2025-06-17 13:25:33'),
(3, '200378711255', 'Nishara De Silva', 'nishara@gmail.com', '743397871', '$2y$10$Svk07u8dbkrG/sYyJsKnTubLodyUvpHTkMd7LC0j9tTlsox1DJCES', 'approved', '2025-06-02 14:13:18', '6847df3a45b27-WhatsApp Image 2025-06-10 at 13.00.54_a5511895.jpg', 'nishara255', '2025-06-18 18:47:54'),
(4, '200334400893', 'Tharindu Sampath', 'vgtharindu165@gmail.com', '772010733', '$2y$10$t7ItNlSx9AtpjR5BQ3KCuucL/lEkR8GxA8vjci4GdoETJ/SuGFhmO', 'approved', '2025-06-04 04:33:31', '684d224bee208-IMG-20231121-WA0160.jpg', 'vgtharindu893', '2025-06-18 20:55:08'),
(5, '200374300868', 'Matheesha Nihari', 'matheenihari13@gmail.com', '775751107', '$2y$10$ubp92Z21EhX2NVgQUwHpiOzD/2OqpYusIMBxLzSLQVdJiJJj.7uMa', 'disabled', '2025-06-07 11:12:41', '684ec27f3fb39-img.jpg', 'h.g.m.nihari868', '2025-06-15 18:22:05'),
(6, '200370912329', 'Amandi Kaushalya', 'amandi@gmail.com', '788167038', '$2y$10$il4oSNcDRwVxGClov5v/QuVTItGCtjcDnqPAJOP4fEL4/6gwp1LPi', 'approved', '2025-06-10 13:35:28', '6849af19d3bb4-67d53d2856fc3-amandi.jpg', 'amandi1234', '2025-06-11 20:16:09'),
(7, '200354711748', 'Ewni Akithma', 'ewniakithma@gmail.com', '772072026', '$2y$10$.gepJD/DhfJgY5A3DHKFvutUoIMIx3OqP6Z0y7vZdvNdDeqn24Vj2', 'approved', '2025-06-14 02:55:29', '684ec43435899-pic1.jpg', 'ewni748', '2025-06-16 05:51:28');

-- --------------------------------------------------------

--
-- Table structure for table `ward`
--

CREATE TABLE `ward` (
  `id` int(11) NOT NULL,
  `ward_name` varchar(100) NOT NULL,
  `team` varchar(255) NOT NULL,
  `managed_by` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ward`
--

INSERT INTO `ward` (`id`, `ward_name`, `team`, `managed_by`, `category`, `description`, `created_at`) VALUES
(1, '1 & 2 - Pediatrics - Combined', 'Team 1', 'Dr. Jayantha', 'Pediatrics', '', '2025-03-08 12:03:36'),
(3, '3 - Surgical Prof - Female', 'Team 2', 'N/A', 'Surgery', '', '2025-03-08 12:03:36'),
(4, '4 - Surgery - Male', 'Team 3', 'Dr. Nalitha Wijesundara', 'Surgery', '', '2025-03-08 12:03:36'),
(5, '5 - Surgical Prof - Male', 'Team 2', 'N/A', 'Surgery', '', '2025-03-08 12:03:36'),
(6, '6 - Surgery - Combined', 'Team 4', 'Dr. Sudheera Herath', 'Surgery', '', '2025-03-08 12:03:36'),
(7, '7 - Surgical Prof - Female', 'Team 2', 'N/A', 'Surgery', '', '2025-03-08 12:03:36'),
(8, '8 - Neuro-Surgery - Female', 'Team 5', 'Dr. Yohan Koralage, Dr. Nishantha Gunasekara', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(9, '9 - Surgery - Combined', 'Team 8', 'Dr. Seewali Thilakarathna', 'Surgery', '', '2025-03-08 12:03:36'),
(10, '10 - Surgery', 'Team 6', 'Dr. Lelwala', 'Surgery', '', '2025-03-08 12:03:36'),
(11, '11 - Medicine Prof - Female', 'Team 9', 'N/A', 'Medicine', '', '2025-03-08 12:03:36'),
(12, '12 - Medicine Prof - Male', 'Team 9', 'N/A', 'Medicine', '', '2025-03-08 12:03:36'),
(14, '14 - Medicine - Male', 'Team 10', 'Dr. P.A Jayasinghe', 'Medicine', '', '2025-03-08 12:03:36'),
(15, '15 - Medicine - Female', 'Team 10', 'N/A', 'Medicine', '', '2025-03-08 12:03:36'),
(16, '16 - Medicine - Male', 'Team 11', 'Dr. Uluwatta', 'Medicine', '', '2025-03-08 12:03:36'),
(17, '17 - Medicine - Female', 'Team 11', 'N/A', 'Medicine', '', '2025-03-08 12:03:36'),
(18, '18 - Psychiatry - Male', 'Team 12', 'Dr. Rubi Ruben', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(19, '19 - Medicine - Male', 'Team 13', 'Dr. Arosha Abeywickrama', 'Medicine', '', '2025-03-08 12:03:36'),
(20, '20 - Orthopedic - Female', 'Team 14', 'Dr. Harsha Mendis, Dr. Jayasekara', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(21, '21 - Medicine - Female', 'Team 13', 'N/A', 'Medicine', '', '2025-03-08 12:03:36'),
(22, '22 - Orthopedic - Male', 'Team 14', 'N/A', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(23, '23 - Psychiatry - Female', 'Team 12', 'N/A', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(24, '24 - Neurology - Combined', 'Team 15', 'Dr. Mohidin', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(25, '25 - Dermatology - Female', 'Team 17', 'Dr. Kapila, Dr. Binari', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(26, '26 - Oro-Maxillary Facial - Combined', 'Team 16', 'N/A', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(27, '27 - Dermatology - Male', 'Team 17', 'N/A', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(28, '28 - Oncology - Male', 'Team 18', 'Dr. Jayamini Horadugoda', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(29, '29 - Oncology - Female', 'Team 18', 'N/A', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(30, '30 - ENT - Male', 'Team 19', 'Dr. Welendawa, Dr. Wickramasinghe', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(31, '31 - ENT - Female', 'Team 19', 'N/A', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(32, '32 - Ophthalmology - Female', 'Team 20', 'Dr. Hemamali, Dr. Lalitha', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(33, '33 - Ophthalmology - Male', 'Team 20', 'N/A', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(34, '34 - Medicine - Male', 'Team 21', 'Dr. Krishantha Jayasekara', 'Medicine', '', '2025-03-08 12:03:36'),
(35, '35 - Medicine - Female', 'Team 21', 'N/A', 'Medicine', '', '2025-03-08 12:03:36'),
(36, '36 - Pediatrics - Combined', 'Team 22', 'Dr. Upeksha Liyanage, Dr. Jagath', 'Pediatrics', '', '2025-03-08 12:03:36'),
(37, '37 - Neuro-Surgery - Male', 'Team 5', 'Dr. Yohan Koralage, Dr. Nishantha Gunasekara', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(39, '39 & 40 - Cardiology', 'Team 23', 'Dr. Sadhanandan', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(41, '41, 42 & 43 - Maliban Rehabilitation', 'Team 24', 'N/A', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(44, '44 - Cardio-Thoracic - Female', 'Team 25', 'Dr. Namal', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(45, '45 - Cardio-Thoracic - Male', 'Team 25', 'N/A', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(46, '46 & 47 - GU Surgery - Male', 'Team 26', 'Dr. Sathis, Dr. Dimantha', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(48, '48 - Onco-Surgery - Female', 'Team 27', 'Dr. Mahaliyana', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(49, '49 - Onco-Surgery - Male', 'Team 27', 'N/A', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(50, '50 - Pediatric Oncology - Combined', 'Team 28', 'N/A', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(51, '51 & 52 - Pediatric Surgery', 'Team 29', 'Dr. Janath, Dr. Kasthuri', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(53, '53 - Ophthalmology - Male', 'Team 31', 'Dr. Dharmadasa', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(54, '54 - Ophthalmology - Female', 'Team 31', 'N/A', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(55, '55 - Rheumatology - Combined', 'Team 32', 'Dr. S.P Dissanayake, Dr. Kalum Deshapriya', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(58, '58 - Emergency/ETC - Male', 'Team 33', 'N/A', 'Surgery', '', '2025-03-08 12:03:36'),
(59, '59 - Emergency/ETC - Female', 'Team 33', 'N/A', 'Surgery', '', '2025-03-08 12:03:36'),
(60, '60 - ETC Pead - Combined', 'Team 34', 'N/A', 'Surgery', '', '2025-03-08 12:03:36'),
(61, '61 & 62 - Bhikku', 'Team 35', 'N/A', 'Medicine', '', '2025-03-08 12:03:36'),
(65, '65 - Palliative', 'Team 36', 'Dr. Mahaliyana', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(67, '67 - Stroke', 'Team 37', 'Dr. Mohondan', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(68, '68 & 69 - Respiratory', 'Team 38', 'N/A', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(70, '70 - Nephrology', 'Team 39', 'N/A', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(71, '71 - Nephrology - Male', 'Team 39', 'N/A', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(72, '72 - Vascular Surgery - Combined', 'Team 40', 'N/A', 'Surgery Subspecialty', '', '2025-03-08 12:03:36'),
(73, '73 - Nephrology - Female', 'Team 39', 'N/A', 'Medicine Subspecialty', '', '2025-03-08 12:03:36'),
(74, '9 (Surgery) - Combined', 'Team 8', 'Dr. Seewali thilakarathna', 'Surgery', '', '2025-03-17 15:35:55'),
(75, '38 (Neuro-Surgery)', 'Team 5', 'Dr. Yohan Koralage, Dr.Nishantha Gunasekara', 'Surgery Subspecialty', '', '2025-03-17 15:41:38'),
(76, 'Children ICU (Neonatal ICU)', 'No Data', 'No Data', 'ICU', '', '2025-03-17 16:24:00'),
(77, 'Children ICU (Pediatric ICU)', 'No Data', 'No Data', 'ICU', '', '2025-03-17 16:24:22'),
(78, 'Adult ICU (ETC ICU)', 'No Data', 'No Data', 'ICU', '', '2025-03-17 16:25:15'),
(79, 'Adult ICU (Main ICU)', 'No Data', 'No Data', 'ICU', '', '2025-03-17 16:25:34'),
(80, 'Adult ICU (CTC ICU)', 'No Data', 'No Data', 'ICU', '', '2025-03-17 16:26:12'),
(81, 'Adult ICU (Onco ICU)', 'No Data', 'No Data', 'ICU', '', '2025-03-17 16:26:26'),
(82, 'Adult ICU (NSU ICU)', 'No Data', 'No Data', 'ICU', '', '2025-03-17 16:26:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nic` (`nic`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `antibiotics`
--
ALTER TABLE `antibiotics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_transactions`
--
ALTER TABLE `book_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dosages`
--
ALTER TABLE `dosages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `antibiotic_id` (`antibiotic_id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `releases`
--
ALTER TABLE `releases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stv_number`),
  ADD KEY `antibiotic_id` (`antibiotic_id`),
  ADD KEY `dosage_id` (`dosage_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nic` (`nic`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ward`
--
ALTER TABLE `ward`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `antibiotics`
--
ALTER TABLE `antibiotics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `book_transactions`
--
ALTER TABLE `book_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dosages`
--
ALTER TABLE `dosages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `releases`
--
ALTER TABLE `releases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=635;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `ward`
--
ALTER TABLE `ward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosages`
--
ALTER TABLE `dosages`
  ADD CONSTRAINT `dosages_ibfk_1` FOREIGN KEY (`antibiotic_id`) REFERENCES `antibiotics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
