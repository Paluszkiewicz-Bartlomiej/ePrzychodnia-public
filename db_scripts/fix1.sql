--dbfix - add AUTO_INCREMENT to positions.id column
ALTER TABLE employees DROP CONSTRAINT fk_employees_2;
ALTER TABLE position_permission_link DROP CONSTRAINT fk_position_permission_link_1;
ALTER TABLE positions MODIFY COLUMN id int AUTO_INCREMENT;
ALTER TABLE employees ADD CONSTRAINT `fk_employees_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE position_permission_link ADD CONSTRAINT `fk_position_permission_link_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;