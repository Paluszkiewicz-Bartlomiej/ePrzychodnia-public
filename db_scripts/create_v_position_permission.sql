CREATE OR REPLACE VIEW v_position_permission AS
	SELECT positions.id, position_permission_link.permission_id, positions.name, positions.description, permissions.description AS permission_description
	FROM `positions` 
	JOIN `position_permission_link` 
	ON positions.id = position_permission_link.position_id 
	JOIN `permissions` 
	ON position_permission_link.permission_id = permissions.id;