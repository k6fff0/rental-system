/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `building_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `building_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `building_user_building_id_foreign` (`building_id`),
  KEY `building_user_user_id_foreign` (`user_id`),
  CONSTRAINT `building_user_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `building_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `building_utilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `building_utilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint unsigned NOT NULL,
  `type` enum('electricity','water','internet') COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `building_utilities_building_id_foreign` (`building_id`),
  CONSTRAINT `building_utilities_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buildings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `municipality_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_amount` decimal(10,2) DEFAULT NULL,
  `initial_renovation_cost` decimal(10,2) DEFAULT NULL,
  `electric_meters` json DEFAULT NULL,
  `internet_lines` json DEFAULT NULL,
  `building_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `families_only` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contract_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contract_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contract_types_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contracts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_id` bigint unsigned NOT NULL,
  `unit_id` bigint unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `rent_amount` decimal(8,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','terminated','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `contracts_contract_number_unique` (`contract_number`),
  KEY `contracts_tenant_id_foreign` (`tenant_id`),
  KEY `contracts_unit_id_foreign` (`unit_id`),
  CONSTRAINT `contracts_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contracts_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `expense_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `expense_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expense_images_expense_id_foreign` (`expense_id`),
  CONSTRAINT `expense_images_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint unsigned NOT NULL,
  `unit_id` bigint unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `invoice_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL,
  `expense_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_building_id_foreign` (`building_id`),
  KEY `expenses_unit_id_foreign` (`unit_id`),
  CONSTRAINT `expenses_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `expenses_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `maintenance_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenance_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maintenance_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `maintenance_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenance_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint unsigned NOT NULL,
  `unit_id` bigint unsigned NOT NULL,
  `tenant_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('new','in_progress','completed','rejected','delayed','waiting_materials','customer_unavailable','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigned_worker_id` bigint unsigned DEFAULT NULL,
  `technician_id` bigint unsigned DEFAULT NULL,
  `start_notes` text COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `end_notes` text COLLATE utf8mb4_unicode_ci,
  `cost` decimal(10,2) DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maintenance_requests_building_id_foreign` (`building_id`),
  KEY `maintenance_requests_unit_id_foreign` (`unit_id`),
  KEY `maintenance_requests_tenant_id_foreign` (`tenant_id`),
  KEY `maintenance_requests_assigned_worker_id_foreign` (`assigned_worker_id`),
  KEY `maintenance_requests_created_by_foreign` (`created_by`),
  KEY `maintenance_requests_category_id_foreign` (`category_id`),
  KEY `maintenance_requests_technician_id_foreign` (`technician_id`),
  CONSTRAINT `maintenance_requests_assigned_worker_id_foreign` FOREIGN KEY (`assigned_worker_id`) REFERENCES `maintenance_workers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `maintenance_requests_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `maintenance_requests_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `maintenance_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `maintenance_requests_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `maintenance_requests_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `maintenance_requests_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE SET NULL,
  CONSTRAINT `maintenance_requests_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `maintenance_workers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenance_workers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_reset_tokens_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payment_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `action` enum('updated','deleted') COLLATE utf8mb4_unicode_ci NOT NULL,
  `changes` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_logs_payment_id_foreign` (`payment_id`),
  KEY `payment_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `payment_logs_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payment_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` bigint unsigned DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `month_for` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payer_id` bigint unsigned DEFAULT NULL,
  `collector_id` bigint unsigned DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_contract_id_foreign` (`contract_id`),
  KEY `payments_payer_id_foreign` (`payer_id`),
  KEY `payments_collector_id_foreign` (`collector_id`),
  CONSTRAINT `payments_collector_id_foreign` FOREIGN KEY (`collector_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_payer_id_foreign` FOREIGN KEY (`payer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `room_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `is_broker_booking` tinyint(1) NOT NULL DEFAULT '0',
  `tentative_at` timestamp NULL DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `auto_expire_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `deposit_paid` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_bookings_unit_id_foreign` (`unit_id`),
  KEY `room_bookings_user_id_foreign` (`user_id`),
  CONSTRAINT `room_bookings_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  CONSTRAINT `room_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` json NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_group_name_unique` (`group`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `technician_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `technician_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `specialty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('available','busy','unavailable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `technician_profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `technician_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `technicians`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `technicians` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tenant_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenant_unit` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint unsigned NOT NULL,
  `unit_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenant_unit_tenant_id_unit_id_unique` (`tenant_id`,`unit_id`),
  KEY `tenant_unit_unit_id_foreign` (`unit_id`),
  CONSTRAINT `tenant_unit_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tenant_unit_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_type` enum('individual','family') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'individual',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `debt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `move_in_date` date DEFAULT NULL,
  `tenant_status` enum('active','late_payer','has_debt','absent','abroad','legal_issue') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `id_front` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tenants_phone_unique` (`phone`),
  KEY `tenants_unit_id_foreign` (`unit_id`),
  KEY `tenants_user_id_foreign` (`user_id`),
  CONSTRAINT `tenants_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tenants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `unit_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unit_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` tinyint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unit_images_unit_id_foreign` (`unit_id`),
  CONSTRAINT `unit_images_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint unsigned NOT NULL,
  `unit_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` int DEFAULT NULL,
  `room_layout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('available','occupied','booked','maintenance','cleaning') COLLATE utf8mb4_unicode_ci DEFAULT 'available',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `unit_type` enum('studio','furnished_studio','room_lounge','furnished_room_lounge','two_rooms_lounge','furnished_two_rooms_lounge','apartment','furnished_apartment') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_unit_per_building` (`building_id`,`unit_number`),
  CONSTRAINT `units_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preferred_language` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ar',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tenant',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2025_05_07_121034_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2025_05_07_121910_create_sessions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2025_05_07_130901_create_buildings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2025_05_07_130902_create_units_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2025_05_07_130903_create_tenants_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2025_05_07_130904_create_contracts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2025_05_07_130905_create_payments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2025_05_07_130906_create_maintenance_workers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2025_05_07_130907_create_maintenance_requests_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2025_05_07_130908_create_expenses_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2025_05_07_130909_create_inventory_items_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2025_05_08_110716_add_type_to_units_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2025_05_08_112600_add_role_to_users_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2025_05_08_154411_add_details_to_buildings_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2025_05_08_160900_add_details_to_expenses_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2025_05_08_212428_add_invoice_image_to_expenses_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2025_05_08_213718_make_description_nullable_in_expenses',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2025_05_08_221533_create_expense_images_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2025_05_08_224736_create_permission_tables',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2025_05_09_131849_add_user_id_to_tenants_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2025_05_09_132910_update_tenants_table_add_relationships',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2025_05_09_135556_add_notes_to_tenants_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2025_05_09_150718_create_maintenance_requests_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2025_05_10_124922_add_status_to_units_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2025_05_10_125820_add_notes_to_contracts_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2025_05_10_142248_create_activity_logs_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2025_05_10_142312_create_payments_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2025_05_10_153003_create_notifications_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2025_05_10_160157_create_notifications_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2025_05_10_214321_add_tenant_status_to_tenants_table',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2025_05_10_215650_add_notes_to_tenants_table',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2025_05_11_010542_modify_status_column_in_units_table',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2025_05_11_011820_add_notes_to_units_table',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2025_05_11_011943_add_notes_column_to_units_table',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2025_05_11_012419_modify_status_enum_in_units_table',16);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2025_05_11_014701_create_tenant_unit_table',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2025_05_12_073955_add_rent_price_to_units_table',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2025_05_12_080311_add_unique_unit_number_per_building',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2025_05_12_172547_update_status_enum_in_maintenance_requests',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2025_05_12_175954_add_category_to_maintenance_requests',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2025_05_12_181436_create_maintenance_categories_table',22);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2025_05_12_181807_add_category_id_to_maintenance_requests',23);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2025_05_12_182125_remove_old_category_column_from_maintenance_requests',24);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2025_05_12_191206_remove_type_from_maintenance_requests_table',25);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (59,'2025_05_13_103053_add_technician_id_to_maintenance_requests_table',26);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (60,'2025_05_13_110308_rename_type_column_in_units_table',27);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (61,'2025_05_13_110859_update_tenant_status_enum',28);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (62,'2025_05_13_120613_create_cache_table',29);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (63,'2025_05_13_132322_add_photo_url_to_users_table',30);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (64,'2025_05_13_175825_add_phone_to_users_table',31);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (65,'2025_05_15_140230_add_is_active_to_users_table',32);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (66,'2025_05_15_163755_add_preferred_language_to_users_table',33);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (67,'2025_05_16_102400_add_unit_type_to_units_table',34);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (68,'2025_05_18_103124_add_location_url_to_buildings_table',35);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (69,'2025_05_18_162102_add_uuid_to_tenants_table',36);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (70,'2025_05_18_175451_create_technicians_table',37);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (71,'2025_05_18_184753_create_technician_profiles_table',38);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (72,'2025_05_19_192141_add_is_hidden_to_users_table',39);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (73,'2025_05_22_210535_create_settings_table',40);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (74,'2025_05_22_215404_create_contract_types_table',41);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (75,'2025_05_23_022811_add_locked_to_settings_table',42);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (76,'2025_05_25_031422_update_units_table_add_cascade',43);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (77,'2025_05_25_044952_add_serial_to_tenants_table',44);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (78,'2025_05_25_212511_alter_location_url_column_in_buildings_table',45);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (79,'2025_05_25_221328_create_building_utilities_table',46);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (80,'2025_05_26_180002_update_unit_type_enum_for_furnished',47);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (81,'2025_05_26_184713_make_contract_number_unique',48);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (82,'2025_05_26_211117_add_status_to_contracts_table',49);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (83,'2025_05_27_003723_add_role_to_users_table',50);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (84,'2025_05_27_013201_update_payments_table_add_columns',51);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (85,'2025_05_27_024125_create_building_user_table',52);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (86,'2025_05_27_044300_add_collector_id_to_payments_table',53);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (87,'2025_05_27_061347_create_payment_logs_table',54);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (88,'2025_05_27_073708_add_deleted_at_to_payments_table',55);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (89,'2025_05_27_202753_add_building_number_to_buildings_table',56);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (90,'2025_05_27_221819_create_unit_images_table',57);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (91,'2025_05_29_063300_create_room_bookings_table',58);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (92,'2025_05_29_090546_alter_status_enum_in_room_bookings',59);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (93,'2025_05_29_093259_make_description_nullable_in_maintenance_requests',60);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (94,'2025_06_01_202112_add_families_only_to_buildings_table',61);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (95,'2025_06_01_203355_add_family_type_to_tenants_table',62);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (96,'2025_06_02_194448_add_broker_fields_to_room_bookings_table',63);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (97,'2025_06_02_194640_add_timestamps_to_room_bookings_table',64);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (98,'2025_06_02_211836_update_status_enum_in_room_bookings_table',65);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (99,'2025_06_03_004349_add_identity_images_to_tenants_table',66);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (100,'2025_06_03_161051_create_password_reset_tokens_table',67);
