ALTER TABLE position_permission_link DROP CONSTRAINT fk_position_permission_link_2;
ALTER TABLE permissions MODIFY COLUMN id int NOT NULL AUTO_INCREMENT;
ALTER TABLE position_permission_link ADD CONSTRAINT `fk_position_permission_link_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;