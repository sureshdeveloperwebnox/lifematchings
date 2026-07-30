-- Database Update Script for Today
-- Project: Life Matchings
-- Date: 2026-07-30

-- 1. Add additional_sub_caste and about_partner columns to partner_expectations table
ALTER TABLE `partner_expectations` ADD COLUMN `additional_sub_caste` VARCHAR(255) NULL AFTER `sub_caste_id`;
ALTER TABLE `partner_expectations` ADD COLUMN `about_partner` TEXT NULL AFTER `manglik`;

-- 2. Create gothrams table for Admin Profile Attributes
CREATE TABLE IF NOT EXISTS `gothrams` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL
);

-- 3. Create mangliks table for Admin Profile Attributes
CREATE TABLE IF NOT EXISTS `mangliks` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `deleted_at` TIMESTAMP NULL
);

-- 4. Initial seed data for mangliks table
INSERT IGNORE INTO `mangliks` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Yes', NOW(), NOW()),
(2, 'No', NOW(), NOW()),
(3, 'Does not matter', NOW(), NOW());

-- 5. Initial seed data for gothrams table
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
