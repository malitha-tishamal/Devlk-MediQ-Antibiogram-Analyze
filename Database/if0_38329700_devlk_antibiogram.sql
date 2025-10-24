-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql113.infinityfree.com
-- Generation Time: Oct 24, 2025 at 02:16 AM
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
-- Database: `if0_38329700_devlk_antibiogram`
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
  `last_login` varchar(50) NOT NULL,
  `logout_time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `nic`, `name`, `email`, `mobile`, `password`, `status`, `created_at`, `profile_picture`, `last_login`, `logout_time`) VALUES
(1, '200202202615', 'Malitha Tishamal', 'admin.malithatishamal@gmail.com', '785530992', '$2y$10$V9liDmZmhbDgdhqF0MgVceklnuQe69XdTUQWWChSIv1tK0m6KEb1i', 'approved', '2025-02-10 12:21:20', '67d9756470279-411001152_1557287805017611_3900716309730349802_n.jpg', '2025-10-24 11:46:08', '2025-10-24 11:46:03'),
(4, '200315813452', 'Malith Sandeepa', 'admin.sandeepa@gmail.com', '763279285', '$2y$10$LOTgvaN3G4b10pJnp0Bf/u2s8dnNWTK3rGJwPYmSxDOtOJT36vxNC', 'approved', '2025-05-31 13:47:49', '684c0f6c943c6-1.jpg', '2025-10-23 21:09:01', ''),
(5, '200354711748', 'Ewni Akithma', 'admin.ewniakithma@gmail.com', '772072026', '$2y$10$4y8XH41IWFXC9CBsZv0fCOUvv0boc6o.9Ejsd8GT32r4jfE/5k65u', 'approved', '2025-06-14 03:12:12', '684ec318d719e-pic1.jpg', '2025-09-04 06:52:57', ''),
(6, '200334400893', 'Tharindu Sampath', 'admin.vgtharindu165@gmail.com', '772010733', '$2y$10$e3yU/.35yCf9ZbkWhUHm8u9IkKvyaO3ZuO/0K2ALLHa/JRWR.5asm', 'approved', '2025-06-14 07:33:21', '684d263313a40-IMG-20231121-WA0160.jpg', '2025-09-08 20:28:32', ''),
(14, '200370912329', 'Amandi Kaushalya', 'admin.kaushalya@gmail.com', '788167038', '$2y$10$shwt5S.ZLyz3l8VJd/XxOuzdxiQL.msKjTJSjm5.C/hc7vFNBk7dG', 'approved', '2025-06-15 12:39:47', '684ec063afdd7-6849af19d3bb4-67d53d2856fc3-amandi.jpg', '2025-07-11 10:09:49', ''),
(18, '199952310740', 'Harshani Madushika', 'admin.harshanimadushika@gmail.com', '746290490', '$2y$10$LsC2OnoT03f/Pg/y8/8VWuojCbIOp2dcVe4/s9JW1K6zkfqeNOw3O', 'approved', '2025-07-09 13:32:20', 'default.jpg', '2025-09-03 09:59:14', ''),
(19, '200374300868', 'Matheesha Nihari', 'admin.matheenihari13@gmail.com', '775751107', '$2y$10$BVWxMUrRaIHlp5ccezHhvuNR6aAJKNrZyDmWHgNPglljb/DDzMVtq', 'approved', '2025-07-11 08:07:42', 'default.jpg', '2025-09-05 23:05:54', ''),
(20, '200378711255', 'Nishara De Silva', 'admin.nishara@gmail.com', '743397871', '$2y$10$e2Xf1FEba6NwPp/Zw464.e0BVr5jfkM5vTl.FYDkV/kiGDGLmM8Oy', 'approved', '2025-09-05 14:34:02', 'default.jpg', '2025-10-19 21:55:51', '2025-10-19 21:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `antibiogram_data`
--

CREATE TABLE `antibiogram_data` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `organism` varchar(255) NOT NULL,
  `antibiotic` varchar(255) NOT NULL,
  `tested_count` int(11) NOT NULL,
  `susceptible_count` int(11) NOT NULL,
  `percentage` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antibiogram_reports`
--

CREATE TABLE `antibiogram_reports` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `original_filename` varchar(255) DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `pasted_data` text DEFAULT NULL,
  `infection_type_filter` varchar(50) DEFAULT NULL,
  `hospital_filter` varchar(100) DEFAULT NULL,
  `organism_group_filter` varchar(100) DEFAULT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Table structure for table `organism_groups`
--

CREATE TABLE `organism_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `group_type` enum('gram_negative','gram_positive') NOT NULL,
  `organism_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `organism_groups`
--

INSERT INTO `organism_groups` (`id`, `group_name`, `group_type`, `organism_name`, `created_at`) VALUES
(1, 'All Gram-negative bacteria', 'gram_negative', 'ACINETOBACTER SPP', '2025-10-24 04:59:23'),
(2, 'All Gram-negative bacteria', 'gram_negative', 'AEROMONAS HYDROPHILA', '2025-10-24 04:59:23'),
(3, 'All Gram-negative bacteria', 'gram_negative', 'BURKHOLDERIA CEPACIA', '2025-10-24 04:59:23'),
(4, 'All Gram-negative bacteria', 'gram_negative', 'BURKHOLDERIA PSEUDOMALLEI', '2025-10-24 04:59:23'),
(5, 'All Gram-negative bacteria', 'gram_negative', 'CITROBACTOR KOSERI', '2025-10-24 04:59:23'),
(6, 'All Gram-negative bacteria', 'gram_negative', 'ENTEROBACTER CLOACAE', '2025-10-24 04:59:23'),
(7, 'All Gram-negative bacteria', 'gram_negative', 'ESCHERICHIA COLI', '2025-10-24 04:59:23'),
(8, 'All Gram-negative bacteria', 'gram_negative', 'ESCHERICHIA COLI 1', '2025-10-24 04:59:23'),
(9, 'All Gram-negative bacteria', 'gram_negative', 'FLAVOBACTERIUM SPP', '2025-10-24 04:59:23'),
(10, 'All Gram-negative bacteria', 'gram_negative', 'HAEMOPHILUS INFLUENZAE', '2025-10-24 04:59:23'),
(11, 'All Gram-negative bacteria', 'gram_negative', 'HAEMOPHILUS INFLUENZAE TYPE B', '2025-10-24 04:59:23'),
(12, 'All Gram-negative bacteria', 'gram_negative', 'KLEBSIELLA SPP', '2025-10-24 04:59:23'),
(13, 'All Gram-negative bacteria', 'gram_negative', 'KLEBSIE+T98:T131LLA SPP', '2025-10-24 04:59:23'),
(14, 'All Gram-negative bacteria', 'gram_negative', 'KLEBSIELLS SPP', '2025-10-24 04:59:23'),
(15, 'All Gram-negative bacteria', 'gram_negative', 'KLEBSIELLA SPP.', '2025-10-24 04:59:23'),
(16, 'All Gram-negative bacteria', 'gram_negative', 'MORGANELLA MORGANII', '2025-10-24 04:59:23'),
(17, 'All Gram-negative bacteria', 'gram_negative', 'MYROIDES SPP.', '2025-10-24 04:59:23'),
(18, 'All Gram-negative bacteria', 'gram_negative', 'OCHROMOBACTRUM ANTHROPI', '2025-10-24 04:59:23'),
(19, 'All Gram-negative bacteria', 'gram_negative', 'PROTEUS SPP', '2025-10-24 04:59:23'),
(20, 'All Gram-negative bacteria', 'gram_negative', 'PROTEUS SPP.', '2025-10-24 04:59:23'),
(21, 'All Gram-negative bacteria', 'gram_negative', 'PROVIDENCIA SPP', '2025-10-24 04:59:23'),
(22, 'All Gram-negative bacteria', 'gram_negative', 'PSEUDOMONAS AERUGINOSA', '2025-10-24 04:59:23'),
(23, 'All Gram-negative bacteria', 'gram_negative', 'PSEUDOMONAS STUTZERI', '2025-10-24 04:59:23'),
(24, 'All Gram-negative bacteria', 'gram_negative', 'PSEUDOMONAS SPP.', '2025-10-24 04:59:23'),
(25, 'All Gram-negative bacteria', 'gram_negative', 'SALMONELLA SPP', '2025-10-24 04:59:23'),
(26, 'All Gram-negative bacteria', 'gram_negative', 'SALMONELLA TYPHIMURIUM', '2025-10-24 04:59:23'),
(27, 'All Gram-negative bacteria', 'gram_negative', 'SERRATIA SPP.', '2025-10-24 04:59:23'),
(28, 'All Gram-negative bacteria', 'gram_negative', 'STENOTROPHOMONAS MALTOPHILIA', '2025-10-24 04:59:23'),
(29, 'All Gram-positive bacteria', 'gram_positive', 'BETA HAEMOLYTIC STREPTOCOCCUS', '2025-10-24 04:59:23'),
(30, 'All Gram-positive bacteria', 'gram_positive', 'ENTEROCOCCUS SPP', '2025-10-24 04:59:23'),
(31, 'All Gram-positive bacteria', 'gram_positive', 'ENTEROCOCCUS SPP.', '2025-10-24 04:59:23'),
(32, 'All Gram-positive bacteria', 'gram_positive', 'GROUP B STREPTOCOCCUS', '2025-10-24 04:59:23'),
(33, 'All Gram-positive bacteria', 'gram_positive', 'KOCURIA KRISTINAE', '2025-10-24 04:59:23'),
(34, 'All Gram-positive bacteria', 'gram_positive', 'LEUCONOSTOC CITREUM', '2025-10-24 04:59:23'),
(35, 'All Gram-positive bacteria', 'gram_positive', 'PROBABLE STREPTOCOCCUS GROUP A', '2025-10-24 04:59:23'),
(36, 'All Gram-positive bacteria', 'gram_positive', 'STAPHYLOCOCCUS AUREUS', '2025-10-24 04:59:23'),
(37, 'All Gram-positive bacteria', 'gram_positive', 'STREPTOCCUS AGALACTIAE', '2025-10-24 04:59:23'),
(38, 'All Gram-positive bacteria', 'gram_positive', 'STREPTOCCUS ALACTOLYTICUS', '2025-10-24 04:59:23'),
(39, 'All Gram-positive bacteria', 'gram_positive', 'STREPTOCCUS PNEUMONIAE', '2025-10-24 04:59:23'),
(40, 'All Gram-positive bacteria', 'gram_positive', 'STREPTOCOCCUS GORDONII', '2025-10-24 04:59:23'),
(41, 'All Gram-positive bacteria', 'gram_positive', 'STREPTOCOCCUS GROUP A', '2025-10-24 04:59:23'),
(42, 'All Gram-positive bacteria', 'gram_positive', 'STREPTOCOCCUS GROUP A(PROBABLE)', '2025-10-24 04:59:23'),
(43, 'All Gram-positive bacteria', 'gram_positive', 'STREPTOCOCCUS GROUP B', '2025-10-24 04:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `last_login` varchar(50) NOT NULL,
  `logout_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nic`, `name`, `email`, `mobile`, `password`, `status`, `created_at`, `profile_picture`, `system_name`, `last_login`, `logout_time`) VALUES
(1, '200202226299', 'user test', 'user@gmail.com', '712222222', '$2y$10$VsfVH9VG3RWyLRBulY6Tr.MKVEMzlUI16kzHTB22LySBaaLuoqJDW', 'approved', '2025-02-15 22:37:20', 'default.jpg', 'user299', '2025-08-26 10:43:12', NULL),
(2, '200515813452', 'Malith Sandeepa', 'malith@gmail.com', '763279285', '$2y$10$XMW2bm/mLEe.bI8645I2B.a5nR10d0RgaNht8ml.v0PLxFxEwhGW2', 'approved', '2025-05-31 13:51:54', '684c0f0cbbca3-1.jpg', 'malith1081', '2025-06-17 13:25:33', NULL),
(3, '200378711255', 'Nishara De Silva', 'nishara@gmail.com', '743397871', '$2y$10$Svk07u8dbkrG/sYyJsKnTubLodyUvpHTkMd7LC0j9tTlsox1DJCES', 'approved', '2025-06-02 14:13:18', '6847df3a45b27-WhatsApp Image 2025-06-10 at 13.00.54_a5511895.jpg', 'nishara255', '2025-06-18 18:47:54', NULL),
(4, '200334400893', 'Tharindu Sampath', 'vgtharindu165@gmail.com', '772010733', '$2y$10$t7ItNlSx9AtpjR5BQ3KCuucL/lEkR8GxA8vjci4GdoETJ/SuGFhmO', 'approved', '2025-06-04 04:33:31', '684d224bee208-IMG-20231121-WA0160.jpg', 'vgtharindu893', '2025-09-05 22:59:28', NULL),
(6, '200370912329', 'Amandi Kaushalya', 'amandi@gmail.com', '788167038', '$2y$10$il4oSNcDRwVxGClov5v/QuVTItGCtjcDnqPAJOP4fEL4/6gwp1LPi', 'approved', '2025-06-10 13:35:28', '6849af19d3bb4-67d53d2856fc3-amandi.jpg', 'amandi1234', '2025-09-05 19:41:58', NULL),
(7, '200354711748', 'Ewni Akithma', 'ewniakithma@gmail.com', '772072026', '$2y$10$.gepJD/DhfJgY5A3DHKFvutUoIMIx3OqP6Z0y7vZdvNdDeqn24Vj2', 'approved', '2025-06-14 02:55:29', '684ec43435899-pic1.jpg', 'ewni748', '2025-10-19 20:14:11', NULL);

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
-- Indexes for table `antibiogram_data`
--
ALTER TABLE `antibiogram_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `antibiogram_reports`
--
ALTER TABLE `antibiogram_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `antibiotics`
--
ALTER TABLE `antibiotics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organism_groups`
--
ALTER TABLE `organism_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_organism` (`organism_name`,`group_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `antibiogram_data`
--
ALTER TABLE `antibiogram_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antibiogram_reports`
--
ALTER TABLE `antibiogram_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antibiotics`
--
ALTER TABLE `antibiotics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `organism_groups`
--
ALTER TABLE `organism_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
