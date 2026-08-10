-- Database Update Script for Today's Changes
-- Project: Life Matchings
-- Date: 2026-08-10

-- 1. Create gothrams and mangliks tables for Admin Profile Attributes
CREATE TABLE IF NOT EXISTS `gothrams` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS `mangliks` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL
);

-- Seed initial values for mangliks
INSERT IGNORE INTO `mangliks` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Yes', NOW(), NOW()),
(2, 'No', NOW(), NOW()),
(3, 'Does not matter', NOW(), NOW());

-- Seed initial values for gothrams
INSERT IGNORE INTO `gothrams` (`name`, `created_at`, `updated_at`) VALUES
('Agastya', NOW(), NOW()),
('Angirasa', NOW(), NOW()),
('Atri', NOW(), NOW()),
('Bharadwaja', NOW(), NOW()),
('Bhrigu', NOW(), NOW()),
('Dhananjaya', NOW(), NOW()),
('Gargya', NOW(), NOW()),
('Gautama', NOW(), NOW()),
('Harita', NOW(), NOW()),
('Jamadagni', NOW(), NOW()),
('Kanva', NOW(), NOW()),
('Kapila', NOW(), NOW()),
('Kashyapa', NOW(), NOW()),
('Kaundinya', NOW(), NOW()),
('Kutsasa', NOW(), NOW()),
('Moudgalya', NOW(), NOW()),
('Naidhruva', NOW(), NOW()),
('Nithyandhana', NOW(), NOW()),
('Parashara', NOW(), NOW()),
('Sandilya', NOW(), NOW()),
('Sankriti', NOW(), NOW()),
('Shatamarshana', NOW(), NOW()),
('Siva', NOW(), NOW()),
('Srivastava', NOW(), NOW()),
('Upamanyu', NOW(), NOW()),
('Vadoolas', NOW(), NOW()),
('Vashishta', NOW(), NOW()),
('Vatsa', NOW(), NOW()),
('Vishnuvardhana', NOW(), NOW()),
('Viswamitra', NOW(), NOW()),
('Other / Don\'t Know', NOW(), NOW());

-- 2. Add expiry_notified column to members table if not exists
ALTER TABLE `members` ADD COLUMN `expiry_notified` TINYINT DEFAULT 0 AFTER `package_validity`;

-- 3. Insert Email Templates for Package Expiration
INSERT IGNORE INTO `email_templates` (`identifier`, `subject`, `body`, `status`, `created_at`, `updated_at`) VALUES
('package_expired_user_email', 'Your Package Has Expired - Life Matchings', '<p>Dear [[name]],</p><p>Your subscription package (<strong>[[package_name]]</strong>) on [[site_name]] has expired on [[expiry_date]].</p><p>Please upgrade or renew your package to continue enjoying premium services.</p><p>Regards,<br>[[from]]</p>', 1, NOW(), NOW()),
('package_expired_admin_email', 'Member Package Expired Alert - [[member_name]]', '<p>Hello Admin,</p><p>The package for member <strong>[[member_name]]</strong> (Email: [[email]]) has expired on [[expiry_date]].</p><p>You can view member details here: <a href="[[profile_link]]">[[profile_link]]</a></p><p>Regards,<br>[[from]]</p>', 1, NOW(), NOW());

-- 4. Add last_login_at timestamp column to users table
ALTER TABLE `users` ADD COLUMN `last_login_at` TIMESTAMP NULL AFTER `remember_token`;
