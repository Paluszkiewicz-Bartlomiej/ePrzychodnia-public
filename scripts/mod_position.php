<?php
	session_start();
	require_once './connect.php';
	$name = $_POST['name'];
	$description = $_POST['description'];
	$position=$_POST['position'];
	$permission=$_POST['permission'];

	if(!empty($position)){
		while(!empty($name) || !empty($description) || !empty($permission)){
			if(!empty($name)){
				$sql = "UPDATE `v_position_permission` SET name = \"$name\" WHERE id=$position";
				$name="";
			}
			elseif(!empty($description)){
				$sql = "UPDATE `v_position_permission` SET description = \"$description\" WHERE id=$position";
				$description="";			}
			elseif(!empty($permission)){
				$sql = "UPDATE `v_position_permission` SET permission_id = $permission WHERE id=$position";
				$permission="";
			}
			echo $sql;
			$conn->begin_transaction();
			try{
				$stat = $conn->prepare($sql);
				$stat->execute();
				$conn->commit();
			}
            catch (mysqli_sql_exception $exception) {
				$conn->rollback();
				$_SESSION['error']=$exception;
				header('location: ../admin.php');
			}
		}
		//$stat->close();
		$_SESSION['success']="Rola zmodyfikowana pomyślnie!";
		header('location: ../admin.php');
	}
	else{
	$_SESSION['error']="Niepowodzenie. Do formularza dostarczono puste parametry!";
	header('location: ../admin.php');
	}
?>