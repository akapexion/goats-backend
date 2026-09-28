-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2026 at 05:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfc-goats`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Vegetables', 1, '2026-09-28 04:22:28', '2026-09-28 04:22:28'),
(3, 'Fresh Fruits', 1, '2026-09-28 04:22:28', '2026-09-28 04:22:28'),
(4, 'Dairy & Eggs', 1, '2026-09-28 04:22:28', '2026-09-28 04:22:28'),
(5, 'Fresh Herbs', 1, '2026-09-28 04:22:28', '2026-09-28 04:22:28'),
(6, 'Grains & Bakery', 1, '2026-09-28 04:22:28', '2026-09-28 04:22:28'),
(7, 'Honey & Preserves', 1, '2026-09-28 04:22:28', '2026-09-28 04:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `farmer_profiles`
--

CREATE TABLE `farmer_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `market_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stall_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `operating_days` varchar(50) DEFAULT NULL,
  `pickup_start_time` time DEFAULT NULL,
  `pickup_end_time` time DEFAULT NULL,
  `cutoff_hours` smallint(5) UNSIGNED NOT NULL DEFAULT 12,
  `approval_status` enum('pending','approved','suspended') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `farmer_profiles`
--

INSERT INTO `farmer_profiles` (`id`, `user_id`, `market_id`, `stall_name`, `description`, `address`, `latitude`, `longitude`, `operating_days`, `pickup_start_time`, `pickup_end_time`, `cutoff_hours`, `approval_status`, `created_at`, `updated_at`) VALUES
(2, 7, 2, 'Bilal Organic Greens', 'Family-owned pesticide-free vegetable farm providing leafy greens and crunchy roots freshly harvested each dawn.', 'Stall #14, Green Valley Market, University Road, Karachi', NULL, NULL, 'Saturday, Sunday', '08:00:00', '13:30:00', 12, 'approved', '2026-09-28 04:26:05', '2026-09-28 04:26:05'),
(3, 8, 3, 'Sun Valley Orchard & Herbs', 'Fresh seasonal fruit orchards and aromatic hydroponic herbs, grown using sustainable soil practices.', 'Stall #03, Beachside Plaza, Clifton Block 4, Karachi', NULL, NULL, 'Sunday', '08:00:00', '12:30:00', 8, 'approved', '2026-09-28 04:30:37', '2026-09-28 04:30:37'),
(4, 9, 4, 'Pure Dairy & Blossom Honey', 'Farm fresh unprocessed raw cow and buffalo milk, country butter, organic eggs, and raw wildflower honey.', 'Stall #208, Model Town Agro Mart, Lahore', NULL, NULL, 'Friday, Saturday', '08:30:00', '15:00:00', 6, 'approved', '2026-09-28 04:30:38', '2026-09-28 04:30:38'),
(5, 10, 5, 'Rashid Greenfield Harvest', 'Fresh organic highland potatoes, sweet carrots, heirloom tomatoes, and freshly stone-milled whole grains.', 'Stall #FV-7, F-7 Markaz Ground, Islamabad', NULL, NULL, 'Sunday', '09:00:00', '14:00:00', 10, 'approved', '2026-09-28 04:30:38', '2026-09-28 04:30:38'),
(6, 11, 6, 'Shabbir Chars Point', 'Shabbir Chars Point is a genuine place.', '#12 st. KHI', NULL, NULL, 'Sat, Sun', '12:27:00', '17:27:00', 12, 'approved', '2026-09-28 07:27:56', '2026-09-28 07:28:25');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `favoritable_type` varchar(255) NOT NULL,
  `favoritable_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `favoritable_type`, `favoritable_id`, `created_at`, `updated_at`) VALUES
(1, 6, 'App\\Models\\Product', 12, '2026-09-28 08:52:13', '2026-09-28 08:52:13');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `markets`
--

CREATE TABLE `markets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `open_days` varchar(50) DEFAULT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`id`, `name`, `address`, `city`, `latitude`, `longitude`, `open_days`, `open_time`, `close_time`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Green Valley Farmers Market', 'Plot #42, University Road, Gulshan-e-Iqbal', 'Karachi', 24.91800000, 67.09710000, 'Saturday, Sunday', '08:00:00', '14:00:00', 1, '2026-09-28 04:26:03', '2026-09-28 04:26:03'),
(3, 'Clifton Beachside Organic Bazaar', 'Near Sea View Park, Marine Promenade, Clifton Block 4', 'Karachi', 24.81380000, 67.03030000, 'Sunday', '07:30:00', '13:00:00', 1, '2026-09-28 04:26:03', '2026-09-28 04:26:03'),
(4, 'Lahore Model Town Agro Mart', 'Central Park Circular Road, Model Town', 'Lahore', 31.48150000, 74.32250000, 'Friday, Saturday', '08:30:00', '15:00:00', 1, '2026-09-28 04:26:03', '2026-09-28 04:26:03'),
(5, 'Islamabad F-7 Sunday Farmers Fair', 'F-7 Markaz Community Ground', 'Islamabad', 33.72150000, 73.05600000, 'Sunday', '08:30:00', '14:30:00', 1, '2026-09-28 04:26:03', '2026-09-28 04:26:03'),
(6, 'Saddar', 'Saddar Town, Karachi, Karachi Division', 'Karachi', 24.86057100, 67.03174100, 'Mon-Wed', '14:22:00', '17:23:00', 1, '2026-09-28 07:23:17', '2026-09-28 07:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_09_24_013348_create_personal_access_tokens_table', 1),
(4, '2026_09_24_080831_create_users_table', 1),
(5, '2026_09_24_081124_create_markets_table', 1),
(6, '2026_09_24_081200_create_farmer_profiles_table', 1),
(7, '2026_09_24_081234_create_categories_table', 1),
(8, '2026_09_24_081307_create_products_table', 1),
(9, '2026_09_24_081343_create_orders_table', 1),
(10, '2026_09_24_081441_create_order_items_table', 1),
(11, '2026_09_24_081652_create_favorites_table', 1),
(12, '2026_09_24_081726_create_reviews_table', 1),
(13, '2026_09_24_081751_create_notifications_table', 1),
(14, '2026_09_28_000000_add_market_id_to_products_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `farmer_profile_id` bigint(20) UNSIGNED NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time` time NOT NULL,
  `status` enum('placed','accepted','ready_for_pickup','completed','cancelled') NOT NULL DEFAULT 'placed',
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `farmer_profile_id`, `pickup_date`, `pickup_time`, `status`, `total_amount`, `note`, `created_at`, `updated_at`) VALUES
(1, 6, 4, '2026-09-28', '17:42:00', 'placed', 380.00, 'demo', '2026-09-28 04:39:36', '2026-09-28 04:39:36'),
(2, 6, 4, '2026-09-30', '21:05:00', 'placed', 1200.00, 'abjbdb', '2026-09-28 07:05:43', '2026-09-28 07:05:43'),
(3, 6, 4, '2026-09-30', '20:39:00', 'placed', 1200.00, 'babshgh', '2026-09-28 07:39:23', '2026-09-28 07:39:23');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 12, 1, 380.00, '2026-09-28 04:39:36', '2026-09-28 04:39:36'),
(2, 2, 13, 1, 1200.00, '2026-09-28 07:05:43', '2026-09-28 07:05:43'),
(3, 3, 13, 1, 1200.00, '2026-09-28 07:39:23', '2026-09-28 07:39:23');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(32, 'App\\Models\\User', 6, 'auth_token', 'fe8f12b7534d89ea5df6dd2a8af759a4b788364a2617b470009ce9d1aca1e82b', '[\"*\"]', '2026-09-28 04:39:51', NULL, '2026-09-28 04:38:55', '2026-09-28 04:39:51'),
(36, 'App\\Models\\User', 5, 'auth_token', '36c92b1502bd60becf398fb9564660453f8370676f79f868357fecae82e9a7e7', '[\"*\"]', '2026-09-28 06:19:11', NULL, '2026-09-28 06:19:06', '2026-09-28 06:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `farmer_profile_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `market_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `stock_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('available','sold_out','hidden') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `farmer_profile_id`, `category_id`, `market_id`, `name`, `description`, `price`, `unit`, `image_path`, `stock_quantity`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 2, 2, 2, 'Fresh Organic Spinach (Palak)', 'Nutrient-rich pesticide-free spinach harvested fresh in the morning.', 120.00, 'bunch', 'products/SeMvQbfsKHPFleNmV0tEzN6KWPP5oFhwKzEWhj0d.jpg', 40, 'available', '2026-09-28 04:30:37', '2026-09-28 05:42:18', NULL),
(4, 2, 2, 2, 'Crisp Red Radish & Carrots', 'Sweet red carrots and crunchy radishes sourced directly from farm soil.', 180.00, '2kg', 'https://images.unsplash.com/photo-1598170845058-32b9d6a5c317?w=600&auto=format&fit=crop&q=80', 30, 'available', '2026-09-28 04:30:37', '2026-09-28 10:11:28', NULL),
(5, 2, 2, 2, 'Vine Ripe Tomatoes & Red Onions', 'Juicy organic red tomatoes paired with sharp red onions.', 220.00, 'kg', 'products/photo-1592924357228-91a4daadcfea.avif', 35, 'available', '2026-09-28 04:30:37', '2026-09-28 10:11:28', NULL),
(6, 2, 2, 2, 'Farm Fresh Cucumbers & Okra', 'Tender green cucumbers and fresh ladyfingers.', 160.00, 'kg', 'products/photo-1449300079323-02e209d9d3a6.avif', 25, 'available', '2026-09-28 04:30:37', '2026-09-28 10:11:28', NULL),
(7, 2, 5, 2, 'Mint & Fresh Coriander Bundle', 'Aromatic mint leaves and fresh coriander for everyday cooking.', 70.00, 'bunch', 'products/photo-1628556270448-4d4e4148e1b1.avif', 60, 'available', '2026-09-28 04:30:37', '2026-09-28 10:11:28', NULL),
(8, 3, 3, 3, 'Sweet Farm Strawberries Box', 'Handpicked ripe strawberries straight from orchard beds.', 450.00, '500g box', 'products/photo-1464965911861-746a04b4bca6.avif', 20, 'available', '2026-09-28 04:30:37', '2026-09-28 10:11:28', NULL),
(9, 3, 3, 3, 'Citrus Farm Oranges (Kinnow)', 'Juicy sweet Sargodha kinnows packed with vitamin C.', 320.00, 'dozen', 'products/photo-1547514701-42782101795e.avif', 45, 'available', '2026-09-28 04:30:37', '2026-09-28 10:11:28', NULL),
(10, 3, 5, 3, 'Hydroponic Sweet Basil & Rosemary', 'Fragrant hydroponically grown sweet basil and rosemary twigs.', 150.00, 'pack', 'products/photo-1608686207856-001b95cf60ca.avif', 15, 'available', '2026-09-28 04:30:37', '2026-09-28 10:11:28', NULL),
(11, 4, 4, 4, 'Farm Pure Buffalo Milk (Unprocessed)', 'Pure rich unprocessed buffalo milk direct from morning milking.', 240.00, 'liter', 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=600&auto=format&fit=crop&q=80', 50, 'available', '2026-09-28 04:30:38', '2026-09-28 10:11:28', NULL),
(12, 4, 4, 4, 'Desi Free-Range Brown Eggs', 'Nutritious brown eggs from free-roaming farm hens.', 380.00, 'dozen', 'products/photo-1582722872445-44dc5f7e3c8f.avif', 29, 'available', '2026-09-28 04:30:38', '2026-09-28 10:11:28', NULL),
(13, 4, 7, 4, 'Wild Sidr Raw Blossom Honey', '100% pure raw unheated Sidr honey with natural healing properties.', 1200.00, '500g jar', 'https://images.unsplash.com/photo-1587049352847-4a222e784d38?w=600&auto=format&fit=crop&q=80', 13, 'available', '2026-09-28 04:30:38', '2026-09-28 10:11:28', NULL),
(14, 5, 2, 5, 'Highland Baby Red Potatoes', 'Naturally grown baby red potatoes ideal for roasting and curries.', 130.00, 'kg', 'products/photo-1518977676601-b53f82aba655.avif', 70, 'available', '2026-09-28 04:30:38', '2026-09-28 10:11:28', NULL),
(15, 5, 6, 5, 'Stone-Ground Whole Wheat Flour (Chakki Atta)', 'Pure traditional stone-ground whole wheat flour loaded with natural bran.', 450.00, '5kg bag', 'products/photo-1574323347407-f5e1ad6d020b.avif', 25, 'available', '2026-09-28 04:30:38', '2026-09-28 10:11:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `farmer_profile_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `farmer_reply` text DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('admin','farmer','customer') NOT NULL DEFAULT 'customer',
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'customer', 'Saif', 'saif@gmail.com', NULL, '$2y$12$urDdzwd3GVW.Opycc7y.8u2ks2PEZ8/AMQC0jvpf48z4s8BRq4qym', '773773773773', NULL, 'active', NULL, '2026-09-28 03:09:25', '2026-09-28 03:09:25', NULL),
(5, 'admin', 'System Admin', 'admin@marketlink.com', NULL, '$2y$12$a0aAN2eFaIiQn/bDbEVhtur6DVAVCP0n.7F4mZ.gd0FxKMllY72Dq', '0300 0000000', NULL, 'active', NULL, '2026-09-28 04:26:04', '2026-09-28 04:26:04', NULL),
(6, 'customer', 'Demo Customer', 'customer@marketlink.com', NULL, '$2y$12$zI74aWKTBHzHuFHXBBG/7OvJdXLZTvnHTA36qc1X.ECYBNwysVX5.', '0311 1112233', NULL, 'active', NULL, '2026-09-28 04:26:05', '2026-09-28 04:26:05', NULL),
(7, 'farmer', 'Bilal Ahmed', 'bilal@organicgreens.pk', NULL, '$2y$12$uWW.ErUavNACPNpCldGRYOqjAhfZhrRwvH2EBraN5y7FD5OTSlaoS', '0300 7144321', NULL, 'active', NULL, '2026-09-28 04:26:05', '2026-09-28 04:26:05', NULL),
(8, 'farmer', 'Tariq Mahmood', 'tariq@sunvalley.pk', NULL, '$2y$12$bWMggXNlheJ2fR048HVU..CKadHv0TiM143neQ3IeqY16U5RoccAC', '0312 2334445', NULL, 'active', NULL, '2026-09-28 04:30:37', '2026-09-28 04:30:37', NULL),
(9, 'farmer', 'Zainab Bibi', 'zainab@puredairy.pk', NULL, '$2y$12$ud5VJ296mWre4kvsiQhyKOyrVPEHgngQZ1UHJ9zhXYlEH55GV0lIS', '0345 6789012', NULL, 'active', NULL, '2026-09-28 04:30:38', '2026-09-28 04:30:38', NULL),
(10, 'farmer', 'Rashid Khan', 'rashid@greenfield.pk', NULL, '$2y$12$P2qakWoVyTnEPVy2WxxXvOZ14QkfyiGzNgIFwaAg7algWijJ.fAGi', '0322 3364566', NULL, 'active', NULL, '2026-09-28 04:30:38', '2026-09-28 04:30:38', NULL),
(11, 'farmer', 'Shabbir', 'shabbir@gmail.com', NULL, '$2y$12$ETqTnIkJ0eoSh/FEPoZfsu7oQkpWmBSAviMrROnkhub0r7ae7U4xK', '773773773773', NULL, 'active', NULL, '2026-09-28 07:25:34', '2026-09-28 07:25:34', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `farmer_profiles`
--
ALTER TABLE `farmer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `farmer_profiles_user_id_unique` (`user_id`),
  ADD KEY `farmer_profiles_market_id_foreign` (`market_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_unique` (`user_id`,`favoritable_type`,`favoritable_id`),
  ADD KEY `favorites_favoritable_type_favoritable_id_index` (`favoritable_type`,`favoritable_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `markets`
--
ALTER TABLE `markets`
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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_status_index` (`customer_id`,`status`),
  ADD KEY `orders_farmer_profile_id_status_index` (`farmer_profile_id`,`status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_farmer_profile_id_status_index` (`farmer_profile_id`,`status`),
  ADD KEY `products_name_index` (`name`),
  ADD KEY `products_market_id_foreign` (`market_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_customer_id_foreign` (`customer_id`),
  ADD KEY `reviews_farmer_profile_id_foreign` (`farmer_profile_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_order_id_foreign` (`order_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farmer_profiles`
--
ALTER TABLE `farmer_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `markets`
--
ALTER TABLE `markets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `farmer_profiles`
--
ALTER TABLE `farmer_profiles`
  ADD CONSTRAINT `farmer_profiles_market_id_foreign` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `farmer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_farmer_profile_id_foreign` FOREIGN KEY (`farmer_profile_id`) REFERENCES `farmer_profiles` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_farmer_profile_id_foreign` FOREIGN KEY (`farmer_profile_id`) REFERENCES `farmer_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_market_id_foreign` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_farmer_profile_id_foreign` FOREIGN KEY (`farmer_profile_id`) REFERENCES `farmer_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
