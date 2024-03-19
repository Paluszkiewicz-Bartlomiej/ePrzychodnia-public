<?php
    function generateChecksum($id){
		$province = '19';
		$city = '00';
		$sum = 0;
		$id= $province. $city . $id;
		$parity = strlen($id)%2;
		for ($i = strlen($id) - 1; $i >= 0; $i--) {
			$factor = $parity ? 2 : 1;
			$parity = $parity ? 0 : 1;
			$sum += array_sum(str_split($id[$i]*$factor));
		}
		$checksum = 10-($sum % 10);
		if($checksum == 10){
			$checksum = 0;
		}
		$id = $id . $checksum;
		return $id;
	}
	function getRandomString($n) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
	  
		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
	}
    session_start();
	$email=$_POST['email'];
	$name=$_POST['name'];
	$surname=$_POST['surname'];
	$pesel=$_POST['pesel'];
	$type=$_POST['type'];
	$position=$_POST['position'];
	$pass="P@ssword";
	//uncomment for production system: $pass=getRandomString(10);
	$pass1 = password_hash($pass, PASSWORD_BCRYPT);
	$number = $_POST['phone'];
    //check if every parameter is set
	require_once './connect.php';
	if ($conn->connect_errno != 0) $error = 2;
	else{
		//check last id in database
		if($type == "patient"){
			$sql = "SELECT SUBSTR(id, 5,5 ) AS id FROM users WHERE id >=20000 ORDER BY SUBSTR(id, 5, 5) DESC LIMIT 1";
			if($result = $conn->query($sql)){
			$row = $result->fetch_assoc();
			$id=intval($row['id']);
			//id patients
			if($id<100000){
				$id++;
			}
			else{
				$_SESSION['error']="Przekroczono liczbę pacjentów dla fili przychodni";
				header('location: ../index.php');
			}
			$id=generateChecksum($id);
				$sql = "INSERT INTO `users` (`id`,`password`, `email`, `phone_number`,`name`,`surname`,`pesel`,`active`) VALUES (?,?,?,?,?,?,?,1)";
			
				$conn->begin_transaction();
				try{
				$stat = $conn->prepare($sql);
				$stat->bind_param("sssssss",  $id,$pass1,$email,$number,$name,$surname,$pesel);
				$stat->execute();
					$sql2 = "INSERT INTO `patients` (`user_id`,`restricted_access`, `registered_online`) VALUES (?,0,0)";
					$stat2 = $conn->prepare($sql2);
					$stat2->bind_param("s",  $id);
					$stat2->execute();
				$conn->commit();
				$_SESSION['success']="Konto $name $surname utworzone pomyślnie! ID: $id";
				$stat->close();
				$stat2->close();
				header('location: ../admin.php');
			}
            catch (mysqli_sql_exception $exception) {
				$conn->rollback();
				$_SESSION['error']=$exception;
				header('location: ../admin.php');
			}            
			}

		}
		else{
		$sql = "SELECT SUBSTR(id, 5,5 ) AS id FROM users WHERE id LIKE '____1%' ORDER BY SUBSTR(id, 5, 5) DESC LIMIT 1";
		if($result = $conn->query($sql)){
			$row = $result->fetch_assoc();
			$id=intval($row['id']);
			//id employees
			
				if($id<20000){
					$id++;
				}
				else{
					$_SESSION['error']="Przekroczono liczbę pracowników dla fili przychodni";
					header('location: ../index.php');
				}
				$id=generateChecksum($id);
				$sql = "INSERT INTO `users` (`id`,`password`, `email`, `phone_number`,`name`,`surname`,`pesel`,`active`) VALUES (?,?,?,?,?,?,?,1)";
			
				$conn->begin_transaction();
				try{
				$stat = $conn->prepare($sql);
				$stat->bind_param("sssssss",  $id,$pass1,$email,$number,$name,$surname,$pesel);
				$stat->execute();
					$sql2 = "INSERT INTO `employees` (`user_id`,`position_id`) VALUES (?,?)";
					$stat2 = $conn->prepare($sql2);
					$stat2->bind_param("ss",  $id, $position);
					$stat2->execute();
				$conn->commit();
				$_SESSION['success']="Konto $name $surname utworzone pomyślnie! ID: $id";
				$stat->close();
				$stat2->close();
				header('location: ../admin.php');
			}
            catch (mysqli_sql_exception $exception) {
				$conn->rollback();
				$_SESSION['error']=$exception;
				header('location: ../admin.php');
			}            
			

		}
	}
		
			
}
    
?>