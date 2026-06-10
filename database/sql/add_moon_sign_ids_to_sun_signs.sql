-- Add moon_sign_ids column to sun_signs table
ALTER TABLE `sun_signs` 
ADD COLUMN `moon_sign_ids` JSON NULL AFTER `name`;

