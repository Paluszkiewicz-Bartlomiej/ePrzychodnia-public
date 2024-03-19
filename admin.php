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
<?php
  session_start();
  $error=0;
  require_once './scripts/connect.php';
  if ($conn->connect_errno != 0){
    $_SESSION['error']="Błąd wewnętrzny. Skontaktuj się ze wsparciem technicznym.";
    $error=1;
  }
  if(isset($_SESSION['id'])){
    if($_SESSION['permission']==1 || $_SESSION['permission']==2){
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
	  link += "?id=";
	  let params = [];
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
	  return link;
	}
	
	function filterTable(inputId, tableId, columnId, hideClass) {
	  // Declare variables
	  var input, filter, table, tr, td, i, txtValue;
	  input = document.getElementById(inputId);
	  filter = input.value.toUpperCase();
	  table = document.getElementById(tableId);
	  tr = table.getElementsByTagName("tr");
	  tdId = document.getElementById(columnId).value;

	  // Loop through all table rows, and hide those who don't match the search query
	  for (i = 0; i < tr.length; i++) {
		if(tr[i].classList.contains(hideClass)==false){
			td = tr[i].getElementsByTagName("td")[tdId];
			if (td) {
			  txtValue = td.textContent || td.innerText;
			  if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			  } else {
				tr[i].style.display = "none";
			  }
			}
		}
	  }
	}
	function send(){
	var doctor_id = document.getElementById('doctorOptions').value;
	var dateStart = document.getElementById('dateStart').value;
	var dateEnd = document.getElementById('dateEnd').value;
	var hourStart = document.getElementById('hourStart').value;
	var hourStart = hourStart.substr(0,2);
	var hourEnd = document.getElementById('hourEnd').value;
	var hourEnd = hourEnd.substr(0,2);
	var xhttp4;
							xhttp_2 = new XMLHttpRequest();
							xhttp_2.onreadystatechange = function() {
							if (this.readyState == 4 && this.status == 200) {
								document.getElementById("success").innerHTML = this.responseText;
							}
							}
							var  the_data_2 ='doctor_id=' + doctor_id + '&dateStart=' + dateStart + '&dateEnd=' + dateEnd + '&hourStart=' + hourStart + '&hourEnd=' + hourEnd;
							xhttp_2.open("POST", "./scripts/appointment.php", false);
							xhttp_2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							xhttp_2.send(the_data_2);
							alert('Dane wysłane pomyślnie!');
	}
	function validate_date(){
		var errorDate=0;
		var errorHour=0;
		var today = new Date();
		const divDate = document.getElementById('validate_date');
		const divHour = document.getElementById('validate_hour');
		const divButton = document.getElementById('validate_button');
		var dateStart = document.getElementById('dateStart').value;
		var dateStart = new Date(dateStart);
		var dateEnd = document.getElementById('dateEnd').value;
		var dateEnd = new Date(dateEnd);
		var hourStart = document.getElementById('hourStart').value;
		var minuteStart = hourStart.slice(3);
		var hourStart = hourStart.substr(0,2);
		var hourEnd = document.getElementById('hourEnd').value;
		var minuteEnd = hourEnd.slice(3);
		var hourEnd = hourEnd.substr(0,2);
		if(dateStart <= today ){
			divDate.innerHTML='<p class="text-danger">Data rozpoczęcia grafiku nie może być z przeszłości!</p>';
			errorDate = 1;
		}
		if(dateEnd <= today && errorDate == 0){
			divDate.innerHTML='<p class="text-danger">Data zakończenia grafiku nie może być z przeszłości!</p>';
			errorDate = 1;
		}
		if(dateEnd == dateStart && errorDate == 0){
			divDate.innerHTML='<p class="text-danger">Data zakończenia grafiku nie może być taka sama jak data rozpoczęcia grafiku!</p>';
			errorDate = 1;
		}
		if(dateEnd < dateStart && errorDate == 0){
			divDate.innerHTML='<p class="text-danger">Data zakończenia grafiku nie może być wcześniejsza niż data rozpoczęcia grafiku!</p>';
			errorDate = 1;
		}
		if(errorDate == 0){
			divDate.innerHTML='';
		}
		if(minuteStart != 0){
			divHour.innerHTML='<p class="text-danger">Czas rozpoczęcia dnia pracy musi być wyrównany do pełnych godzin!</p>';
			errorHour = 1;
		}
		if(minuteEnd != 0 && errorHour == 0){
			divHour.innerHTML='<p class="text-danger">Czas zakończenia dnia pracy musi być wyrównany do pełnych godzin!</p>';
			errorHour = 1;
		}
		if(hourEnd < hourStart && errorHour == 0){
			divHour.innerHTML='<p class="text-danger">Godzina zakończenia dnia pracy nie może być wcześniejsza niż godzina rozpoczęcia dnia pracy!</p>';
			errorHour = 1;
		}
		if(errorHour == 0){
			divHour.innerHTML='';
		}
		if(errorHour == 1 ){
			divButton.innerHTML='';
		}
		if(errorDate == 1 ){
			divButton.innerHTML='';
		}
		if(errorDate == 0 && errorHour == 0){
			divButton.innerHTML='<button type="button" onclick="javascript:send()" class="btn btn-success">Wyślij</button>';
		}
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
        <a href="admin.php" class="simple-text logo-normal">
          E-Przychodnia
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a onclick="javascript:show('showhide','add_user','flex')">
			  <i class="nc-icon nc-diamond"></i>
              <p>Twórz konta</p>
            </a>
          </li>
		  <li>
            <a onclick="javascript:show('showhide','modify_user','inline')">
              <i class="nc-icon nc-diamond"></i>
              <p>Modyfikuj konta</p>
            </a>
          </li>
		  <li>
            <a onclick="javascript:show('showhide','add_modify_role','flex')">
			  <i class="nc-icon nc-diamond"></i>
              <p>Twórz i modyfikuj role</p>
            </a>
          </li>
		  <li>
            <a onclick="javascript:show('showhide','add_work_schedule','inline')">
			  <i class="nc-icon nc-diamond"></i>
              <p>Twórz grafik pracy</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel" style="height: 100vh;">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
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
            <h3 class="description">E-Przychodnia Panel Administracyjny</h3>
          </div>
		  <?php
          if(isset($_SESSION['error'])){
                $error = $_SESSION['error'];
                echo <<<ERROR
                  <div class="showhide">
                    <div class="alert alert-danger">$error</div>
                  </div>
                ERROR;
                unset($_SESSION['error']);
              }
              if(isset($_SESSION['success'])){
                $success = $_SESSION['success'];
                echo <<<SUCCESS
                  <div class="showhide">
                    <div class="alert alert-success">$success</div>
                  </div>
                SUCCESS;
                unset($_SESSION['success']);
              }
          ?>  
        </div>
		<div class="showhide" id="add_user" style="display:none">
		  <div class="col-md-4">
			<form action="./scripts/add_user.php" method="post">
			  <div class="card card-login">
			    <div class="card-header ">
				  <h3 class="header text-center">Tworzenie konta pracownika</h3>
			    </div>
                <div class="card-body ">
				  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="email" class="form-control" placeholder="Adres e-mail" name="email" required />
                  </div>
				  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Numer telefonu" name="phone" required />
                  </div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Imię" name="name" required />
                  </div>
				  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Nazwisko" name="surname" required />
                  </div>
				  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="PESEL" name="pesel" required />
                  </div>
				  <div class="input-group">
					<div class="input-group-prepend">
					  <span class="input-group-text">
						<i class="nc-icon nc-single-02"></i>
					  </span>
					</div>
					<select class="custom-select" id="positionOptions" name="position">   
					  <?php
						//select positions from db
						$sql = "SELECT id, name FROM `positions`";
						if ($result = $conn -> query($sql)) {
						  while($row = $result -> fetch_array()){
							$id_position = $row[0];
							$position = $row[1];
							//list positions
							echo <<< POSITIONS
							  <option value=$id_position>$position</option>
							POSITIONS;
						  }
						}
					  ?>
					</select>
				  </div>
				</div>
				<input type="hidden" name="type" value="employee"/>
                <div class="card-footer text-center">
                  <br>
                    <button type="submit" class="btn btn-fill btn-wd ">Utwórz</button>
                </div>
              </div>
			</form>
		  </div>
		  <div class="col-md-4">
			<form action="./scripts/add_user.php" method="post">
			  <div class="card card-login">
			    <div class="card-header ">
				  <h3 class="header text-center">Tworzenie konta klienta</h3>
			    </div>
                <div class="card-body ">
				  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="email" class="form-control" placeholder="Adres e-mail" name="email" required />
                  </div>
				  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Numer telefonu" name="phone" required />
                  </div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Imię" name="name" required />
                  </div>
				  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Nazwisko" name="surname" required />
                  </div>
				  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="PESEL" name="pesel" required />
                  </div>
                </div>
				<input type="hidden" name="type" value="patient"/>
                <div class="card-footer text-center">
                  <br>
                    <button type="submit" class="btn btn-fill btn-wd ">Utwórz</button>
                </div>
              </div>
			</form>
		  </div>
		</div>
		<div class="showhide" id="add_modify_role" style="display:none">
		  <div class="col-md-4">
			<form action="./scripts/mod_position.php" method="post">
			  <div class="card card-login">
			    <div class="card-header ">
				  <h3 class="header text-center">Modyfikowanie roli</h3>
			    </div>
				<script>
					  function showDescription(position_id) {
                        var xhttp;
                        if (position_id == "") {
                          document.getElementById("position-description").innerHTML = "Opis:";
                          return;
                        }
                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                          if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("position-description").innerHTML = this.responseText;
                          }
                        };
                        xhttp.open("POST", "./scripts/position_description.php", false);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send("position_id=" + position_id);
                      }
				</script>
                <div class="card-body ">
				  <div class="input-group">
					<div class="input-group-prepend">
					  <span class="input-group-text">
						<i class="nc-icon nc-single-02"></i>
					  </span>
					</div>
					<select onclick="javascript:showDescription(positionOptions.value)" class="custom-select" id="positionOptions" name="position">   
					  <option default></option>
					  <?php
						//select positions from db
						$sql = "SELECT id, CONCAT(name, \" - \", permission_description) AS description FROM `v_position_permission`";
						if ($result = $conn -> query($sql)) {
						  while($row = $result -> fetch_array()){
							$id_position = $row[0];
							$position = $row[1];
							//list positions
							echo <<< POSITIONS
							  <option value=$id_position>$position</option>
							POSITIONS;
						  }
						}
					  ?>
					</select>
				  </div>
					<div class="input-group">
					  <div class="input-group-prepend" id="position-description">
					  </div>
					</div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Nowa nazwa" name="name"/>
                  </div>
				  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Nowy opis" name="description"/>
                  </div>
				  <div class="input-group">
					<div class="input-group-prepend">
					  <span class="input-group-text">
						<i class="nc-icon nc-single-02"></i>
					  </span>
					</div>
					<select class="custom-select" id="permissionOptions" name="permission">   
					  <option default></option>
					  <?php
						//select permissions from db
						$sql = "SELECT id, description FROM `permissions`";
						if ($result = $conn -> query($sql)) {
						  while($row = $result -> fetch_array()){
							$id_permission = $row[0];
							$permission = $row[1];
							//list permissions
							echo <<< PERMISSIONS
							  <option value=$id_permission>$permission</option>
							PERMISSIONS;
						  }
						}
					  ?>
					</select>
				  </div>
				</div>
                <div class="card-footer text-center">
                  <br>
                    <button type="submit" class="btn btn-fill btn-wd ">Modyfikuj</button>
                </div>
              </div>
			</form>
		  </div>
		  <div class="col-md-4">
			<form action="./scripts/add_position.php" method="post">
			  <div class="card card-login">
			    <div class="card-header ">
				  <h3 class="header text-center">Tworzenie roli</h3>
			    </div>
                <div class="card-body ">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Nazwa" name="name" required />
                  </div>
				  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Opis" name="description" required />
                  </div>
				  <div class="input-group">
					<div class="input-group-prepend">
					  <span class="input-group-text">
						<i class="nc-icon nc-single-02"></i>
					  </span>
					</div>
					<select class="custom-select" id="permissionOptions" name="permission">   
					  <?php
						//select permissions from db
						$sql = "SELECT id, description FROM `permissions`";
						if ($result = $conn -> query($sql)) {
						  while($row = $result -> fetch_array()){
							$id_permission = $row[0];
							$permission = $row[1];
							//list permissions
							echo <<< PERMISSIONS
							  <option value=$id_permission>$permission</option>
							PERMISSIONS;
						  }
						}
					  ?>
					</select>
				  </div>
				</div>
                <div class="card-footer text-center">
                  <br>
                    <button type="submit" class="btn btn-fill btn-wd ">Utwórz</button>
                </div>
              </div>
			</form>
		  </div>
		  <div class="col-md-4">
			<form action="./scripts/del_position.php" method="get">
			  <div class="card card-login">
			    <div class="card-header ">
				  <h3 class="header text-center">Usuwanie roli</h3>
			    </div>
                <div class="card-body ">
                  <div class="input-group">
					<div class="input-group-prepend">
					  <span class="input-group-text">
						<i class="nc-icon nc-single-02"></i>
					  </span>
					</div>
					<select class="custom-select" id="positionOptions" name="position">   
					  <?php
						//select empty positions from db
						$sql = "SELECT id, name FROM `v_empty_positions`";
						if ($result = $conn -> query($sql)) {
						  while($row = $result -> fetch_array()){
							$id_position = $row[0];
							$position = $row[1];
							//list positions
							echo <<< POSITIONS
							  <option value=$id_position>$position</option>
							POSITIONS;
						  }
						}
					  ?>
					</select>
				  </div>
				  </br>
				  <p>Uwaga: na liście znajdują się wyłącznie role, do których nie jest przypisany żaden pracownik!</p>
				</div>
                <div class="card-footer text-center">
                  <br>
                    <button type="submit" class="btn btn-fill btn-wd ">Usuń</button>
                </div>
              </div>
			</form>
		  </div>
		</div>
		<div class="showhide" id="modify_user" style="display:none">
          <div class="col-md-12">
		    <h2>Konta klientów</h2>
			<div class="input-group">
				  <span class="input-group-text">
					<select class="custom-select" id="filterUserOptions" name="filter">   
						<option value="0">ID</option>
						<option value="1">Imię</option>
						<option value="2">Nazwisko</option>
						<option value="3">Telefon</option>
						<option value="4">E-Mail</option>
						<option value="5">PESEL</option>
					</select>
				  </span>
				<input type="text" id="filterClients" onkeyup="javascript:filterTable('filterClients','clientsTable', 'filterUserOptions', 'hideUserModRow')" placeholder="Wyszukaj..."/>
			</div>
		    <div class="table-responsive">
			  <table id="clientsTable" class="table" style="max-height:300px;">
				<thead class=" text-primary">
				   <tr>
					  <th> ID </th>
					  <th> Imię </th>
					  <th> Nazwisko </th>
					  <th> Telefon </th>
					  <th> E-mail </th>
					  <th> PESEL </th>
					  <th> Dostęp </th>
					  <th> Edytuj </th>
					  <th> Usuń </th>
				   </tr>
				</thead>
				<tbody>
				  <?php
					$sql = "SELECT * FROM v_patients_details";
					if ($result = $conn -> query($sql)) {
					  while($row = $result -> fetch_array()){
						$id = $row[0];
						$name = $row[1];
						$surname = $row[2];
						$phone_number = $row[3];
						$email = $row[4];
						$pesel = $row[5];
						$restricted_access = $row[6];
						if($restricted_access == 0)$full_access = "PEŁNY";
						else $full_access = "OGRANICZONY";
						echo <<< USERS
						<tr>
						  <td>$id</td>
						  <td>$name</td>
						  <td>$surname</td>
						  <td>$phone_number</td>
						  <td>$email</td>
						  <td>$pesel</td>
						  <td>$full_access</td>
						  <td class="nc-icon nc-paper" onclick="javascript:show('hideUserModRow','userModRow$id','table-row')"></td>
							  <td><a onclick="javascript:if(confirm('Czy na pewno chcesz usunąć użytkownika o ID $id?')){ location.href='./scripts/delete_user.php?id=$id';}">USUŃ</a></td>
							</tr>
							<tr class="hideUserModRow" id="userModRow$id" style="display:none">
							  <td>$id</td>
							  <td><input type="text" class="form-control" placeholder="Imię" name="$id"/></td>
							  <td><input type="text" class="form-control" placeholder="Nazwisko" name="$id"/></td>
							  <td><input type="text" class="form-control" placeholder="Telefon" name="$id"/></td>
							  <td><input type="email" class="form-control" placeholder="E-mail" name="$id"/></td>
							  <td>$pesel</td>
							  <td><select class="custom-select" id="accessOptions" name="$id">
									<option default></option>
									<option id=1 value=1>OGRANICZONY</option>
									<option id=2 value=0>PEŁNY</option>
								  </select></td>
							  <td onclick="javascript:show('hideUserModRow','','table-row')"><a class="nc-icon nc-simple-remove"></a></td>
							  <td onclick="javascript:window.location.assign(getLink('./scripts/mod_user.php','user','$id'))">ZAPISZ</td>
							</tr>
						USERS;
					  }
					}
				  ?>
				</tbody>
			  </table>
		    </div>
		  </div>
		  <div class="col-md-12">
		    <h2>Konta pracowników</h2>
			<div class="input-group">
				  <span class="input-group-text">
					<select class="custom-select" id="filterEmpOptions" name="filter">   
						<option value="0">ID</option>
						<option value="1">Imię</option>
						<option value="2">Nazwisko</option>
						<option value="3">Rola</option>
						<option value="4">Telefon</option>
						<option value="5">E-Mail</option>
						<option value="6">PESEL</option>
					</select>
				  </span>
				<input type="text" id="filterEmps" onkeyup="javascript:filterTable('filterEmps','empsTable', 'filterEmpOptions', 'hideEmpModRow')" placeholder="Wyszukaj..."/>
			</div>
		    <div class="table-responsive" style="max-height:300px;">
			  <table class="table" id="empsTable">
				<thead class=" text-primary">
				   <tr>
					  <th> ID </th>
					  <th> Imię </th>
					  <th> Nazwisko </th>
					  <th> Rola </th>
					  <th> Telefon </th>
					  <th> E-mail </th>
					  <th> PESEL </th>
					  <th> Edytuj </th>
					  <th>  </th>
				   </tr>
				</thead>
				<tbody>
				  <?php
				    $sql2 = "SELECT id, name FROM `positions`";
					$result2 = $conn -> query($sql2);
					$result2 -> fetch_all();
					$sql = "SELECT * FROM v_employees_details";
					if ($result = $conn -> query($sql)) {
					  while($row = $result -> fetch_array()){
						$id = $row[0];
						$name = $row[1];
						$surname = $row[2];
						$position = $row[3];
						$phone_number = $row[4];
						$email = $row[5];
						$pesel = $row[6];
						echo <<< USERS
							<tr>
							  <td>$id</td>
							  <td>$name</td>
							  <td>$surname</td>
							  <td>$position</td>
							  <td>$phone_number</td>
							  <td>$email</td>
							  <td>$pesel</td>
							  <td class="nc-icon nc-paper" onclick="javascript:show('hideEmpModRow','userModRow$id','table-row')"></td>
							  <td><a onclick="javascript:if(confirm('Czy na pewno chcesz usunąć użytkownika o ID $id?')){ location.href='./scripts/delete_user.php?id=$id';}">USUŃ</a></td>
							</tr>
							<tr class="hideEmpModRow" id="userModRow$id" style="display:none">
							  <td>$id</td>
							  <td><input type="text" class="form-control" placeholder="Imię" name="$id"/></td>
							  <td><input type="text" class="form-control" placeholder="Nazwisko" name="$id"/></td>
							  <td><select class="custom-select" id="positionOptions" name="$id">
						USERS;
						foreach($result2 as $row2){
							$id_newposition = $row2['id'];
							$newposition = $row2['name'];
							echo "<option value=$id_newposition>$newposition</option>";
						}
						echo "</select></td>";
						echo <<< USERS
							  <td><input type="text" class="form-control" placeholder="Telefon" name="$id"/></td>
							  <td><input type="email" class="form-control" placeholder="E-mail" name="$id"/></td>
							  <td>$pesel</td>
							  <td onclick="javascript:show('hideEmpModRow','','table-row')"><a class="nc-icon nc-simple-remove"></a></td>
							  <td onclick="javascript:window.location.assign(getLink('./scripts/mod_emp.php','emp','$id'))">ZAPISZ</td>
							</tr>
						USERS;
					  }
					}
				  ?>
				</tbody>
			  </table>
		    </div>
		  </div>
		</div>
		<div class="showhide" id="add_work_schedule" style="display:none">
		  <div class="col-md-12">
		  <form action="./scripts/add_work_schedule.php" method="post">
		  <div class="form-group">
		  <select class="custom-select" id="doctorOptions" name="doctorOptions">   
			<?php
				//select doctors from db
				$sql = "SELECT users.id, users.name, users.surname, positions.name FROM `users` JOIN `employees` ON users.id=employees.user_id 
JOIN `positions` ON employees.position_id = positions.id NATURAL JOIN position_permission_link WHERE permission_id = 3";
				if ($result = $conn -> query($sql)) {
				while($row = $result -> fetch_array()){
					$id_user = $row[0];
					$name = $row[1];
					$surname = $row[2];
					$position = $row[3];
					//list doctors
					echo <<< LEKARZE
					<option value=$id_user>$name $surname - $position</option>
					LEKARZE;
				}
				}
    		?>
  			</select>
			<div id="validate_date"></div>
			<div>Wprowadź datę początku grafiku:</div>
				<input type="date" id="dateStart" name="dateStart" value="<?php echo $today ?>" min="<?php echo $today ?>" onchange="javascript:validate_date()" required>
			<div>Wprowadź datę końca grafiku:</div>
				<input type="date" id="dateEnd" name="dateEnd" value="<?php echo $today ?>" min="<?php echo $today ?>" onchange="javascript:validate_date()" required>
			<div id="validate_hour"></div>
			<div>Wprowadź godzinę początku pracy:</div>
				<input type="time" id="hourStart" name="hourStart" min="06:00" max="20:00" value="08:00" step="3600" onchange="javascript:validate_date()" required />
			<div>Wprowadź godzinę końca pracy:</div>
				<input type="time" id="hourEnd" name="hourEnd" min="06:00" max="20:00" value="16:00" step="3600" onchange="javascript:validate_date()" required/>
			<div id="validate_button"></div>
			<div id="success"></div>
		</div>			
		</div>
		</div>
	  </div>
	  	  
      <footer class="footer" style="position: absolute; bottom: 0; width: -webkit-fill-available;">
        <div class="container-fluid">
          <div class="row">
          </div>
        </div>
      </footer>
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
  <script src="./scripts/showhide.js"></script>
  <script src="./scripts/login.js"></script>
</body>

</html>
