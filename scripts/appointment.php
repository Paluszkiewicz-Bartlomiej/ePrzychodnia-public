<?php
        require_once("./connect.php");
		$link="https://meet.google.com/jqe-giae-yrt";
        //check is that working day
        function workingDay($date){
            $time = strtotime($date);
            $dayOfWeek = (int)date('w',$time);
            $year = (int)date('Y',$time);
        
            //check weekend
            if( $dayOfWeek==6 || $dayOfWeek==0 ) {
                return false;
            }
        
            #all permanent holidays
            $holiday=array('01-01', '01-06','05-01','05-03','08-15','11-01','11-11','12-25','12-26');
        
            #add movable holidays
            #easter
            $easter = date('m-d', easter_date( $year ));
            #easter_monday
            $easterSec = date('m-d', strtotime('+1 day', strtotime( $year . '-' . $easter) ));
            #Pentecost
            $p = date('m-d', strtotime('+49 days', strtotime( $year . '-' . $easter) ));
            #divine body
            $cc = date('m-d', strtotime('+60 days', strtotime( $year . '-' . $easter) ));

            $holiday[] = $easter;
            $holiday[] = $easterSec;
            $holiday[] = $cc;
            $holiday[] = $p;
        
            $md = date('m-d',strtotime($date));
            if(in_array($md, $holiday)) return false;
 
            return true;
        }
        //list hour
        if(!empty($_POST['doctor_id'])&&!empty($_POST['date'])){
            $doctor_id = ($_POST['doctor_id']);
            $date_ = ($_POST['date']);
            $date_next = date('Y-m-d', strtotime($date_ . ' +1 day'));//add +1day
            $sql = "SELECT id, date FROM `appointments` WHERE date >='$date_' AND date <'$date_next' AND employee_id=$doctor_id AND is_online=0; "   ;
        if ($result = $conn -> query($sql)) {
            $num_rows = $result->num_rows;
            if($num_rows == 0){
                echo "<div>Brak wolnych terminów:</div>";
            }
            else{
            echo <<< HOUR
            <div>Wprowadź godzinę planowanej wizyty:</div>
                <div>
                <select class="custom-select" id="hour" name="hour">
            HOUR;
          while($row = $result -> fetch_array()){
                $id = $row[0];
            $hour = $row[1];
            echo <<< HOUR
                
                <option value=$id>$hour </option>
            HOUR;    
            
            }
            echo <<< HOUR
                </select>
                </div>
            HOUR;
          }
        }
        }
        //appointment
        if(!empty($_POST['patient_id'])&&!empty($_POST['appointment_id'])){
            $patient_id = $_POST['patient_id'];
            $appointment_id = $_POST['appointment_id'];
            $sql = "UPDATE appointments SET patient_id = $patient_id, is_online = 1 WHERE id = $appointment_id AND is_online = 0";
        if (mysqli_query($conn, $sql)) {
        }
            else{
                $_SESSION['error']="Termin zajęty";
		        $stat->close();
		        header('location: ../rezerwacja.php');
            }
          }
        if(!empty($_POST['delete_appointment_id'])){
            $appointment_id = $_POST['delete_appointment_id'];
            $sql = "UPDATE appointments SET patient_id = null, is_online = 0 WHERE id = $appointment_id";
        if (mysqli_query($conn, $sql)) {
                echo <<< DATE
                    Anulowano wizytę
                DATE;    
          }
        else{
            echo <<< DATE
                Nie udało się anulować wizyty
                DATE;
        }
        }
        //appointment more info
        if(!empty($_POST['appointment_id'])&&!empty($_POST['note'])&&!empty($_POST['type'])){
            $appointment_id = $_POST['appointment_id'];
            $note = $_POST['note'];
            $type = $_POST['type'];
			if($type != 1) $link = NULL;
            $sql = "UPDATE appointments SET meeting_link='$link', notes = '$note', types = $type WHERE id = $appointment_id";
        if (mysqli_query($conn, $sql)) {
            $sql = "SELECT date FROM appointments WHERE id = $appointment_id";
            if ($result = $conn -> query($sql)) {
              while($row = $result -> fetch_array()){
                    $date = $row[0];
                    $date_2 = substr($date,0,10);
                    $hour = substr($date,11,5); 
                echo <<< DATE
                    <div>Zarezerwowano pomyślnie wizytę dnia $date_2 o godzinie $hour</div>
                DATE;    
                
                }
              }
            }
            else{
                echo <<< DATE
                    <div>Nie uzupełniono dodatkowych informacji</div>
                DATE;
                $stat->close();
            }
          }
          //add work schedule for doctors
          if(!empty($_POST['doctor_id'])&&!empty($_POST['dateStart'])&&!empty($_POST['dateEnd'])&&!empty($_POST['hourStart'])&&!empty($_POST['hourEnd'])){
                $doctor_id = $_POST['doctor_id'];
                $dateStart = $_POST['dateStart'];
                $dateEnd = $_POST['dateEnd'];
                $hourStart = $_POST['hourStart'];
                $hourEnd = $_POST['hourEnd'];
                $date = $dateStart;
                while($dateEnd >=$date){
                    if(workingDay($date) == true){
                        $hour = $hourStart;
                        while($hourEnd>$hour){
                            $test="$date . $hour:00:00";
                            $test_date = date('Y-m-d H:i:s', strtotime($test));
                            $sql = "INSERT INTO `appointments` (`employee_id`, `date`, `is_online`) SELECT $doctor_id, '$test_date', b'0' FROM DUAL WHERE NOT EXISTS (SELECT id FROM `appointments` WHERE  `employee_id`=$doctor_id AND `date` = '$test_date')";
                            if (mysqli_query($conn, $sql)) {
                                }
                            $test="$date . $hour:30:00";
                            $test_date = date('Y-m-d H:i:s', strtotime($test));
                            $sql = "INSERT INTO `appointments` (`employee_id`, `date`, `is_online`) SELECT $doctor_id, '$test_date', b'0' FROM DUAL WHERE NOT EXISTS (SELECT id FROM `appointments` WHERE  `employee_id`=$doctor_id AND `date` = '$test_date')";
                            if (mysqli_query($conn, $sql)) {
                                }
                            $hour = $hour + 1;

                        }
                        
                    }
                    $date = date('Y-m-d', strtotime($date . ' +1 day'));
                }
            

          }
?>