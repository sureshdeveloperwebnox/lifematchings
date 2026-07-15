-- Database updates for present address, career details, spiritual backgrounds, astronomic info, family info, and partner expectation info

ALTER TABLE addresses ADD address TEXT DEFAULT NULL AFTER postal_code;
ALTER TABLE careers ADD annual_income VARCHAR(255) DEFAULT NULL AFTER company;
ALTER TABLE careers ADD additional_income VARCHAR(255) DEFAULT NULL AFTER annual_income;

ALTER TABLE spiritual_backgrounds ADD mother_tongue VARCHAR(255) DEFAULT NULL AFTER sub_caste_id;
ALTER TABLE spiritual_backgrounds ADD diet VARCHAR(255) DEFAULT NULL AFTER mother_tongue;
ALTER TABLE spiritual_backgrounds ADD living_in VARCHAR(255) DEFAULT NULL AFTER diet;
ALTER TABLE spiritual_backgrounds ADD nationality VARCHAR(255) DEFAULT NULL AFTER living_in;

ALTER TABLE astrologies ADD manglik VARCHAR(255) DEFAULT NULL AFTER city_of_birth;

ALTER TABLE families ADD no_of_married INT DEFAULT 0 AFTER no_of_sisters;
ALTER TABLE families ADD no_of_unmarried INT DEFAULT 0 AFTER no_of_married;
ALTER TABLE families ADD family_value VARCHAR(255) DEFAULT NULL AFTER no_of_unmarried;
ALTER TABLE families ADD family_status VARCHAR(255) DEFAULT NULL AFTER family_value;

ALTER TABLE partner_expectations ADD age_from INT DEFAULT NULL AFTER user_id;
ALTER TABLE partner_expectations ADD age_to INT DEFAULT NULL AFTER age_from;
