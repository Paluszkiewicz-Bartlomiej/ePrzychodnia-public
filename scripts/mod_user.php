<?php
	session_start();
	require_once './connect.php';
	$id = $_GET['id'];
	$name = $_GET['n'];
	$surname = $_GET['s'];
	$restricted_access = $_GET['r'];
	$phone_number = $_GET['pn'];
	$email = $_GET['e'];
	if(!empty($id) && (!empty($name) || !empty($surname) || !empty($restricted_access) || !empty($phone_number) || !empty($email))){
		while(!empty($name) || !empty($surname) || !empty($restricted_access) || !empty($phone_number) || !empty($email)){
			echo $sql;
			if(!empty($name)){
				$sql = "UPDATE `v_patients_details` SET name=\"$name\" WHERE id=$id"; 
				$name="";
			}
			elseif(!empty($surname)){
				$sql = "UPDATE `v_patients_details` SET surname=\"$surname\" WHERE id=$id"; 
				$surname="";
			}
			elseif(!empty($phone_number)){
				$sql = "UPDATE `v_patients_details` SET phone_number=\"$phone_number\" WHERE id=$id"; 
				$phone_number="";
			}
			elseif(!empty($email)){
				$sql = "UPDATE `v_patients_details` SET email=\"$email\" WHERE id=$id";
				$email="";
			}
			elseif(!empty($restricted_access)){
				$sql = "UPDATE `v_patients_details` SET restricted_access=$restricted_access WHERE id=$id";
				$restricted_access="";
			}
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