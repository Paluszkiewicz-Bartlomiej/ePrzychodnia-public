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
    if(!isset($_SESSION['position'])){
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
      if(isset($_SESSION['position'])){
      unset($_SESSION['position']);
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
var hour_is=0;
var patient = '<?=$id_user?>';
function showHour(doctor_id, date) {
                        var xhttp;
                        xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                          if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("select-hour").innerHTML = this.responseText;
                          }
                        }
                        var  the_data = 'doctor_id=' + doctor_id +'&date=' + date;
                        xhttp.open("POST", "./scripts/appointment.php", false);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send(the_data);
                        hour_is=1;
                      }
function appointment(patient_id,appointment_id){
                        var xhttp2;
                        xhttp_2 = new XMLHttpRequest();
                        xhttp_2.onreadystatechange = function() {
                          if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("add-information").innerHTML = this.responseText;
                          }
                        }
                        var  the_data_2 ='patient_id=' + patient_id + '&appointment_id=' + appointment_id;
                        xhttp_2.open("POST", "./scripts/appointment.php", false);
                        xhttp_2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp_2.send(the_data_2);
}
function next() {
  var doctor = document.getElementById('doctorOptions').value;
  var date = document.getElementById('start').value;
  if(hour_is == 1){
    var hour = document.getElementById('hour').value;
    appointment(patient,hour);
    show('showhide','add_information','inline');
  }
  else
  alert("Nie wybrano lekarza i dnia");
  
  
}
function undo(){
  var appointment_id = document.getElementById('hour').value;
  var xhttp3;
                        xhttp_3 = new XMLHttpRequest();
                        xhttp_3.onreadystatechange = function() {
                          if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("delete-appointment").innerHTML = this.responseText;
                          }
                        }
                        var  the_data_3 ='delete_appointment_id=' + appointment_id;
                        xhttp_3.open("POST", "./scripts/appointment.php", false);
                        xhttp_3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp_3.send(the_data_3);
                        show('showhide','select_date','inline');
}
function send(){
  var appointment_id = document.getElementById('hour').value;
  var notes = document.getElementById('notes').value;
  var type;
  var types = document.getElementsByName('appType');
  for(i = 0; i < types.length; i++) {
	if(types[i].checked) type = types[i].value;
  }
  var xhttp4;
                        xhttp_4 = new XMLHttpRequest();
                        xhttp_4.onreadystatechange = function() {
                          if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("success").innerHTML = this.responseText;
                          }
                        }
                        var  the_data_4 ='appointment_id=' + appointment_id + '&note=' + notes + '&type=' + type;
                        xhttp_4.open("POST", "./scripts/appointment.php", false);
                        xhttp_4.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp_4.send(the_data_4);
                        show('showhide','success','inline');
}
//test
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
        <a href="index.php" class="simple-text logo-normal">
          E-Przychodnia
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="rezerwacja.php">
              <i class="nc-icon nc-bank"></i>
              <p>Zarezerwuj wizytę</p>
            </a>
          </li>
          <li>
            <a href="incoming.php">
              <i class="nc-icon nc-diamond"></i>
              <p>Nadchodzące wizyty</p>
            </a>
          </li>
          <li>
            <a href="historia.php">
              <i class="nc-icon nc-diamond"></i>
              <p>Historia wizyt</p>
            </a>
          </li>
          <li>
            <a href="kontakt.php">
              <i class="nc-icon nc-pin-3"></i>
              <p>Kontakt</p>
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
            <a class="navbar-brand" >Zarezerwuj wizytę</a>
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
        </div>
<div>
	  
	  <form action="./scripts/rezerwacja.php" method="post">
    <div class="showhide" id="select_date" style="display:inline">
  <div class="form-group">
  <div class="input-group-prepend" id="delete-appointment"></div>
    <label for="exampleFormControlSelect1">Wybierz lekarza</label>
    <select class="custom-select" id="doctorOptions" name="doctors" onclick="javascript:showHour(doctorOptions.value,start.value)">   
      <?php
        //select doctors from db
        $sql = "SELECT users.id, users.name, users.surname, positions.name FROM `users` JOIN `employees` ON users.id=employees.user_id 
        JOIN `positions` ON employees.position_id = positions.id NATURAL JOIN position_permission_link WHERE permission_id=3";
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

<div>Wprowadź datę planowanej wizyty:</div>
<input type="date" id="start" name="dateDate" value="<?php echo $today ?>" min="<?php echo $today ?>" required onchange="javascript:showHour(doctorOptions.value,start.value)">
  <div class="input-group-prepend" id="select-hour"></div>
<button type="button"  onclick="javascript:next()" class="btn btn-success">Dalej</button>
</div>
</div>
<div class="showhide" id="add_information" style="display:none">
<button type="button"  onclick="javascript:undo()" class="btn btn-error">Wstecz</button>
<div>Wybierz rodzaj wizyty:</div>
<input type="radio" id="online" name="appType" value=1 checked="checked" required>
<label for="button1">on-line</label>
<input type="radio" id="telefon" name="appType" value=2>
<label for="button2">telefoniczna</label>
<input type="radio" id="f2f" name="appType" value=3>
<label for="button2">facetoface</label>


<div style="margin-top: 10px;">Dodatkowe informacje (np. o zażywanych lekach)</div>
  <div class="form-group">
    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
  </div>
  <button type="button" onclick="javascript:send()" class="btn btn-success">Wyślij</button>
</form>
</div>
</div>
<div class="showhide" id="success" style="display:none">
<div id="add-information"></div>
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
  <script src="./scripts/showhide.js"></script>
  <script src="./scripts/login.js"></script>
  
</body>

</html>
