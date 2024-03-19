<?php
    session_start();
    //check db connection
    require_once '../scripts/connect.php';
    if ($conn->connect_errno != 0) $error = 1;
    if(isset($_SESSION['id'])){
            //unset user id from session variables
            if(isset($_SESSION['permission'])){
            unset($_SESSION['permission']);
            }
            unset($_SESSION['id']);
            $conn-> close();
            $_SESSION['success']="Nastąpiło wylogowanie.";
            header('location: ../login.php');
            exit();
        }
    else {
        $_SESSION['error']="Sesja wygasła. Zaloguj się ponownie";
        header('location: ../login.php');
        exit();
    }
    
    //if error occurs, go to start page
    if(!empty($error)){
        $conn-> close();
        $_SESSION['error']="Błąd wewnętrzny. Skonaktuj się ze wsparciem technicznym. Identyfikator: I$error";
        header('location: ../index.php');
        exit();
    }
?>