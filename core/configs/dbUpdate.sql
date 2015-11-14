ALTER TABLE `cms_gallery_picture` ADD `_level1_order` INT NOT NULL DEFAULT '0' AFTER `_level1`;
ALTER TABLE `cms_gallery_picture` ADD `_level2_order` INT NOT NULL DEFAULT '0' AFTER `_level2`;
ALTER TABLE `cms_gallery_picture` ADD `_latest_order` INT NOT NULL DEFAULT '0' AFTER `_latest`;
ALTER TABLE `cms_gallery_picture` ADD `_featured_order` INT NOT NULL DEFAULT '0' AFTER `_featured`;
