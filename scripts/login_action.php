<?php
    session_start();
    require_once 'connect.php';
    //check if every parameter is set
    if ($conn->connect_errno != 0) $error = 1;
    else{
    if(!empty ($_POST['id']) &&!empty ($_POST['password'])){
        //check db connection
            //escape sql injection
            $id = intval(htmlentities($_POST['id'], ENT_QUOTES, "UTF-8"));
            $pass = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");
            //check id checksum
            $id_check = ($id-($id%10))/10;
            $id_check = (string)$id_check;
            $sum = 0;
            $parity = strlen($id_check)%2;
            //calculate checksum
            for ($i = strlen($id_check) - 1; $i >= 0; $i--) {
                $factor = $parity ? 2 : 1;
                $parity = $parity ? 0 : 1;
                $sum += array_sum(str_split($id_check[$i]*$factor));
            }
            $checksum = 10-($sum % 10);
            if($checksum == 10){
                $checksum = 0;
            }
            if($checksum != ($id%10)){
                $error = 3;
            }
            else{
            //select account with given id
            $sql = sprintf("SELECT * FROM `users` WHERE id=\"%s\"",mysqli_real_escape_string($conn,$id));
            //$sql = sprintf("SELECT * FROM `users` WHERE id=\"%s\"",mysqli_real_escape_string($conn, $id));
            if ($result = $conn->query($sql)) {
                $row = $result->fetch_assoc();
                $passdb = $row['password'];
                $id = $row['id'];
                //verify passwords
                if(password_verify($pass, $passdb)){
                    //add user login to log
                    $sql2 = "INSERT INTO user_log (user_id,login_time) VALUES($id,NOW())";
                    if($result2 = $conn->query($sql2));{
                        //pass user id into session variable
                        $_SESSION['id']=$id;
                        //for patients
                        if(substr($id,4,1)!='1'){
                            header('location: ../incoming.php');
                            exit();
                        }
                        //for employees
                        else{
                            $sql = "SELECT permission_id from position_permission_link NATURAL JOIN employees WHERE user_id='$id'";
                            if ($result = $conn -> query($sql)) {
                                while($row = $result -> fetch_array()){
                                      $permission = $row[0];
                                  }
                                $_SESSION['permission']=$permission;
                            if($permission == 1){
                                header('location: ../admin.php');  
                            }
                            else{
                                if($permission == 2){
                                    header('location: ../doctor.php');  
                                }
                                else{
                                    if($permission == 3){
                                        header('location: ../doctor.php');  
                                    }
                                    else{
                                        $error = 2;
                                    }
                                }
                            }
                            exit();
                        }
                        }
                    }                    
                        
                }
                
                else $error = 2;

            }
            else $error = 2;
        }

    }
        
    else{
        $_SESSION['error']="Wypełnij wszystkie pola!";
        $conn->close();
        header('location: ../login.php'); 
        exit();
    }
    //if login creditentials are incorrect, go back to the start page
    if($error == 2){
        $_SESSION['error']="Wprowadzone dane logowania są nieprawidłowe!";
        $conn->close();
        header('location: ../login.php'); 
        exit();
    }
    if($error == 3){
        $_SESSION['error']="Wprowadzone dane logowania są nieprawidłowe!";
        $conn->close();
        header('location: ../login.php'); 
        exit();
    }

    //if critical error occured, turn back to the start page
    else{
        $_SESSION['error']="Błąd wewnętrzny. Skonaktuj się ze wsparciem technicznym. Identyfikator: H$error";
        $conn->close();
        //header('location: ../index3.php');
        exit();
    }
    }
    
?>