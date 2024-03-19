<?php
	session_start();
	require_once './connect.php';
	$id = $_GET['id'];
	$sql = "UPDATE users SET active=0 WHERE id=?";
	$stat = $conn->prepare($sql);
	$stat->bind_param("s",  $id);
	if($stat->execute()){
		$_SESSION['success']="Konto $id zostało usunięte!";
		$stat->close();
		header('location: ../admin.php');
	}                    
	else{
		$_SESSION['error']="Nie udało się usunąć konta o ID: $id";
	}
?>