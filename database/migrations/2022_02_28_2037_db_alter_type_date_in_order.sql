ALTER TABLE up_order CHANGE CREATION_DATE CREATION_DATE TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE up_order CHANGE EDITING_DATE EDITING_DATE TIMESTAMP NULL;