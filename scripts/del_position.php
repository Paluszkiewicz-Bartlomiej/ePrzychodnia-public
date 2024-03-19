<?php
	session_start();
	require_once './connect.php';
	$id = $_GET['position'];
	$sql = "DELETE FROM positions WHERE id=?";
	$stat = $conn->prepare($sql);
	$stat->bind_param("s",  $id);
	if($stat->execute()){
		$_SESSION['success']="Rola została usunięta!";
		$stat->close();
		header('location: ../admin.php');
	}                    
?>