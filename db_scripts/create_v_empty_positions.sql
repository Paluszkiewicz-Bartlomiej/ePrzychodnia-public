CREATE OR REPLACE VIEW v_empty_positions
	AS SELECT id, name
	FROM positions
	WHERE id NOT IN
		(SELECT id
		FROM employees
		JOIN positions
		ON positions.id = employees.position_id
		GROUP BY id);