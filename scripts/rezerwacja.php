<?php
    session_start();
    //check if every parameter is set
    require_once './connect.php';
    $date = ($_POST['date']);
    $patient_id = 1900150933;
    $employee_id = ($_POST['doctors']);
    $notes = ($_POST['notes']);
    $is_online = ($_POST['appType']);
    echo "$date $employee_id $notes $is_online";
    echo "test0";
    if ($conn->connect_errno != 0) $error = 1;
    else{
        echo "test1";
        $sql="INSERT INTO `clinic`.`appointments` (`date`, `patient_id`, `employee_id`, `notes`, `is_online`) 
        VALUES (?, ?, ?, ?, 1)";
        echo "test1,1";
        $stat = $conn->prepare($sql);
        echo "test1,2\n";
        echo $sql;
        $stat->bind_param("siis", $date, $patient_id, $employee_id, $notes);
        echo "test2";
        //check if transaction ended successfully
        if($stat->execute()){
            echo "test3";
            $conn->close();
            $_SESSION['success']="Wizyta została zarezerwowana.";
            header('location: ../incoming.php');
            exit();
        }
        else echo "ZLE!!!";//$error = 1;
    }

?>