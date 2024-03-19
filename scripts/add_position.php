<?php
	session_start();
	require_once './connect.php';
	$name = $_POST['name'];
	$description = $_POST['description'];
	$permission = $_POST['permission'];
	echo $name;
	echo $description;
	$sql = "INSERT INTO `positions` ( `name`, `description`) 
		SELECT \"$name\", \"$description\" FROM dual
		WHERE NOT EXISTS
		(SELECT `id` FROM `positions` WHERE `name` = \"$name\")";
	echo $sql;
	$conn->begin_transaction();
	try{
		$stat = $conn->prepare($sql);
		$stat->execute();
		$position = $conn->insert_id;
		$sql2 = "INSERT INTO `position_permission_link` (`position_id`, `permission_id`) VALUES ($position, $permission)";
		$stat2 = $conn->prepare($sql2);
		$stat2->execute();
		$conn->commit();
		$_SESSION['success']="Rola $name utworzona pomyślnie!";
		$stat->close();
		$stat2->close();
		header('location: ../admin.php');
	}
	catch (mysqli_sql_exception $exception) {
		$conn->rollback();
		$_SESSION['error']=$exception;
		header('location: ../admin.php');
	}
?>