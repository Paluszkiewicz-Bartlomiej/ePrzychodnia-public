<?php
	require_once './connect.php';
	$id=$_GET['id'];
	$reccomendations=$_GET['n'];
	echo $id;
	echo $reccomendations;
	$sql = "UPDATE `appointments` SET reccomendations = ? WHERE id = ?";
	$conn->begin_transaction();
	try{
		$stat = $conn->prepare($sql);
		$stat->bind_param("ss", $reccomendations, $id);
		$stat->execute();
		$conn->commit();
		$_SESSION['success']="Zalecenia zaktualizowane!";
		$stat->close();
		header('location: ../doctor.php');
	}
	catch (mysqli_sql_exception $exception) {
		$conn->rollback();
		$_SESSION['error']=$exception;
		//header('location: ../doctor.php');
		echo $exception;
	}
?>