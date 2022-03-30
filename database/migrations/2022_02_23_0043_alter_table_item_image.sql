ALTER TABLE up_item ADD IMG VARCHAR(255) NOT NULL DEFAULT 'no_image.jpg' AFTER FULL_DESC;
ALTER TABLE up_item_image DROP foreign key up_item_image_ibfk_2;
ALTER TABLE up_item_image DROP INDEX FK_II_IMAGE;
ALTER TABLE up_item_image CHANGE IMAGE_ID IMG VARCHAR(255) NOT NULL DEFAULT 'no_image.jpg';
DROP TABLE up_image;