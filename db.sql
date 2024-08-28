-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2024 at 11:59 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `bank_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account`, `bank_id`, `user_id`, `created_at`, `updated_at`) VALUES
(32, '578794512', 1, 33, '2024-03-20 01:46:19', NULL),
(38, '454687897545', 1, 39, '2024-03-20 02:20:35', NULL),
(39, '456489754512', 1, 40, '2024-03-20 09:38:17', NULL),
(40, '111111111', 1, 43, '2024-03-20 09:48:42', NULL),
(41, '11152635987452', 1, 44, '2024-03-20 11:43:31', NULL),
(42, '251365484552', 1, 45, '2024-03-21 07:49:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE `apartments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `floor_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `room_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `electric_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `building_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rent_val` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`id`, `name`, `description`, `floor_number`, `room_number`, `electric_id`, `building_id`, `user_id`, `created_at`, `updated_at`, `rent_val`) VALUES
(1, 'شقة رقم 1', 'شقة ثلاث غرف وصالة مع حمامين', '1', '3', NULL, 1, 1, '2024-03-14 17:11:47', '2024-03-17 20:02:16', 15000),
(2, 'تجربة', NULL, NULL, NULL, NULL, 1, 1, '2024-03-19 19:37:00', '2024-03-19 19:37:00', NULL),
(3, 'تجرية 1', NULL, NULL, NULL, NULL, 1, 1, '2024-03-19 19:42:26', '2024-03-19 19:42:26', 15000);

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_user_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `deleted_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `updated_user_id`, `deleted`, `deleted_user_id`) VALUES
(1, 'مصرف الراجحي', 1, '2019-06-07 19:15:37', NULL, NULL, 0, NULL),
(2, 'البنك السعودي الفرنسي', 1, '2019-06-07 19:15:53', NULL, NULL, 0, NULL),
(3, 'مصرف الإنماء', 1, '2019-06-07 19:16:07', NULL, NULL, 0, NULL),
(4, 'البنك العربي الوطني', 1, '2019-06-07 19:16:19', NULL, NULL, 0, NULL),
(5, 'بنك البلاد', 1, '2019-06-07 19:16:28', NULL, NULL, 0, NULL),
(6, 'بنك البحرين الوطني', 1, '2019-06-07 19:16:35', NULL, NULL, 0, NULL),
(7, 'بنك الجزيرة', 1, '2019-06-07 19:16:43', NULL, NULL, 0, NULL),
(8, 'بنك مسقط', 1, '2019-06-07 19:16:50', NULL, NULL, 0, NULL),
(9, 'مصرف باريس الوطني باريباس', 1, '2019-06-07 19:16:59', NULL, NULL, 0, NULL),
(10, 'البنك الألماني', 1, '2019-06-07 19:17:06', NULL, NULL, 0, NULL),
(11, 'بنك الإمارات الدولي', 1, '2019-06-07 19:17:14', NULL, NULL, 0, NULL),
(12, 'بنك الخليج الدولي', 1, '2019-06-07 19:17:22', NULL, NULL, 0, NULL),
(13, 'بنك الكويت الوطني', 1, '2019-06-07 19:17:31', NULL, NULL, 0, NULL),
(14, 'البنك الأهلي التجاري', 1, '2019-06-07 19:17:37', NULL, NULL, 0, NULL),
(15, 'بنك الرياض', 1, '2019-06-07 19:17:45', NULL, NULL, 0, NULL),
(16, 'مجموعة سامبا المالية', 1, '2019-06-07 19:17:54', NULL, NULL, 0, NULL),
(17, 'البنك السعودي الهولندي', 1, '2019-06-07 19:18:03', NULL, NULL, 0, NULL),
(18, 'البنك السعودي للاستثمار', 1, '2019-06-07 19:18:11', NULL, NULL, 0, NULL),
(19, 'بنك الهند الوطني', 1, '2019-06-07 19:18:37', NULL, NULL, 0, NULL),
(20, 'بنك زراعات', 1, '2019-06-07 19:18:55', NULL, NULL, 0, NULL),
(21, 'البنك السعودي البريطاني', 1, '2019-06-07 19:19:03', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `benefits`
--

CREATE TABLE `benefits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `distract_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `name`, `description`, `address`, `notes`, `user_id`, `created_at`, `updated_at`, `distract_id`) VALUES
(1, 'الجرف', 'عمارة من ثلاث شقق', 'المدينة المنورة - الجرف', NULL, 1, '2024-02-27 11:52:52', '2024-03-16 21:51:34', NULL),
(2, 'تجربة', NULL, NULL, NULL, 1, '2024-03-26 19:44:01', '2024-03-26 19:44:01', 2);

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `min_transaction` int(11) DEFAULT NULL,
  `max_transaction` int(11) DEFAULT NULL,
  `fee` int(11) DEFAULT NULL,
  `fund_iban` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fund_acc` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `renter_id` int(11) NOT NULL,
  `start_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hijri_start_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `end_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hijri_end_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rent_duration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rent_unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rent_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pay_repeat` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `ended` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `apartment_id`, `renter_id`, `start_date`, `hijri_start_date`, `end_date`, `hijri_end_date`, `rent_duration`, `rent_unit`, `rent_amount`, `pay_repeat`, `active`, `ended`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 1, 1, '20-03-2024', '10-09-1445', '10-03-2025', '10-09-1446', '1', 'سنة', '12000', 6, 1, 0, 1, '2024-03-19 23:23:41', '2024-03-19 23:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `distracts`
--

CREATE TABLE `distracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `distracts`
--

INSERT INTO `distracts` (`id`, `name`) VALUES
(1, 'حي العزيزية'),
(2, 'حي الملك فهد'),
(3, 'حي الربوة'),
(4, 'حي سيد الشهداء'),
(5, 'حي قباء'),
(6, 'حي العنابس'),
(7, 'حي السحمان'),
(8, 'حي المستراح'),
(9, 'حي البحر'),
(10, 'حي الجبور'),
(11, 'حي النصر'),
(12, 'حي العنبرية'),
(13, 'حي العوالي'),
(14, 'حي العيون'),
(15, 'حي المناخة'),
(16, 'حي الأغوات'),
(17, 'حي الساحة'),
(18, 'حي زقاق الطيار'),
(19, 'حي الحرة الشرقية'),
(20, 'حي التاجوري'),
(21, 'حي باب المجيدي'),
(22, 'حي باب الشامي'),
(23, 'حي الحرة الغربية'),
(24, 'حي الجرف'),
(25, 'حي الدويمة'),
(26, 'حي القبلتين'),
(27, 'حي أبيار علي'),
(28, 'حي الخالدية'),
(29, 'حي الاسكان'),
(30, 'حي المطار'),
(31, 'حي البيداء'),
(32, 'حي تلعة الهبوب'),
(33, 'حي المبعوث'),
(34, 'حي العاقول'),
(35, 'حي الخضراء'),
(36, 'حي وعيره'),
(37, 'حي الفيصل'),
(38, 'حي الحرة الشمالية الشرقية'),
(39, 'حي قربان'),
(40, 'حي المنشية'),
(41, 'حي السيح'),
(42, 'حي الوبرة'),
(43, 'حي عروة'),
(44, 'حي الدخل المحدود'),
(45, 'حي العصبة'),
(46, 'حي شوران'),
(47, 'حي الراية'),
(48, 'حي الفتح'),
(49, 'حي الحمراء'),
(50, 'حي أبو مرخه'),
(51, 'حي المصانع');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2020_05_10_202423_users_banks', 2),
(4, '2020_05_10_203007_create_accounts_table', 2),
(5, '2020_05_14_221138_create_roles_table', 3),
(6, '2020_05_14_221619_users_roles', 3),
(7, '2020_05_19_202833_create_transactions_table', 4),
(8, '2020_06_13_220523_create_configs_table', 5),
(11, '2020_06_14_152602_create_loans_table', 6),
(12, '2020_06_16_213351_create_websockets_statistics_entries_table', 7),
(13, '2020_06_18_193821_create_notifications_table', 8),
(14, '2020_08_12_195540_create_reject_reasons_table', 9),
(15, '2014_10_12_100000_create_password_resets_table', 10),
(16, '2020_11_27_131616_create_buildings_table', 10),
(17, '2020_11_27_150023_create_apartments_table', 11),
(18, '2020_11_27_162957_create_renters_table', 12),
(20, '2020_11_28_162136_create_contracts_table', 13),
(21, '2024_03_05_143103_create_stds_table', 14),
(22, '2024_03_05_144447_add_deleted_to_stds', 15),
(23, '2024_03_10_171851_create_offers_table', 16),
(24, '2024_03_17_223214_help', 17),
(26, '2024_03_20_122918_add_id_to_users', 18),
(27, '2024_03_26_210729_distract', 19),
(28, '2024_03_26_224056_add_distract_id_to_building', 20);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('17c433f9-6597-46bb-ba70-364843b79dc7', 'App\\Notifications\\new_register', 'App\\User', 1, '{\"user\":\"\\u0645\\u062d\\u0645\\u062f\"}', '2024-03-21 08:14:18', '2024-03-20 11:43:44', '2024-03-21 08:14:18'),
('6da644d9-636f-4866-bdcf-768e126a7af4', 'App\\Notifications\\new_register', 'App\\User', 1, '{\"user\":\"\\u0645\\u062d\\u0645\\u062f\"}', '2024-03-21 08:14:18', '2024-03-20 02:20:40', '2024-03-21 08:14:18'),
('793ed0b9-b647-42cd-b9c6-299999b08fc0', 'App\\Notifications\\new_register', 'App\\User', 1, '{\"user\":\"\\u0645\\u062d\\u0645\\u062f\"}', '2024-03-21 08:14:18', '2024-03-20 09:48:46', '2024-03-21 08:14:18'),
('7c91d2a4-cc8f-4a6d-b40f-30501f514a88', 'App\\Notifications\\new_register', 'App\\User', 1, '{\"user\":\"\\u0645\\u062d\\u0645\\u062f\"}', '2024-03-21 08:14:18', '2024-03-20 09:38:22', '2024-03-21 08:14:18'),
('d4184cc7-b458-4bdc-b4ee-9ff2cc78af9d', 'App\\Notifications\\new_register', 'App\\User', 1, '{\"user\":\"\\u0645\\u062d\\u0645\\u062f \\u0645\\u0635\\u0639\\u0628 \\u0627\\u0644\\u062c\\u0644\\u0645\\u0648\\u062f\"}', '2024-03-21 08:14:18', '2024-03-21 07:49:11', '2024-03-21 08:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caption` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `offer_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `caption`, `img`, `description`, `offer_url`, `active`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'عرض بداية العام', 'files/file-16955642621710317135.jpg', NULL, '/add_offer', 1, 1, '2024-03-13 05:05:35', '2024-03-13 05:05:35'),
(2, 'عرض وسط العام', 'files/file-8273852111710317155.jpg', NULL, NULL, 1, 1, '2024-03-13 05:05:55', '2024-03-13 05:05:55'),
(3, 'عرض نهاية العام', 'files/file-14693552151710317176.jpg', NULL, NULL, 1, 1, '2024-03-13 05:06:16', '2024-03-13 05:06:16');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payable_payments`
--

CREATE TABLE `payable_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `payable_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payable_H_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'non-payable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payable_payments`
--

INSERT INTO `payable_payments` (`id`, `contract_id`, `amount`, `payable_date`, `payable_H_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 6000, '20-03-2024', '10-09-1445', 'payable', '2024-03-19 23:23:41', NULL),
(2, 3, 6000, '14-09-2024', '10-03-1446', 'non-payable', '2024-03-19 23:23:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reject_reasons`
--

CREATE TABLE `reject_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `renters`
--

CREATE TABLE `renters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `renters`
--

INSERT INTO `renters` (`id`, `name`, `id_number`, `phone_number`, `attachment`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'محمد أحمد منصور', '2239545885', '0544699112', 'files/file-1680407411710448068.pdf', 0, '2024-03-14 17:27:48', '2024-03-16 21:52:45'),
(4, 'محمد مصعب الجلمود', '39693985589', '0544699112', 'defualt', 45, '2024-03-21 07:49:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'مدير', NULL, '2020-05-14 21:00:00', NULL),
(2, 'employee', 'موظف', NULL, '2020-05-14 21:00:00', NULL),
(3, 'user', 'مستخدم ', NULL, '2020-05-14 21:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contract_id` int(11) NOT NULL,
  `transaction_number` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL,
  `transaction_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hijri_transaction_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `received_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `social_status` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_phone` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_num` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `sex`, `social_status`, `mobile_phone`, `email`, `active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `id_num`) VALUES
(1, 'admin', 1, '1', '0555555555', 'admin@someone.com', 1, '2020-11-20 23:25:12', '$2y$10$as8lg8x5tsE.UrEFF9YcCu3B/qul7k9qz6WQ/AQvXND6.2WMYpnI2', 'CQUdwcM3HDzfnwFJ8JNBHFYqzQOY2zLIyXE1pOXpiTOQYK4ySgGrbGHKfFti', '2020-11-20 22:50:26', '2020-11-29 15:36:58', NULL),
(45, 'محمد مصعب الجلمود', 1, '1', '0544699112', 'mosaab_g@msn.com', 1, '2024-03-21 07:49:54', '$2y$10$WNFrPo70qLT9xIB/vutgsO29lm3m9ncaWaQRzetZPv75wkw.L7qzW', 'pK9vXJWk1LvLQmYnWjfTyzcJqna1JPdblUoo02YZ0zKAvQMnsHv3wcCt6o3M', '2024-03-21 07:49:00', '2024-03-21 07:49:54', '39693985589');

-- --------------------------------------------------------

--
-- Table structure for table `users_banks`
--

CREATE TABLE `users_banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_banks`
--

INSERT INTO `users_banks` (`id`, `user_id`, `bank_id`) VALUES
(32, 33, 1),
(38, 39, 1),
(39, 40, 1),
(40, 43, 1),
(41, 44, 1),
(42, 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2020-11-20 22:50:26', NULL),
(33, 3, 33, '2024-03-20 01:46:19', NULL),
(39, 3, 39, '2024-03-20 02:20:35', NULL),
(40, 3, 40, '2024-03-20 09:38:17', NULL),
(41, 3, 43, '2024-03-20 09:48:42', NULL),
(42, 3, 44, '2024-03-20 11:43:31', NULL),
(43, 3, 45, '2024-03-21 07:49:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `benefits`
--
ALTER TABLE `benefits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `distracts`
--
ALTER TABLE `distracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payable_payments`
--
ALTER TABLE `payable_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reject_reasons`
--
ALTER TABLE `reject_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `renters`
--
ALTER TABLE `renters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_unique` (`id_number`) USING BTREE;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_id_num_unique` (`id_num`);

--
-- Indexes for table `users_banks`
--
ALTER TABLE `users_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `benefits`
--
ALTER TABLE `benefits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `distracts`
--
ALTER TABLE `distracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payable_payments`
--
ALTER TABLE `payable_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reject_reasons`
--
ALTER TABLE `reject_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `renters`
--
ALTER TABLE `renters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users_banks`
--
ALTER TABLE `users_banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
