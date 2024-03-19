CREATE OR REPLACE VIEW v_patients_details AS
	SELECT id, name, surname, phone_number, email, pesel, restricted_access 
	FROM users 
	JOIN patients 
	ON patients.user_id = users.id 
	WHERE active=1;