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
            <a class="navbar-brand" >Historia wizyt</a>
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
		
		<p>Poniżej znajduje się lista Twoich wizyt wraz z zaleceniami lekarza.</p>
      </div>
      <div class="col-md-12">
	  <div class="table-responsive">
      <table class="table">
        <thead class=" text-primary">
           <tr>
              <th> Data wizyty </th>
              <th> Imię lekarza </th>
              <th> Nazwisko lekarza </th>
              <th> Specjalizacja </th>
			  <th> Forma </th>
			  <th> Link </th>
			  <th> Telefon </th>
			  <th> Zalecenia </th>
           </tr>
        </thead>
        <tbody>
        <?php
      $sql = "SELECT appointments.date, users.name, users.surname, positions.description, appointments.is_online, appointments.meeting_link, users.phone_number, appointments.reccomendations FROM appointments JOIN employees ON appointments.employee_id = employees.user_id        JOIN users ON users.id = employees.user_id
JOIN positions ON employees.position_id = positions.id WHERE appointments.date < NOW() AND patient_id = $id_user;";
                  if ($result = $conn -> query($sql)) {
                    while($row = $result -> fetch_array()){
                      $date = $row[0];
                      $name = $row[1];
                      $surname = $row[2];
                      $description = $row[3];
					  if($row[4] == 1) $online = "online";
					  else $online = "offline";
					  $link = $row[5];
					  $phone_number = $row[6];
					  $reccomendations = $row[7];
                      echo <<< APPOINTMENTS
                      <tr>
                        <td>$date</td>
                        <td>$name</td>
                        <td>$surname</td>
                        <td>$description</td>
                        <td>$online</td>
                        <td>
                      APPOINTMENTS;
                      if(!empty($link)) echo "<a href='$link'>Kilknij, aby rozpocząć połączenie</a>";
                      echo <<< APPOINTMENTS
                        </td>
                        <td>$phone_number</td>
                        <td>$reccomendations</td>
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
