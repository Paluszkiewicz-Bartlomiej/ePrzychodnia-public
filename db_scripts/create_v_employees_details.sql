CREATE OR REPLACE VIEW v_employees_details AS
	SELECT users.id, users.name, surname, positions.name AS 'position', phone_number, email, pesel 
	FROM users 
	JOIN employees 
	ON employees.user_id = users.id 
	JOIN positions 
	ON employees.position_id = positions.id 
	WHERE active=1;