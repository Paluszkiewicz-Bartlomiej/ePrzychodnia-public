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
  $result="";

 if(isset($_POST['submit'])){
  
   require 'phpmailer\PHPMailerAutoload.php';
   
   $mail = new PHPMailer;

   $mail->Host='smtp.gmail.com';
   $mail->Port=587;
   $mail->SMTPAuth=true;
   $mail->SMTPSecure='tls';
   $mail->Username='elektroniczna.przychodnia@gmail.com';
   $mail->Password='';

   $mail->setFrom($_POST['email'],$_POST['name']);
   $mail->addAddress('elektroniczna.przychodnia@gmail.com');
   
   $mail->isHTML(true);
   $mail->Subject='Form Submission:'.$_POST['subject'];
   $mail->Body='<h1 algin=center>Name: '.$_POST['name'].'<br>Email: '.$_POST['email'].'<br>Message: '.$_POST['msg'].'</h1>';

  if(!$mail->send()){
  $result="błąd";
 }
 else{
   $result="Wiadomość została wysłana!";
 }
 }

?>
<!DOCTYPE html>
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
            <a class="navbar-brand">Kontakt</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
          <h5><?= $result; ?></h5> 
		  	<?php 
				session_start();
				if(isset($_SESSION['id'])){
					echo <<< BUTTON
					        <form action="./scripts/logout.php" id="logout-form">
								<button type="submit" class="btn btn-info btn-fill btn-wd">Wyloguj</button>
							</form> 
					BUTTON;
				}
			?>
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
		<p>Jeśli chcesz zadać nam pytanie, skorzystaj z formularza poniżej.</p>
      
	  <form>
    <div class="form-group">
    <input type="text" class="form-control" name="name" id="name" placeholder="Imię" required>
  </div>

  <div class="form-group">
    <input type="email" class="form-control" name="email" id="email" placeholder="Adres mailowy" required>
  </div>
 
  <div class="form-group">

    <textarea class="form-control" class="msg" id="msg" placeholder="Twoja wiadomość" rows="3" required></textarea>
  </div>
    <div class="form-group" text-center div-center">
                  <div class="center-item g-recaptcha" data-sitekey="6LcONPcfAAAAABEzX56XjlMLYB7Ai7ADcv2L-r9O"></div>
                  <br>
                  <script>
                    document.getElementById("contact_form").addEventListener("submit",function(evt)
                      {
                      
                      var response = grecaptcha.getResponse();
                      if(response.length == 0) 
                      { 
                        //reCaptcha not verified
                        alert("Zweryfikuj że jesteś człowiekiem!"); 
                        evt.preventDefault();
                        return false;
                      }
                      //captcha verified
                      
                    });
                  </script>
                </div>
  <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="Wyślij">
  </div>

</form>
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
  <!-- Google reCAPTCHA -->
  <script src="https://www.google.com/recaptcha/api.js"></script>
</body>
</html>