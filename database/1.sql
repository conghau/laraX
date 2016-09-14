-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.50-0ubuntu0.14.04.1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for larach
CREATE DATABASE IF NOT EXISTS `larach` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `larach`;

-- Dumping data for table larach.admin_users: ~0 rows (approximately)
DELETE FROM `admin_users`;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;

-- Dumping data for table larach.menus: ~2 rows (approximately)
DELETE FROM `menus`;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` (`id`, `name`, `slug`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(2, 'Admin menu', 'admin-menu', 1, NULL, '2014-10-25 01:26:30', '2016-01-11 09:59:26'),
	(3, 'Main menu', 'main-menu', 1, NULL, '2016-05-26 23:21:28', '2016-05-26 23:21:28');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;

-- Dumping data for table larach.menu_contents: ~4 rows (approximately)
DELETE FROM `menu_contents`;
/*!40000 ALTER TABLE `menu_contents` DISABLE KEYS */;
INSERT INTO `menu_contents` (`id`, `menu_id`, `created_at`, `updated_at`) VALUES
	(2, 2, '2014-10-25 01:26:30', '2016-01-11 09:59:26'),
	(8, 2, '2016-05-12 00:33:51', '2016-05-12 00:33:51'),
	(9, 3, '2016-05-26 23:21:28', '2016-05-26 23:21:28'),
	(10, 3, '2016-05-31 23:53:25', '2016-05-31 23:53:25');
/*!40000 ALTER TABLE `menu_contents` ENABLE KEYS */;

-- Dumping data for table larach.menu_nodes: ~51 rows (approximately)
DELETE FROM `menu_nodes`;
/*!40000 ALTER TABLE `menu_nodes` DISABLE KEYS */;
INSERT INTO `menu_nodes` (`id`, `menu_content_id`, `parent_id`, `related_id`, `type`, `url`, `icon_font`, `position`, `title`, `css_class`, `created_at`, `updated_at`) VALUES
	(272, 2, 0, 0, 'custom-link', 'dashboard', 'fa fa-home', 0, 'Dashboard', 'start', '2015-01-09 07:34:11', '2015-01-26 15:08:30'),
	(273, 2, 301, 0, 'custom-link', 'categories', 'fa fa-sitemap', 1, 'Post Categories', '', '2015-01-09 07:34:11', '2016-01-18 03:43:37'),
	(280, 2, 403, 0, 'custom-link', 'custom-fields', 'fa fa-edit', 2, 'Custom fields', '', '2015-01-09 07:34:11', '2016-01-21 04:16:51'),
	(283, 2, 0, 0, 'custom-link', 'pages', 'fa fa-tasks', 3, 'Pages', '', '2015-01-09 07:34:11', '2015-12-22 11:30:12'),
	(291, 2, 403, 0, 'custom-link', 'settings', 'fa fa-gear', 1, 'Options', '', '2015-01-09 07:34:11', '2016-01-20 09:45:17'),
	(297, 2, 403, 0, 'custom-link', 'menus', 'fa fa-bars', 0, 'Menus', '', '2015-01-09 07:34:11', '2015-12-22 11:30:12'),
	(300, 2, 301, 0, 'custom-link', 'posts', 'icon-layers', 0, 'Posts', '', '2015-03-14 16:47:08', '2016-01-18 03:43:37'),
	(301, 2, 0, 0, 'custom-link', 'post', 'icon-layers', 1, 'Posts', '', '2015-03-14 16:47:08', '2015-12-22 09:48:57'),
	(331, 2, 414, 0, 'custom-link', 'products', 'fa fa-cubes', 0, 'Products', '', '2015-04-02 15:54:31', '2016-01-18 12:22:11'),
	(332, 2, 414, 0, 'custom-link', 'product-categories', 'fa fa-sitemap', 1, 'Product categories', '', '2015-04-02 15:54:31', '2016-01-18 12:22:11'),
	(403, 2, 0, 0, 'custom-link', 'settings', 'fa fa-cogs', 5, 'Settings', '', '2015-09-13 01:22:25', '2016-01-20 09:45:17'),
	(414, 2, 0, 0, 'custom-link', 'orders', 'fa fa-shopping-cart', 2, 'Ecommerce', '', '2016-01-15 07:12:15', '2016-01-18 12:22:11'),
	(415, 2, 438, 0, 'custom-link', 'admin-users', 'icon-users', 1, 'Admin users', '', '2016-01-19 06:50:46', '2016-01-24 14:05:00'),
	(416, 2, 403, 0, 'custom-link', 'settings/languages', 'fa fa-language', 3, 'Languages', '', '2016-01-21 02:10:32', '2016-01-21 04:16:51'),
	(437, 2, 403, 0, 'custom-link', 'countries-cities', 'fa fa-building', 4, 'Countries/Cities', '', '2016-01-24 06:24:54', '2016-01-24 06:24:54'),
	(438, 2, 0, 0, 'custom-link', 'users', 'icon-users', 4, 'Users', '', '2016-01-24 14:05:00', '2016-01-24 14:05:00'),
	(439, 2, 438, 0, 'custom-link', 'users', 'icon-users', 0, 'Users', '', '2016-01-24 14:05:00', '2016-01-24 14:05:00'),
	(440, 2, 414, 0, 'custom-link', 'coupons', 'fa fa-code', 3, 'Coupons', '', '2016-01-27 09:23:56', '2016-07-08 15:48:10'),
	(441, 2, 0, 0, 'custom-link', 'contacts', 'fa fa-suitcase', 7, 'Contacts', '', '2016-01-28 10:14:54', '2016-06-03 19:36:11'),
	(462, 8, 0, 0, 'custom-link', 'dashboard', 'fa fa-home', 0, 'Dashboard', '', '2016-05-12 00:36:16', '2016-05-12 00:36:16'),
	(463, 8, 0, 0, 'custom-link', 'posts', 'icon-layers', 1, 'Posts', '', '2016-05-12 00:36:16', '2016-05-12 18:00:19'),
	(464, 8, 463, 0, 'custom-link', 'posts', 'icon-layers', 0, 'Posts', '', '2016-05-12 00:36:16', '2016-05-12 18:00:19'),
	(465, 8, 463, 0, 'custom-link', 'categories', 'fa fa-sitemap', 1, 'Categories', '', '2016-05-12 00:36:16', '2016-05-12 18:00:19'),
	(466, 8, 0, 0, 'custom-link', 'orders', 'fa fa-shopping-cart', 2, 'E-commerce', '', '2016-05-12 00:36:16', '2016-05-12 18:00:19'),
	(467, 8, 466, 0, 'custom-link', 'products', 'fa fa-cubes', 0, 'Products', '', '2016-05-12 00:38:17', '2016-05-12 18:00:19'),
	(468, 8, 466, 0, 'custom-link', 'product-categories', 'fa fa-sitemap', 1, 'Product categories', '', '2016-05-12 00:38:17', '2016-05-12 18:00:19'),
	(469, 8, 466, 0, 'custom-link', 'coupons', 'fa fa-code', 2, 'Coupons', '', '2016-05-12 00:38:17', '2016-05-12 18:00:19'),
	(470, 8, 0, 0, 'custom-link', 'pages', 'fa fa-tasks', 3, 'Pages', '', '2016-05-12 00:38:17', '2016-05-12 18:00:19'),
	(471, 8, 0, 0, 'custom-link', 'users', 'icon-users', 4, 'Users', '', '2016-05-12 00:40:08', '2016-05-12 18:00:19'),
	(472, 8, 471, 0, 'custom-link', 'users', 'icon-users', 0, 'Users', '', '2016-05-12 00:40:08', '2016-05-12 18:00:19'),
	(473, 8, 471, 0, 'custom-link', 'admin-users', 'icon-users', 1, 'Admin users', '', '2016-05-12 00:40:08', '2016-05-12 18:00:19'),
	(474, 8, 0, 0, 'custom-link', 'settings', 'fa fa-cogs', 5, 'Settings', '', '2016-05-12 00:40:08', '2016-05-12 18:00:19'),
	(475, 8, 474, 0, 'custom-link', 'menus', 'fa fa-bars', 0, 'Menus', '', '2016-05-12 00:43:52', '2016-05-12 18:00:19'),
	(476, 8, 474, 0, 'custom-link', 'settings', 'fa fa-gear', 1, 'Options', '', '2016-05-12 00:43:52', '2016-05-12 18:00:19'),
	(477, 8, 474, 0, 'custom-link', 'custom-fields', 'fa fa-edit', 2, 'Custom fields', '', '2016-05-12 00:43:52', '2016-05-12 00:43:52'),
	(478, 8, 474, 0, 'custom-link', 'settings/languages', 'fa fa-language', 3, 'Languages', '', '2016-05-12 00:43:52', '2016-05-12 18:00:19'),
	(479, 8, 474, 0, 'custom-link', 'countries-cities', 'fa fa-building', 4, 'Countries/Cities', '', '2016-05-12 00:43:52', '2016-05-12 00:43:52'),
	(480, 8, 0, 0, 'custom-link', 'contacts', 'fa fa-suitcase', 7, 'Contacts', '', '2016-05-12 00:43:52', '2016-06-03 19:35:30'),
	(501, 8, 466, 0, 'custom-link', 'brands', '', 3, 'Brands', 'icon-umbrella', '2016-05-29 01:36:47', '2016-05-29 01:36:47'),
	(502, 8, 0, 0, 'custom-link', 'subscribed-emails', '', 8, 'Subscribed emails', 'icon-envelope', '2016-05-29 01:36:47', '2016-06-03 19:35:30'),
	(503, 2, 414, 0, 'custom-link', 'brands', 'icon-umbrella', 4, 'Brands', '', '2016-05-29 01:38:13', '2016-07-08 15:48:10'),
	(504, 2, 0, 0, 'custom-link', 'subscribed-emails', 'icon-envelope', 8, 'Subscribed emails', '', '2016-05-29 01:38:13', '2016-06-03 19:36:11'),
	(509, 9, 0, 2, 'page', '', '', 0, '', '', '2016-05-31 20:24:38', '2016-06-12 08:47:35'),
	(510, 10, 0, 1, 'page', '', '', 0, '', '', '2016-05-31 23:53:48', '2016-05-31 23:54:48'),
	(511, 10, 0, 2, 'category', '', '', 1, '', '', '2016-05-31 23:53:48', '2016-05-31 23:53:48'),
	(512, 10, 0, 3, 'category', '', '', 2, '', '', '2016-05-31 23:53:48', '2016-05-31 23:53:48'),
	(513, 10, 0, 1, 'category', '', '', 3, '', '', '2016-05-31 23:53:48', '2016-05-31 23:53:48'),
	(514, 10, 0, 2, 'page', '', '', 4, 'Liên hệ', '', '2016-05-31 23:53:48', '2016-06-01 00:18:30'),
	(515, 8, 0, 0, 'custom-link', 'comments', 'icon-bubbles', 6, 'Comments', '', '2016-06-03 19:35:30', '2016-06-03 19:35:30'),
	(516, 2, 0, 0, 'custom-link', 'comments', 'icon-bubbles', 6, 'Comments', '', '2016-06-03 19:36:11', '2016-06-03 19:36:11'),
	(517, 2, 414, 0, 'custom-link', 'product-attribute-sets', 'fa fa-bars', 2, 'Attributes', '', '2016-07-08 15:48:10', '2016-07-08 15:48:10');
/*!40000 ALTER TABLE `menu_nodes` ENABLE KEYS */;

-- Dumping data for table larach.migrations: ~6 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`migration`, `batch`) VALUES
	('2014_10_12_000000_create_users_table', 1),
	('2014_10_12_100000_create_password_resets_table', 1),
	('2016_09_12_101311_create_settings_table', 1),
	('2016_09_13_031848_create_admin_users_table', 2),
	('2016_09_13_133706_create_menuses_table', 2),
	('2016_09_14_025941_create_menus_table', 3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping data for table larach.password_resets: ~0 rows (approximately)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping data for table larach.settings: ~0 rows (approximately)
DELETE FROM `settings`;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping data for table larach.users: ~0 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
