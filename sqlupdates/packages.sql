-- 6. Update Free package limits (id = 1)
UPDATE `packages` 
SET `express_interest` = 15, `contact` = 0, `validity` = 30 
WHERE `id` = 1;
