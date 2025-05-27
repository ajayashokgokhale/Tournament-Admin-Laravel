-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 27, 2025 at 02:03 AM
-- Server version: 10.11.11-MariaDB-0ubuntu0.24.04.2
-- PHP Version: 8.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tournament_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

DROP TABLE IF EXISTS `contests`;
CREATE TABLE `contests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `match_title` varchar(255) NOT NULL,
  `match_datetime` datetime DEFAULT NULL,
  `match_location` varchar(255) NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `franchises_1_id` bigint(20) UNSIGNED NOT NULL,
  `franchises_2_id` bigint(20) UNSIGNED NOT NULL,
  `score_1` int(10) UNSIGNED DEFAULT 0,
  `score_2` int(10) UNSIGNED DEFAULT 0,
  `status` enum('scheduled','live','completed') DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`id`, `match_title`, `match_datetime`, `match_location`, `event_id`, `franchises_1_id`, `franchises_2_id`, `score_1`, `score_2`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Match-1', '2025-05-20 14:00:00', 'Dallas, Texas', 1, 1, 2, 185, 172, 'completed', '2025-05-26 02:30:00', '2025-05-26 02:30:00', NULL),
(2, 'Match-2', '2025-05-22 15:30:00', 'Phoenix, Arizona', 1, 3, 4, 198, 210, 'completed', '2025-05-26 02:31:00', '2025-05-26 02:31:00', NULL),
(3, 'Match-3', '2025-05-23 16:00:00', 'Denver, Colorado', 1, 2, 1, 150, 155, 'completed', '2025-05-26 02:32:00', '2025-05-26 02:32:00', NULL),
(4, 'Match-4', '2025-05-25 14:30:00', 'Orlando, Florida', 1, 4, 3, 200, 198, 'completed', '2025-05-26 02:33:00', '2025-05-26 02:33:00', NULL),
(5, 'Match-5', '2025-05-26 00:00:00', 'Seattle, Washington', 1, 1, 4, 0, 0, 'live', '2025-05-26 02:34:00', '2025-05-26 10:09:18', NULL),
(6, 'Match-6', '2025-05-26 22:15:00', 'San Diego, California', 1, 2, 3, 0, 0, 'live', '2025-05-26 02:35:00', '2025-05-26 10:09:31', NULL),
(7, 'Match-7', '2025-05-28 17:15:00', 'Boston, Massachusetts', 1, 3, 1, 0, 0, 'scheduled', '2025-05-26 02:36:00', '2025-05-26 02:36:00', NULL),
(8, 'Match-8', '2025-05-29 18:00:00', 'Chicago, Illinois', 1, 4, 2, 0, 0, 'scheduled', '2025-05-26 02:37:00', '2025-05-26 02:37:00', NULL),
(9, 'Match-9', '2025-05-18 15:30:00', 'Atlanta, Georgia', 1, 2, 4, 143, 162, 'completed', '2025-05-26 02:38:00', '2025-05-26 02:38:00', NULL),
(10, 'Match-10', '2025-05-21 14:00:00', 'Austin, Texas', 1, 1, 3, 176, 165, 'completed', '2025-05-26 02:39:00', '2025-05-26 02:39:00', NULL),
(11, 'Match-11', '2025-05-30 16:00:00', 'Portland, Oregon', 1, 3, 2, 0, 0, 'scheduled', '2025-05-26 02:40:00', '2025-05-26 02:40:00', NULL),
(12, 'Match-12', '2025-05-31 14:30:00', 'Las Vegas, Nevada', 1, 4, 1, 0, 0, 'scheduled', '2025-05-26 02:41:00', '2025-05-26 02:41:00', NULL),
(13, 'Match-13', '2025-05-19 13:15:00', 'Charlotte, North Carolina', 1, 1, 2, 152, 143, 'completed', '2025-05-26 02:42:00', '2025-05-26 02:42:00', NULL),
(14, 'Match-14', '2025-05-24 16:45:00', 'Indianapolis, Indiana', 1, 2, 3, 165, 190, 'completed', '2025-05-26 02:43:00', '2025-05-26 02:43:00', NULL),
(15, 'Match-15', '2025-06-01 15:30:00', 'Philadelphia, Pennsylvania', 1, 3, 4, 0, 0, 'scheduled', '2025-05-26 02:44:00', '2025-05-26 02:44:00', NULL),
(16, 'Match-16', '2025-05-17 14:00:00', 'San Antonio, Texas', 1, 4, 1, 174, 181, 'completed', '2025-05-26 02:45:00', '2025-05-26 02:45:00', NULL),
(17, 'Match-17', '2025-06-02 13:45:00', 'Columbus, Ohio', 1, 2, 1, 0, 0, 'scheduled', '2025-05-26 02:46:00', '2025-05-26 02:46:00', NULL),
(18, 'Match-18', '2025-06-03 16:20:00', 'Nashville, Tennessee', 1, 1, 3, 0, 0, 'scheduled', '2025-05-26 02:47:00', '2025-05-26 02:47:00', NULL),
(19, 'Match-19', '2025-05-15 13:30:00', 'Detroit, Michigan', 1, 3, 2, 142, 158, 'completed', '2025-05-26 02:48:00', '2025-05-26 02:48:00', NULL),
(20, 'Match-20', '2025-06-04 17:00:00', 'Jacksonville, Florida', 1, 4, 2, 0, 0, 'scheduled', '2025-05-26 02:49:00', '2025-05-26 02:49:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_start` datetime NOT NULL,
  `event_end` datetime NOT NULL,
  `event_location` varchar(255) NOT NULL,
  `event_photo` varchar(150) DEFAULT NULL,
  `event_youtube_link` varchar(255) DEFAULT NULL,
  `event_status` enum('upcoming','ongoing','completed') DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_name`, `event_start`, `event_end`, `event_location`, `event_photo`, `event_youtube_link`, `event_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Minicup Cricket Champions Trophy', '2025-05-14 22:37:00', '2025-05-28 22:37:00', 'Aurangabad', NULL, NULL, 'upcoming', '2025-04-10 10:54:47', '2025-05-26 06:42:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
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
-- Table structure for table `franchises`
--

DROP TABLE IF EXISTS `franchises`;
CREATE TABLE `franchises` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `logo` varchar(150) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `about_franchise` text DEFAULT NULL,
  `status` enum('active','hold','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `franchises`
--

INSERT INTO `franchises` (`id`, `name`, `email`, `logo`, `tagline`, `address_id`, `about_franchise`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Team - Delhi', 'enq@exeire.com', 'franchiseslogo/logo_s6s5cBBhXCZgi1U20250526134935.jpeg', 'Capital Hitters, Unstoppable Winners!', NULL, 'This is about Franchise', 'active', '2025-04-03 02:45:24', '2025-05-26 08:22:40', NULL),
(2, 'Team - Mumbai', 'contact@team-mumbai.in', 'franchiseslogo/logo_orbrHtlVCCZHTGT20250526134149.jpeg', 'Maximum Mumbai, Maximum Impact!', NULL, 'This is FR2', 'active', '2025-04-03 04:29:08', '2025-05-26 08:21:40', NULL),
(3, 'Team - Rajasthan', 'info@team-rajasthan.in', 'franchiseslogo/logo_cYUUjeeNffJgcte20250526134429.jpeg', 'Desert Storms, Fierce and Fast!', NULL, 'This is about FR34', 'active', '2025-04-03 07:04:54', '2025-05-26 08:22:26', NULL),
(4, 'Team - Gujrath', 'askme@team-gujrath.in', 'franchiseslogo/logo_BuUJgJtB2GzAkgN20250526134454.jpeg', 'Power Play from the West!', NULL, 'This is about Franchise fr5', 'active', '2025-04-06 22:47:44', '2025-05-26 08:23:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
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

DROP TABLE IF EXISTS `job_batches`;
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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `franchise_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(50) NOT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `status` enum('active','hold','inactive') DEFAULT 'active',
  `profile` text DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `franchise_id`, `name`, `position`, `photo`, `status`, `profile`, `youtube_link`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'James Anderson', 'Batter', NULL, 'active', NULL, NULL, '2025-05-25 06:01:07', '2025-05-26 01:47:39', NULL),
(2, 2, 'Michael Smith', 'Bowler', NULL, 'active', NULL, NULL, '2025-05-25 06:15:20', '2025-05-26 01:48:10', NULL),
(3, 3, 'William Johnson', 'All-rounder', NULL, 'active', NULL, NULL, '2025-05-25 06:31:32', '2025-05-26 01:49:22', NULL),
(4, 4, 'David Brown', 'Wicket-keeper', NULL, 'active', NULL, NULL, '2025-05-25 06:40:43', '2025-05-26 01:50:31', NULL),
(5, 1, 'John Davis', 'Batter', NULL, 'active', NULL, NULL, '2025-05-25 06:50:54', '2025-05-26 01:51:40', NULL),
(6, 2, 'Robert Miller', 'Bowler', NULL, 'active', NULL, NULL, '2025-05-25 07:01:05', '2025-05-26 01:52:49', NULL),
(7, 3, 'Christopher Wilson', 'All-rounder', NULL, 'active', NULL, NULL, '2025-05-25 07:11:16', '2025-05-26 01:53:58', NULL),
(8, 4, 'Daniel Moore', 'Wicket-keeper', NULL, 'active', NULL, NULL, '2025-05-25 07:21:27', '2025-05-26 01:55:07', NULL),
(9, 1, 'Matthew Taylor', 'Batter', NULL, 'active', NULL, NULL, '2025-05-25 07:31:38', '2025-05-26 01:56:16', NULL),
(10, 2, 'Anthony Anderson', 'Bowler', NULL, 'active', NULL, NULL, '2025-05-25 07:41:49', '2025-05-26 01:57:25', NULL),
(11, 3, 'Mark Thomas', 'All-rounder', NULL, 'active', NULL, NULL, '2025-05-25 07:52:00', '2025-05-26 01:58:34', NULL),
(12, 4, 'Joshua Jackson', 'Wicket-keeper', NULL, 'active', NULL, NULL, '2025-05-25 08:02:11', '2025-05-26 01:59:43', NULL),
(13, 1, 'Andrew White', 'Batter', NULL, 'active', NULL, NULL, '2025-05-25 08:12:22', '2025-05-26 02:00:52', NULL),
(14, 2, 'Joseph Harris', 'Bowler', NULL, 'active', NULL, NULL, '2025-05-25 08:22:33', '2025-05-26 02:02:01', NULL),
(15, 3, 'Charles Martin', 'All-rounder', NULL, 'active', NULL, NULL, '2025-05-25 08:32:44', '2025-05-26 02:03:10', NULL),
(16, 4, 'Steven Thompson', 'Wicket-keeper', NULL, 'active', NULL, NULL, '2025-05-25 08:42:55', '2025-05-26 02:04:19', NULL),
(17, 1, 'Brian Garcia', 'Batter', NULL, 'active', NULL, NULL, '2025-05-25 08:53:06', '2025-05-26 02:05:28', NULL),
(18, 2, 'Kevin Martinez', 'Bowler', NULL, 'active', NULL, NULL, '2025-05-25 09:03:17', '2025-05-26 02:06:37', NULL),
(19, 3, 'Jason Robinson', 'All-rounder', NULL, 'active', NULL, NULL, '2025-05-25 09:13:28', '2025-05-26 02:07:46', NULL),
(20, 4, 'Eric Clark', 'Wicket-keeper', NULL, 'active', NULL, NULL, '2025-05-25 09:23:39', '2025-05-26 02:08:55', NULL),
(21, 1, 'Ryan Rodriguez', 'Bowler', NULL, 'active', NULL, NULL, '2025-05-25 09:33:50', '2025-05-26 02:10:04', NULL),
(22, 2, 'Gary Lewis', 'Batter', NULL, 'active', NULL, NULL, '2025-05-25 09:44:01', '2025-05-26 02:11:13', NULL),
(23, 3, 'Justin Lee', 'All-rounder', NULL, 'active', NULL, NULL, '2025-05-25 09:54:12', '2025-05-26 02:12:22', NULL),
(24, 4, 'Brandon Walker', 'Bowler', NULL, 'active', NULL, NULL, '2025-05-25 10:04:23', '2025-05-26 02:13:31', NULL),
(25, 1, 'Scott Hall', 'Wicket-keeper', NULL, 'active', NULL, NULL, '2025-05-25 10:14:34', '2025-05-26 02:14:40', NULL),
(999, 1, 'Player 1', 'Batter', NULL, 'active', NULL, NULL, '2025-05-25 11:31:07', '2025-05-26 14:08:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `playing_players`
--

DROP TABLE IF EXISTS `playing_players`;
CREATE TABLE `playing_players` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player_id` bigint(20) UNSIGNED NOT NULL,
  `match_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ctwpILsNaq1SLUHJpr64e5OeyfB6k4doh7xJb2F1', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUE15WWQ1dUkza2JlTU5UUHdaOXVRMjJlZ3pvRVVRVHBpa0h3MDFKWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYXRjaGVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1748240535),
('FHsHv3gbOjabqTvbztFfV3W7oATAlOuc0TP4HGgc', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiajdxY1B1VnI5SUw3YVJsZ0ZVUDd0MzVhQWdUcnNOd01YUWhTa0lTSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jb250ZXN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1748281598);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Basketball Admin', 'basketballadmin@exeire.com', NULL, '$2y$12$R8MyD/jR9s9UdVkCrGxAEO2dwrjTK8X3cfLM4jnQYCK57i79sVDYW', NULL, '2025-04-02 23:49:07', '2025-04-02 23:49:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_to_franchises`
--

DROP TABLE IF EXISTS `user_to_franchises`;
CREATE TABLE `user_to_franchises` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `franchise_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `contests`
--
ALTER TABLE `contests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `franchises_1_id` (`franchises_1_id`),
  ADD KEY `franchises_2_id` (`franchises_2_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `franchises`
--
ALTER TABLE `franchises`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `franchise_id` (`franchise_id`);

--
-- Indexes for table `playing_players`
--
ALTER TABLE `playing_players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`),
  ADD KEY `match_id` (`match_id`);

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
-- Indexes for table `user_to_franchises`
--
ALTER TABLE `user_to_franchises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `franchise_id` (`franchise_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contests`
--
ALTER TABLE `contests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1224;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `franchises`
--
ALTER TABLE `franchises`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `playing_players`
--
ALTER TABLE `playing_players`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_to_franchises`
--
ALTER TABLE `user_to_franchises`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contests`
--
ALTER TABLE `contests`
  ADD CONSTRAINT `contests_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contests_ibfk_2` FOREIGN KEY (`franchises_1_id`) REFERENCES `franchises` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contests_ibfk_3` FOREIGN KEY (`franchises_2_id`) REFERENCES `franchises` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`franchise_id`) REFERENCES `franchises` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `playing_players`
--
ALTER TABLE `playing_players`
  ADD CONSTRAINT `playing_players_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playing_players_ibfk_2` FOREIGN KEY (`match_id`) REFERENCES `contests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_to_franchises`
--
ALTER TABLE `user_to_franchises`
  ADD CONSTRAINT `user_to_franchises_ibfk_1` FOREIGN KEY (`franchise_id`) REFERENCES `franchises` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_to_franchises_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
