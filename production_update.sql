-- Database Update Script for Production
-- Project: Life Matchings
-- Date: 2026-07-29

-- 1. Add Contact No 2 (phone2) column to users table if not exists
ALTER TABLE `users` ADD COLUMN `phone2` VARCHAR(255) NULL AFTER `phone`;

-- 2. Modify height column in physical_attributes table to VARCHAR(50) for string values (e.g. 5' 6")
ALTER TABLE `physical_attributes` MODIFY COLUMN `height` VARCHAR(50) NULL;

-- 3. Add Gothram column to spiritual_backgrounds table
ALTER TABLE `spiritual_backgrounds` ADD COLUMN `gothram` VARCHAR(255) NULL AFTER `sub_caste_id`;
