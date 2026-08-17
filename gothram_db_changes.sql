-- ============================================================
-- GOTHRAM & RELATED DB CHANGES - Life Matchings
-- Generated for server team cross-check
-- Run these queries on the LIVE server database
-- ============================================================


-- ============================================================
-- STEP 1: Create `gothrams` table
-- (Migration: 2026_07_30_000004_create_gothrams_and_mangliks_tables)
-- ============================================================

CREATE TABLE IF NOT EXISTS `gothrams` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- STEP 2: Create `mangliks` table
-- (Migration: 2026_07_30_000004_create_gothrams_and_mangliks_tables)
-- ============================================================

CREATE TABLE IF NOT EXISTS `mangliks` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- STEP 3: Add `gothram` column to `spiritual_backgrounds` table
-- (Migration: 2026_07_29_000002_add_gothram_to_spiritual_backgrounds_table)
-- ============================================================

ALTER TABLE `spiritual_backgrounds`
    ADD COLUMN IF NOT EXISTS `gothram` VARCHAR(255) NULL DEFAULT NULL AFTER `sub_caste_id`;


-- ============================================================
-- STEP 4: Add `additional_sub_caste` and `about_partner` columns
--         to `partner_expectations` table
-- (Migration: 2026_07_30_000003_add_additional_sub_caste_and_about_partner_to_partner_expectations_table)
-- ============================================================

ALTER TABLE `partner_expectations`
    ADD COLUMN IF NOT EXISTS `additional_sub_caste` VARCHAR(255) NULL DEFAULT NULL AFTER `sub_caste_id`,
    ADD COLUMN IF NOT EXISTS `about_partner`        TEXT          NULL DEFAULT NULL AFTER `manglik`;


-- ============================================================
-- STEP 5: Register migrations in `migrations` table
--         (so Laravel does not try to re-run them)
-- ============================================================

INSERT IGNORE INTO `migrations` (`migration`, `batch`)
SELECT '2026_07_29_000002_add_gothram_to_spiritual_backgrounds_table', IFNULL((SELECT MAX(`batch`) FROM `migrations`), 1)
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations`
    WHERE `migration` = '2026_07_29_000002_add_gothram_to_spiritual_backgrounds_table'
);

INSERT IGNORE INTO `migrations` (`migration`, `batch`)
SELECT '2026_07_30_000003_add_additional_sub_caste_and_about_partner_to_partner_expectations_table', IFNULL((SELECT MAX(`batch`) FROM `migrations`), 1)
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations`
    WHERE `migration` = '2026_07_30_000003_add_additional_sub_caste_and_about_partner_to_partner_expectations_table'
);

INSERT IGNORE INTO `migrations` (`migration`, `batch`)
SELECT '2026_07_30_000004_create_gothrams_and_mangliks_tables', IFNULL((SELECT MAX(`batch`) FROM `migrations`), 1)
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations`
    WHERE `migration` = '2026_07_30_000004_create_gothrams_and_mangliks_tables'
);


-- ============================================================
-- VERIFICATION QUERIES
-- Run these after applying the above to confirm success
-- ============================================================

-- Check tables exist
SHOW TABLES LIKE 'gothrams';
SHOW TABLES LIKE 'mangliks';

-- Check columns added
SHOW COLUMNS FROM `spiritual_backgrounds` LIKE 'gothram';
SHOW COLUMNS FROM `partner_expectations` LIKE 'additional_sub_caste';
SHOW COLUMNS FROM `partner_expectations` LIKE 'about_partner';

-- Check migrations registered
SELECT * FROM `migrations`
WHERE `migration` IN (
    '2026_07_29_000002_add_gothram_to_spiritual_backgrounds_table',
    '2026_07_30_000003_add_additional_sub_caste_and_about_partner_to_partner_expectations_table',
    '2026_07_30_000004_create_gothrams_and_mangliks_tables'
);

-- ============================================================
-- END OF FILE
-- ============================================================
