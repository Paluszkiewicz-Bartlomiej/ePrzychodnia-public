<?php
	require_once("./connect.php");
    if(!empty($_POST['position_id'])){
        $position_id = $_POST['position_id'];
        $sql="SELECT description FROM positions WHERE id=$position_id";
        if ($result = $conn -> query($sql)){
            if($row = $result->fetch_array()){
                $description = $row[0];
                echo "Opis: $description";
            }
            else echo "jeszcze jakies inne bledy";
        }
        else echo "polaczenie z db siada";
    }
	else echo "dane nie przychodza ale odpowiadam";
?>