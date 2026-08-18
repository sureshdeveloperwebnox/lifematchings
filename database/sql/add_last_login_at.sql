-- ============================================================
-- Migration: Add last_login_at column to users table
-- Project  : Life Matchings
-- Date     : 2026-08-18
-- Safe to run on live DB (checks if column exists first)
-- ============================================================

SET @dbname = DATABASE();

SET @preparedStatement = (
    SELECT IF(
        COUNT(*) = 0,
        'ALTER TABLE `users` ADD COLUMN `last_login_at` TIMESTAMP NULL DEFAULT NULL AFTER `remember_token`',
        'SELECT "Column last_login_at already exists, skipping." AS info'
    )
    FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = @dbname
      AND TABLE_NAME   = 'users'
      AND COLUMN_NAME  = 'last_login_at'
);

PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;
