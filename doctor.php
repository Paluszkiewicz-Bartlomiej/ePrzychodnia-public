<!--
=========================================================
* Paper Dashboard 2 - v2.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/paper-dashboard-2
* Copyright 2020 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<script>
function removeapp(appointment_id){
	var xhttp3;
	xhttp_3 = new XMLHttpRequest();
	xhttp_3.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		alert(this.responseText);
	  }
	}
	var  the_data_3 ='delete_appointment_id=' + appointment_id;
	xhttp_3.open("POST", "./scripts/appointment.php", false);
	xhttp_3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp_3.send(the_data_3);
}
</script>
<?php
  session_start();
  $error=0;
  require_once './scripts/connect.php';
  if ($conn->connect_errno != 0){
    $_SESSION['error']="Błąd wewnętrzny. Skontaktuj się ze wsparciem technicznym.";
    $error=1;
  }
  if(isset($_SESSION['id'])){
    if($_SESSION['permission']==3 || $_SESSION['permission']==2){
    $id_user = $_SESSION['id'];
    }
    else{
      $_SESSION['error']="Dostęp nieautoryzowany. Nastąpiło wylogowanie z powodu bezpieczeństwa";
      $error=1;
    }
  }
  else {
    $_SESSION['error']="Dostęp nieautoryzowany. Zaloguj się";
    $error=1;
  }
  //logout for critical error
  if($error==1){
    $conn->close();
    if(isset($_SESSION['id'])){
      //unset user id from session variables
      if(isset($_SESSION['permission'])){
      unset($_SESSION['permission']);
      }
      unset($_SESSION['id']);
    }
    header('location: ./login.php');
    exit();
  }
?>
<!doctype html>
<html lang="pl">
<script>
	function getLink(link, type, id){
	  /*link += "?id=";
	  /*let params = [];
	  if(type=="emp"){
		params = ["n","s","p","pn","e"];
	  }
	  else{
		  params = ["n","s","pn","e","r"];
	  }
	  let pLen = params.length;
	  link += id;
	  for (let i = 0; i < pLen; i++){
		link += "&" + params[i] + "=" + document.getElementsByName(id)[i].value;
	  }
	  */
	  link += id "&" + "n=" + document.getElementById(id).value;
	  return link;
	}
</script>
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    E-Przychodnia
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="./assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="https" class="simple-text logo-mini">
          <!-- <div class="logo-image-small">
            <img src="./assets/img/logo-small.png">
          </div> -->
          <!-- <p>CT</p> -->
        </a>
        <a href="doctor.php" class="simple-text logo-normal">
          E-Przychodnia
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="active">
            <a href="doctor.php">
              <i class="nc-icon nc-diamond"></i>
              <p>Nadchodzące wizyty</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel" style="height: 100vh;">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="index.html">Nadchodzące wizyty</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form action="./scripts/logout.php" id="logout-form">
                <button type="submit" class="btn btn-info btn-fill btn-wd">Wyloguj</button>
            </form> 
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <h3 class="description">Witaj w E-Przychodni!</h3>
          </div>
          <?php
          if(isset($_SESSION['error'])){
                $error = $_SESSION['error'];
                echo <<< ERROR
                  <p style="border:2px solid Red;"><big>$error</big></p>
                  ERROR;
                unset($_SESSION['error']);
              }
          ?>
        </div>
      </div>
	  <div class="col-md-12">
	  		<div class="input-group">
		<form id="selectDoctor" action="#" method="post">
		<select class="custom-select" id="doctorOptions" name="doctor">   
		  <?php
			//select doctors from db
			if($_SESSION['permission']==3){
				$sql = "SELECT id, CONCAT(name, ' ', surname, ' - ', position) FROM v_employees_details WHERE id = $id_user";
				$doctorId = $id_user;
				if ($result = $conn -> query($sql)) {
				  while($row = $result -> fetch_array()){
					$id_employee = $row[0];
					$employee = $row[1];
					//list doctors
					echo "<option default value=$id_employee>$employee</option>";
				  }
				}
			}
			elseif($_SESSION['permission']==2){
				if(!empty($_POST['doctor'])){
					$doctorId = $_POST['doctor'];			
					$sql = "SELECT users.id, CONCAT(users.name, ' ', surname, ' - ', positions.name) FROM users  JOIN employees  ON employees.user_id = users.id AND users.active
= 1 JOIN positions  ON employees.position_id = positions.id JOIN position_permission_link ON positions.id = position_permission_link.position_id AND position_permission_link.permission_id = 3 WHERE users.id = $doctorId";
					if ($result = $conn -> query($sql)) {
						while($row = $result -> fetch_array()){
							$id_employee = $row[0];
							$employee = $row[1];
							//list doctors
							echo "<option default value=$id_employee>$employee</option>";
						}
					}
				$sql = "SELECT users.id, CONCAT(users.name, ' ', surname, ' - ', positions.name) FROM users  JOIN employees  ON employees.user_id = users.id AND users.active
= 1 JOIN positions  ON employees.position_id = positions.id JOIN position_permission_link ON positions.id = position_permission_link.position_id AND position_permission_link.permission_id = 3 WHERE users.id != $doctorId";
				}
				else{
					echo "<option default/>";
					$sql = "SELECT users.id, CONCAT(users.name, ' ', surname, ' - ', positions.name) FROM users  JOIN employees  ON employees.user_id = users.id AND users.active
= 1 JOIN positions  ON employees.position_id = positions.id JOIN position_permission_link ON positions.id = position_permission_link.position_id AND position_permission_link.permission_id = 3";
				}
				if ($result = $conn -> query($sql)) {
				  while($row = $result -> fetch_array()){			
					$id_employee = $row[0];
					$employee = $row[1];
					echo <<< POSITIONS
						<option onclick="javascript:document.getElementById('selectDoctor').submit()" value=$id_employee>$employee</option>
						POSITIONS;
				  }
				}
			}
		  ?>
		</select>
		</form>
		</div>
	  <div class="table-responsive">
   <table class="table">
      <thead class=" text-primary">
         <tr>
            <th> Data wizyty </th>
            <th> Imię </th>
			<th> Nazwisko </th>
			<th> Forma </th>
			<th> Link </th>
			<th> Telefon </th>
            <th> Szczegóły </th>
			<th> Zalecenia </th>
			<th>  </th>
			<th> Odwołaj </th>
         </tr>
      </thead>
      <tbody>
        <?php
		  $sql = "SELECT appointments.date, users.name, users.surname, appointments.types, appointments.meeting_link, users.phone_number, appointments.notes, appointments.reccomendations, appointments.id FROM appointments JOIN patients ON appointments.patient_id = patients.user_id 
		  JOIN users ON users.id = patients.user_id WHERE appointments.employee_id = \"$doctorId\" AND appointments.date > CURRENT_DATE();";
		  if ($result = $conn -> query($sql)) {
			while($row = $result -> fetch_array()){
			$date = $row[0];
			$name = $row[1];
			$surname = $row[2];
			$is_online = $row[3];
			if($is_online == 1)$online = "online";
			elseif($is_online ==2)$online = "telefon";
			else $online = "offline";
			$link = $row[4];
			$phone_number = $row[5];
			$description = $row[6];
			$reccomendations = $row[7];
			$id = $row[8];
			echo <<< APPOINTMENTS
			  <tr>
				<td>$date</td>
				<td>$name</td>
				<td>$surname</td>
				<td>$online</td>
				<td>
			APPOINTMENTS;
			if(!empty($link)) echo "<a href='$link'>Kilknij, aby rozpocząć połączenie</a>";
			echo <<< APPOINTMENTS
				</td>
				<td>$phone_number</td>
				<td>$description</td>
				<td><textarea id="$id">$reccomendations</textarea></td>
				<td onclick="javascript:window.location.assign('./scripts/mod_reccomendations.php?id=$id&n=' + document.getElementById($id).value)">ZAPISZ</td>
				<td><a onclick="javascript:if(confirm('Czy na pewno chcesz odwołać wizytę?')){ removeapp($id);}">ODWOŁAJ</a></td>
			  </tr>
			APPOINTMENTS;
			}
		}
	  ?>
   </table>
</div>
            </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/jquery.min.js"></script>
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="./assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="./assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
  <script src="./scripts/login.js"></script>
  
</body>

</html>
