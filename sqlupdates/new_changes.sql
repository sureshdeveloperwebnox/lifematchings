-- SQL Updates and Database Schema Changes
-- This script contains the tables and column updates corresponding to the migrations resolved during setup.

-- 1. Create manual_payment_methods table
CREATE TABLE IF NOT EXISTS `manual_payment_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Add isInitialPaymentPaid column to users table
ALTER TABLE `users` 
  ADD COLUMN IF NOT EXISTS `isInitialPaymentPaid` int(11) NOT NULL DEFAULT 0 AFTER `referred_by`;

-- 3. Create sun_signs table
CREATE TABLE IF NOT EXISTS `sun_signs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Create moon_signs table
CREATE TABLE IF NOT EXISTS `moon_signs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Add moon_sign_ids JSON column to sun_signs table
ALTER TABLE `sun_signs` 
  ADD COLUMN IF NOT EXISTS `moon_sign_ids` json NULL DEFAULT NULL AFTER `name`;

-- 6. Update Free package limits (id = 1)
UPDATE `packages` 
SET `express_interest` = 15, `contact` = 0, `validity` = 30 
WHERE `id` = 1;
