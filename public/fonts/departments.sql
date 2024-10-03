-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 03, 2024 at 06:06 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrms`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `company_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `company_id`, `name`, `desc`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sales', 'The sales department, including front sales,upsell and support.', NULL, '2023-03-08 02:08:02', '2023-03-08 02:32:46'),
(2, 1, 'Production', 'Production depart include Designers and Developers', NULL, '2023-03-08 02:47:09', '2023-03-08 02:47:09'),
(3, 1, 'Human Resource', 'The HR Department', NULL, '2023-03-08 02:47:24', '2023-03-08 02:47:24'),
(4, 1, 'UPWork', 'UPWork Sales Team', NULL, '2023-03-10 07:43:38', '2023-03-10 07:43:38'),
(5, 1, 'E-Book Sales', 'Ebook Sales Team', NULL, '2023-03-10 07:44:09', '2023-03-10 07:44:09'),
(6, 1, 'Quality Aussurance', 'QA and Complinace', NULL, '2023-03-10 07:44:34', '2023-03-10 07:44:34'),
(7, 1, 'Hardware', 'Hardware', NULL, '2023-03-10 07:44:50', '2023-03-10 07:44:50'),
(8, 1, 'MSP & DevOps', 'DevOps', NULL, '2023-03-10 07:45:35', '2023-03-10 07:45:35'),
(9, 1, 'Group Marketing', 'Social Media Marketing \r\nPaid Marketing \r\nSeo', NULL, '2023-03-10 07:50:33', '2023-03-10 07:50:33'),
(10, 1, 'Video Production', '3D Video\r\n2D Video', NULL, '2023-03-10 07:51:11', '2023-03-10 07:51:11'),
(11, 1, 'Group IT', 'Group IT', NULL, '2023-03-10 07:52:21', '2023-03-10 07:52:21'),
(12, 1, 'Content Production', 'Content Production', NULL, '2023-03-10 07:53:21', '2023-03-10 07:53:21'),
(13, 1, 'Group Admin', 'Admin And Maintenance', NULL, '2023-03-10 07:54:02', '2023-03-10 07:54:02'),
(14, 1, 'Group Finance', 'Finance And Accounting', NULL, '2023-03-10 07:54:26', '2023-03-10 07:54:26'),
(15, 1, 'Group Operation', 'Operations', NULL, '2023-03-10 07:56:21', '2023-03-10 07:56:21'),
(16, 1, 'Marketing Operations', 'Marketing Operations', NULL, '2023-03-14 00:36:04', '2023-03-14 00:36:04'),
(17, 1, 'Branding', 'Brand Management', NULL, '2023-03-14 04:16:06', '2023-03-14 04:16:06'),
(18, 1, 'Printing & Packaging', 'Printing & Packaging', NULL, '2023-03-14 22:28:53', '2023-03-14 22:28:53'),
(19, 1, 'Fleet', 'Fleet Department', NULL, '2023-03-15 02:24:04', '2023-03-15 02:24:04'),
(20, 1, 'PPC Marketing', 'PPC Marketing', NULL, '2023-03-15 22:23:57', '2023-03-15 22:23:57'),
(21, 1, 'SEO', 'SEO Department', NULL, '2023-03-16 00:59:28', '2023-03-16 00:59:28'),
(22, 1, 'Strategic Planning & QA', 'Strategic Planning & QA Team', NULL, '2023-07-21 16:39:45', '2023-07-21 16:39:45'),
(23, 1, 'CEO', 'Chief Executive Officer is the full form of CEO. A chief executive officer is considered to be the senior-most officer of a business or a company and is the one who makes the most crucial decisions for the organization.', NULL, '2024-03-13 22:35:46', '2024-03-13 22:35:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
