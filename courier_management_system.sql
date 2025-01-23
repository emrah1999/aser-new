-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 30 Oca 2020, 02:54:01
-- Sunucu sürümü: 10.1.37-MariaDB
-- PHP Sürümü: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `courier_management_system`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `awb`
--

CREATE TABLE `awb` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `series` varchar(50) NOT NULL,
  `location_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `awb`
--

INSERT INTO `awb` (`id`, `number`, `series`, `location_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 98765432, '501', 2, NULL, NULL, '2019-09-02 11:11:32', NULL, NULL),
(2, 788989, '502', 1, 1, '2019-09-02 11:11:43', '2019-09-02 11:12:09', '2019-09-02 11:12:09', 1),
(3, 12345678, '501', 2, 1, '2019-11-26 11:02:53', '2019-11-26 11:02:53', NULL, NULL),
(4, 46516, '501', 2, 9, '2019-12-05 15:26:53', '2019-12-05 15:27:50', '2019-12-05 15:27:50', 9),
(5, 456165165, '501', 2, 9, '2019-12-05 15:27:24', '2019-12-05 15:27:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `balance_log`
--

CREATE TABLE `balance_log` (
  `id` int(11) NOT NULL,
  `payment_code` varchar(20) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `amount_azn` decimal(18,2) NOT NULL,
  `client_id` int(11) NOT NULL,
  `status` varchar(3) NOT NULL COMMENT 'in, out',
  `type` varchar(4) NOT NULL COMMENT 'cash, cart',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `balance_log`
--

INSERT INTO `balance_log` (`id`, `payment_code`, `amount`, `amount_azn`, `client_id`, `status`, `type`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, '000003376242', '0.00', '0.00', 3, 'out', 'cash', 3, '2019-12-28 16:53:44', '2019-12-28 16:53:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location_id` int(3) NOT NULL,
  `count` int(5) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `batches`
--

INSERT INTO `batches` (`id`, `name`, `location_id`, `count`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, '191126120312632', 2, 0, 9, '2019-11-26 12:03:13', '2019-11-26 12:03:13', NULL, NULL),
(2, '14785', 2, 0, 9, '2019-12-03 10:14:55', '2019-12-03 10:14:55', NULL, NULL),
(3, '147845', 2, 0, 9, '2019-12-03 10:17:05', '2019-12-03 10:17:05', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `category`
--

INSERT INTO `category` (`id`, `name`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'books', NULL, NULL, NULL, NULL, NULL),
(2, 'car_parts', NULL, NULL, NULL, NULL, NULL),
(3, 'clothing', NULL, NULL, NULL, NULL, NULL),
(4, 'clothing_accessories', NULL, NULL, NULL, NULL, NULL),
(5, 'deodrant_spray', NULL, NULL, NULL, NULL, NULL),
(6, 'electronics', NULL, NULL, NULL, NULL, NULL),
(7, 'game_cd', NULL, NULL, NULL, NULL, NULL),
(8, 'hand_bags', NULL, NULL, '2019-09-04 12:52:29', NULL, NULL),
(9, 'household_appliances', NULL, NULL, NULL, NULL, NULL),
(10, 'jewellery', NULL, NULL, NULL, NULL, NULL),
(11, 'smartphone', NULL, NULL, '2019-09-04 12:54:09', NULL, NULL),
(12, 'tests', 1, '2019-09-02 15:01:26', '2019-09-02 15:02:50', '2019-09-02 15:02:50', 1),
(13, 'test1', 9, '2019-12-17 17:38:51', '2019-12-17 17:38:51', NULL, NULL),
(14, 'test2', 9, '2019-12-17 17:39:00', '2019-12-17 17:39:00', NULL, NULL),
(15, 'test5', 9, '2019-12-17 17:48:47', '2019-12-17 17:48:47', NULL, NULL),
(17, 'test9', 9, '2019-12-17 17:51:38', '2019-12-17 17:51:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `client_transaction`
--

CREATE TABLE `client_transaction` (
  `id` int(11) NOT NULL,
  `amount` varchar(50) CHARACTER SET utf8 NOT NULL,
  `description` longtext CHARACTER SET utf8 NOT NULL,
  `purchase_description` longtext CHARACTER SET utf8 NOT NULL,
  `source` varchar(50) CHARACTER SET utf8 NOT NULL,
  `type` varchar(50) CHARACTER SET utf8 NOT NULL,
  `currency_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `client_transaction`
--

INSERT INTO `client_transaction` (`id`, `amount`, `description`, `purchase_description`, `source`, `type`, `currency_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, '1', '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Sahib Fermanli', 'Sahib Fermanli', 'Sahib Fermanli', 'Sahib Fermanli', 'Sahib Fermanli', '0', NULL, NULL, NULL, '2019-12-11 08:22:36', '2019-12-11 08:22:36'),
(2, 'Sahib Fermanli', 'sahibfermanli230@gmail.com', '+994777220075', 'csdcsd', 'sdcsdcds', '0', NULL, NULL, NULL, '2019-12-11 08:28:46', '2019-12-11 08:28:46'),
(3, 'Sahib Fermanli', 'sahibfermanli230@gmail.com', '+994777220075', 'csdcsd', 'dcf rgtrg trgtr gththet hythtyh', '0', NULL, NULL, NULL, '2019-12-11 08:34:45', '2019-12-11 08:34:45');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `container`
--

CREATE TABLE `container` (
  `id` int(11) NOT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `awb_id` int(11) DEFAULT NULL,
  `departure_id` int(11) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `close_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `container`
--

INSERT INTO `container` (`id`, `flight_id`, `awb_id`, `departure_id`, `destination_id`, `close_date`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(2, 1, 1, 1, 2, NULL, NULL, '2019-09-11 00:00:00', NULL, NULL, NULL),
(3, 1, 1, 2, 1, '2019-09-11 00:00:00', 1, '2019-09-11 18:53:31', '2019-09-11 18:53:31', NULL, NULL),
(4, 1, 1, 2, 1, NULL, 1, '2019-09-11 18:53:31', '2019-09-11 18:53:59', '2019-09-11 18:53:59', 1),
(5, 1, 1, 2, 1, NULL, 1, '2019-09-11 18:53:31', '2019-09-11 18:53:31', NULL, NULL),
(6, 2, 1, 2, 1, NULL, 1, '2019-11-21 12:23:02', '2019-11-23 01:58:51', '2019-11-23 01:58:51', 1),
(7, 2, 1, 2, 1, NULL, 1, '2019-11-21 12:23:02', '2019-11-23 02:02:25', '2019-11-23 02:02:25', 1),
(8, 2, 1, 2, 1, NULL, 1, '2019-11-21 12:23:02', '2019-11-21 12:23:02', NULL, NULL),
(9, 2, 3, 2, 1, NULL, 1, '2019-11-26 11:03:18', '2019-11-26 11:03:18', NULL, NULL),
(10, 2, 3, 2, 1, NULL, 9, '2019-12-05 15:38:12', '2019-12-05 15:39:50', '2019-12-05 15:39:50', 9),
(11, 6, NULL, 2, 1, NULL, 9, '2019-12-16 02:38:32', '2019-12-16 02:41:39', '2019-12-16 02:41:39', 1),
(12, 6, NULL, 2, 1, NULL, 9, '2019-12-16 02:38:32', '2019-12-16 02:39:06', '2019-12-16 02:39:06', 9),
(13, 2, NULL, 2, 1, NULL, 9, '2019-12-16 02:38:43', '2019-12-16 02:38:43', NULL, NULL),
(14, 6, NULL, 2, 1, NULL, 1, '2019-12-16 02:41:15', '2019-12-16 02:41:15', NULL, NULL),
(15, 1, NULL, NULL, NULL, NULL, 9, '2020-01-20 03:15:54', '2020-01-20 03:15:54', NULL, NULL),
(16, 1, NULL, 2, NULL, NULL, 9, '2020-01-20 03:19:10', '2020-01-20 03:19:10', NULL, NULL),
(17, 1, NULL, 2, 1, NULL, 9, '2020-01-20 03:20:26', '2020-01-20 03:20:26', NULL, NULL),
(18, 9, NULL, 2, 1, NULL, 9, '2020-01-24 20:41:32', '2020-01-24 20:41:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contract`
--

CREATE TABLE `contract` (
  `id` int(11) NOT NULL,
  `system` varchar(50) CHARACTER SET utf8 NOT NULL,
  `description` longtext CHARACTER SET utf8,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `default_option` int(1) NOT NULL DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `contract`
--

INSERT INTO `contract` (`id`, `system`, `description`, `start_date`, `end_date`, `default_option`, `is_active`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'General', 'General rate', '2019-10-11', '2020-12-25', 1, 1, 1, '2019-11-15 21:10:30', '2020-01-16 11:05:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contract_detail`
--

CREATE TABLE `contract_detail` (
  `id` int(11) NOT NULL,
  `contract_id` int(11) NOT NULL,
  `type_id` int(3) NOT NULL DEFAULT '1',
  `service_name` varchar(50) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `from_weight` double NOT NULL,
  `to_weight` double NOT NULL,
  `weight_control` int(1) NOT NULL DEFAULT '2' COMMENT '1 - max(volume, gross); 2 - gross',
  `rate` double NOT NULL DEFAULT '0',
  `charge` double NOT NULL DEFAULT '0',
  `currency_id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `departure_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `calculate_type` int(1) DEFAULT '0',
  `console_rate` double DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `quantity_rate` double DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `default_option` int(1) NOT NULL DEFAULT '0',
  `is_active` int(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `contract_detail`
--

INSERT INTO `contract_detail` (`id`, `contract_id`, `type_id`, `service_name`, `seller_id`, `category_id`, `from_weight`, `to_weight`, `weight_control`, `rate`, `charge`, `currency_id`, `destination_id`, `departure_id`, `start_date`, `end_date`, `calculate_type`, `console_rate`, `priority`, `quantity_rate`, `type`, `default_option`, `is_active`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`, `country_id`, `title`) VALUES
(1, 1, 1, 'ABS 0.001 - 0.250', NULL, NULL, 0.01, 0.25, 1, 2.95, 0, 1, 1, 2, '2019-11-10', '2020-11-30', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2019-11-15 21:11:44', '2020-01-20 02:47:25', NULL, NULL, 2, 'ABS-dan Bakiya'),
(2, 1, 1, 'ABS 0.251 - 0.500', NULL, NULL, 0.251, 0.5, 1, 3.95, 0, 1, 1, 2, '2019-11-15', '2020-11-30', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2019-11-15 21:16:19', '2020-01-20 02:47:27', NULL, NULL, 2, 'ABS - dan Bakiya'),
(3, 1, 1, 'ABS 0.501 - 0.750', NULL, NULL, 0.501, 0.75, 1, 5.95, 0, 1, 1, 2, '2019-11-15', '2020-11-30', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2019-11-15 21:17:08', '2020-01-20 02:47:30', NULL, NULL, 2, 'ABS-dan Bakiya'),
(4, 1, 1, 'ABS 0.751 - 1', NULL, NULL, 0.751, 1, 1, 6.45, 0, 1, 1, 2, '2019-11-15', '2020-11-30', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2019-11-15 21:17:50', '2020-01-20 02:47:32', NULL, NULL, 2, 'ABS-dan Bakiya'),
(5, 1, 1, 'ABS 1.01 - 10', NULL, NULL, 1.01, 10, 1, 6.45, 0, 1, 1, 2, '2019-11-15', '2020-11-30', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2019-11-15 21:18:40', '2020-01-20 02:47:36', NULL, NULL, 2, 'ABS-dan Bakiya'),
(6, 1, 1, 'ABS 10.01 +', NULL, NULL, 10.01, 10000, 1, 6.05, 0, 1, 1, 2, '2019-11-15', '2020-11-30', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2019-11-15 21:19:28', '2020-01-20 02:47:38', NULL, NULL, 2, 'ABS-dan Bakiya'),
(7, 1, 1, 'Turkey 0.001 - 0.250', NULL, NULL, 0.001, 0.25, 1, 1.95, 0, 1, 1, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:00:40', '2020-01-20 17:03:42', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA'),
(8, 1, 1, 'Turkey 0.251 -  0.500', NULL, NULL, 0.251, 0.5, 1, 2.95, 0, 1, 1, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:04:40', '2020-01-20 17:04:40', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA'),
(9, 1, 1, 'Turkey 0.501 - 0.750', NULL, NULL, 0.501, 0.75, 1, 3.95, 0, 1, 1, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:05:33', '2020-01-20 17:05:33', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA'),
(10, 1, 1, 'Turkey 0.751 - 1', NULL, NULL, 0.751, 1, 1, 4.95, 0, 1, 1, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:06:16', '2020-01-20 17:06:16', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA'),
(11, 1, 1, 'Turkey 1.001 - 10', NULL, NULL, 1.001, 10, 1, 4.95, 0, 1, 1, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:07:00', '2020-01-20 17:07:29', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA'),
(12, 1, 1, 'Turkey 10.001 +', NULL, NULL, 10.001, 1000000, 1, 4.5, 0, 1, 1, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:08:10', '2020-01-20 17:08:10', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA'),
(13, 1, 2, 'Turkey Liquid 0.001 - 0.250', NULL, NULL, 0.001, 0.25, 1, 5.95, 0, 1, 1, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:09:59', '2020-01-20 17:09:59', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA'),
(14, 1, 2, 'Turkey Liquid 0.251 - 0.500', NULL, NULL, 0.251, 0.5, 1, 7.95, 0, 1, 1, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:11:10', '2020-01-20 17:11:10', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA'),
(15, 1, 2, 'Turkey Liquid 0.501 - 0.750', NULL, NULL, 0.501, 0.75, 1, 8.95, 0, 1, 5, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:12:24', '2020-01-20 17:12:24', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA'),
(16, 1, 2, 'Turkey Liquid 0.751 - 1', NULL, NULL, 0.751, 1, 1, 9.95, 0, 1, 1, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:13:23', '2020-01-20 17:13:23', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA'),
(17, 1, 2, 'Turkey Liquid 1 +', NULL, NULL, 1, 10000, 1, 9.95, 0, 1, 1, 5, '2020-01-02', '2021-01-02', 0, NULL, NULL, NULL, NULL, 0, 1, 1, '2020-01-20 17:14:06', '2020-01-20 17:14:06', NULL, NULL, 3, 'TÜRKİYƏDƏN BAKIYA');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `countries`
--

CREATE TABLE `countries` (
  `id` int(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(5) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `currency_id` int(3) DEFAULT NULL,
  `url_permission` int(1) NOT NULL DEFAULT '0' COMMENT 'saytdan link ile sifaris vermek',
  `sort` int(2) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `flag`, `image`, `currency_id`, `url_permission`, `sort`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'Azerbaijan', 'AZE', '/front/frontend/web/uploads/images/country/turkey.png', '/front/frontend/web/uploads/images/country/turkish-flag.png', 3, 0, 0, 1, '2019-12-01 00:00:00', NULL, NULL, NULL),
(2, 'USA', 'USA', '/front/frontend/web/uploads/images/country/usa.png', '/front/frontend/web/uploads/images/country/usa-flag.png', 1, 0, 0, 1, NULL, NULL, NULL, NULL),
(3, 'Turkey', 'TR', '/front/frontend/web/uploads/images/country/turkey.png', '/front/frontend/web/uploads/images/country/turkish-flag.png', 4, 1, 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `country_details`
--

CREATE TABLE `country_details` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `information` varchar(500) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `country_details`
--

INSERT INTO `country_details` (`id`, `country_id`, `title`, `information`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 3, 'Ad Soyad:', '{name_surname}', 1, NULL, NULL, NULL, NULL),
(2, 3, 'Adres satır 1', 'Oruçreis mahallesi Giyimkent 19 sokak No: 103', 1, NULL, NULL, NULL, NULL),
(3, 3, ' İl (Şehir)', 'İSTANBUL', 1, NULL, NULL, NULL, NULL),
(4, 3, 'İlçe', 'Esenler', 1, NULL, NULL, NULL, NULL),
(5, 3, 'Semt', 'Giyimkent', 1, NULL, NULL, NULL, NULL),
(6, 3, 'Adres satır 2', '{aser_id} Aser EXPRESS', 1, NULL, NULL, NULL, NULL),
(7, 3, 'Ülke', 'TURKİYE', 1, NULL, NULL, NULL, NULL),
(8, 3, 'ZIP/Post kodu', '34235', 1, NULL, NULL, NULL, NULL),
(9, 3, 'Cep numarası', '+905454541315', 1, NULL, NULL, NULL, NULL),
(10, 3, 'Vergi numarası', '5750466991', 1, NULL, NULL, NULL, NULL),
(11, 3, 'TC kimlik', '67132132252', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `currency`
--

INSERT INTO `currency` (`id`, `name`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'USD', NULL, NULL, NULL, NULL, NULL),
(2, 'GBP', NULL, NULL, NULL, NULL, NULL),
(3, 'AZN', NULL, NULL, NULL, NULL, NULL),
(4, 'TRY', 1, '2019-09-02 17:13:20', '2019-09-02 17:13:44', '2019-09-02 17:13:44', NULL),
(5, 'EUR', 1, '2020-01-16 00:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `content` longtext CHARACTER SET utf8,
  `fromEmail` varchar(50) CHARACTER SET utf8 NOT NULL,
  `receiveDate` datetime DEFAULT NULL,
  `seller` varchar(50) CHARACTER SET utf8 NOT NULL,
  `subject` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `email`
--

INSERT INTO `email` (`id`, `content`, `fromEmail`, `receiveDate`, `seller`, `subject`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'dc', '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exchange_rate`
--

CREATE TABLE `exchange_rate` (
  `id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `rate` double NOT NULL,
  `from_currency_id` int(11) NOT NULL,
  `to_currency_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `exchange_rate`
--

INSERT INTO `exchange_rate` (`id`, `from_date`, `to_date`, `rate`, `from_currency_id`, `to_currency_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, '2019-09-12', '2020-09-13', 1.7, 1, 3, 1, '2019-09-12 16:08:14', '2019-09-12 16:08:14', NULL, NULL),
(2, '2020-01-20', '2020-10-31', 0.287, 4, 3, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `faqs`
--

CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `created_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'aser EXPRESS-dən necə sifariş etməli?', '<ol>\r\n	<li>aser.az saytından qeydiyyatdan ke&ccedil;mək.</li>\r\n	<li>Qeydiyyatdan sonra Sizə ABŞ-da şəxsi po&ccedil;t &uuml;nvanı veriləcəkdir, və Siz internet-mağazalarından alış-veriş edərkən &ccedil;atdırılma &uuml;nvanı olaraq sizə verilən &uuml;nvanı qeyd edəcəksiz.</li>\r\n	<li>ABŞ ərazisində &ccedil;atdırılma həyata ke&ccedil;irən istənilən internet-mağazadan alış-veriş etmək.</li>\r\n	<li>&nbsp;Malı almadan &ouml;ncə, onun Azərbaycana &ccedil;atdırılmasının qadağan edilmədiyindən və sayının və məbləğinin g&ouml;mr&uuml;k qaydalarına zidd olmadığından əmin olun.</li>\r\n	<li>Bağlamanın qeyd edilən &uuml;nvana g&ouml;ndərilməsindən sonra satıcı Sizə bağlamanın trekinq-kodunu (izləmə n&ouml;mrəsi) və invoys verir.</li>\r\n	<li>Sonra ilkin bəyannamə doldurulmalıdır. Bəyannamədə mağaza, malın kateqoriyası və təsviri qeyd edilməlidir.</li>\r\n	<li>Əgər ABŞ anbarına daxil olan mala bəyannamə tərtib edilməyibsə, bəyannamə tərtib edilənədək anbarda saxlanılacaq.</li>\r\n	<li>Bəyannaməsi olan b&uuml;t&uuml;n bağlamaların Azərbaycana g&ouml;ndərilməsi hər həftə həyata ke&ccedil;irilir.</li>\r\n	<li>Bağlamanın Azərbaycana&nbsp;g&ouml;ndərilməsindən sonra, malınızın yolda olması barədə bildiriş və xidmətin &ouml;dənilməsi &uuml;&ccedil;&uuml;n invoys alacaqsız.</li>\r\n	<li>İnvoysu onlayn olaraq aser.az saytındakı şəxsi kabinetiniz vasitəsilə, yaxud nəğd və ya bank kartı ilə &ouml;dəyə bilərsiz.</li>\r\n	<li>G&ouml;mr&uuml;k baxışından ke&ccedil;dikdən sonra bağlamalar Bakı ofisinə &ccedil;atdırılır, və bundan sonra Siz elektron &uuml;nvan və sms vasitəsilə bildiriş alırsız.</li>\r\n	<li>Bağlamanızı iş saatları &ccedil;ər&ccedil;ivəsində sizə uyğun vaxtda g&ouml;t&uuml;rə bilərsiz.</li>\r\n</ol>\r\n', NULL, NULL, NULL, NULL, NULL),
(2, 'ABŞ-da vasitəçi xidməti mənə nə üçün lazımdı?', '<p>ABŞ mağazalarının 10-dan 9-u, o c&uuml;mlədən Amazon, Azərbaycana birbaşa mal &ccedil;atdırılması həyata ke&ccedil;irmir. Hətta mağaza beynəlxalq &ccedil;atdırılma xidməti təklif etsə belə, bu &ccedil;ox bahalı&nbsp; xidmətdir, və siz Amerikadan hər ayrıca sifarişin tam dəyərini &ouml;dəməli olacaqsız. Kolibri Ekspres ABŞ-da sizə &ouml;dənişsiz şəxsi &uuml;nvan təqdim edərək b&uuml;t&uuml;n bu problemləri aradan qaldırır. Bu&nbsp;&uuml;nvana siz mal sifariş edə, orda malı 30 g&uuml;n ərzində saxlaya, və beynəlxalq &ccedil;atdırılma xidməti &uuml;&ccedil;&uuml;n əhəmiyyətli dərəcədə az vəsait sərf edərək sifarişinizi Azərbaycanda ala<br />\r\nbiləcəksiz.</p>\r\n', NULL, NULL, NULL, NULL, NULL),
(3, 'Çatdırılmanın qiymətini necə öyrənməli?', 'Çatdırılmanın təxmini qiymətini, malın çəkisini daxil edərək saytda verilən kalkulyator vasitəsilə hesablamaq olar. Malların dəyəri çatdırlma qiymətinə təsir etmir.', NULL, NULL, NULL, NULL, NULL),
(4, 'Niyə bağlamanın mağaza tərəfindən qeyd edilən çəkisi anbarda qeyd edilən çəkidən fərqlidir?', 'Mağazalar və poçt xidmətləri adətən malın təxmini çəkisini qeyd edir, Kolibri anbarına daxil olduqda isə bağlama elektron tərəzidə çəkilir, və beləliklə də dəqiq çəki qeyd edilir.', NULL, NULL, NULL, NULL, NULL),
(5, '1000 ABŞ dolları limiti nədir?', '<p>Fiziki şəxslər tərəfindən g&ouml;mr&uuml;k ərazisinə gətirilən istehsal və kommersiya məqsədləri &uuml;&ccedil;&uuml;n nəzərdə tutulmayan malların g&ouml;mr&uuml;k dəyəri (Nazirlər Kabinetinin qəbul etdiyi 305 №-li qərarın 2.1.4-c&uuml;&nbsp; bəndini rəhbər tutaraq) 30 g&uuml;n m&uuml;ddətində 1000 ABŞ dolları ekvivalentindən artıq olmayan məbləğdə y&uuml;k&uuml;n &ouml;lkəyə idxal edilməsi sadələşdirilmiş qaydada həyata ke&ccedil;irilir.<br />\r\nFiziki dəyər 1000 ABŞ dollarından &ccedil;ox olduqda, qanunvericiliyə uyğun olaraq 36%-dək g&ouml;mr&uuml;k r&uuml;sumu &ouml;dənilir.<br />\r\n1000 ABŞ dolları limitinə əşyanın &ouml;z dəyəri və saxlanılan bağlamanın daşınma haqqı daxildir.<br />\r\nLimiti ke&ccedil;miş hesab sahiblərinin bağlamaları DGK tərəfindən saxlanılır.<br />\r\n*Bağlamanın&nbsp; BCT-də saxlanılması zamanı ilk g&uuml;n 12 AZN, sonrakı hər g&uuml;n &uuml;&ccedil;&uuml;n 2 AZN (1 avro) saxlanc haqqı hesablanır.</p>\r\n', NULL, NULL, NULL, NULL, NULL),
(6, '«Tracking İD» nədir?', '<p>Bağlama onlayn mağazada tam qablaşdırıldıqdan sonra, alıcıya çatdırılması üçün ölkə daxili kuryerlərə verilir. Kuryer xidməti öz növbəsində bağlamaya yol nömrəsi təyin edir. Trek nömrə bağlamanın kuryerin anbarından təyinat məntəqəsinə çatdırılanadək mövqeyini izləməyə imkan yaradır. Trek nömrə hər bağlama üçün ayrı-ayrılıqda verilir, fərqli olur və təkrarlanmır. Bağlamanız daşıyıcı şirkətin anbarına çatdırılanadək yükün mövqeyini daxili kuryer xidmətinin səhifəsində izləyə bilərsiniz.</p>', NULL, NULL, NULL, NULL, NULL),
(7, 'Onlayn alış edərkən nəyi bilməyiniz zəruridir?', '<p>Onlayn alışı zamanı &ldquo;shipping adress&rdquo; b&ouml;lməsinin xanaları aser hesabınızda təqdim edilən n&uuml;munəyə uyğun olaraq doldurulmalıdır.</p>\r\n\r\n<p>Ad, Soyad və şəxsi n&ouml;mrə d&uuml;zg&uuml;n qeyd edilmədiyi təqdirə, bağlama xarici anbarlarda saxlanılır, Azərbaycana g&ouml;ndərilmir və &ccedil;atdırılma m&uuml;ddəti bağlamanın sahibi təyin edilənədək uzadılır.</p>\r\n\r\n<p>Belə hal yarandığı təqdirdə sifarişin gecikməsinə g&ouml;rə şirkət &ouml;hdəlik daşımır.</p>\r\n', NULL, NULL, NULL, NULL, NULL),
(8, 'Satıcıdan anbara bağlamanın çatdırılması', '<p>Onlayn satış mağazasında alış tamamlandıqdan sonra m&uuml;əyyən vaxta bağlama m&uuml;ştərinin qeyd etdiyi &uuml;nvana &ccedil;atdırılır. Bunun &uuml;&ccedil;&uuml;n bağlama yerli po&ccedil;t xidmətinə verilir.</p>\r\n\r\n<p>Bağlama anbara &ccedil;atdırılmamışdan əvvəl &ldquo;aser&rdquo;-nin m&uuml;ştərinin y&uuml;k&uuml; haqqında məlumatı olmur və şirkət y&uuml;k anbara təhvil verilənədək he&ccedil; bir &ouml;hdəlik daşımır. Bağlama anbara daxil olduqdan sonra m&uuml;ştərinin şəxsi hesabında qeyd olunur və n&ouml;vbəti reyslə Azərbaycana g&ouml;ndərilir.</p>\r\n', NULL, NULL, NULL, NULL, NULL),
(9, 'Şəxsi hesabda bağlama haqqında məlumat nə üçün qeyd edilməlidir?', '<p>Azərbaycan hava limanına &ccedil;atdırılan hər bir bağlama g&ouml;mr&uuml;k yoxlamasından ke&ccedil;ir.</p>\r\n\r\n<p>Gecikmələrin yaranmaması &uuml;&ccedil;&uuml;n m&uuml;ştəri aser şəxsi hesabına daxil olaraq, sifarişi haqqında məlumatı əvvəlcədən bəyan etməlidir. Sifariş haqqında məlumat bağlama xarici anbarlara &ccedil;atdırılmamışdan əvvəl qeyd olunmalıdır. Y&uuml;k&uuml;n bəyan edilməsi yalnız bağlama satıcı tərəfindən kuryerə verildikdən və izləmə n&ouml;mrəsi təqdim edildikdən sonra m&uuml;mk&uuml;nd&uuml;r.</p>\r\n', NULL, NULL, NULL, NULL, NULL),
(10, 'Mən bütün sual-cavabları oxudum, lakin sualıma cavab tapa bilmədim. Belə halda nə etməliyəm?', '<p>Belə halda Siz bizim dəstək xidmətimizlə əlaqə saxlaya bilərsiz. Şəxsi hesabınızı qeydiyyatdan ke&ccedil;irmək &uuml;&ccedil;&uuml;n istifadə etdiyiniz elektron &uuml;nvanınızdan yazmağı məsləhətə g&ouml;r&uuml;r&uuml;k. M&uuml;raciət zamanı eyniləşdirmə n&ouml;mrənizi, həm&ccedil;inin sual konkret g&ouml;ndərişə aiddirsə, bağlama&nbsp; n&ouml;mrəsini qeyd etməyiniz &ccedil;ox vacibdi. Nəzərinizə &ccedil;atdırırıq ki, onlayn &ccedil;atda yalnız &uuml;mumi suallara cavab ala bilərsiz. Konkret g&ouml;ndərişlə əlaqəli istənilən sualınızla bağlı bizimlə elektron &uuml;nvan vasitəsilə əlaqə saxlamağınız məsləhət g&ouml;r&uuml;l&uuml;r.</p>\r\n', NULL, NULL, NULL, NULL, NULL),
(11, 'Həcmi çəki nədir və necə hesablanır?', '<p>Təyyarədə daşınan y&uuml;k&uuml;n &ccedil;əkisi, Hava Daşımaları qaydalarına əsasən, &ouml;l&ccedil;&uuml;lərindən asılı olaraq iki c&uuml;r hesablana bilər:</p>\r\n\r\n<p>Fiziki &ccedil;əki;</p>\r\n\r\n<p>Həcm &ccedil;əkisi.</p>\r\n\r\n<p>Beynəlxalq hesablama standartlara uyğun olaraq həcmi &ccedil;əki aşağıdakı kimi hesablanır:<br />\r\n(En x Uzunluq x H&uuml;nd&uuml;rl&uuml;k)/6000&nbsp; = Həcm &ccedil;əkisi (kg)<br />\r\nBağlamaların &ouml;l&ccedil;&uuml;ləri b&ouml;y&uuml;k olduqda (təyyarədə daha &ccedil;ox yer tutduqda) əvvəlcə hər iki &ccedil;əki hesablanır, daha sonra g&ouml;stəricisi b&ouml;y&uuml;k olan &ccedil;əki daşınma &ccedil;əkisi kimi se&ccedil;ilir.</p>\r\n', NULL, NULL, NULL, NULL, NULL),
(12, 'Anbarların iş saatları', '<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:500px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td style=\"text-align:center\"><span style=\"color:#8B4513\"><strong>ABŞ</strong></span></td>\r\n			<td style=\"text-align:center\"><span style=\"color:#8B4513\"><strong>ALMANİYA</strong></span></td>\r\n			<td style=\"text-align:center\"><span style=\"color:#8B4513\"><strong>T&Uuml;RKİYƏ</strong></span></td>\r\n			<td style=\"text-align:center\"><span style=\"color:#8B4513\"><strong>BƏƏ</strong></span></td>\r\n			<td style=\"text-align:center\"><span style=\"color:#8B4513\"><strong>İNGİLTƏRƏ</strong></span></td>\r\n		</tr>\r\n		<tr>\r\n			<td><span style=\"color:#2F4F4F\"><strong>Bazar Ertəsi</strong></span></td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-17:00</td>\r\n		</tr>\r\n		<tr>\r\n			<td><span style=\"color:#2F4F4F\"><strong>&Ccedil;ərşənbə axşamı</strong></span></td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-17:00</td>\r\n		</tr>\r\n		<tr>\r\n			<td><span style=\"color:#2F4F4F\"><strong>&Ccedil;ərşənbə</strong></span></td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-17:00</td>\r\n		</tr>\r\n		<tr>\r\n			<td><span style=\"color:#2F4F4F\"><strong>C&uuml;mə axşamı</strong></span></td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-17:00</td>\r\n		</tr>\r\n		<tr>\r\n			<td><span style=\"color:#2F4F4F\"><strong>C&uuml;mə</strong></span></td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>09:00-18:00</td>\r\n			<td>Qeyri-iş g&uuml;n&uuml;</td>\r\n			<td>09:00-17:00</td>\r\n		</tr>\r\n		<tr>\r\n			<td><span style=\"color:#2F4F4F\"><strong>Şənbə</strong></span></td>\r\n			<td>Qeyri-iş g&uuml;n&uuml;</td>\r\n			<td>Qeyri-iş g&uuml;n&uuml;</td>\r\n			<td>Qeyri-iş g&uuml;n&uuml;</td>\r\n			<td>09:00-18:00</td>\r\n			<td>Qeyri-iş g&uuml;n&uuml;</td>\r\n		</tr>\r\n		<tr>\r\n			<td><span style=\"color:#2F4F4F\"><strong>Bazar</strong></span></td>\r\n			<td>Qeyri-iş g&uuml;n&uuml;</td>\r\n			<td>Qeyri-iş g&uuml;n&uuml;</td>\r\n			<td>Qeyri-iş g&uuml;n&uuml;</td>\r\n			<td>09:00-18:00</td>\r\n			<td>Qeyri-iş g&uuml;n&uuml;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `flight`
--

CREATE TABLE `flight` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `carrier` varchar(3) CHARACTER SET utf8 NOT NULL,
  `flight_number` varchar(5) CHARACTER SET utf8 NOT NULL,
  `awb` varchar(15) DEFAULT NULL,
  `departure` varchar(50) CHARACTER SET utf8 NOT NULL,
  `destination` varchar(50) CHARACTER SET utf8 NOT NULL,
  `fact_take_off` datetime DEFAULT NULL,
  `fact_arrival` datetime DEFAULT NULL,
  `plan_take_off` datetime NOT NULL,
  `plan_arrival` datetime DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `flight`
--

INSERT INTO `flight` (`id`, `name`, `carrier`, `flight_number`, `awb`, `departure`, `destination`, `fact_take_off`, `fact_arrival`, `plan_take_off`, `plan_arrival`, `closed_by`, `closed_at`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, '', '7L', '007', '15651565', 'JFK', 'GYD', '2019-09-04 13:50:00', '2019-09-20 19:50:00', '2019-06-13 01:50:00', '2019-06-12 21:50:00', NULL, NULL, NULL, NULL, '2019-09-12 18:26:50', NULL, NULL),
(2, '', 'J2', '257', '', 'GYD', 'NAJ', '2019-09-13 19:50:00', NULL, '2019-09-12 16:04:00', '2019-09-12 16:05:00', 9, '2020-01-14 13:49:57', 1, '2019-09-12 16:05:14', '2020-01-14 13:49:57', NULL, NULL),
(3, '', 'J2', '258', '', 'GYD', 'NAJ', NULL, '2019-09-19 18:50:00', '2019-09-12 19:30:00', '2019-09-26 18:45:00', NULL, NULL, 1, '2019-09-12 18:16:42', '2019-09-12 18:25:51', NULL, NULL),
(4, '', 'J2', '2541', '', 'NAJ', 'GYD', NULL, '2019-12-05 19:50:00', '2019-12-05 14:50:00', '2019-12-27 18:45:00', NULL, NULL, 9, '2019-12-05 15:17:16', '2019-12-05 15:19:22', '2019-12-05 15:19:22', 9),
(5, '', '7L', '250', '0585525655', 'NAJ', 'GYD', NULL, NULL, '2019-12-18 10:50:00', NULL, NULL, NULL, 9, '2019-12-16 02:03:34', '2019-12-16 02:03:55', '2019-12-16 02:03:55', 9),
(6, '', '7L', '298', '1361646565', 'NAJ', 'GYD', NULL, NULL, '2019-12-17 17:45:00', NULL, 9, '2020-01-14 13:50:11', 9, '2019-12-16 02:08:31', '2020-01-14 13:50:11', NULL, NULL),
(7, 'TUR720200114', '7L', '255', '215611532', 'TUR', 'GYD', NULL, NULL, '2020-01-14 10:10:00', NULL, NULL, NULL, 9, '2020-01-14 10:11:13', '2020-01-14 10:14:58', NULL, NULL),
(8, 'NAJ820200115', '7L', '255', '0585525655', 'NAJ', 'GYD', NULL, NULL, '2020-01-15 14:50:00', NULL, NULL, NULL, 9, '2020-01-14 10:13:01', '2020-01-14 10:14:42', NULL, NULL),
(9, 'TUR920200116', '7L', '250', '0585525655', 'TUR', 'GYD', NULL, NULL, '2020-01-16 14:50:00', NULL, NULL, NULL, 9, '2020-01-14 10:14:04', '2020-01-14 10:14:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `instructions`
--

CREATE TABLE `instructions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `instructions`
--

INSERT INTO `instructions` (`id`, `title`, `content`, `img`, `created_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'COLİBRİ QEYDİYYATINDAN KEÇİN', 'aser-də qeydiyyatdan keçin və ABŞ, Türkiyə, Almaniya, BƏƏ, İngiltərə-də şəxsi ünvanınız olsun.', '/front/frontend/web/uploads//images/how-it-works/carry-info.svg', 1, NULL, NULL, '2019-12-04 20:00:00', '2019-12-04 20:00:00'),
(2, 'SEVDİYİNİZ MARKALARIN MƏHSULLARINI ALIN', 'Sevdiyiniz markaların mağazalarını gəzin və istədiyiniz malı ABŞ, Türkiyə, Almaniya, BƏƏ və İngiltərədə yerləşən anbarlardan birinə sifariş edin.', '/front/frontend/web/uploads//images/how-it-works/carry-store.svg', 2, NULL, NULL, '2019-12-04 20:00:00', '2019-12-04 20:00:00'),
(3, 'SİFARİŞİNİZ XARİCİ ANBARIMIZDADIR', 'Sifarişiniz bizim ABŞ, Türkiyə, Almaniya, BƏƏ və ya İngiltərədə yerləşən anbara qəbul edilir.', '/front/frontend/web/uploads//images/how-it-works/carry-moving.svg', 3, NULL, NULL, '2019-12-04 20:00:00', '2019-12-04 20:00:00'),
(4, 'SİFARİŞİNİZ AZƏRBAYCANA ÇATDIRILIR', 'Sifarişiniz Bakıya çatdırıldı.', '/front/frontend/web/uploads//images/how-it-works/carry-home.svg', 4, NULL, NULL, '2019-12-04 20:00:00', '2019-12-04 20:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `price` decimal(18,3) DEFAULT '0.000',
  `price_usd` decimal(18,3) DEFAULT '0.000',
  `currency_id` int(3) DEFAULT NULL,
  `invoice_doc` varchar(255) DEFAULT NULL,
  `invoice_confirmed` int(1) NOT NULL DEFAULT '0',
  `quantity` int(11) DEFAULT '0',
  `title` varchar(100) DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `item`
--

INSERT INTO `item` (`id`, `category_id`, `code`, `price`, `price_usd`, `currency_id`, `invoice_doc`, `invoice_confirmed`, `quantity`, `title`, `package_id`, `created_by`, `created_at`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 6, NULL, '0.000', '0.000', NULL, NULL, 0, 1, NULL, 1, 1, '2019-11-26 11:56:01', '2019-11-28 15:46:27', 1, NULL, NULL),
(2, 6, NULL, '0.000', '0.000', NULL, NULL, 0, 1, NULL, 24, 1, '2019-11-27 17:04:45', '2019-11-27 17:04:45', NULL, NULL, NULL),
(3, 6, NULL, '58.000', '58.000', NULL, NULL, 0, 1, NULL, 28, 9, '2019-12-04 14:20:38', '2019-12-04 14:21:07', 9, NULL, NULL),
(4, 6, NULL, '5.000', '5.000', NULL, NULL, 0, 1, NULL, 29, 9, '2019-12-04 14:26:08', '2019-12-04 14:26:08', NULL, NULL, NULL),
(5, 1, NULL, '25.000', '25.000', NULL, NULL, 0, 1, NULL, 30, 9, '2019-12-04 14:41:09', '2020-01-24 13:02:24', 9, '2020-01-24 13:02:24', 3),
(6, 6, NULL, '125.000', '125.000', NULL, NULL, 0, 1, NULL, 31, 9, '2019-12-05 11:15:23', '2019-12-05 11:43:52', 9, NULL, NULL),
(7, 6, NULL, '10.000', '10.000', 2, NULL, 0, 1, NULL, 32, 9, '2019-12-06 00:00:00', '2020-01-24 13:07:44', 9, '2020-01-24 13:07:44', 3),
(8, 1, NULL, '12.000', '12.000', 2, NULL, 0, 1, NULL, 23, 9, '2019-12-19 15:55:23', '2019-12-19 15:55:23', NULL, NULL, NULL),
(9, 11, NULL, '84.000', '85.000', 2, 'salam', 1, 1, NULL, 33, 9, '2019-12-20 01:22:21', '2020-01-24 13:05:48', 9, '2020-01-24 13:05:48', 3),
(10, 1, NULL, '100.000', '0.000', 4, '/uploads/files/packages/invoices/01234567890_invoice_X82H_1579869023.pdf', 0, 3, 'fenerbahce', 35, NULL, '2020-01-24 12:30:23', '2020-01-24 12:30:23', NULL, NULL, NULL),
(11, 3, NULL, '200.000', '0.000', 4, '/uploads/files/packages/invoices/0123654799_invoice_yvRh_1579869593.JPG', 0, 5, 'Fenerbahce', 36, NULL, '2020-01-24 12:39:53', '2020-01-24 12:39:53', NULL, NULL, NULL),
(12, 4, NULL, '120.000', '0.000', 4, '/uploads/files/packages/invoices/0155615656_invoice_3eso_1579869773.pdf', 1, 2, 'Fener', 37, NULL, '2020-01-24 12:42:53', '2020-01-24 13:02:56', NULL, '2020-01-24 13:02:56', 3),
(13, 1, NULL, NULL, '0.000', 3, '/uploads/files/packages/invoices/01234567890_invoice_2mAg_1579882728.JPG', 2, 2, 'fener 1907', 38, NULL, '2020-01-24 13:14:33', '2020-01-24 20:46:59', 9, NULL, NULL),
(14, 4, NULL, '150.000', '0.000', 4, '/uploads/files/packages/invoices/fb19071907_invoice_as7W_1579882994.pdf', 2, 3, 'fener test', 39, NULL, '2020-01-24 20:23:14', '2020-01-24 20:28:27', 9, NULL, NULL),
(15, 7, NULL, '236.000', '0.000', 4, '/uploads/files/packages/invoices/01478520_invoice_SswG_1579883819.pdf', 2, 5, 'test 252', 40, NULL, '2020-01-24 20:36:59', '2020-01-25 02:16:07', 9, NULL, NULL),
(16, 11, NULL, '210.000', '0.000', 1, '/uploads/files/packages/invoices/6521563165325_invoice_o0VP_1579896615.pdf', 2, 25, 'salam', 41, NULL, '2020-01-25 00:10:15', '2020-01-25 00:16:49', NULL, '2020-01-25 00:16:49', 3),
(17, 2, NULL, '5325.000', '0.000', 4, '/uploads/files/packages/invoices/0258963215_invoice_ZykB_1579944449.pdf', 1, 1, 'test', 44, NULL, '2020-01-25 13:27:29', '2020-01-25 13:27:29', NULL, NULL, NULL),
(18, 2, NULL, '5325.000', '0.000', 4, '/uploads/files/packages/invoices/215156156_invoice_8VE9_1579945131.pdf', 1, 1, 'test', 45, NULL, '2020-01-25 13:38:51', '2020-01-25 13:38:51', NULL, NULL, NULL),
(19, 2, NULL, '5325.000', '0.000', 4, '/uploads/files/packages/invoices/215156156_invoice_jQ9x_1579945144.pdf', 1, 1, 'test', 46, NULL, '2020-01-25 13:39:04', '2020-01-25 13:39:04', NULL, NULL, NULL),
(20, 6, NULL, '5325.000', '0.000', 4, '/uploads/files/packages/invoices/19074555_invoice_iDzM_1579945323.pdf', 1, 1, 'test', 47, NULL, '2020-01-25 13:42:03', '2020-01-25 13:42:03', NULL, NULL, NULL),
(21, 2, NULL, '5325.000', '0.000', 4, '/uploads/files/packages/invoices/199721515_invoice_Wb34_1579945416.pdf', 1, 1, 'cjcsdnm', 48, NULL, '2020-01-25 13:43:36', '2020-01-25 13:43:36', NULL, NULL, NULL),
(22, 1, NULL, '5325.000', '0.000', 4, '/uploads/files/packages/invoices/19990152052_invoice_jW4s_1579945575.pdf', 1, 1, 'cdcsd', 49, NULL, '2020-01-25 13:46:15', '2020-01-25 13:46:15', NULL, NULL, NULL),
(23, 3, NULL, NULL, NULL, 1, NULL, 0, 1, NULL, 50, 9, '2020-01-27 17:35:02', '2020-01-27 17:35:02', NULL, NULL, NULL),
(24, 3, NULL, '12.000', '12.000', 1, NULL, 0, 1, NULL, 51, 9, '2020-01-27 17:43:48', '2020-01-27 17:43:48', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lb_status`
--

CREATE TABLE `lb_status` (
  `id` int(3) NOT NULL,
  `status` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `for_collector` int(1) NOT NULL DEFAULT '0',
  `for_special_order` int(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `lb_status`
--

INSERT INTO `lb_status` (`id`, `status`, `color`, `for_collector`, `for_special_order`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'package created', 'yellow', 0, 0, 1, '2019-11-06 00:00:00', NULL, NULL, NULL),
(2, 'paid', 'green', 0, 1, 1, '2019-11-06 00:00:00', NULL, NULL, NULL),
(3, 'delivered', 'blue', 0, 0, 1, '2019-11-06 00:00:00', NULL, NULL, NULL),
(4, 'received', 'green', 0, 0, 1, '2019-11-18 00:00:00', NULL, NULL, NULL),
(5, 'collected', 'green', 1, 0, 1, '2019-11-18 00:00:00', NULL, NULL, NULL),
(6, 'No invoice', 'yellow', 1, 0, 1, NULL, NULL, NULL, NULL),
(7, 'Prohibited', 'red', 1, 0, 1, NULL, NULL, NULL, NULL),
(8, 'Damaged', 'red', 1, 0, 1, NULL, NULL, NULL, NULL),
(9, 'incorrect invoice', 'yellow', 1, 0, 1, NULL, NULL, NULL, NULL),
(10, 'Not paid', 'green', 0, 1, 1, NULL, NULL, NULL, NULL),
(11, 'Declared', 'green', 0, 1, 1, NULL, NULL, NULL, NULL),
(12, 'Canceled', 'red', 0, 1, 1, NULL, NULL, NULL, NULL),
(13, 'Order placed', 'green', 0, 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `city` varchar(50) CHARACTER SET utf8 NOT NULL,
  `country_id` int(3) DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_volume` int(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `locations`
--

INSERT INTO `locations` (`id`, `city`, `country_id`, `name`, `address`, `is_volume`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'Baku', 1, 'Baku', NULL, 1, NULL, NULL, '2019-12-01 22:10:36', NULL, NULL),
(2, 'Delaware', 2, 'New Castle', '320 Comell Dr Ste C4 Wilmington, DE 19801', 0, NULL, NULL, '2019-11-01 12:03:51', NULL, NULL),
(3, 'city', 0, 'Test', NULL, 0, 1, '2019-09-02 07:03:27', '2019-09-02 07:03:32', '2019-09-02 07:03:32', 1),
(4, 'tes', 0, 'test', NULL, 1, 1, '2019-11-01 12:02:03', '2019-11-01 12:02:50', '2019-11-01 12:02:50', 1),
(5, 'Istanbul', 3, 'Istanbul', NULL, 0, 1, '2020-01-20 17:01:19', '2020-01-20 17:01:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_05_120706_create_instructions_table', 1),
(3, '2020_01_28_100730_create_prohibited_items_table', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `device1` varchar(50) CHARACTER SET utf8 NOT NULL,
  `device2` varchar(50) CHARACTER SET utf8 NOT NULL,
  `location_id` int(3) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `options`
--

INSERT INTO `options` (`id`, `title`, `device1`, `device2`, `location_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'Nizami queue printer', '40:83:DE:72:AF:B9', '192.168.92.246', 1, 1, '2019-11-23 00:00:00', '2019-11-28 17:45:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `package`
--

CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `number` varchar(255) CHARACTER SET utf8 NOT NULL,
  `internal_id` varchar(10) DEFAULT NULL,
  `client_id` bigint(20) DEFAULT NULL,
  `client_name_surname` varchar(255) DEFAULT NULL,
  `console_name` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `console` int(1) DEFAULT '0',
  `width` int(11) DEFAULT '0',
  `height` int(11) DEFAULT '0',
  `length` int(11) DEFAULT '0',
  `volume_weight` decimal(18,3) NOT NULL DEFAULT '0.000',
  `gross_weight` decimal(18,3) DEFAULT '0.000',
  `chargeable_weight` int(1) NOT NULL DEFAULT '1' COMMENT '1-gross, 2-volume',
  `total_charge_value` decimal(18,2) DEFAULT '0.00' COMMENT 'items price total',
  `paid` decimal(18,2) NOT NULL DEFAULT '0.00',
  `paid_status` int(1) NOT NULL DEFAULT '0',
  `payment_receipt` varchar(100) DEFAULT NULL,
  `payment_receipt_date` datetime DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `email_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT '0',
  `country_id` int(3) DEFAULT NULL,
  `departure_id` int(11) DEFAULT NULL,
  `destination_id` int(11) DEFAULT '1' COMMENT 'default Baku',
  `used_contract_detail_id` int(11) DEFAULT NULL,
  `last_status_id` int(3) NOT NULL DEFAULT '1',
  `last_status_date` datetime DEFAULT NULL,
  `container_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `remark` varchar(5000) DEFAULT NULL,
  `tariff_type_id` int(3) DEFAULT '1',
  `is_warehouse` int(1) NOT NULL DEFAULT '0' COMMENT '0 - anbarda qebul edilmeyib; 1 - xarici anbarda; 2- xarici anbardan cixib',
  `received_by` int(11) DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `collected_at` datetime DEFAULT NULL,
  `delivered_by` int(11) DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `package`
--

INSERT INTO `package` (`id`, `number`, `internal_id`, `client_id`, `client_name_surname`, `console_name`, `console`, `width`, `height`, `length`, `volume_weight`, `gross_weight`, `chargeable_weight`, `total_charge_value`, `paid`, `paid_status`, `payment_receipt`, `payment_receipt_date`, `unit`, `currency_id`, `email_id`, `seller_id`, `country_id`, `departure_id`, `destination_id`, `used_contract_detail_id`, `last_status_id`, `last_status_date`, `container_id`, `position_id`, `description`, `remark`, `tariff_type_id`, `is_warehouse`, `received_by`, `received_at`, `collected_at`, `delivered_by`, `delivered_at`, `created_by`, `batch_id`, `created_at`, `updated_by`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'P01103244657', 'CBR000027', 3, NULL, NULL, 0, 0, 0, 0, '0.000', '1.500', 1, '103.00', '9.98', 1, 'RC259320', '2019-11-29 15:12:12', 'kg', 1, NULL, 2, NULL, 2, 1, 5, 5, NULL, NULL, 10, NULL, NULL, 1, 0, NULL, NULL, '2019-11-28 15:46:27', NULL, '2019-11-27 10:58:27', 1, NULL, '2019-11-26 11:56:01', 1, '2019-11-29 15:12:12', NULL, NULL),
(2, '1231066702133383229150887000010012', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '25.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:21', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:21', NULL, '2019-11-26 12:03:21', NULL, NULL),
(3, '19111520130151', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '25.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:24', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:24', NULL, '2019-11-26 12:03:24', NULL, NULL),
(4, '1207076732056653229000887000010011', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:27', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:27', NULL, '2019-11-26 12:03:27', NULL, NULL),
(5, 'CBR044198', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:27', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:27', NULL, '2019-11-26 12:03:27', NULL, NULL),
(6, 'D\"6L\"RD\"YMTAHILMKAAA6J\"', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:29', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:29', NULL, '2019-11-26 12:03:29', NULL, NULL),
(7, 'M810209821', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:29', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:29', NULL, '2019-11-26 12:03:29', NULL, NULL),
(8, 'RK00000000075', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:30', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:30', NULL, '2019-11-26 12:03:30', NULL, NULL),
(9, '1207076717928203189000887000010011', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:37', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:37', NULL, '2019-11-26 12:03:37', NULL, NULL),
(10, 'CBR050230', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:38', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:38', NULL, '2019-11-26 12:03:38', NULL, NULL),
(11, '23530341576400100031', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:39', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:39', NULL, '2019-11-26 12:03:39', NULL, NULL),
(12, 'I119111202393', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:41', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:41', NULL, '2019-11-26 12:03:41', NULL, NULL),
(13, 'D\"6L\"RD\"TWTALTGQNAAA6J\"', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:43', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:43', NULL, '2019-11-26 12:03:43', NULL, NULL),
(14, 'P01103456726', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:46', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:46', NULL, '2019-11-26 12:03:46', NULL, NULL),
(15, 'D\"6L\"RD\"BOTALGZPVAAA6J\"', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:48', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:48', NULL, '2019-11-26 12:03:48', NULL, NULL),
(16, 'CBR048952', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:51', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:51', NULL, '2019-11-26 12:03:51', NULL, NULL),
(17, '1Z447F880350369526', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:55', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:55', NULL, '2019-11-26 12:03:55', NULL, NULL),
(18, '261046136897041047516070', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:03:58', NULL, NULL, NULL, 9, 1, '2019-11-26 12:03:58', NULL, '2019-11-26 12:03:58', NULL, NULL),
(19, '219052011066991047106699', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:04:00', NULL, NULL, NULL, 9, 1, '2019-11-26 12:04:00', NULL, '2019-11-26 12:04:00', NULL, NULL),
(20, '7251198413742', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:04:02', NULL, NULL, NULL, 9, 1, '2019-11-26 12:04:02', NULL, '2019-11-26 12:04:02', NULL, NULL),
(21, '219052010361011047036101', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:04:03', NULL, NULL, NULL, 9, 1, '2019-11-26 12:04:03', NULL, '2019-11-26 12:04:03', NULL, NULL),
(22, 'P01102691266', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1, 0, 9, '2019-11-26 12:04:04', NULL, NULL, NULL, 9, 1, '2019-11-26 12:04:04', NULL, '2019-11-26 12:04:04', NULL, NULL),
(23, '123ABC', 'CBR000026', 3, NULL, NULL, 0, 13, 12, 12, '0.312', '2.400', 1, '15.48', '9.68', 1, 'RC393941', '2019-11-27 11:23:14', 'kg', 1, NULL, 1, NULL, 2, 1, 5, 5, NULL, NULL, 10, NULL, NULL, 1, 0, NULL, NULL, '2019-12-19 15:55:22', 7, '2019-11-27 15:45:53', 1, NULL, '2019-11-26 11:56:01', 9, '2019-12-19 15:55:23', NULL, NULL),
(24, 'RC743474', 'CBR000025', 3, NULL, NULL, 0, 0, 0, 0, '0.000', '1.500', 1, '9.68', '9.68', 1, 'RC393941', '2019-11-27 11:23:14', 'kg', 1, NULL, 2, NULL, 2, 1, 5, 5, NULL, 2, NULL, NULL, NULL, 1, 0, NULL, NULL, '2019-11-27 17:04:45', NULL, '2019-11-27 10:58:39', 1, NULL, '2019-11-26 11:56:01', 1, '2019-11-27 17:04:45', NULL, NULL),
(25, 'RC854441', 'CBR000024', 3, NULL, NULL, 0, 0, 0, 0, '0.000', '1.500', 1, '103.00', '9.68', 1, 'RC259320', '2019-11-29 15:12:12', 'kg', 1, NULL, 2, NULL, 2, 1, 5, 2, NULL, NULL, 10, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, '2019-11-27 10:58:54', 1, NULL, '2019-11-26 11:56:01', NULL, '2019-11-29 15:12:12', NULL, NULL),
(26, '3456789012340', 'CBR000023', 3, NULL, NULL, 0, 0, 0, 0, '0.000', '1.500', 1, '103.00', '0.00', 0, 'RC393941', '2019-11-27 11:23:14', 'kg', 1, NULL, 2, NULL, 2, 1, 5, 3, NULL, NULL, 10, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, '2019-11-27 10:59:13', 1, NULL, '2019-11-26 11:56:01', NULL, '2019-11-27 11:23:14', NULL, NULL),
(27, 'RC497201', 'CBR000022', 3, NULL, NULL, 0, 0, 0, 0, '0.000', '1.500', 1, '103.00', '9.68', 1, 'RC525738', '2019-11-27 15:02:53', 'kg', 1, NULL, 2, NULL, 2, 1, 5, 9, '2020-01-06 00:00:00', NULL, 10, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, '2019-11-26 17:47:30', 1, NULL, '2019-11-26 11:56:01', NULL, '2019-11-27 15:02:53', NULL, NULL),
(28, '651615615', 'CBR000028', 4, NULL, NULL, 0, 0, 0, 0, '0.000', '1.690', 1, '0.00', '0.00', 0, NULL, NULL, 'kg', 1, NULL, 2, 2, 2, 1, NULL, 5, NULL, NULL, 1, NULL, NULL, 1, 0, NULL, NULL, '2019-12-04 14:21:07', NULL, NULL, 9, NULL, '2019-12-04 14:20:38', 9, '2019-12-04 14:21:07', NULL, NULL),
(29, '615561565', 'CBR000029', 3, NULL, NULL, 0, 0, 0, 0, '0.000', '1.600', 1, '10.32', '0.00', 0, NULL, NULL, 'kg', 1, NULL, 2, NULL, 2, 1, 5, 5, NULL, NULL, 1, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 9, NULL, '2019-12-04 14:26:08', NULL, '2019-12-04 14:26:08', NULL, NULL),
(30, '123456', NULL, 3, NULL, NULL, 0, 5, 2, 2, '0.003', '1.580', 1, '10.19', '0.00', 0, NULL, NULL, 'kg', 1, NULL, 1, NULL, 2, 1, 5, 5, NULL, NULL, 3, NULL, NULL, 1, 0, NULL, NULL, '2019-12-04 14:48:51', NULL, NULL, 9, NULL, '2019-12-04 14:41:09', 9, '2020-01-24 13:02:24', '2020-01-24 13:02:24', 3),
(31, '5156165', 'CBR000031', 3, NULL, NULL, 0, NULL, NULL, NULL, '0.000', '1.600', 1, '10.32', '0.00', 0, NULL, NULL, 'kg', 1, NULL, 2, NULL, 2, 1, 5, 5, NULL, 5, NULL, NULL, NULL, 1, 0, NULL, NULL, '2019-12-05 11:43:52', NULL, NULL, 9, NULL, '2019-12-05 10:39:46', 9, '2019-12-05 11:43:52', NULL, NULL),
(32, '156156156', NULL, 3, '', NULL, 0, NULL, NULL, NULL, '0.000', '1.900', 1, '12.26', '12.26', 1, NULL, NULL, 'kg', 1, NULL, 2, NULL, 2, 1, 5, 5, '2020-01-18 13:21:05', NULL, 3, NULL, NULL, 1, 0, NULL, NULL, '2020-01-18 13:21:05', NULL, NULL, 9, NULL, '2019-12-05 11:17:19', 9, '2020-01-24 13:07:44', '2020-01-24 13:07:44', 3),
(33, '12345670', NULL, 3, '', NULL, 0, 220, 9, 99, '32.670', '1.000', 2, '197.65', '12.38', 1, NULL, NULL, 'kg', 1, NULL, 3, NULL, 2, 1, 6, 7, '2020-01-20 00:06:45', 14, NULL, 'salam 2515', NULL, 1, 0, NULL, NULL, '2020-01-16 12:02:18', NULL, NULL, 9, NULL, '2019-12-20 01:22:21', 9, '2020-01-24 13:05:48', '2020-01-24 13:05:48', 3),
(34, '01234567890', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 2, 3, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 3, NULL, '2020-01-24 12:29:31', NULL, '2020-01-24 12:29:31', NULL, NULL),
(35, '01234567890', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 2, 3, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 3, NULL, '2020-01-24 12:30:23', NULL, '2020-01-24 12:30:23', NULL, NULL),
(36, '0123654799', NULL, NULL, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 5, 3, NULL, NULL, NULL, 11, '2020-01-24 12:39:53', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 3, NULL, '2020-01-24 12:39:53', NULL, '2020-01-24 12:39:53', NULL, NULL),
(37, '0155615656', NULL, 3, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 5, 3, NULL, NULL, NULL, 11, '2020-01-24 12:42:53', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 3, NULL, '2020-01-24 12:42:53', NULL, '2020-01-24 13:02:56', '2020-01-24 13:02:56', 3),
(38, '01234567890', 'CBR000052', 3, '', NULL, 0, 0, 0, 0, '0.000', '1.200', 1, '7.74', '0.00', 0, NULL, NULL, 'kg', 1, NULL, 2, 2, 2, 1, 5, 5, '2020-01-24 20:45:05', 3, NULL, NULL, 'test 123560023023', 1, 0, NULL, NULL, '2020-01-24 20:46:59', NULL, NULL, 3, NULL, '2020-01-24 13:14:33', 9, '2020-01-24 20:46:59', NULL, NULL),
(39, 'fb19071907', 'CBR000050', 3, '', NULL, 0, 0, 0, 0, '0.000', '1.600', 1, '10.32', '0.00', 0, NULL, NULL, 'kg', 1, NULL, 1, 2, 2, 1, 5, 5, '2020-01-24 20:28:27', NULL, 2, 'test desc', 'test qeyd', 1, 0, NULL, NULL, '2020-01-24 20:28:27', NULL, NULL, 3, NULL, '2020-01-24 20:23:14', 9, '2020-01-24 20:28:27', NULL, NULL),
(40, '01478520', 'CBR000051', 3, '', NULL, 0, 0, 0, 0, '0.000', '0.200', 1, '0.59', '0.00', 0, NULL, NULL, 'kg', 1, NULL, 16, 2, 2, 1, 1, 5, '2020-01-24 20:38:20', NULL, 5, NULL, 'fghfhhgjgj', 1, 0, NULL, NULL, '2020-01-25 02:16:07', NULL, NULL, 3, NULL, '2020-01-24 20:36:59', 9, '2020-01-25 02:16:07', NULL, NULL),
(41, '6521563165325', NULL, 3, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 11, 2, NULL, 1, NULL, 11, '2020-01-25 00:10:15', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 3, NULL, '2020-01-25 00:10:15', NULL, '2020-01-25 00:16:49', '2020-01-25 00:16:49', 3),
(42, '2589631907', NULL, 3, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, 1, NULL, 11, '2020-01-25 13:22:00', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-01-25 13:22:00', NULL, '2020-01-25 13:22:00', NULL, NULL),
(43, '0258963215', NULL, 3, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 17, 3, NULL, 1, NULL, 11, '2020-01-25 13:24:08', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-01-25 13:24:08', NULL, '2020-01-25 13:24:08', NULL, NULL),
(44, '0258963215', NULL, 3, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 17, 3, NULL, 1, NULL, 11, '2020-01-25 13:27:29', NULL, NULL, NULL, 'salam', 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-01-25 13:27:29', NULL, '2020-01-25 13:27:29', NULL, NULL),
(45, '215156156', NULL, 3, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, 1, NULL, 11, '2020-01-25 13:38:51', NULL, NULL, NULL, 'salam', 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-01-25 13:38:51', NULL, '2020-01-25 13:38:51', NULL, NULL),
(46, '215156156', NULL, 3, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 1, 3, NULL, 1, NULL, 11, '2020-01-25 13:39:04', NULL, NULL, NULL, 'salam', 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-01-25 13:39:04', NULL, '2020-01-25 13:39:04', NULL, NULL),
(47, '19074555', NULL, 3, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 2, 3, NULL, 1, NULL, 11, '2020-01-25 13:42:03', NULL, NULL, NULL, 'salam', 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-01-25 13:42:03', NULL, '2020-01-25 13:42:03', NULL, NULL),
(48, '199721515', NULL, 3, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 10, 3, NULL, 1, NULL, 11, '2020-01-25 13:43:36', NULL, NULL, NULL, 'salam', 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-01-25 13:43:36', NULL, '2020-01-25 13:43:36', NULL, NULL),
(49, '19990152052', NULL, 3, NULL, NULL, 0, 0, 0, 0, '0.000', '0.000', 1, '0.00', '0.00', 0, NULL, NULL, NULL, NULL, NULL, 10, 3, NULL, 1, NULL, 11, '2020-01-25 13:46:15', NULL, NULL, NULL, 'salam', 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2020-01-25 13:46:15', NULL, '2020-01-25 13:46:15', NULL, NULL),
(50, 'CBR000053', 'CBR000053', 4, '', NULL, 0, 1, 1, 1, '0.000', '1.000', 1, '6.45', '0.00', 0, NULL, NULL, 'kg', 1, NULL, 5, 2, 2, 1, 4, 5, '2020-01-27 17:13:26', NULL, 2, 'qwert', NULL, 1, 0, NULL, NULL, '2020-01-27 17:35:02', NULL, NULL, 9, NULL, '2020-01-27 17:13:26', 9, '2020-01-27 17:35:03', NULL, NULL),
(51, 'CBR000054', 'CBR000054', 0, 'SahIb Test', NULL, 0, 1, 1, 1, '0.000', '1.000', 1, '6.45', '0.00', 0, NULL, NULL, 'kg', 1, NULL, 2, 2, 2, 1, 4, 5, '2020-01-27 17:43:48', NULL, 2, 'asd', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 9, NULL, '2020-01-27 17:43:48', NULL, '2020-01-27 17:43:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `package_files`
--

CREATE TABLE `package_files` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `package_id` int(11) NOT NULL,
  `type` int(1) NOT NULL COMMENT '1-image, 2-file',
  `name` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `package_files`
--

INSERT INTO `package_files` (`id`, `url`, `package_id`, `type`, `name`, `extension`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, '/uploads/files/packages/images/12345670_0_Nl5l_1579362299.jpg', 33, 1, '12345670_0_Nl5l_1579362299', 'jpg', 9, '2020-01-18 19:44:59', '2020-01-19 17:09:12', '2020-01-19 17:09:12', 9),
(2, '/uploads/files/packages/images/12345670_1_z9EM_1579362299.jpg', 33, 1, '12345670_1_z9EM_1579362299', 'jpg', 9, '2020-01-18 19:44:59', '2020-01-19 17:12:54', '2020-01-19 17:12:54', 9),
(3, '/uploads/files/packages/images/12345670_0_6FaI_1579362910.jpg', 33, 1, '12345670_0_6FaI_1579362910', 'jpg', 9, '2020-01-18 19:55:10', '2020-01-19 17:12:35', '2020-01-19 17:12:35', 9),
(4, '/uploads/files/packages/images/12345670_0_ydta_1579439606.jpg', 33, 1, '12345670_0_ydta_1579439606', 'jpg', 9, '2020-01-19 17:13:26', '2020-01-19 17:13:57', '2020-01-19 17:13:57', 9),
(5, '/uploads/files/packages/images/12345670_1_T1Ql_1579439606.jpg', 33, 1, '12345670_1_T1Ql_1579439606', 'jpg', 9, '2020-01-19 17:13:26', '2020-01-19 17:13:26', NULL, NULL),
(6, '/uploads/files/packages/images/12345670_0_U3Yt_1579441584.jpg', 33, 1, '12345670_0_U3Yt_1579441584', 'jpg', 9, '2020-01-19 17:46:24', '2020-01-19 17:46:24', NULL, NULL),
(7, '/uploads/files/packages/images/01234567890_0_9iWD_1579884196.JPG', 38, 1, '01234567890_0_9iWD_1579884196', 'JPG', 9, '2020-01-24 20:43:16', '2020-01-24 20:43:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `package_status`
--

CREATE TABLE `package_status` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `status_id` int(3) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `package_status`
--

INSERT INTO `package_status` (`id`, `package_id`, `status_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 5, 1, '2019-11-26 11:56:01', '2019-11-26 11:56:01', NULL, NULL),
(2, 1, 2, 6, '2019-11-26 12:00:46', '2019-11-26 12:00:46', NULL, NULL),
(3, 1, 3, 7, '2019-11-26 12:02:51', '2019-11-26 12:02:51', NULL, NULL),
(4, 2, 4, 9, '2019-11-26 12:03:21', '2019-11-26 12:03:21', NULL, NULL),
(5, 3, 4, 9, '2019-11-26 12:03:24', '2019-11-26 12:03:24', NULL, NULL),
(6, 4, 4, 9, '2019-11-26 12:03:27', '2019-11-26 12:03:27', NULL, NULL),
(7, 5, 4, 9, '2019-11-26 12:03:27', '2019-11-26 12:03:27', NULL, NULL),
(8, 6, 4, 9, '2019-11-26 12:03:29', '2019-11-26 12:03:29', NULL, NULL),
(9, 7, 4, 9, '2019-11-26 12:03:29', '2019-11-26 12:03:29', NULL, NULL),
(10, 8, 4, 9, '2019-11-26 12:03:30', '2019-11-26 12:03:30', NULL, NULL),
(11, 9, 4, 9, '2019-11-26 12:03:37', '2019-11-26 12:03:37', NULL, NULL),
(12, 10, 4, 9, '2019-11-26 12:03:38', '2019-11-26 12:03:38', NULL, NULL),
(13, 11, 4, 9, '2019-11-26 12:03:39', '2019-11-26 12:03:39', NULL, NULL),
(14, 12, 4, 9, '2019-11-26 12:03:41', '2019-11-26 12:03:41', NULL, NULL),
(15, 13, 4, 9, '2019-11-26 12:03:43', '2019-11-26 12:03:43', NULL, NULL),
(16, 14, 4, 9, '2019-11-26 12:03:46', '2019-11-26 12:03:46', NULL, NULL),
(17, 15, 4, 9, '2019-11-26 12:03:48', '2019-11-26 12:03:48', NULL, NULL),
(18, 16, 4, 9, '2019-11-26 12:03:51', '2019-11-26 12:03:51', NULL, NULL),
(19, 17, 4, 9, '2019-11-26 12:03:55', '2019-11-26 12:03:55', NULL, NULL),
(20, 18, 4, 9, '2019-11-26 12:03:58', '2019-11-26 12:03:58', NULL, NULL),
(21, 19, 4, 9, '2019-11-26 12:04:00', '2019-11-26 12:04:00', NULL, NULL),
(22, 20, 4, 9, '2019-11-26 12:04:02', '2019-11-26 12:04:02', NULL, NULL),
(23, 21, 4, 9, '2019-11-26 12:04:03', '2019-11-26 12:04:03', NULL, NULL),
(24, 22, 4, 9, '2019-11-26 12:04:04', '2019-11-26 12:04:04', NULL, NULL),
(25, 1, 2, 6, '2019-11-26 14:54:20', '2019-11-26 14:54:20', NULL, NULL),
(26, 1, 2, 6, '2019-11-26 17:20:11', '2019-11-26 17:20:11', NULL, NULL),
(27, 1, 3, 7, '2019-11-26 17:29:03', '2019-11-26 17:29:03', NULL, NULL),
(28, 1, 2, 6, '2019-11-26 17:35:46', '2019-11-26 17:35:46', NULL, NULL),
(29, 23, 2, 6, '2019-11-26 17:35:46', '2019-11-26 17:35:46', NULL, NULL),
(30, 27, 2, 6, '2019-11-26 17:44:51', '2019-11-26 17:44:51', NULL, NULL),
(31, 26, 2, 6, '2019-11-26 17:44:51', '2019-11-26 17:44:51', NULL, NULL),
(32, 27, 3, 7, '2019-11-26 17:47:30', '2019-11-26 17:47:30', NULL, NULL),
(33, 26, 3, 7, '2019-11-26 17:47:42', '2019-11-26 17:47:42', NULL, NULL),
(34, 24, 2, 6, '2019-11-27 09:42:59', '2019-11-27 09:42:59', NULL, NULL),
(35, 25, 2, 6, '2019-11-27 09:42:59', '2019-11-27 09:42:59', NULL, NULL),
(36, 23, 3, 7, '2019-11-27 10:04:50', '2019-11-27 10:04:50', NULL, NULL),
(37, 23, 3, 7, '2019-11-27 10:24:44', '2019-11-27 10:24:44', NULL, NULL),
(38, 23, 3, 7, '2019-11-27 10:27:35', '2019-11-27 10:27:35', NULL, NULL),
(39, 1, 2, 6, '2019-11-27 10:42:02', '2019-11-27 10:42:02', NULL, NULL),
(40, 24, 2, 6, '2019-11-27 10:44:26', '2019-11-27 10:44:26', NULL, NULL),
(41, 25, 2, 6, '2019-11-27 10:45:56', '2019-11-27 10:45:56', NULL, NULL),
(42, 23, 2, 6, '2019-11-27 10:56:33', '2019-11-27 10:56:33', NULL, NULL),
(43, 26, 2, 6, '2019-11-27 10:56:33', '2019-11-27 10:56:33', NULL, NULL),
(44, 23, 3, 7, '2019-11-27 10:58:09', '2019-11-27 10:58:09', NULL, NULL),
(45, 1, 3, 7, '2019-11-27 10:58:27', '2019-11-27 10:58:27', NULL, NULL),
(46, 24, 3, 7, '2019-11-27 10:58:40', '2019-11-27 10:58:40', NULL, NULL),
(47, 25, 3, 7, '2019-11-27 10:58:54', '2019-11-27 10:58:54', NULL, NULL),
(48, 26, 3, 7, '2019-11-27 10:59:13', '2019-11-27 10:59:13', NULL, NULL),
(49, 27, 2, 6, '2019-11-27 11:25:41', '2019-11-27 11:25:41', NULL, NULL),
(50, 25, 2, 6, '2019-11-27 11:25:41', '2019-11-27 11:25:41', NULL, NULL),
(51, 23, 2, 6, '2019-11-27 11:25:41', '2019-11-27 11:25:41', NULL, NULL),
(52, 24, 2, 6, '2019-11-27 11:25:42', '2019-11-27 11:25:42', NULL, NULL),
(53, 23, 3, 7, '2019-11-27 11:27:34', '2019-11-27 11:27:34', NULL, NULL),
(54, 23, 3, 7, '2019-11-27 11:31:05', '2019-11-27 11:31:05', NULL, NULL),
(55, 23, 3, 7, '2019-11-27 11:33:45', '2019-11-27 11:33:45', NULL, NULL),
(56, 23, 3, 7, '2019-11-27 11:34:28', '2019-11-27 11:34:28', NULL, NULL),
(57, 23, 3, 7, '2019-11-27 11:56:09', '2019-11-27 11:56:09', NULL, NULL),
(58, 23, 3, 7, '2019-11-27 11:59:01', '2019-11-27 11:59:01', NULL, NULL),
(59, 23, 3, 7, '2019-11-27 12:01:30', '2019-11-27 12:01:30', NULL, NULL),
(60, 23, 3, 7, '2019-11-27 12:03:18', '2019-11-27 12:03:18', NULL, NULL),
(61, 23, 3, 7, '2019-11-27 12:06:36', '2019-11-27 12:06:36', NULL, NULL),
(62, 23, 3, 7, '2019-11-27 12:07:41', '2019-11-27 12:07:41', NULL, NULL),
(63, 23, 3, 7, '2019-11-27 12:08:55', '2019-11-27 12:08:55', NULL, NULL),
(64, 23, 3, 7, '2019-11-27 12:11:30', '2019-11-27 12:11:30', NULL, NULL),
(65, 23, 3, 7, '2019-11-27 12:13:45', '2019-11-27 12:13:45', NULL, NULL),
(66, 23, 3, 7, '2019-11-27 12:17:51', '2019-11-27 12:17:51', NULL, NULL),
(67, 23, 3, 7, '2019-11-27 15:24:21', '2019-11-27 15:24:21', NULL, NULL),
(68, 23, 3, 7, '2019-11-27 15:27:37', '2019-11-27 15:27:37', NULL, NULL),
(69, 23, 3, 7, '2019-11-27 15:35:34', '2019-11-27 15:35:34', NULL, NULL),
(70, 23, 3, 7, '2019-11-27 15:39:48', '2019-11-27 15:39:48', NULL, NULL),
(71, 23, 3, 7, '2019-11-27 15:44:39', '2019-11-27 15:44:39', NULL, NULL),
(72, 23, 3, 7, '2019-11-27 15:45:53', '2019-11-27 15:45:53', NULL, NULL),
(73, 24, 5, 1, '2019-11-27 17:04:45', '2019-11-27 17:04:45', NULL, NULL),
(74, 1, 5, 1, '2019-11-28 15:46:27', '2019-11-28 15:46:27', NULL, NULL),
(75, 28, 5, 9, '2019-12-04 14:20:38', '2019-12-04 14:20:38', NULL, NULL),
(76, 28, 5, 9, '2019-12-04 14:21:07', '2019-12-04 14:21:07', NULL, NULL),
(77, 29, 5, 9, '2019-12-04 14:26:08', '2019-12-04 14:26:08', NULL, NULL),
(78, 30, 5, 9, '2019-12-04 14:41:09', '2019-12-04 14:41:09', NULL, NULL),
(79, 30, 5, 9, '2019-12-04 14:41:38', '2019-12-04 14:41:38', NULL, NULL),
(80, 31, 5, 9, '2019-12-05 10:39:46', '2019-12-05 10:39:46', NULL, NULL),
(81, 31, 5, 9, '2019-12-05 11:15:00', '2019-12-05 11:15:00', NULL, NULL),
(82, 32, 5, 9, '2019-12-05 11:17:19', '2019-12-05 11:17:19', NULL, NULL),
(83, 23, 5, 9, '2019-12-19 15:55:22', '2019-12-19 15:55:22', NULL, NULL),
(84, 33, 5, 9, '2019-12-20 01:22:21', '2019-12-20 01:22:21', NULL, NULL),
(85, 33, 5, 9, '2019-12-20 01:23:38', '2019-12-20 01:23:38', NULL, NULL),
(86, 32, 5, 9, '2019-12-24 02:21:53', '2019-12-24 02:21:53', NULL, NULL),
(87, 33, 5, 9, '2019-12-28 15:28:57', '2019-12-28 15:28:57', NULL, NULL),
(88, 33, 7, 9, '2019-12-28 15:34:05', '2019-12-28 15:34:05', NULL, NULL),
(89, 33, 8, 9, '2019-12-28 15:35:49', '2019-12-28 15:35:49', NULL, NULL),
(90, 32, 2, 3, '2019-12-28 16:49:44', '2019-12-28 16:49:44', NULL, NULL),
(91, 33, 2, 3, '2019-12-28 16:49:44', '2019-12-28 16:49:44', NULL, NULL),
(92, 32, 2, 3, '2019-12-28 16:50:09', '2019-12-28 16:50:09', NULL, NULL),
(93, 33, 2, 3, '2019-12-28 16:50:09', '2019-12-28 16:50:09', NULL, NULL),
(94, 32, 2, 3, '2019-12-28 16:53:11', '2019-12-28 16:53:11', NULL, NULL),
(95, 33, 2, 3, '2019-12-28 16:53:11', '2019-12-28 16:53:11', NULL, NULL),
(96, 33, 5, 9, '2020-01-16 11:04:35', '2020-01-16 11:04:35', NULL, NULL),
(97, 33, 7, 9, '2020-01-16 12:03:06', '2020-01-16 12:03:06', NULL, NULL),
(98, 33, 8, 9, '2020-01-16 12:03:54', '2020-01-16 12:03:54', NULL, NULL),
(99, 33, 7, 9, '2020-01-16 13:11:01', '2020-01-16 13:11:01', NULL, NULL),
(100, 33, 6, 9, '2020-01-16 20:22:55', '2020-01-16 20:22:55', NULL, NULL),
(101, 33, 7, 9, '2020-01-16 20:30:48', '2020-01-16 20:30:48', NULL, NULL),
(102, 33, 8, 9, '2020-01-16 20:33:54', '2020-01-16 20:33:54', NULL, NULL),
(103, 33, 6, 9, '2020-01-16 20:35:49', '2020-01-16 20:35:49', NULL, NULL),
(104, 33, 8, 9, '2020-01-16 20:43:02', '2020-01-16 20:43:02', NULL, NULL),
(105, 33, 7, 9, '2020-01-16 20:46:57', '2020-01-16 20:46:57', NULL, NULL),
(106, 33, 8, 9, '2020-01-16 20:48:25', '2020-01-16 20:48:25', NULL, NULL),
(107, 33, 7, 9, '2020-01-16 20:49:21', '2020-01-16 20:49:21', NULL, NULL),
(108, 33, 8, 9, '2020-01-16 20:51:01', '2020-01-16 20:51:01', NULL, NULL),
(109, 33, 7, 9, '2020-01-16 21:17:24', '2020-01-16 21:17:24', NULL, NULL),
(110, 33, 8, 9, '2020-01-16 21:24:31', '2020-01-16 21:24:31', NULL, NULL),
(111, 33, 7, 9, '2020-01-16 21:25:10', '2020-01-16 21:25:10', NULL, NULL),
(112, 33, 8, 9, '2020-01-16 21:25:37', '2020-01-16 21:25:37', NULL, NULL),
(113, 33, 7, 9, '2020-01-16 21:26:05', '2020-01-16 21:26:05', NULL, NULL),
(114, 33, 6, 9, '2020-01-16 21:27:53', '2020-01-16 21:27:53', NULL, NULL),
(115, 33, 7, 9, '2020-01-16 21:35:46', '2020-01-16 21:35:46', NULL, NULL),
(116, 32, 5, 9, '2020-01-18 13:21:05', '2020-01-18 13:21:05', NULL, NULL),
(117, 33, 8, 9, '2020-01-18 19:44:59', '2020-01-18 19:44:59', NULL, NULL),
(118, 33, 7, 9, '2020-01-18 19:54:03', '2020-01-18 19:54:03', NULL, NULL),
(119, 33, 8, 9, '2020-01-18 19:55:10', '2020-01-18 19:55:10', NULL, NULL),
(120, 33, 7, 9, '2020-01-19 17:13:26', '2020-01-19 17:13:26', NULL, NULL),
(121, 33, 8, 9, '2020-01-19 17:17:24', '2020-01-19 17:17:24', NULL, NULL),
(122, 33, 6, 9, '2020-01-20 00:03:37', '2020-01-20 00:03:37', NULL, NULL),
(123, 33, 7, 9, '2020-01-20 00:06:45', '2020-01-20 00:06:45', NULL, NULL),
(124, 36, 11, 3, '2020-01-24 12:39:53', '2020-01-24 12:39:53', NULL, NULL),
(125, 37, 11, 3, '2020-01-24 12:42:53', '2020-01-24 12:42:53', NULL, NULL),
(126, 38, 11, 3, '2020-01-24 13:14:33', '2020-01-24 13:14:33', NULL, NULL),
(127, 39, 11, 3, '2020-01-24 20:23:14', '2020-01-24 20:23:14', NULL, NULL),
(128, 39, 5, 9, '2020-01-24 20:28:27', '2020-01-24 20:28:27', NULL, NULL),
(129, 40, 11, 3, '2020-01-24 20:36:59', '2020-01-24 20:36:59', NULL, NULL),
(130, 40, 5, 9, '2020-01-24 20:38:20', '2020-01-24 20:38:20', NULL, NULL),
(131, 38, 7, 9, '2020-01-24 20:43:16', '2020-01-24 20:43:16', NULL, NULL),
(132, 38, 5, 9, '2020-01-24 20:45:05', '2020-01-24 20:45:05', NULL, NULL),
(133, 41, 11, 3, '2020-01-25 00:10:15', '2020-01-25 00:10:15', NULL, NULL),
(134, 42, 11, 1, '2020-01-25 13:22:00', '2020-01-25 13:22:00', NULL, NULL),
(135, 43, 11, 1, '2020-01-25 13:24:08', '2020-01-25 13:24:08', NULL, NULL),
(136, 44, 11, 1, '2020-01-25 13:27:29', '2020-01-25 13:27:29', NULL, NULL),
(137, 45, 11, 1, '2020-01-25 13:38:51', '2020-01-25 13:38:51', NULL, NULL),
(138, 46, 11, 1, '2020-01-25 13:39:04', '2020-01-25 13:39:04', NULL, NULL),
(139, 47, 11, 1, '2020-01-25 13:42:03', '2020-01-25 13:42:03', NULL, NULL),
(140, 48, 11, 1, '2020-01-25 13:43:36', '2020-01-25 13:43:36', NULL, NULL),
(141, 49, 11, 1, '2020-01-25 13:46:15', '2020-01-25 13:46:15', NULL, NULL),
(142, 50, 5, 9, '2020-01-27 17:13:26', '2020-01-27 17:13:26', NULL, NULL),
(143, 51, 5, 9, '2020-01-27 17:43:48', '2020-01-27 17:43:48', NULL, NULL);

--
-- Tetikleyiciler `package_status`
--
DELIMITER $$
CREATE TRIGGER `add_last_status` AFTER INSERT ON `package_status` FOR EACH ROW UPDATE package SET last_status_id = NEW.status_id, last_status_date = NEW.created_at WHERE id = NEW.package_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `packing_services`
--

CREATE TABLE `packing_services` (
  `id` int(3) NOT NULL,
  `title` varchar(50) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `packing_services`
--

INSERT INTO `packing_services` (`id`, `title`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'Minimize the Package', NULL, NULL, NULL, NULL, NULL),
(2, 'Original Outer  Package must be used', NULL, NULL, NULL, NULL, NULL),
(3, 'Original Inner  Package must be used', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payment_log`
--

CREATE TABLE `payment_log` (
  `id` int(11) NOT NULL,
  `payment` decimal(18,2) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `payment_log`
--

INSERT INTO `payment_log` (`id`, `payment`, `currency_id`, `client_id`, `package_id`, `type`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, '9.68', 1, 3, 1, 1, 6, '2019-11-26 12:00:46', '2019-11-26 12:00:46', NULL, NULL),
(2, '9.68', 1, 3, 1, 1, 6, '2019-11-26 14:54:20', '2019-11-26 14:54:20', NULL, NULL),
(3, '9.68', 1, 3, 1, 1, 6, '2019-11-26 17:20:11', '2019-11-26 17:20:11', NULL, NULL),
(4, '9.68', 1, 3, 1, 1, 6, '2019-11-26 17:35:46', '2019-11-26 17:35:46', NULL, NULL),
(5, '9.68', 1, 3, 23, 1, 6, '2019-11-26 17:35:46', '2019-11-26 17:35:46', NULL, NULL),
(6, '9.68', 1, 3, 27, 1, 6, '2019-11-26 17:44:51', '2019-11-26 17:44:51', NULL, NULL),
(7, '9.68', 1, 3, 26, 1, 6, '2019-11-26 17:44:51', '2019-11-26 17:44:51', NULL, NULL),
(8, '9.68', 1, 3, 24, 1, 6, '2019-11-27 09:42:59', '2019-11-27 09:42:59', NULL, NULL),
(9, '9.68', 1, 3, 25, 1, 6, '2019-11-27 09:42:59', '2019-11-27 09:42:59', NULL, NULL),
(10, '9.68', 1, 3, 1, 1, 6, '2019-11-27 10:42:02', '2019-11-27 10:42:02', NULL, NULL),
(11, '9.68', 1, 3, 24, 1, 6, '2019-11-27 10:44:26', '2019-11-27 10:44:26', NULL, NULL),
(12, '9.68', 1, 3, 25, 1, 6, '2019-11-27 10:45:55', '2019-11-27 10:45:55', NULL, NULL),
(13, '9.68', 1, 3, 23, 1, 6, '2019-11-27 10:56:33', '2019-11-27 10:56:33', NULL, NULL),
(14, '9.68', 1, 3, 26, 1, 6, '2019-11-27 10:56:33', '2019-11-27 10:56:33', NULL, NULL),
(15, '9.68', 1, 3, 27, 1, 6, '2019-11-27 11:25:41', '2019-11-27 11:25:41', NULL, NULL),
(16, '9.68', 1, 3, 24, 1, 6, '2019-11-27 11:25:41', '2019-11-27 11:25:41', NULL, NULL),
(17, '9.68', 1, 3, 25, 1, 6, '2019-11-27 11:25:41', '2019-11-27 11:25:41', NULL, NULL),
(18, '9.68', 1, 3, 23, 1, 6, '2019-11-27 11:25:41', '2019-11-27 11:25:41', NULL, NULL),
(19, '12.26', 1, 3, 32, 1, 3, '2019-12-28 16:49:44', '2019-12-28 16:49:44', NULL, NULL),
(20, '12.38', 1, 3, 33, 1, 3, '2019-12-28 16:49:44', '2019-12-28 16:49:44', NULL, NULL),
(21, '12.26', 1, 3, 32, 1, 3, '2019-12-28 16:50:09', '2019-12-28 16:50:09', NULL, NULL),
(22, '12.38', 1, 3, 33, 1, 3, '2019-12-28 16:50:09', '2019-12-28 16:50:09', NULL, NULL),
(23, '12.26', 1, 3, 32, 1, 3, '2019-12-28 16:53:11', '2019-12-28 16:53:11', NULL, NULL),
(24, '12.38', 1, 3, 33, 1, 3, '2019-12-28 16:53:11', '2019-12-28 16:53:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payment_task`
--

CREATE TABLE `payment_task` (
  `id` int(11) NOT NULL,
  `payment_key` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `is_paid` int(1) NOT NULL DEFAULT '0',
  `response_code` varchar(2) DEFAULT NULL,
  `response_code_description` varchar(255) DEFAULT NULL,
  `response_rc` varchar(3) DEFAULT NULL,
  `response_rc_description` varchar(255) DEFAULT NULL,
  `pan` varchar(50) DEFAULT NULL,
  `amount` varchar(10) DEFAULT NULL,
  `response_str` varchar(1000) DEFAULT NULL,
  `type` varchar(10) NOT NULL COMMENT 'millikart, paytr',
  `ip_address` varchar(30) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `payment_task`
--

INSERT INTO `payment_task` (`id`, `payment_key`, `status`, `is_paid`, `response_code`, `response_code_description`, `response_rc`, `response_rc_description`, `pan`, `amount`, `response_str`, `type`, `ip_address`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'hIHRCV', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 15:38:37', '2020-01-28 15:38:37', NULL, NULL),
(2, 'ekxm9J', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:15:14', '2020-01-28 19:15:14', NULL, NULL),
(3, 'PbMVyg', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:16:10', '2020-01-28 19:16:10', NULL, NULL),
(4, 'qfzgGc', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:17:13', '2020-01-28 19:17:13', NULL, NULL),
(5, '8AGAEb', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:17:35', '2020-01-28 19:17:35', NULL, NULL),
(6, 'WIX5VC', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:17:59', '2020-01-28 19:17:59', NULL, NULL),
(7, 'aUAElb', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:18:14', '2020-01-28 19:18:14', NULL, NULL),
(8, '7xon84', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:18:25', '2020-01-28 19:18:25', NULL, NULL),
(9, 'ooeW6D', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:18:43', '2020-01-28 19:18:43', NULL, NULL),
(10, 'jM7pO3', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:18:58', '2020-01-28 19:18:58', NULL, NULL),
(11, 'F5te50', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:19:10', '2020-01-28 19:19:10', NULL, NULL),
(12, 'Cm8Ufp', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:22:39', '2020-01-28 19:22:39', NULL, NULL),
(13, 'u9sRRO', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:23:23', '2020-01-28 19:23:23', NULL, NULL),
(14, 'FqJDPE', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:23:55', '2020-01-28 19:23:55', NULL, NULL),
(15, '1o3MgP', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:24:12', '2020-01-28 19:24:12', NULL, NULL),
(16, '4Xgr6A', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:24:29', '2020-01-28 19:24:29', NULL, NULL),
(17, 'fUBm0y', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:25:48', '2020-01-28 19:25:48', NULL, NULL),
(18, 'btHEXU', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:26:16', '2020-01-28 19:26:16', NULL, NULL),
(19, 'rgNAqN', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:26:47', '2020-01-28 19:26:47', NULL, NULL),
(20, 'yt2G9t', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:27:05', '2020-01-28 19:27:05', NULL, NULL),
(21, 'MpR3FN', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:29:06', '2020-01-28 19:29:06', NULL, NULL),
(22, 'KZhXiH', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:29:29', '2020-01-28 19:29:29', NULL, NULL),
(23, 'A86nqt', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:31:00', '2020-01-28 19:31:00', NULL, NULL),
(24, '3FQ5uS', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:31:18', '2020-01-28 19:31:18', NULL, NULL),
(25, 'jopiHF', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 19:32:21', '2020-01-28 19:32:21', NULL, NULL),
(26, 'sJm8MM', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 20:11:41', '2020-01-28 20:11:41', NULL, NULL),
(27, 'iXvzip', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 20:12:17', '2020-01-28 20:12:17', NULL, NULL),
(28, 'edNKNu', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 20:12:25', '2020-01-28 20:12:25', NULL, NULL),
(29, 'Sej1qa', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 20:12:47', '2020-01-28 20:12:47', NULL, NULL),
(30, '4JucO3cHo6', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'millikart', '127.0.0.1', 3, '2020-01-28 20:28:35', '2020-01-28 20:28:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `active_tracking_log` int(11) DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `location_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `position`
--

INSERT INTO `position` (`id`, `active_tracking_log`, `name`, `location_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 0, 'NCL1', 2, NULL, NULL, NULL, NULL, NULL),
(2, 0, 'NCL2', 2, NULL, NULL, NULL, NULL, NULL),
(3, 0, 'NCL3', 2, NULL, NULL, NULL, NULL, NULL),
(4, 0, 'NCL4', 2, NULL, NULL, NULL, NULL, NULL),
(5, 0, 'NCL5', 2, NULL, NULL, NULL, NULL, NULL),
(6, 0, 'NCL6', 2, NULL, NULL, NULL, NULL, NULL),
(7, 0, 'NCL7', 2, NULL, NULL, NULL, NULL, NULL),
(8, 0, 'NCL8', 2, NULL, NULL, NULL, NULL, NULL),
(9, 0, 'NCL9', 2, NULL, NULL, NULL, NULL, NULL),
(10, 2, 'NCL10', 2, NULL, NULL, NULL, NULL, NULL),
(11, 1, 'NCL11', 2, NULL, NULL, NULL, NULL, NULL),
(12, 0, 'NCL12', 2, NULL, NULL, NULL, NULL, NULL),
(13, 0, 'NCL13', 2, NULL, NULL, NULL, NULL, NULL),
(14, 0, 'NCL14', 2, NULL, NULL, NULL, NULL, NULL),
(15, 0, 'NCL15', 2, NULL, NULL, NULL, NULL, NULL),
(16, 0, 'NCL16', 2, NULL, NULL, NULL, NULL, NULL),
(17, 1, 'NCL17', 2, NULL, NULL, NULL, NULL, NULL),
(18, 0, 'NCL18', 2, NULL, NULL, NULL, NULL, NULL),
(19, 0, 'NCL19', 2, NULL, NULL, NULL, NULL, NULL),
(20, 0, 'NCL20', 2, NULL, NULL, NULL, NULL, NULL),
(21, 0, 'NCL21', 2, NULL, NULL, NULL, NULL, NULL),
(22, 0, 'NCL22', 2, NULL, NULL, NULL, NULL, NULL),
(23, 0, 'NCL23', 2, NULL, NULL, NULL, NULL, NULL),
(24, 0, 'NCL24', 2, NULL, NULL, NULL, NULL, NULL),
(25, 0, 'NCL25', 2, NULL, NULL, NULL, NULL, NULL),
(26, 0, 'NCL26', 2, NULL, NULL, NULL, NULL, NULL),
(27, 1, 'NCL27', 2, NULL, NULL, NULL, NULL, NULL),
(28, 2, 'NCL28', 2, NULL, NULL, NULL, NULL, NULL),
(29, 5, 'NCL29', 2, NULL, NULL, NULL, NULL, NULL),
(30, 6, 'NCL30', 2, NULL, NULL, NULL, NULL, NULL),
(31, 6, 'NZM1', 1, NULL, NULL, NULL, NULL, NULL),
(32, 0, 'NZM2', 1, NULL, NULL, NULL, NULL, NULL),
(33, 0, 'NZM3', 1, NULL, NULL, NULL, NULL, NULL),
(34, 0, 'NZM4', 1, NULL, NULL, NULL, NULL, NULL),
(35, 0, 'NZM5', 1, NULL, NULL, NULL, NULL, NULL),
(36, 0, 'NZM6', 1, NULL, NULL, NULL, NULL, NULL),
(37, 0, 'NZM7', 1, NULL, NULL, NULL, NULL, NULL),
(38, 0, 'NZM8', 1, NULL, NULL, NULL, NULL, NULL),
(39, 0, 'NZM9', 1, NULL, NULL, NULL, NULL, NULL),
(40, 1, 'NZM10', 1, NULL, NULL, NULL, NULL, NULL),
(41, 0, 'NZM11', 1, NULL, NULL, NULL, NULL, NULL),
(42, 0, 'NZM12', 1, NULL, NULL, NULL, NULL, NULL),
(43, 0, 'NZM13', 1, NULL, NULL, NULL, NULL, NULL),
(44, 0, 'NZM14', 1, NULL, NULL, NULL, NULL, NULL),
(45, 0, 'NZM15', 1, NULL, NULL, NULL, NULL, NULL),
(46, 0, 'NZM16', 1, NULL, NULL, NULL, NULL, NULL),
(47, 1, 'NZM17', 1, NULL, NULL, NULL, NULL, NULL),
(48, 0, 'NZM18', 1, NULL, NULL, NULL, NULL, NULL),
(49, 0, 'NZM19', 1, NULL, NULL, NULL, NULL, NULL),
(50, 0, 'NZM20', 1, NULL, NULL, NULL, NULL, NULL),
(51, 1, 'NZM21', 1, NULL, NULL, NULL, NULL, NULL),
(52, 0, 'NZM22', 1, NULL, NULL, NULL, NULL, NULL),
(53, 0, 'NZM23', 1, NULL, NULL, NULL, NULL, NULL),
(54, 0, 'NZM24', 1, NULL, NULL, NULL, NULL, NULL),
(55, 0, 'NZM25', 1, NULL, NULL, NULL, NULL, NULL),
(56, 0, 'NZM26', 1, NULL, NULL, NULL, NULL, NULL),
(57, 0, 'NZM27', 1, NULL, NULL, NULL, NULL, NULL),
(58, 0, 'NZM28', 1, NULL, NULL, NULL, NULL, NULL),
(59, 3, 'NZM29', 1, NULL, NULL, NULL, NULL, NULL),
(60, 0, 'NZM30', 1, NULL, NULL, NULL, NULL, NULL),
(61, 0, 'NZM31', 1, NULL, NULL, NULL, NULL, NULL),
(62, 0, 'NZM32', 1, NULL, NULL, NULL, NULL, NULL),
(63, 0, 'NCL31', 2, NULL, NULL, NULL, NULL, NULL),
(64, 0, 'NCL32', 2, NULL, NULL, NULL, NULL, NULL),
(65, 13, 'DL', 2, NULL, NULL, NULL, NULL, NULL),
(66, 0, 'test', 2, 1, '2019-09-02 10:38:17', '2019-09-02 10:40:46', '2019-09-02 10:40:46', 1),
(67, 0, 'test23', 2, 1, '2019-09-02 10:39:41', '2019-09-02 10:47:49', '2019-09-02 10:47:49', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `prohibited_items`
--

CREATE TABLE `prohibited_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` int(11) NOT NULL,
  `item` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `prohibited_items`
--

INSERT INTO `prohibited_items` (`id`, `country_id`, `item`, `created_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '<al>\r\n	<li>Xüsusi saxlanma tələb edən və tez xarab olan mallar.</li>\r\n	<li>Qida məhsulları, spirt tərkibli məhsullar, siqaret, siqar, tütün məhsulları, elektron siqaret.</li>\r\n	<li>Heyvanlar, heyvan dəriləri, flora və fauna, toxumlar.</li>\r\n	<li>Əxlaq pozğunluğunu, zorakılığı, terrorizmi təbliğ və reklam edən materiallar.</li>\r\n	<li>Mobil telefonlar.</li>\r\n	<li>Akkumulatorlar, amortizatorlar, maşın yağları və maşın yağının olduğu bütün mallar.</li>\r\n	<li>Narkotik, psixotrop, zəhərləyici, partlayıcı maddələrin hazırlanması texnologiyasına aid materiallar.</li>\r\n	<li>Zərgərlik əşyaları, qiymətli qaşlar və metallar.</li>\r\n	<li>Pul (Banknotlar, kredit kartları, debit və ya hədiyyə kartları) və səyahət çekləri.</li>\r\n	<li>Bütün növ silahlar, odlu silah hissələri (tüfəng çəngəlləri, tetik mexanizmləri, vintlər / boltlar və s. daxil olmaqla), döyüş sursatı, hərbi təyinatlı hər cür əşyalar, partlayıcı maddələr, hərbi texnika, ov tüfəngi üçün patronunun yenidən doldurulması aparatı.</li>\r\n	<li>Azərbaycan Respublikasında Müdafiə, Milli Təhlükəsizlik və Daxili İşlər nazirliyinin operativ istintaq fəaliyyəti üzrə informasiya sistemləri, gizli kameralar, xüsusi məxfi rabitə vasitələri və digər casus avadanlıqları.</li>\r\n	<li>Təhlükəli mallar, aerozollar(quru şampun, sprey, parfumeriya və s.), tezalışan tərkibli mallar, quru buz, bioloji maddələr, təzyiq altında olan mallar və Beynəlxalq Hava Nəqliyyatı Assosiasiyasının (\"IATA\") qaydalarına uyğun olaraq Hava Nəqliyyatı vasitəsi ilə daşınılması mümkün olmayan mallar.</li>\r\n</al>', 1, NULL, NULL, '2019-09-19 08:00:25', '2019-09-02 20:00:00'),
(2, 2, '<al>\r\n	<li>Xüsusi saxlanma tələb edən və tez xarab olan mallar.</li>\r\n	<li>Qida məhsulları, spirt tərkibli məhsullar, siqaret, siqar, tütün məhsulları, elektron siqaret.</li>\r\n	<li>Heyvanlar, heyvan dəriləri, flora və fauna, toxumlar.</li>\r\n	<li>Əxlaq pozğunluğunu, zorakılığı, terrorizmi təbliğ və reklam edən materiallar.</li>\r\n	<li>Mobil telefonlar.</li>\r\n	<li>Akkumulatorlar, amortizatorlar, maşın yağları və maşın yağının olduğu bütün mallar.</li>\r\n	<li>Narkotik, psixotrop, zəhərləyici, partlayıcı maddələrin hazırlanması texnologiyasına aid materiallar.</li>\r\n	<li>Zərgərlik əşyaları, qiymətli qaşlar və metallar.</li>\r\n	<li>Pul (Banknotlar, kredit kartları, debit və ya hədiyyə kartları) və səyahət çekləri.</li>\r\n	<li>Bütün növ silahlar, odlu silah hissələri (tüfəng çəngəlləri, tetik mexanizmləri, vintlər / boltlar və s. daxil olmaqla), döyüş sursatı, hərbi təyinatlı hər cür əşyalar, partlayıcı maddələr, hərbi texnika, ov tüfəngi üçün patronunun yenidən doldurulması aparatı.</li>\r\n	<li>Azərbaycan Respublikasında Müdafiə, Milli Təhlükəsizlik və Daxili İşlər nazirliyinin operativ istintaq fəaliyyəti üzrə informasiya sistemləri, gizli kameralar, xüsusi məxfi rabitə vasitələri və digər casus avadanlıqları.</li>\r\n	<li>Müxtəlif növ powerbanklar, sim-kart girişli mallar, batareyalar və batareya tərkibli mallar.</li>\r\n</al>', 1, NULL, NULL, '2019-12-04 20:00:00', '2019-09-25 20:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'c - cashier (101-399); d - delivery (401-699); i - information (701-999))',
  `no` int(3) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `location_id` int(3) NOT NULL,
  `used` int(1) NOT NULL DEFAULT '0',
  `used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `queue`
--

INSERT INTO `queue` (`id`, `date`, `type`, `no`, `user_id`, `location_id`, `used`, `used_at`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, '2019-11-26', 'c', 101, 3, 0, 0, NULL, '2019-11-26 11:59:55', '2019-11-26 11:59:55', NULL, NULL),
(2, '2019-11-26', 'd', 401, 3, 0, 0, NULL, '2019-11-26 12:00:51', '2019-11-26 12:00:51', NULL, NULL),
(3, '2019-11-26', 'd', 402, 3, 0, 0, NULL, '2019-11-26 12:02:05', '2019-11-26 12:02:05', NULL, NULL),
(4, '2019-11-26', 'd', 403, 3, 0, 0, NULL, '2019-11-26 12:02:12', '2019-11-26 12:02:12', NULL, NULL),
(5, '2019-11-26', 'd', 404, 3, 0, 0, NULL, '2019-11-26 13:36:42', '2019-11-26 13:36:42', NULL, NULL),
(6, '2019-11-26', 'd', 405, 3, 0, 0, NULL, '2019-11-26 13:36:57', '2019-11-26 13:36:57', NULL, NULL),
(7, '2019-11-26', 'd', 406, 3, 0, 0, NULL, '2019-11-26 13:37:06', '2019-11-26 13:37:06', NULL, NULL),
(8, '2019-11-26', 'c', 102, 3, 0, 0, NULL, '2019-11-26 14:52:11', '2019-11-26 14:52:11', NULL, NULL),
(9, '2019-11-26', 'd', 407, 3, 0, 0, NULL, '2019-11-26 14:58:09', '2019-11-26 14:58:09', NULL, NULL),
(10, '2019-11-26', 'd', 408, 3, 0, 0, NULL, '2019-11-26 15:02:35', '2019-11-26 15:02:35', NULL, NULL),
(11, '2019-11-26', 'd', 409, 3, 0, 0, NULL, '2019-11-26 15:03:07', '2019-11-26 15:03:07', NULL, NULL),
(12, '2019-11-26', 'd', 410, 3, 0, 0, NULL, '2019-11-26 15:05:41', '2019-11-26 15:05:41', NULL, NULL),
(13, '2019-11-26', 'd', 411, 3, 0, 0, NULL, '2019-11-26 15:06:14', '2019-11-26 15:06:14', NULL, NULL),
(14, '2019-11-26', 'd', 412, 3, 0, 0, NULL, '2019-11-26 15:08:34', '2019-11-26 15:08:34', NULL, NULL),
(15, '2019-11-26', 'd', 413, 3, 0, 0, NULL, '2019-11-26 15:09:41', '2019-11-26 15:09:41', NULL, NULL),
(16, '2019-11-26', 'd', 414, 3, 0, 0, NULL, '2019-11-26 15:11:41', '2019-11-26 15:11:41', NULL, NULL),
(17, '2019-11-26', 'd', 415, 3, 0, 0, NULL, '2019-11-26 15:13:25', '2019-11-26 15:13:25', NULL, NULL),
(18, '2019-11-26', 'd', 416, 3, 0, 0, NULL, '2019-11-26 15:14:12', '2019-11-26 15:14:12', NULL, NULL),
(19, '2019-11-26', 'd', 417, 3, 0, 0, NULL, '2019-11-26 15:22:21', '2019-11-26 15:22:21', NULL, NULL),
(20, '2019-11-26', 'd', 418, 3, 0, 0, NULL, '2019-11-26 15:36:07', '2019-11-26 15:36:07', NULL, NULL),
(21, '2019-11-26', 'd', 419, 3, 0, 0, NULL, '2019-11-26 15:38:57', '2019-11-26 15:38:57', NULL, NULL),
(22, '2019-11-26', 'd', 420, 3, 0, 0, NULL, '2019-11-26 15:46:43', '2019-11-26 15:46:43', NULL, NULL),
(23, '2019-11-26', 'i', 701, NULL, 0, 0, NULL, '2019-11-26 17:18:49', '2019-11-26 17:18:49', NULL, NULL),
(24, '2019-11-26', 'c', 103, 3, 0, 0, NULL, '2019-11-26 17:19:07', '2019-11-26 17:19:07', NULL, NULL),
(25, '2019-11-26', 'i', 702, NULL, 0, 0, NULL, '2019-11-26 17:19:29', '2019-11-26 17:19:29', NULL, NULL),
(26, '2019-11-26', 'i', 703, NULL, 0, 0, NULL, '2019-11-26 17:19:31', '2019-11-26 17:19:31', NULL, NULL),
(27, '2019-11-26', 'i', 704, NULL, 0, 0, NULL, '2019-11-26 17:19:38', '2019-11-26 17:19:38', NULL, NULL),
(28, '2019-11-26', 'd', 421, 3, 0, 0, NULL, '2019-11-26 17:20:16', '2019-11-26 17:20:16', NULL, NULL),
(29, '2019-11-26', 'i', 705, NULL, 0, 0, NULL, '2019-11-26 17:20:48', '2019-11-26 17:20:48', NULL, NULL),
(30, '2019-11-26', 'i', 706, NULL, 0, 0, NULL, '2019-11-26 17:20:50', '2019-11-26 17:20:50', NULL, NULL),
(31, '2019-11-26', 'c', 104, 3, 0, 0, NULL, '2019-11-26 17:30:48', '2019-11-26 17:30:48', NULL, NULL),
(32, '2019-11-26', 'd', 422, 3, 0, 0, NULL, '2019-11-26 17:35:48', '2019-11-26 17:35:48', NULL, NULL),
(33, '2019-11-26', 'd', 423, 3, 0, 0, NULL, '2019-11-26 17:35:50', '2019-11-26 17:35:50', NULL, NULL),
(34, '2019-11-26', 'd', 424, 3, 0, 0, NULL, '2019-11-26 17:43:16', '2019-11-26 17:43:16', NULL, NULL),
(35, '2019-11-26', 'd', 425, 3, 0, 0, NULL, '2019-11-26 17:43:16', '2019-11-26 17:43:16', NULL, NULL),
(36, '2019-11-26', 'c', 105, 3, 0, 0, NULL, '2019-11-26 17:44:12', '2019-11-26 17:44:12', NULL, NULL),
(37, '2019-11-26', 'i', 707, NULL, 0, 0, NULL, '2019-11-26 17:44:18', '2019-11-26 17:44:18', NULL, NULL),
(38, '2019-11-26', 'd', 426, 3, 0, 0, NULL, '2019-11-26 17:44:53', '2019-11-26 17:44:53', NULL, NULL),
(39, '2019-11-26', 'd', 427, 3, 0, 0, NULL, '2019-11-26 17:44:54', '2019-11-26 17:44:54', NULL, NULL),
(40, '2019-11-26', 'i', 708, NULL, 0, 0, NULL, '2019-11-26 17:56:10', '2019-11-26 17:56:10', NULL, NULL),
(41, '2019-11-27', 'd', 401, 3, 0, 0, NULL, '2019-11-27 09:43:01', '2019-11-27 09:43:01', NULL, NULL),
(42, '2019-11-27', 'd', 402, 3, 0, 0, NULL, '2019-11-27 09:43:02', '2019-11-27 09:43:02', NULL, NULL),
(43, '2019-11-27', 'd', 403, 3, 0, 0, NULL, '2019-11-27 10:25:33', '2019-11-27 10:25:33', NULL, NULL),
(44, '2019-11-27', 'd', 404, 3, 0, 0, NULL, '2019-11-27 10:25:34', '2019-11-27 10:25:34', NULL, NULL),
(45, '2019-11-27', 'd', 405, 3, 0, 0, NULL, '2019-11-27 10:25:36', '2019-11-27 10:25:36', NULL, NULL),
(46, '2019-11-27', 'd', 406, 3, 0, 0, NULL, '2019-11-27 10:26:36', '2019-11-27 10:26:36', NULL, NULL),
(47, '2019-11-27', 'd', 407, 3, 0, 0, NULL, '2019-11-27 10:27:25', '2019-11-27 10:27:25', NULL, NULL),
(48, '2019-11-27', 'd', 408, 3, 0, 0, NULL, '2019-11-27 10:29:10', '2019-11-27 10:29:10', NULL, NULL),
(49, '2019-11-27', 'd', 409, 3, 0, 0, NULL, '2019-11-27 10:30:45', '2019-11-27 10:30:45', NULL, NULL),
(50, '2019-11-27', 'd', 410, 3, 0, 0, NULL, '2019-11-27 10:31:11', '2019-11-27 10:31:11', NULL, NULL),
(51, '2019-11-27', 'd', 411, 3, 0, 0, NULL, '2019-11-27 10:31:41', '2019-11-27 10:31:41', NULL, NULL),
(52, '2019-11-27', 'd', 412, 3, 0, 0, NULL, '2019-11-27 10:32:10', '2019-11-27 10:32:10', NULL, NULL),
(53, '2019-11-27', 'd', 413, 3, 0, 0, NULL, '2019-11-27 10:32:59', '2019-11-27 10:32:59', NULL, NULL),
(54, '2019-11-27', 'd', 414, 3, 0, 0, NULL, '2019-11-27 10:33:51', '2019-11-27 10:33:51', NULL, NULL),
(55, '2019-11-27', 'd', 415, 3, 0, 0, NULL, '2019-11-27 10:36:57', '2019-11-27 10:36:57', NULL, NULL),
(56, '2019-11-27', 'd', 416, 3, 0, 0, NULL, '2019-11-27 10:39:11', '2019-11-27 10:39:11', NULL, NULL),
(57, '2019-11-27', 'i', 701, NULL, 0, 0, NULL, '2019-11-27 10:40:20', '2019-11-27 10:40:20', NULL, NULL),
(58, '2019-11-27', 'c', 101, 3, 0, 0, NULL, '2019-11-27 10:40:36', '2019-11-27 10:40:36', NULL, NULL),
(59, '2019-11-27', 'i', 702, NULL, 0, 0, NULL, '2019-11-27 10:40:37', '2019-11-27 10:40:37', NULL, NULL),
(60, '2019-11-27', 'd', 417, 3, 0, 0, NULL, '2019-11-27 10:42:03', '2019-11-27 10:42:03', NULL, NULL),
(61, '2019-11-27', 'd', 418, 3, 0, 0, NULL, '2019-11-27 10:43:05', '2019-11-27 10:43:05', NULL, NULL),
(62, '2019-11-27', 'd', 419, 3, 0, 0, NULL, '2019-11-27 10:44:14', '2019-11-27 10:44:14', NULL, NULL),
(63, '2019-11-27', 'd', 420, 3, 0, 0, NULL, '2019-11-27 10:44:28', '2019-11-27 10:44:28', NULL, NULL),
(64, '2019-11-27', 'd', 421, 3, 0, 0, NULL, '2019-11-27 10:45:57', '2019-11-27 10:45:57', NULL, NULL),
(65, '2019-11-27', 'd', 422, 3, 0, 0, NULL, '2019-11-27 10:56:35', '2019-11-27 10:56:35', NULL, NULL),
(66, '2019-11-27', 'i', 703, NULL, 0, 0, NULL, '2019-11-27 11:00:43', '2019-11-27 11:00:43', NULL, NULL),
(67, '2019-11-27', 'i', 704, NULL, 0, 0, NULL, '2019-11-27 11:01:51', '2019-11-27 11:01:51', NULL, NULL),
(68, '2019-11-27', 'c', 102, 3, 0, 0, NULL, '2019-11-27 11:23:14', '2019-11-27 11:23:14', NULL, NULL),
(69, '2019-11-27', 'i', 705, NULL, 0, 0, NULL, '2019-11-27 11:23:46', '2019-11-27 11:23:46', NULL, NULL),
(70, '2019-11-27', 'i', 706, NULL, 0, 0, NULL, '2019-11-27 11:24:18', '2019-11-27 11:24:18', NULL, NULL),
(71, '2019-11-27', 'd', 423, 3, 0, 0, NULL, '2019-11-27 11:25:43', '2019-11-27 11:25:43', NULL, NULL),
(72, '2019-11-27', 'i', 707, NULL, 0, 0, NULL, '2019-11-27 13:00:45', '2019-11-27 13:00:45', NULL, NULL),
(73, '2019-11-27', 'i', 708, NULL, 0, 0, NULL, '2019-11-27 13:02:59', '2019-11-27 13:02:59', NULL, NULL),
(74, '2019-11-27', 'i', 709, NULL, 0, 0, NULL, '2019-11-27 13:04:09', '2019-11-27 13:04:09', NULL, NULL),
(75, '2019-11-27', 'i', 710, NULL, 0, 0, NULL, '2019-11-27 13:04:10', '2019-11-27 13:04:10', NULL, NULL),
(76, '2019-11-27', 'i', 711, NULL, 0, 0, NULL, '2019-11-27 13:07:37', '2019-11-27 13:07:37', NULL, NULL),
(77, '2019-11-27', 'i', 712, NULL, 0, 0, NULL, '2019-11-27 13:57:13', '2019-11-27 13:57:13', NULL, NULL),
(78, '2019-11-27', 'd', 424, 3, 0, 0, NULL, '2019-11-27 14:37:27', '2019-11-27 14:37:27', NULL, NULL),
(79, '2019-11-27', 'd', 425, 3, 0, 0, NULL, '2019-11-27 15:02:53', '2019-11-27 15:02:53', NULL, NULL),
(80, '2019-11-29', 'd', 401, 4, 1, 0, NULL, '2019-11-29 13:59:48', '2019-11-29 13:59:48', NULL, NULL),
(81, '2019-11-29', 'd', 402, 4, 1, 0, NULL, '2019-11-29 14:00:01', '2019-11-29 14:00:01', NULL, NULL),
(82, '2019-11-29', 'd', 403, 4, 1, 0, NULL, '2019-11-29 14:01:09', '2019-11-29 14:01:09', NULL, NULL),
(83, '2019-11-29', 'd', 404, 4, 1, 0, NULL, '2019-11-29 14:01:12', '2019-11-29 14:01:12', NULL, NULL),
(84, '2019-11-29', 'i', 701, NULL, 1, 0, NULL, '2019-11-29 14:01:18', '2019-11-29 14:01:18', NULL, NULL),
(85, '2019-11-29', 'c', 101, 4, 1, 0, NULL, '2019-11-29 14:01:24', '2019-11-29 14:01:24', NULL, NULL),
(86, '2019-11-29', 'c', 102, 4, 1, 0, NULL, '2019-11-29 14:01:27', '2019-11-29 14:01:27', NULL, NULL),
(87, '2019-11-29', 'c', 103, 4, 1, 0, NULL, '2019-11-29 14:01:30', '2019-11-29 14:01:30', NULL, NULL),
(88, '2019-11-29', 'c', 101, 4, 2, 0, NULL, '2019-11-29 14:01:35', '2019-11-29 14:01:35', NULL, NULL),
(89, '2019-11-29', 'c', 102, 4, 2, 0, NULL, '2019-11-29 14:01:38', '2019-11-29 14:01:38', NULL, NULL),
(90, '2019-11-29', 'c', 101, 4, 3, 0, NULL, '2019-11-29 14:01:43', '2019-11-29 14:01:43', NULL, NULL),
(91, '2019-11-29', 'c', 101, 4, 4, 0, NULL, '2019-11-29 14:01:51', '2019-11-29 14:01:51', NULL, NULL),
(92, '2019-11-29', 'c', 102, 4, 4, 0, NULL, '2019-11-29 14:01:56', '2019-11-29 14:01:56', NULL, NULL),
(93, '2019-11-29', 'c', 101, 4, 10, 0, NULL, '2019-11-29 14:02:02', '2019-11-29 14:02:02', NULL, NULL),
(94, '2019-11-29', 'c', 103, 4, 2, 0, NULL, '2019-11-29 14:03:07', '2019-11-29 14:03:07', NULL, NULL),
(95, '2019-11-29', 'c', 104, 4, 1, 0, NULL, '2019-11-29 14:03:13', '2019-11-29 14:03:13', NULL, NULL),
(96, '2019-11-29', 'c', 105, 4, 1, 0, NULL, '2019-11-29 14:03:17', '2019-11-29 14:03:17', NULL, NULL),
(97, '2019-11-29', 'c', 106, 4, 1, 0, NULL, '2019-11-29 14:03:19', '2019-11-29 14:03:19', NULL, NULL),
(98, '2019-11-29', 'c', 107, 4, 1, 0, NULL, '2019-11-29 14:03:22', '2019-11-29 14:03:22', NULL, NULL),
(99, '2019-11-29', 'c', 104, 4, 2, 0, NULL, '2019-11-29 14:03:29', '2019-11-29 14:03:29', NULL, NULL),
(100, '2019-11-29', 'c', 105, 4, 2, 0, NULL, '2019-11-29 14:03:32', '2019-11-29 14:03:32', NULL, NULL),
(101, '2019-11-29', 'c', 108, 4, 1, 0, NULL, '2019-11-29 14:03:39', '2019-11-29 14:03:39', NULL, NULL),
(102, '2019-11-29', 'c', 109, 4, 1, 0, NULL, '2019-11-29 15:04:55', '2019-11-29 15:04:55', NULL, NULL),
(103, '2019-11-29', 'c', 110, 4, 1, 0, NULL, '2019-11-29 15:16:09', '2019-11-29 15:16:09', NULL, NULL),
(104, '2019-11-29', 'c', 111, 4, 1, 0, NULL, '2019-11-29 15:16:12', '2019-11-29 15:16:12', NULL, NULL),
(105, '2019-11-29', 'c', 112, 4, 1, 0, NULL, '2019-11-29 15:16:16', '2019-11-29 15:16:16', NULL, NULL),
(106, '2019-11-29', 'c', 113, 4, 1, 0, NULL, '2019-11-29 15:16:20', '2019-11-29 15:16:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `roles`
--

CREATE TABLE `roles` (
  `id` int(3) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'admin', 1, '2019-08-26 00:00:00', NULL, NULL, NULL),
(2, 'client', 1, '2019-08-26 00:00:00', NULL, NULL, NULL),
(3, 'collector', 1, '2019-08-26 00:00:00', NULL, NULL, NULL),
(4, 'cashier', 1, '2019-08-26 00:00:00', NULL, NULL, NULL),
(5, 'delivery manager', 1, '2019-09-02 18:03:01', NULL, NULL, NULL),
(6, 'distributor', 1, '2019-11-13 00:00:00', NULL, NULL, NULL),
(7, 'operator', 1, '2019-11-25 15:36:08', '2019-11-25 15:36:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `seller`
--

CREATE TABLE `seller` (
  `id` int(11) NOT NULL,
  `img` text,
  `name` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT 'for site',
  `url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `in_home` int(1) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `seller`
--

INSERT INTO `seller` (`id`, `img`, `name`, `title`, `url`, `category_id`, `in_home`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, NULL, 'amazon.com', 'amazon.com', 'https://amazon.com', 1, 1, NULL, NULL, '2019-09-06 13:20:40', NULL, NULL),
(2, NULL, 'ebay.com', 'ebay.com', 'https://ebay.com', 6, 1, NULL, NULL, '2019-09-04 12:50:07', NULL, NULL),
(3, NULL, 'home_depot', 'home depot', 'homedepot.com', 0, 1, NULL, NULL, NULL, NULL, NULL),
(4, NULL, 'oldnavy', 'oldnavy', 'oldnavy.com', 0, 1, NULL, NULL, NULL, NULL, NULL),
(5, NULL, 'guess', 'guess', 'https://guess.com', 0, 1, NULL, NULL, '2019-09-04 12:53:08', NULL, NULL),
(6, NULL, 'mouser_electronics', 'mouser electronics', 'mouser.electronics.com', 0, 1, NULL, NULL, NULL, NULL, NULL),
(7, NULL, 'camera_box', 'camera box', 'camerabox.com', 0, 0, NULL, NULL, NULL, NULL, NULL),
(8, NULL, 'columbia', 'columbia', 'columbia.com', 0, 0, NULL, NULL, NULL, NULL, NULL),
(9, NULL, 'datavision', 'datavision', 'datavision.com', 0, 0, NULL, NULL, NULL, NULL, NULL),
(10, NULL, 'birthday_direct', 'birthday direct', 'https://birthdaydirect.com', 1, 0, NULL, NULL, '2019-09-04 12:49:15', NULL, NULL),
(11, NULL, 'patpat.com', 'patpat.com', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(14, NULL, 'potterybarnkids.com', 'potterybarnkids.com', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(15, NULL, 'zara.com', 'zara.com', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(16, NULL, 'ralphlauren.com', 'ralphlauren.com', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(17, NULL, '6pm.com', '6pm.com', 'https://www.google.com', 0, 0, NULL, NULL, '2019-12-16 00:33:07', NULL, NULL),
(18, 'C:\\xampp\\tmp\\phpA59A.tmp', 'google', 'google', 'https://www.google.com', 0, 0, 1, '2019-09-02 14:24:01', '2019-09-02 14:43:58', '2019-09-02 14:43:58', 1),
(19, 'C:\\xampp\\tmp\\phpED6.tmp', 'test', 'test', 'https://stackoverflow.com/questions/37896292/replace-backward-slashes-with-forward-slashes-javascript', 0, 0, 1, '2019-09-02 14:27:44', '2019-09-02 14:44:05', '2019-09-02 14:44:05', 1),
(20, 'C:\\xampp\\tmp\\php3E06.tmp', 'zcsc', 'zcsc', 'https://www.google.com', 0, 0, 1, '2019-09-02 14:31:13', '2019-09-02 14:44:08', '2019-09-02 14:44:08', 1),
(21, NULL, 'vdfdf', 'vdfdf', 'https://www.google.com', 0, 0, 1, '2019-09-02 14:31:59', '2019-09-02 14:46:00', '2019-09-02 14:46:00', 1),
(22, NULL, '32kl', '32kl', 'https://www.google.com', 0, 0, 1, '2019-09-02 14:32:30', '2019-09-02 14:46:07', '2019-09-02 14:46:07', 1),
(23, NULL, 'test', 'test', 'https://www.google.com', 0, 0, 1, '2019-09-02 17:15:01', '2019-09-02 17:15:12', '2019-09-02 17:15:12', 1),
(24, '/uploads/files/icons/test1_test2_dJDD_0.66144300 1576442781.jpg', 'test1_test_2', 'test1 test 2.com', 'https://test1test2.com', 1, 1, 1, '2019-12-16 00:46:21', '2019-12-16 00:48:59', NULL, NULL),
(25, NULL, 'test1', 'test1', NULL, NULL, 0, 9, '2019-12-17 17:26:21', '2019-12-17 17:26:21', NULL, NULL),
(26, NULL, 'test2', 'test2', NULL, NULL, 0, 9, '2019-12-17 17:28:25', '2019-12-17 17:28:25', NULL, NULL),
(27, NULL, 'test_3_salam_1_sd', 'test 3 salam 1 sd.com', NULL, NULL, 0, 9, '2019-12-17 17:29:04', '2019-12-17 17:29:04', NULL, NULL),
(28, NULL, 'test4', 'test4', NULL, NULL, 0, 9, '2019-12-17 17:30:39', '2019-12-17 17:30:39', NULL, NULL),
(29, NULL, 'test8', 'test8', NULL, NULL, 0, 9, '2019-12-17 17:51:33', '2019-12-17 17:51:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `seller_category`
--

CREATE TABLE `seller_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `seller_category`
--

INSERT INTO `seller_category` (`id`, `category_id`, `seller_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL, 1),
(2, 1, 2, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `seller_location`
--

CREATE TABLE `seller_location` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `seller_location`
--

INSERT INTO `seller_location` (`id`, `seller_id`, `location_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL, NULL),
(2, 3, 2, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(1) NOT NULL,
  `last_internal_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `last_internal_id`, `created_at`, `updated_at`) VALUES
(1, 57, NULL, '2020-01-27 17:50:43');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `special_orders`
--

CREATE TABLE `special_orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `country_id` int(3) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `quantity` int(3) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `price_azn` decimal(18,2) NOT NULL,
  `currency_id` int(3) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `is_paid` int(1) NOT NULL DEFAULT '0',
  `paid` decimal(18,2) NOT NULL DEFAULT '0.00',
  `paid_at` datetime DEFAULT NULL,
  `last_status_id` int(3) DEFAULT NULL,
  `last_status_date` datetime DEFAULT NULL,
  `group_code` varchar(255) DEFAULT NULL,
  `operator_id` int(11) DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL COMMENT 'sifarislere dusdukden sonra',
  `declarated_at` datetime DEFAULT NULL COMMENT 'sifarislere dusdukden sonra',
  `canceled_by` int(11) DEFAULT NULL,
  `canceled_at` datetime DEFAULT NULL,
  `placed_by` int(11) DEFAULT NULL,
  `placed_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `special_orders`
--

INSERT INTO `special_orders` (`id`, `client_id`, `country_id`, `url`, `quantity`, `price`, `price_azn`, `currency_id`, `title`, `description`, `is_paid`, `paid`, `paid_at`, `last_status_id`, `last_status_date`, `group_code`, `operator_id`, `accepted_at`, `package_id`, `declarated_at`, `canceled_by`, `canceled_at`, `placed_by`, `placed_at`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 3, 3, 'https://www.valyuta.com/valyuta-konvertor', 2, '25.00', '7.18', 4, NULL, 'valyuta.com', 0, '0.00', NULL, 10, '2020-01-21 15:58:22', 'kFlZP3mMwd5XI3Y3fCY2B3dCEwdumDsIb0CaBnGRtkdYOBCjENTAwq67VgGJctKPZaSJZ7HT3cRUSA842xIGzt59o6CWQ7jgLziRSOoOSEIQuzt66x2BO07cG6o7eQWb9S6nqgybe5WVAN0pXv283ApfGDnWFtsEWdxUC48fj1bst1DN8cJjGEvaz752VLYFVMW5lmmL1579622302', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-21 15:58:22', '2020-01-21 15:58:22', NULL, NULL),
(2, 3, 3, 'https://www.youtube.com/watch?v=6IV8AOKsLUk', 5, '100.00', '28.70', 4, NULL, 'youtube', 1, '0.00', NULL, 2, '2020-01-29 09:13:00', 'kFlZP3mMwd5XI3Y3fCY2B3dCEwdumDsIb0CaBnGRtkdYOBCjENTAwq67VgGJctKPZaSJZ7HT3cRUSA842xIGzt59o6CWQ7jgLziRSOoOSEIQuzt66x2BO07cG6o7eQWb9S6nqgybe5WVAN0pXv283ApfGDnWFtsEWdxUC48fj1bst1DN8cJjGEvaz752VLYFVMW5lmmL1579622302', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-21 15:58:22', '2020-01-29 09:13:00', NULL, NULL),
(3, 3, 3, 'https://www.valyuta.com/valyuta-konvertor', 2, '25.00', '7.18', 4, NULL, 'valyuta.com', 0, '0.00', NULL, 10, '2020-01-21 16:00:15', 'DPY4AZ6QnZCoodzHsdsjGVClJbiLjsCyQUOFhB491Yv245WNQwSmucigfpBXUcKLI68GJRFY8qTecSj4xXDRLO1xbHTwzvxxLnjaZKo9IhbhDbIfmnnM4Coq4ovbcXvfdP4ran0SyqJOaiwXzEt7sdl6j5Pv5RvnrYeIf75svhCQW3ceXz4xFsHNDJg8tkoi7WJk8hYv1579622415', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-21 16:00:15', '2020-01-23 11:35:19', '2020-01-23 11:35:19', 3),
(4, 3, 3, 'https://www.youtube.com/watch?v=6IV8AOKsLUk', 5, '100.00', '28.70', 4, NULL, 'youtube', 0, '0.00', NULL, 10, '2020-01-21 16:00:15', 'DPY4AZ6QnZCoodzHsdsjGVClJbiLjsCyQUOFhB491Yv245WNQwSmucigfpBXUcKLI68GJRFY8qTecSj4xXDRLO1xbHTwzvxxLnjaZKo9IhbhDbIfmnnM4Coq4ovbcXvfdP4ran0SyqJOaiwXzEt7sdl6j5Pv5RvnrYeIf75svhCQW3ceXz4xFsHNDJg8tkoi7WJk8hYv1579622415', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-21 16:00:15', '2020-01-21 16:00:15', NULL, NULL),
(5, 3, 3, 'https://www.valyuta.com/valyuta-konvertor', 25, '2252.00', '646.32', 4, NULL, 'salam', 1, '0.00', NULL, 10, '2020-01-21 16:04:01', 'eyfzwS0ZBBfiH6GfJzJz9uxagurXI44d7BqKuRdLFczaov8vqVnAlQjtB6qO4SavTT1nVvmTfswEegSNQ41HNb179pHJLi7jAVd0oMimnnUoYr4ttsg6AOaePCSqthasOPYpZcqtO416tV3x6Ush22whaNlnRF8kfcWpEq0AkPHMuFeppjwMXIORbKyFwu2TmIAgblWr1579622641', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-21 16:04:01', '2020-01-21 16:04:01', NULL, NULL),
(6, 3, 3, 'https://www.valyuta.com/valyuta-konvertor', 25, '2252.00', '646.32', 4, NULL, 'salam', 0, '0.00', NULL, 10, '2020-01-21 16:04:56', 'O4MbOHe2miKLKDqPxsbmmWM0pVbomWl5mru2QBoSQTW9RpvIgPMl4HGYedF7hNULuWFDQs6VWVNL4zOtjYsacCyVSXL0a9814ldUgivE503N4AlqSl7ndKI9PNwaMbinA6YjlHNpX7Tnarc1HynHxFqAx6ks3OMb0tWvD4YRtf3rbhuggrNJa3PCECtGWflPg7OK5NZK1579622696', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-21 16:04:56', '2020-01-21 17:19:10', '2020-01-21 17:19:10', 3),
(7, 3, 3, 'https://www.valyuta.com/valyuta-konvertor', 2, '15.00', '0.00', 4, NULL, 'ujyyi u yuiyui', 1, '0.00', NULL, 2, '2020-01-25 14:22:46', 'hEO1wRoiSMHLlHnx5Z5Oy9eDQ4PdrkTVQOpXzOMRusEGTcOvhJOsQiaW3fCtITk6SJFh6sHffL6wMPsdymUYUm2ckBZqcBGWKYz7wRveeMgY5QCcU0gGxUCQRPAwznW828b200mF6xJntXUfERQZ8aLlnl1PLnZAFla63MValNwwP6M8jFOItY7KN3E9z5BLLRJYttT41579623407', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-21 16:16:47', '2020-01-29 09:12:56', '2020-01-29 09:12:56', 3),
(8, 3, 3, 'fddf df df', 5, '25.00', '7.18', 4, NULL, 'xc c c', 0, '0.00', NULL, 10, '2020-01-21 16:19:36', 'XYAWjHsbKlr6GZlxY3TXtr2wywxMZCmYYlPlQMA9nN99IOM1dMPnSUEU8g8FoHki5mRToxBWn5HrN7zzvtobjBvJeO4L71FnOSlPQrhXo4rbvEy8fbxFX3g8le7YRIzk9vBYUNffEHLn8w7SXP8lSjfDt14t84SjpFuZ0nn5QAXYrv5ZwAvnQOxuQkZHNfuRgJwx8VmZ1579623576', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-21 16:19:36', '2020-01-25 00:18:58', '2020-01-25 00:18:58', 3),
(9, 3, 3, 'fddf df df', 2, '25.00', '0.00', 4, 'title test', 'salam', 1, '0.00', NULL, 2, '2020-01-25 14:22:41', 'UP62IRDX5rnLzf9h3mMk3k9IBdpYU9U5OQjbBcEYefmsfKbOPSz9wIDbEWEH1eUPDTm6CpimAv4R6v9M0goxAJbCzngdlUv729g55cl8Us7JLRipZckbHP1jsWB14rjsjvd1hOYnfdSLW9yjZ4dwIfoIxWP8l5ri6CUgYhrpH1YZyTxuWTZByoRej0yILNebXFRyT8H01579623704', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-21 16:21:44', '2020-01-29 10:06:14', '2020-01-29 10:06:14', 3),
(10, 3, 3, 'fddf df df', 2, '25.00', '7.18', 4, NULL, 'salam necesen?', 0, '0.00', NULL, 10, '2020-01-21 16:21:56', 'YztOLzssLLlN7huQjMCCoVZRnmCAQGvMlYXp4eA5YNQSBwcJXBNh9iJgGfEglbH1Re6aNfMKQAUgTBdT3g1NetDYLUw941GDu53MUec8kjKS7lgmeNxhgjGpkA9Zw0mvScFotyFsi4uCwJ0dPKlPh0w6XOKFRNVXXEi61RrCHs0JRJFbiSBgQyDHK8PI4eiDCLL2vC6m1579623716', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-21 16:21:56', '2020-01-25 00:18:49', '2020-01-25 00:18:49', 3),
(11, 3, 3, 'https://www.valyuta.com/valyuta-konvertor', 1, '5325.00', '1528.27', 4, NULL, 'salam', 1, '0.00', NULL, 11, '2020-01-25 13:46:15', 'k5r2tptSQWNeGuXXTNRyBhnczpUOXeG6laTHpAI2v3CZ8spMU1KmH2vlEo7fwZiMHzKt9jSAmvunEcKNNmKJjJXPoxw39YBJixzPWJGzZde2QHbq9PqXNpyPqvsOkVj9DwPtOmTNuOBbXmdxsvthOQnPJd8PWkTyyNS6ko1ABapQdfL8aYq13aw4B477jzuRtAldW2qy1579787033', 1, NULL, NULL, '2020-01-25 00:00:00', NULL, NULL, 1, '2020-01-25 00:00:00', 3, '2020-01-23 13:43:54', '2020-01-25 13:46:15', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `special_order_status`
--

CREATE TABLE `special_order_status` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status_id` int(3) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `special_order_status`
--

INSERT INTO `special_order_status` (`id`, `order_id`, `status_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 10, 3, '2020-01-21 15:58:22', '2020-01-21 15:58:22', NULL, NULL),
(2, 2, 10, 3, '2020-01-21 15:58:22', '2020-01-21 15:58:22', NULL, NULL),
(3, 3, 10, 3, '2020-01-21 16:00:15', '2020-01-21 16:00:15', NULL, NULL),
(4, 4, 10, 3, '2020-01-21 16:00:15', '2020-01-21 16:00:15', NULL, NULL),
(5, 5, 10, 3, '2020-01-21 16:04:01', '2020-01-21 16:04:01', NULL, NULL),
(6, 6, 10, 3, '2020-01-21 16:04:56', '2020-01-21 16:04:56', NULL, NULL),
(7, 7, 10, 3, '2020-01-21 16:16:47', '2020-01-21 16:16:47', NULL, NULL),
(8, 8, 10, 3, '2020-01-21 16:19:36', '2020-01-21 16:19:36', NULL, NULL),
(9, 9, 10, 3, '2020-01-21 16:21:44', '2020-01-21 16:21:44', NULL, NULL),
(10, 10, 10, 3, '2020-01-21 16:21:56', '2020-01-21 16:21:56', NULL, NULL),
(11, 11, 10, 3, '2020-01-23 13:43:54', '2020-01-23 13:43:54', NULL, NULL),
(12, 7, 12, 1, '2020-01-25 12:12:11', '2020-01-25 12:12:11', NULL, NULL),
(13, 11, 13, 1, '2020-01-25 12:24:33', '2020-01-25 12:24:33', NULL, NULL),
(14, 11, 11, 1, '2020-01-25 13:38:52', '2020-01-25 13:38:52', NULL, NULL),
(15, 11, 11, 1, '2020-01-25 13:39:04', '2020-01-25 13:39:04', NULL, NULL),
(16, 11, 11, 1, '2020-01-25 13:42:03', '2020-01-25 13:42:03', NULL, NULL),
(17, 11, 11, 1, '2020-01-25 13:43:36', '2020-01-25 13:43:36', NULL, NULL),
(18, 11, 11, 1, '2020-01-25 13:46:15', '2020-01-25 13:46:15', NULL, NULL),
(19, 9, 2, 3, '2020-01-25 14:22:41', '2020-01-25 14:22:41', NULL, NULL),
(20, 7, 2, 3, '2020-01-25 14:22:46', '2020-01-25 14:22:46', NULL, NULL),
(21, 2, 2, 3, '2020-01-29 09:13:00', '2020-01-29 09:13:00', NULL, NULL);

--
-- Tetikleyiciler `special_order_status`
--
DELIMITER $$
CREATE TRIGGER `add_last_status_for_special_orders` AFTER INSERT ON `special_order_status` FOR EACH ROW UPDATE special_orders SET last_status_id = NEW.status_id, last_status_date = NEW.created_at WHERE id = NEW.order_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tariff_types`
--

CREATE TABLE `tariff_types` (
  `id` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tariff_types`
--

INSERT INTO `tariff_types` (`id`, `name`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 'General', 1, NULL, NULL, NULL, NULL),
(2, 'Liquid', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tracking_log`
--

CREATE TABLE `tracking_log` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `operator_id` int(11) NOT NULL,
  `container_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tracking_log`
--

INSERT INTO `tracking_log` (`id`, `package_id`, `operator_id`, `container_id`, `position_id`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, 1, 1, 9, NULL, 1, '2019-11-26 11:56:01', '2019-11-26 11:56:01', NULL, NULL),
(2, 1, 9, NULL, 10, 9, '2019-11-26 11:59:31', '2019-11-26 11:59:31', NULL, NULL),
(3, 1, 9, NULL, 10, 9, '2019-11-26 12:00:33', '2019-11-26 12:00:33', NULL, NULL),
(4, 24, 1, 2, NULL, 1, '2019-11-27 17:04:45', '2019-11-27 17:04:45', NULL, NULL),
(5, 1, 1, NULL, 10, 1, '2019-11-28 15:46:27', '2019-11-28 15:46:27', NULL, NULL),
(6, 28, 9, NULL, 1, 9, '2019-12-04 14:20:38', '2019-12-04 14:20:38', NULL, NULL),
(7, 28, 9, NULL, 1, 9, '2019-12-04 14:21:07', '2019-12-04 14:21:07', NULL, NULL),
(8, 29, 9, NULL, 1, 9, '2019-12-04 14:26:08', '2019-12-04 14:26:08', NULL, NULL),
(9, 30, 9, NULL, 1, 9, '2019-12-04 14:41:09', '2019-12-04 14:41:09', NULL, NULL),
(10, 30, 9, NULL, 1, 9, '2019-12-04 14:41:38', '2019-12-04 14:41:38', NULL, NULL),
(11, 30, 9, NULL, 1, 9, '2019-12-04 14:43:20', '2019-12-04 14:43:20', NULL, NULL),
(12, 30, 9, NULL, 3, 9, '2019-12-04 14:43:33', '2019-12-04 14:43:33', NULL, NULL),
(13, 30, 9, NULL, 3, 9, '2019-12-04 14:47:36', '2019-12-04 14:47:36', NULL, NULL),
(14, 30, 9, NULL, 3, 9, '2019-12-04 14:47:43', '2019-12-04 14:47:43', NULL, NULL),
(15, 30, 9, NULL, 3, 9, '2019-12-04 14:48:15', '2019-12-04 14:48:15', NULL, NULL),
(16, 30, 9, NULL, 3, 9, '2019-12-04 14:48:28', '2019-12-04 14:48:28', NULL, NULL),
(17, 30, 9, NULL, 3, 9, '2019-12-04 14:48:51', '2019-12-04 14:48:51', NULL, NULL),
(18, 31, 9, NULL, 1, 9, '2019-12-05 11:15:23', '2019-12-05 11:15:23', NULL, NULL),
(19, 32, 9, NULL, 2, 9, '2019-12-05 11:17:19', '2019-12-05 11:17:19', NULL, NULL),
(20, 31, 9, NULL, 1, 9, '2019-12-05 11:27:56', '2019-12-05 11:27:56', NULL, NULL),
(21, 31, 9, NULL, 2, 9, '2019-12-05 11:28:12', '2019-12-05 11:28:12', NULL, NULL),
(22, 31, 9, NULL, 31, 9, '2019-12-05 11:28:40', '2019-12-05 11:28:40', NULL, NULL),
(23, 31, 9, 2, NULL, 9, '2019-12-05 11:42:50', '2019-12-05 11:42:50', NULL, NULL),
(24, 31, 9, 5, NULL, 9, '2019-12-05 11:43:17', '2019-12-05 11:43:17', NULL, NULL),
(25, 31, 9, 2, NULL, 9, '2019-12-05 11:43:27', '2019-12-05 11:43:27', NULL, NULL),
(26, 31, 9, 5, NULL, 9, '2019-12-05 11:43:38', '2019-12-05 11:43:38', NULL, NULL),
(27, 31, 9, 5, NULL, 9, '2019-12-05 11:43:52', '2019-12-05 11:43:52', NULL, NULL),
(28, 23, 9, NULL, 10, 9, '2019-12-19 15:55:23', '2019-12-19 15:55:23', NULL, NULL),
(29, 33, 9, NULL, 16, 9, '2019-12-20 01:22:21', '2019-12-20 01:22:21', NULL, NULL),
(30, 33, 9, NULL, 16, 9, '2019-12-20 01:23:38', '2019-12-20 01:23:38', NULL, NULL),
(31, 33, 9, NULL, 16, 9, '2019-12-20 02:04:08', '2019-12-20 02:04:08', NULL, NULL),
(32, 33, 9, NULL, 16, 9, '2019-12-20 04:33:33', '2019-12-20 04:33:33', NULL, NULL),
(33, 33, 9, NULL, 16, 9, '2019-12-20 04:46:41', '2019-12-20 04:46:41', NULL, NULL),
(34, 33, 9, NULL, 16, 9, '2019-12-20 10:33:37', '2019-12-20 10:33:37', NULL, NULL),
(35, 33, 9, NULL, 6, 9, '2019-12-20 10:45:32', '2019-12-20 10:45:32', NULL, NULL),
(36, 33, 9, NULL, 6, 9, '2019-12-20 10:46:44', '2019-12-20 10:46:44', NULL, NULL),
(37, 33, 9, NULL, 6, 9, '2019-12-20 11:09:58', '2019-12-20 11:09:58', NULL, NULL),
(38, 33, 9, NULL, 6, 9, '2019-12-20 11:10:39', '2019-12-20 11:10:39', NULL, NULL),
(39, 33, 9, NULL, 15, 9, '2019-12-20 11:18:06', '2019-12-20 11:18:06', NULL, NULL),
(40, 33, 9, 3, NULL, 9, '2019-12-20 11:21:43', '2019-12-20 11:21:43', NULL, NULL),
(41, 33, 9, 3, NULL, 9, '2019-12-20 11:27:48', '2019-12-20 11:27:48', NULL, NULL),
(42, 33, 9, 3, NULL, 9, '2019-12-20 11:29:15', '2019-12-20 11:29:15', NULL, NULL),
(43, 33, 9, 3, NULL, 9, '2019-12-20 11:31:20', '2019-12-20 11:31:20', NULL, NULL),
(44, 33, 9, 3, NULL, 9, '2019-12-20 11:50:48', '2019-12-20 11:50:48', NULL, NULL),
(45, 33, 9, 14, NULL, 9, '2019-12-20 11:54:17', '2019-12-20 11:54:17', NULL, NULL),
(46, 33, 9, 14, NULL, 9, '2019-12-20 16:03:00', '2019-12-20 16:03:00', NULL, NULL),
(47, 33, 9, 14, NULL, 9, '2019-12-20 16:06:46', '2019-12-20 16:06:46', NULL, NULL),
(48, 33, 9, 14, NULL, 9, '2019-12-20 16:07:40', '2019-12-20 16:07:40', NULL, NULL),
(49, 33, 9, 14, NULL, 9, '2019-12-24 01:13:16', '2019-12-24 01:13:16', NULL, NULL),
(50, 33, 9, 14, NULL, 9, '2019-12-24 01:18:45', '2019-12-24 01:18:45', NULL, NULL),
(51, 33, 9, 14, NULL, 9, '2019-12-24 01:19:55', '2019-12-24 01:19:55', NULL, NULL),
(52, 33, 9, 14, NULL, 9, '2019-12-24 01:20:43', '2019-12-24 01:20:43', NULL, NULL),
(53, 33, 9, 14, NULL, 9, '2019-12-24 01:21:24', '2019-12-24 01:21:24', NULL, NULL),
(54, 33, 9, 14, NULL, 9, '2019-12-24 01:22:07', '2019-12-24 01:22:07', NULL, NULL),
(55, 33, 9, 14, NULL, 9, '2019-12-24 01:48:27', '2019-12-24 01:48:27', NULL, NULL),
(56, 33, 9, 14, NULL, 9, '2019-12-24 01:49:17', '2019-12-24 01:49:17', NULL, NULL),
(57, 33, 9, 14, NULL, 9, '2019-12-24 01:54:04', '2019-12-24 01:54:04', NULL, NULL),
(58, 33, 9, 14, NULL, 9, '2019-12-24 02:02:25', '2019-12-24 02:02:25', NULL, NULL),
(59, 33, 9, 14, NULL, 9, '2019-12-24 02:06:03', '2019-12-24 02:06:03', NULL, NULL),
(60, 33, 9, 14, NULL, 9, '2019-12-24 02:08:05', '2019-12-24 02:08:05', NULL, NULL),
(61, 33, 9, 14, NULL, 9, '2019-12-24 02:12:02', '2019-12-24 02:12:02', NULL, NULL),
(62, 32, 9, NULL, 2, 9, '2019-12-24 02:21:53', '2019-12-24 02:21:53', NULL, NULL),
(63, 32, 9, NULL, 2, 9, '2019-12-24 02:22:08', '2019-12-24 02:22:08', NULL, NULL),
(64, 32, 9, NULL, 2, 9, '2019-12-24 02:27:44', '2019-12-24 02:27:44', NULL, NULL),
(65, 33, 9, 14, NULL, 9, '2019-12-24 03:02:35', '2019-12-24 03:02:35', NULL, NULL),
(66, 33, 9, 14, NULL, 9, '2019-12-24 03:14:52', '2019-12-24 03:14:52', NULL, NULL),
(67, 33, 9, 14, NULL, 9, '2019-12-24 03:18:07', '2019-12-24 03:18:07', NULL, NULL),
(68, 33, 9, 14, NULL, 9, '2019-12-24 03:19:44', '2019-12-24 03:19:44', NULL, NULL),
(69, 33, 9, 14, NULL, 9, '2019-12-24 03:21:07', '2019-12-24 03:21:07', NULL, NULL),
(70, 33, 9, 14, NULL, 9, '2019-12-24 03:21:50', '2019-12-24 03:21:50', NULL, NULL),
(71, 33, 9, 14, NULL, 9, '2019-12-24 03:22:08', '2019-12-24 03:22:08', NULL, NULL),
(72, 33, 9, 14, NULL, 9, '2019-12-24 03:23:04', '2019-12-24 03:23:04', NULL, NULL),
(73, 33, 9, 14, NULL, 9, '2019-12-24 03:30:02', '2019-12-24 03:30:02', NULL, NULL),
(74, 33, 9, 14, NULL, 9, '2019-12-24 03:51:31', '2019-12-24 03:51:31', NULL, NULL),
(75, 33, 9, 14, NULL, 9, '2019-12-24 03:51:49', '2019-12-24 03:51:49', NULL, NULL),
(76, 33, 9, 14, NULL, 9, '2019-12-24 03:52:21', '2019-12-24 03:52:21', NULL, NULL),
(77, 33, 9, 14, NULL, 9, '2019-12-28 15:28:57', '2019-12-28 15:28:57', NULL, NULL),
(78, 33, 9, 14, NULL, 9, '2019-12-28 15:29:43', '2019-12-28 15:29:43', NULL, NULL),
(79, 33, 9, 14, NULL, 9, '2019-12-28 15:30:16', '2019-12-28 15:30:16', NULL, NULL),
(80, 33, 9, 14, NULL, 9, '2019-12-28 15:30:31', '2019-12-28 15:30:31', NULL, NULL),
(81, 33, 9, 14, NULL, 9, '2019-12-28 15:31:35', '2019-12-28 15:31:35', NULL, NULL),
(82, 33, 9, 14, NULL, 9, '2019-12-28 15:34:05', '2019-12-28 15:34:05', NULL, NULL),
(83, 33, 9, 14, NULL, 9, '2019-12-28 15:35:22', '2019-12-28 15:35:22', NULL, NULL),
(84, 33, 9, 14, NULL, 9, '2019-12-28 15:35:49', '2019-12-28 15:35:49', NULL, NULL),
(85, 33, 9, 14, NULL, 9, '2020-01-16 11:04:36', '2020-01-16 11:04:36', NULL, NULL),
(86, 33, 9, 14, NULL, 9, '2020-01-16 11:06:04', '2020-01-16 11:06:04', NULL, NULL),
(87, 33, 9, 14, NULL, 9, '2020-01-16 11:07:53', '2020-01-16 11:07:53', NULL, NULL),
(88, 33, 9, 14, NULL, 9, '2020-01-16 11:12:15', '2020-01-16 11:12:15', NULL, NULL),
(89, 33, 9, 14, NULL, 9, '2020-01-16 11:14:02', '2020-01-16 11:14:02', NULL, NULL),
(90, 33, 9, 14, NULL, 9, '2020-01-16 11:14:27', '2020-01-16 11:14:27', NULL, NULL),
(91, 33, 9, 14, NULL, 9, '2020-01-16 11:49:47', '2020-01-16 11:49:47', NULL, NULL),
(92, 33, 9, 14, NULL, 9, '2020-01-16 11:56:22', '2020-01-16 11:56:22', NULL, NULL),
(93, 33, 9, 14, NULL, 9, '2020-01-16 11:57:14', '2020-01-16 11:57:14', NULL, NULL),
(94, 33, 9, 14, NULL, 9, '2020-01-16 11:59:14', '2020-01-16 11:59:14', NULL, NULL),
(95, 33, 9, 14, NULL, 9, '2020-01-16 12:02:18', '2020-01-16 12:02:18', NULL, NULL),
(96, 33, 9, 14, NULL, 9, '2020-01-16 12:03:06', '2020-01-16 12:03:06', NULL, NULL),
(97, 33, 9, 14, NULL, 9, '2020-01-16 12:03:54', '2020-01-16 12:03:54', NULL, NULL),
(98, 33, 9, 14, NULL, 9, '2020-01-16 13:11:01', '2020-01-16 13:11:01', NULL, NULL),
(99, 33, 9, 14, NULL, 9, '2020-01-16 20:22:55', '2020-01-16 20:22:55', NULL, NULL),
(100, 33, 9, 14, NULL, 9, '2020-01-16 20:33:17', '2020-01-16 20:33:17', NULL, NULL),
(101, 33, 9, 14, NULL, 9, '2020-01-16 20:33:54', '2020-01-16 20:33:54', NULL, NULL),
(102, 33, 9, 14, NULL, 9, '2020-01-16 20:37:08', '2020-01-16 20:37:08', NULL, NULL),
(103, 33, 9, 14, NULL, 9, '2020-01-16 20:43:02', '2020-01-16 20:43:02', NULL, NULL),
(104, 33, 9, 14, NULL, 9, '2020-01-16 20:46:57', '2020-01-16 20:46:57', NULL, NULL),
(105, 33, 9, 14, NULL, 9, '2020-01-16 20:48:25', '2020-01-16 20:48:25', NULL, NULL),
(106, 33, 9, 14, NULL, 9, '2020-01-16 20:49:21', '2020-01-16 20:49:21', NULL, NULL),
(107, 33, 9, 14, NULL, 9, '2020-01-16 21:17:24', '2020-01-16 21:17:24', NULL, NULL),
(108, 33, 9, 14, NULL, 9, '2020-01-16 21:24:31', '2020-01-16 21:24:31', NULL, NULL),
(109, 33, 9, 14, NULL, 9, '2020-01-16 21:25:10', '2020-01-16 21:25:10', NULL, NULL),
(110, 33, 9, 14, NULL, 9, '2020-01-16 21:25:37', '2020-01-16 21:25:37', NULL, NULL),
(111, 33, 9, 14, NULL, 9, '2020-01-16 21:26:05', '2020-01-16 21:26:05', NULL, NULL),
(112, 33, 9, 14, NULL, 9, '2020-01-16 21:27:53', '2020-01-16 21:27:53', NULL, NULL),
(113, 33, 9, 14, NULL, 9, '2020-01-16 21:35:46', '2020-01-16 21:35:46', NULL, NULL),
(114, 33, 9, 14, NULL, 9, '2020-01-18 13:19:45', '2020-01-18 13:19:45', NULL, NULL),
(115, 33, 9, 14, NULL, 9, '2020-01-18 13:19:55', '2020-01-18 13:19:55', NULL, NULL),
(116, 33, 9, 14, NULL, 9, '2020-01-18 13:20:03', '2020-01-18 13:20:03', NULL, NULL),
(117, 32, 9, NULL, 3, 9, '2020-01-18 13:21:05', '2020-01-18 13:21:05', NULL, NULL),
(118, 33, 9, 14, NULL, 9, '2020-01-18 13:22:36', '2020-01-18 13:22:36', NULL, NULL),
(119, 33, 9, 14, NULL, 9, '2020-01-18 19:44:59', '2020-01-18 19:44:59', NULL, NULL),
(120, 33, 9, 14, NULL, 9, '2020-01-18 19:54:03', '2020-01-18 19:54:03', NULL, NULL),
(121, 33, 9, 14, NULL, 9, '2020-01-18 19:55:10', '2020-01-18 19:55:10', NULL, NULL),
(122, 33, 9, 14, NULL, 9, '2020-01-19 17:13:26', '2020-01-19 17:13:26', NULL, NULL),
(123, 33, 9, 14, NULL, 9, '2020-01-19 17:17:24', '2020-01-19 17:17:24', NULL, NULL),
(124, 33, 9, 14, NULL, 9, '2020-01-19 17:19:45', '2020-01-19 17:19:45', NULL, NULL),
(125, 33, 9, 14, NULL, 9, '2020-01-19 17:46:01', '2020-01-19 17:46:01', NULL, NULL),
(126, 33, 9, 14, NULL, 9, '2020-01-19 17:46:24', '2020-01-19 17:46:24', NULL, NULL),
(127, 33, 9, 14, NULL, 9, '2020-01-20 00:03:38', '2020-01-20 00:03:38', NULL, NULL),
(128, 33, 9, 14, NULL, 9, '2020-01-20 00:06:36', '2020-01-20 00:06:36', NULL, NULL),
(129, 33, 9, 14, NULL, 9, '2020-01-20 00:06:45', '2020-01-20 00:06:45', NULL, NULL),
(130, 33, 9, 14, NULL, 9, '2020-01-20 00:08:33', '2020-01-20 00:08:33', NULL, NULL),
(131, 33, 9, 14, NULL, 9, '2020-01-20 00:08:41', '2020-01-20 00:08:41', NULL, NULL),
(132, 33, 9, 14, NULL, 9, '2020-01-20 00:12:38', '2020-01-20 00:12:38', NULL, NULL),
(133, 33, 9, 14, NULL, 9, '2020-01-20 00:12:51', '2020-01-20 00:12:51', NULL, NULL),
(134, 33, 9, 14, NULL, 9, '2020-01-20 00:13:25', '2020-01-20 00:13:25', NULL, NULL),
(135, 33, 9, 14, NULL, 9, '2020-01-20 00:13:40', '2020-01-20 00:13:40', NULL, NULL),
(136, 33, 9, 14, NULL, 9, '2020-01-20 00:13:55', '2020-01-20 00:13:55', NULL, NULL),
(137, 33, 9, 14, NULL, 9, '2020-01-20 00:14:02', '2020-01-20 00:14:02', NULL, NULL),
(138, 33, 9, 14, NULL, 9, '2020-01-20 00:14:16', '2020-01-20 00:14:16', NULL, NULL),
(139, 33, 9, 14, NULL, 9, '2020-01-20 00:14:21', '2020-01-20 00:14:21', NULL, NULL),
(140, 33, 9, 14, NULL, 9, '2020-01-20 02:49:31', '2020-01-20 02:49:31', NULL, NULL),
(141, 33, 9, 14, NULL, 9, '2020-01-20 02:51:50', '2020-01-20 02:51:50', NULL, NULL),
(142, 33, 9, 14, NULL, 9, '2020-01-20 02:52:01', '2020-01-20 02:52:01', NULL, NULL),
(143, 33, 9, 14, NULL, 9, '2020-01-20 02:52:18', '2020-01-20 02:52:18', NULL, NULL),
(144, 33, 9, 14, NULL, 9, '2020-01-20 02:52:29', '2020-01-20 02:52:29', NULL, NULL),
(145, 33, 9, 14, NULL, 9, '2020-01-23 10:17:27', '2020-01-23 10:17:27', NULL, NULL),
(146, 33, 9, 14, NULL, 9, '2020-01-23 10:17:36', '2020-01-23 10:17:36', NULL, NULL),
(147, 33, 9, 14, NULL, 9, '2020-01-23 10:17:47', '2020-01-23 10:17:47', NULL, NULL),
(148, 33, 9, 14, NULL, 9, '2020-01-23 10:28:38', '2020-01-23 10:28:38', NULL, NULL),
(149, 33, 9, 14, NULL, 9, '2020-01-23 11:41:25', '2020-01-23 11:41:25', NULL, NULL),
(150, 33, 9, 14, NULL, 9, '2020-01-23 11:47:34', '2020-01-23 11:47:34', NULL, NULL),
(151, 33, 9, 14, NULL, 9, '2020-01-23 11:47:40', '2020-01-23 11:47:40', NULL, NULL),
(152, 33, 9, 14, NULL, 9, '2020-01-23 11:47:48', '2020-01-23 11:47:48', NULL, NULL),
(153, 33, 9, 14, NULL, 9, '2020-01-23 11:47:55', '2020-01-23 11:47:55', NULL, NULL),
(154, 33, 9, 14, NULL, 9, '2020-01-23 11:52:05', '2020-01-23 11:52:05', NULL, NULL),
(155, 33, 9, 14, NULL, 9, '2020-01-23 13:26:36', '2020-01-23 13:26:36', NULL, NULL),
(156, 33, 9, 14, NULL, 9, '2020-01-23 13:26:41', '2020-01-23 13:26:41', NULL, NULL),
(157, 33, 9, 14, NULL, 9, '2020-01-23 13:26:47', '2020-01-23 13:26:47', NULL, NULL),
(158, 33, 9, 14, NULL, 9, '2020-01-23 13:26:52', '2020-01-23 13:26:52', NULL, NULL),
(159, 33, 9, 14, NULL, 9, '2020-01-23 13:26:57', '2020-01-23 13:26:57', NULL, NULL),
(160, 33, 9, 14, NULL, 9, '2020-01-23 14:49:25', '2020-01-23 14:49:25', NULL, NULL),
(161, 33, 9, 14, NULL, 9, '2020-01-23 14:49:31', '2020-01-23 14:49:31', NULL, NULL),
(162, 33, 9, 14, NULL, 9, '2020-01-23 14:49:38', '2020-01-23 14:49:38', NULL, NULL),
(163, 33, 9, 14, NULL, 9, '2020-01-23 14:50:09', '2020-01-23 14:50:09', NULL, NULL),
(164, 33, 9, 14, NULL, 9, '2020-01-23 14:50:14', '2020-01-23 14:50:14', NULL, NULL),
(165, 39, 9, NULL, 2, 9, '2020-01-24 20:28:27', '2020-01-24 20:28:27', NULL, NULL),
(166, 40, 9, NULL, 5, 9, '2020-01-24 20:38:20', '2020-01-24 20:38:20', NULL, NULL),
(167, 38, 9, 18, NULL, 9, '2020-01-24 20:43:16', '2020-01-24 20:43:16', NULL, NULL),
(168, 38, 9, 5, NULL, 9, '2020-01-24 20:45:05', '2020-01-24 20:45:05', NULL, NULL),
(169, 38, 9, 3, NULL, 9, '2020-01-24 20:46:59', '2020-01-24 20:46:59', NULL, NULL),
(170, 40, 9, NULL, 5, 9, '2020-01-25 02:16:07', '2020-01-25 02:16:07', NULL, NULL),
(171, 50, 9, NULL, 2, 9, '2020-01-27 17:35:02', '2020-01-27 17:35:02', NULL, NULL),
(172, 51, 9, NULL, 2, 9, '2020-01-27 17:43:48', '2020-01-27 17:43:48', NULL, NULL);

--
-- Tetikleyiciler `tracking_log`
--
DELIMITER $$
CREATE TRIGGER `add_position_or_container` AFTER INSERT ON `tracking_log` FOR EACH ROW UPDATE package SET position_id = NEW.position_id, container_id
 = NEW.container_id WHERE id = NEW.package_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tutorials`
--

CREATE TABLE `tutorials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `img` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `video` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `tutorials`
--

INSERT INTO `tutorials` (`id`, `img`, `video`, `content`, `created_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '/uploads/static/video1.jpg', 'https://www.youtube.com/embed/-QVe-myc2M0', 'aser ilə yeni alış-veriş tərzini kəşf edin\r\n\r\n', 1, NULL, NULL, '2019-12-25 20:00:00', '2019-09-18 20:40:26'),
(2, '/uploads/static/video2.jpg', 'https://www.youtube.com/embed/-QVe-myc2M0', 'SİZ ALIRSINIZ, BİZ ÇATDIRIRIQ\r\n\r\n', 1, NULL, NULL, '2019-10-21 10:00:00', '2019-10-28 02:32:50');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT 'client',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `first_pass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client',
  `city_id` int(3) DEFAULT NULL COMMENT 'client (not null)',
  `address1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client (not null)',
  `address2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client ',
  `address3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client ',
  `zip1` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client (not null)',
  `zip2` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client ',
  `zip3` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client ',
  `phone1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone2` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client ',
  `phone3` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client ',
  `passport_series` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client (not null)',
  `passport_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client  (not null)',
  `passport_fin` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL COMMENT 'client (not null)',
  `gender` int(1) DEFAULT NULL COMMENT 'client (1-male, 2-female)',
  `language` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client (not null)',
  `suite` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C' COMMENT 'client (not null)',
  `balance` decimal(18,2) NOT NULL DEFAULT '0.00',
  `console_limit` int(11) DEFAULT '0' COMMENT 'client',
  `console_option` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'client',
  `contract_id` int(11) DEFAULT NULL COMMENT 'client',
  `packing_service_id` int(3) DEFAULT NULL COMMENT 'client (not null)',
  `destination_id` int(11) DEFAULT NULL COMMENT 'operator (not null)',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(3) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_active_time` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `parent_id`, `name`, `surname`, `username`, `password`, `first_pass`, `email`, `email_verified_at`, `image`, `city_id`, `address1`, `address2`, `address3`, `zip1`, `zip2`, `zip3`, `phone1`, `phone2`, `phone3`, `passport_series`, `passport_number`, `passport_fin`, `birthday`, `gender`, `language`, `suite`, `balance`, `console_limit`, `console_option`, `contract_id`, `packing_service_id`, `destination_id`, `remember_token`, `role_id`, `token`, `last_active_time`, `created_by`, `created_at`, `updated_at`, `deleted_at`, `deleted_by`) VALUES
(1, NULL, 'Sahib', 'Fermanli', 'sfermanli', '$2y$10$bYCeDpcyE4vuAV7n.LWGGOQaENv7XzT77L2DWVKB2s4LDJd7y2D8K', 'Sayko1907', 'sfermanli@swgh.az', NULL, NULL, NULL, 'salam', 'hava', 'necedir', '', NULL, NULL, '0777220075', NULL, NULL, NULL, '', NULL, NULL, 1, NULL, 'C', '0.00', 0, NULL, NULL, NULL, 2, 'TXcDhRgUW6tnARWf2SNxNUtfanY0Fe1QgEytCqEtsSJO0OYOZV4OZo12PO3K', 1, 'lH0TUnC27dzScgRcbtlG1XlEd6iYmti76caJhgZueZlrulgxLnGBeMyOjLwkEjoopSN5OVwzsyeeDOLdPriRy5wUQxFpJfgKYkk9oG1u2sMxLeVvOv7gq3skc9nOmPRN4posl12SJmyxDf0TPf2k3bCTwEgUNaIBCaKQfhZ63GWEPMq5OwLUnflYMF2f42kuOR2KbOTYsjXnn1y5ygA34mhFQCtbuf7dqxMaCvV8vuCzqYNgNAitf7CEa4X0IAS', 1574690125, NULL, '2019-08-25 20:00:00', '2019-11-25 13:55:25', '2019-08-29 13:02:57', NULL),
(2, NULL, 'Ilkin', 'Xelilov', 'ilkin', '$2y$10$BJqkajKW92LcaMNtYPDpneZS.ifHj6wusaxoZtOLK2dZYGVTkXWX.', 'asasdsd', 'ilkin@swgh.az', NULL, NULL, NULL, 'hello', 'what', 'company', '1000', NULL, NULL, '0777220075', NULL, NULL, NULL, '09815711', NULL, '1997-05-23', 1, 'AZ', 'C', '0.00', 0, NULL, 1, 1, 1, 'Pguda2RKnIhdpTSG0XI2bEXjoaDKFubJRjc89BkviGBH3SJmAfm3FXzt8uH5', 2, NULL, NULL, 1, '2019-08-25 20:00:00', '2019-08-30 04:22:37', '2019-08-30 08:22:37', 1),
(3, NULL, 'Nail', 'Balayev', 'nbalayev', '$2y$10$bYCeDpcyE4vuAV7n.LWGGOQaENv7XzT77L2DWVKB2s4LDJd7y2D8K', '12345678', 'nbalayev@swgh.az', NULL, NULL, NULL, 'baki', 'suraxani', NULL, '15123', NULL, NULL, '0777220075', NULL, NULL, NULL, '05520712', NULL, '1998-02-02', 1, 'RUS', 'C', '3.86', NULL, 'quantity', 1, 1, NULL, 'PrV5kTzwe3HxoRAZpPi6RaaKbd70TYgIpRZfXRwep0sXR1SefsuDWmFsplmS', 2, NULL, NULL, 1, '2019-08-29 10:49:53', '2019-12-28 12:53:44', NULL, NULL),
(4, 3, 'Murad', 'Mustafayev', 'murad', '$2y$10$8nbR/zB4mzyToHhGvp6x5uTK8LCeF6IHKdXPUX3hU.fd.K47Ah2QW', 'jk@dff6+23f#vf', 'sahibfermanli230@gmail.com', NULL, NULL, NULL, 'nehrem', 'vdvd', NULL, '5120', '1000', NULL, '+994777220075', NULL, NULL, NULL, '09815713', NULL, '1997-05-23', 1, 'ENG', 'C', '0.00', 12, 'select', 3, 2, NULL, NULL, 2, NULL, NULL, 1, '2019-08-29 11:12:51', '2019-08-30 08:30:44', NULL, NULL),
(5, NULL, 'Ferhad', 'Azizov', 'ferhad', '$2y$10$31QStTi59K2XYXyFqf4tIuZn4ny368ptO1MgFimSuvrFmNJU5NP2O', '12345678', 'anbar@test.az', NULL, NULL, NULL, 'dcdcdfvcdf', NULL, NULL, '45132', NULL, NULL, '5632156', NULL, NULL, NULL, '56231', NULL, '2018-05-05', 1, 'AZ', 'C', '0.00', NULL, NULL, 1, 2, NULL, NULL, 2, NULL, NULL, 1, '2019-08-30 08:10:18', '2019-08-30 08:14:01', NULL, NULL),
(6, NULL, 'Cashier1', 'Cashier2', 'cashier', '$2y$10$x6rcnBaNYHlCUFhW1faAMO4luvodaTvaPReYA3QB.PNz6ZUUvW8Eu', '123456', 'cashier@mail.ru', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0777220073', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', '0.00', 0, NULL, NULL, NULL, 1, NULL, 4, '3rhfn5pflrswTIAxoskoP1YAw8q4120rUC60IGTFXjrYP6OkPuwyYyfkSrI8kacydH6HExeTO8qbKl5whZN9msoF0D3S2cscHLtgid0oM6MaMHi9r7DyFKyWBZjXBEuOrS1LOSauKQqhdA3ijQWfSzubkMuzI9pZ9a8QxuyUDyCZzMTjIY4uKir9C1uzXCP8igJ4Xakzj3dD4JEr0WE2gqVWjCTOduz5Pb3LykLKIxtaerCDSC799zyh8Qw8iHF', 1574839530, 1, '2019-09-02 13:49:13', '2019-11-27 07:25:30', '2019-09-02 17:52:18', NULL),
(7, NULL, 'Delivery', 'Test', 'delivery', '$2y$10$SK8EFUCnGLEmzMlIBacLi.zFgU1ceIq4Iyc7X.WClKTWiqyvtz..C', '123456', 'delivery@swgh.az', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0777220075', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', '0.00', 0, NULL, NULL, NULL, 1, NULL, 5, 'M7wEZAtL68nyPyDxdhUVagH5HT4aHioXnC3umrbzbfVEgmSNKfGzf0xI66ppNQGO0ovGjb0wFT83nAoPADDgqui170DDiWWgHamMRYAZpIaRpGwUBBgzBQKVTr8iAwQiGfjoo6ctMSmPsVRAGwSg6l9wcGkj4rZwbBIiqBuN0FDSmC15jyAVIvIGKaFrHSSkeP3zFqGrVx3xiz65prJ21aclS3MU46o8w8Cs7DmdLujuF1Ukl1IgudEg5ErcGtN', 1574857404, 1, '2019-11-15 08:16:46', '2019-11-27 12:23:24', NULL, NULL),
(8, NULL, 'Distributor', 'Test', 'distributor', '$2y$10$T.3TCX7/KQg6NkWHxtlB1eGAV8hPitLhNO4WYdc2UqxuG4AiZ1jNC', '123456', 'dist@swgh.az', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0777220075', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', '0.00', 0, NULL, NULL, NULL, 2, NULL, 6, 'BA9pISmgG6RPdo5d10AQ7x6lFMrfms77vd3evqh8x0XxATvmu6WtRPi0bJ2tzeLRFyMCz60P7hoZkxCC1iK6uIjV8VSuLQcRPMBlQH7WswkoILUcu3z8sjf6hv5U4Sl8rubypEWh6rEsbAzdeqcwmDq9W4qaJ05P6ld17LqkLj1a5RFLn4gKWvFhHXcT6dRJU6SUbGos8DJAfxR5OPrAqzl7ARihA7zKRPp8pfsKVLoEZf1w9rcoKPfqBPEX8bW', 1575029334, 1, '2019-11-15 08:17:46', '2019-11-29 12:38:51', NULL, NULL),
(9, NULL, 'Collector', 'Test', 'collector', '$2y$10$YBmos10XAjyi8r7FGr1L1uuZPbutxJv75.AKY6/AU9AzrVcv/MC9G', '12345678', 'collector@swgh.az', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0777220075', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', '0.00', 0, NULL, NULL, NULL, 2, NULL, 3, 'WEyYIJuWakNnlERSNUD6AxsbI7vxcWKtaIUnG3rGA58YvXHWSd66nk1rEyVGBUa5WJp5r5891mfNy1AiwML8iyvsJPS5xdDR3TVmiKa8bh5b5Qv1f9pgfJJJ3DwlCd2XM6AZ1669Ou1ThZ3rnxWSh4Zx72lGf6nxW2xZWccLjxGWw1VfwP9agwuHfnKse1tXcIQzAlrMrmBI2vCZQgx07uKY0ul1bW148ic0YV4KUj2NrsQjpFyWLLw1jlmLWrV', 1575353522, 1, '2019-11-15 08:19:07', '2019-12-03 06:12:02', NULL, NULL),
(10, NULL, 'operator', 'test', 'operator', '$2y$10$yBRFNz40VHBzUFtOctjYt.EVsdPbIK83wqkrwVEXY2tancdwSgrhS', '123456', 'operator@test.az', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0777220075', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', '0.00', 0, NULL, NULL, NULL, 1, NULL, 7, '3IPOja6q7HBdN2MenYBEHbEpeoaxUFs6FQcun485oR7XAS8hh9em8lx9TATxOGRD4Je1yNzSw4DJJaLP8jcI1oYohuBq5s8z65EqtHxsoZoDE1vofVk1xWWwjv6VER5ZV09LjpL3ORAOWqfd37MFnYRYSgrtAqR1fpQ7Q5KvIlf5jtSoJdlvCHAn9jkc9dq7Tcno08EzqKvBwqpmZlh8cPhjfCgk8KjZOA3OgGX15a9MNJKNV0Fnuhc7CH3DbuT', 1574686318, 1, '2019-11-25 11:35:58', '2019-11-25 12:51:58', NULL, NULL),
(11, NULL, 'delivery1', 'test', 'delivery1', '$2y$10$Rl612noZcFwcXZBBTRAvgukbPwEIpHvmoGJhOE6dxffvHnZziorsW', '123456', 'delicert@wdsd.ci', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0777220075', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'C', '0.00', 0, NULL, NULL, NULL, 1, NULL, 5, NULL, NULL, 1, '2019-11-27 12:27:15', '2019-11-27 12:27:15', NULL, NULL),
(12, 1656515, 'firudin', 'fermanli', 'firudin@mail.ru', '$2y$10$13slJkGIWJa/rugInrS97OAtNaRvancGFo8A3rVlfNOIFL9AUU4E2', NULL, 'firudin@mail.ru', NULL, NULL, 2, 'naxcivan seher', NULL, NULL, NULL, NULL, NULL, '0707220075', NULL, NULL, 'AZE', '2165156', '561KA55', '1999-06-23', 1, 'EN', 'C', '0.00', 0, NULL, NULL, NULL, NULL, 'eKHtAzOei6AOuViTVBaMD0kxG0AYHj5Sh2nPMk58MgXeVFBKcUS3yDOHdi8Z', 2, NULL, NULL, NULL, '2020-01-05 17:53:38', '2020-01-05 17:53:38', NULL, NULL),
(13, NULL, 'settar', 'qenberli', 'settar@mail.ru', '$2y$10$rJCYOJTNzJQynzwA3LwmBOoGKLDikR7vZInh5JU.4zvMeaNXuU9FW', NULL, 'settar@mail.ru', NULL, NULL, 1, 'address1', NULL, NULL, NULL, NULL, NULL, '0708525852', '0512586325', NULL, 'AZE', '2258555', '5616515', '1997-05-23', 2, 'RU', 'C', '0.00', 0, NULL, NULL, NULL, NULL, 'i56Po9fFWy2FvHRMlNuYKvWliy8NNlycMy5OeAOkzfmHeU6xdVTbXD6Jnsuj', 2, NULL, NULL, NULL, '2020-01-06 04:25:06', '2020-01-06 04:25:06', NULL, NULL);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `awb`
--
ALTER TABLE `awb`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `balance_log`
--
ALTER TABLE `balance_log`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Tablo için indeksler `client_transaction`
--
ALTER TABLE `client_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `container`
--
ALTER TABLE `container`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `contract_detail`
--
ALTER TABLE `contract_detail`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `country_details`
--
ALTER TABLE `country_details`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `exchange_rate`
--
ALTER TABLE `exchange_rate`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `instructions`
--
ALTER TABLE `instructions`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `lb_status`
--
ALTER TABLE `lb_status`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `package_files`
--
ALTER TABLE `package_files`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `package_status`
--
ALTER TABLE `package_status`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `packing_services`
--
ALTER TABLE `packing_services`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `payment_log`
--
ALTER TABLE `payment_log`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `payment_task`
--
ALTER TABLE `payment_task`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_6g0ek52nh6ky8tf8revw39w5h` (`location_id`);

--
-- Tablo için indeksler `prohibited_items`
--
ALTER TABLE `prohibited_items`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `seller_category`
--
ALTER TABLE `seller_category`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `seller_location`
--
ALTER TABLE `seller_location`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `special_orders`
--
ALTER TABLE `special_orders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `special_order_status`
--
ALTER TABLE `special_order_status`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tariff_types`
--
ALTER TABLE `tariff_types`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tracking_log`
--
ALTER TABLE `tracking_log`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tutorials`
--
ALTER TABLE `tutorials`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `awb`
--
ALTER TABLE `awb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `balance_log`
--
ALTER TABLE `balance_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `client_transaction`
--
ALTER TABLE `client_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `container`
--
ALTER TABLE `container`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `contract`
--
ALTER TABLE `contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `contract_detail`
--
ALTER TABLE `contract_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `country_details`
--
ALTER TABLE `country_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `exchange_rate`
--
ALTER TABLE `exchange_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `flight`
--
ALTER TABLE `flight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `instructions`
--
ALTER TABLE `instructions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Tablo için AUTO_INCREMENT değeri `lb_status`
--
ALTER TABLE `lb_status`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Tablo için AUTO_INCREMENT değeri `package_files`
--
ALTER TABLE `package_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `package_status`
--
ALTER TABLE `package_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- Tablo için AUTO_INCREMENT değeri `packing_services`
--
ALTER TABLE `packing_services`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `payment_log`
--
ALTER TABLE `payment_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Tablo için AUTO_INCREMENT değeri `payment_task`
--
ALTER TABLE `payment_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Tablo için AUTO_INCREMENT değeri `prohibited_items`
--
ALTER TABLE `prohibited_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- Tablo için AUTO_INCREMENT değeri `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Tablo için AUTO_INCREMENT değeri `seller_category`
--
ALTER TABLE `seller_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `seller_location`
--
ALTER TABLE `seller_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `special_orders`
--
ALTER TABLE `special_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `special_order_status`
--
ALTER TABLE `special_order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `tariff_types`
--
ALTER TABLE `tariff_types`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `tracking_log`
--
ALTER TABLE `tracking_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- Tablo için AUTO_INCREMENT değeri `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `position`
--
ALTER TABLE `position`
  ADD CONSTRAINT `FK_6g0ek52nh6ky8tf8revw39w5h` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
