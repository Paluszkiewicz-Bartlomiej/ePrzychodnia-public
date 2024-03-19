<?php
	session_start();
	require_once './connect.php';
	$id = $_GET['id'];
	$name = $_GET['n'];
	$surname = $_GET['s'];
	$position = $_GET['p'];
	$phone_number = $_GET['pn'];
	$email = $_GET['e'];
	if(!empty($id) && (!empty($name) || !empty($surname) || !empty($position) || !empty($phone_number) || !empty($email))){
		while(!empty($name) || !empty($surname) || !empty($position) || !empty($phone_number) || !empty($email)){
			if(!empty($name)){
				$sql = "UPDATE `users` SET name=\"$name\" WHERE id=$id"; 
				$name="";
			}
			elseif(!empty($surname)){
				$sql = "UPDATE `users` SET surname=\"$surname\" WHERE id=$id"; 
				$surname="";
			}
			elseif(!empty($position)){
				$sql = "UPDATE `employees` SET position_id=$position WHERE user_id=$id"; 
				$position="";
			}
			elseif(!empty($phone_number)){
				$sql = "UPDATE `users` SET phone_number=\"$phone_number\" WHERE id=$id"; 
				$phone_number="";
			}
			elseif(!empty($email)){
				$sql = "UPDATE `users` SET email=\"$email\" WHERE id=$id";
				$email="";
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
		$stat->close();
		$_SESSION['success']="Konto o ID $id zmodyfikowane pomyślnie!";
		header('location: ../admin.php');
	}
	else{
	$_SESSION['error']="Niepowodzenie. Do formularza dostarczono puste parametry!";
	header('location: ../admin.php');
	}
?>