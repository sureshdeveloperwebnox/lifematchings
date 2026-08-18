-- ============================================================
-- Fix: Create gothrams and mangliks tables
-- Project  : Life Matchings
-- Date     : 2026-08-18
-- Fixes    : 500 error on /admin/gothrams page (live server)
-- Safe to run multiple times (uses CREATE TABLE IF NOT EXISTS)
-- ============================================================

-- Gothrams table
CREATE TABLE IF NOT EXISTS `gothrams` (
    `id`         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Mangliks table
CREATE TABLE IF NOT EXISTS `mangliks` (
    `id`         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add gothram column to spiritual_backgrounds if missing
-- (required for member profile gothram field)
ALTER TABLE `spiritual_backgrounds`
    ADD COLUMN IF NOT EXISTS `gothram` VARCHAR(255) NULL DEFAULT NULL AFTER `sub_caste_id`;
