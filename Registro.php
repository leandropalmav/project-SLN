<?php 
ob_start();


include('Conexion.php');
session_start();
?>

<!DOCTYPE html>
            
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Service Provider SLN</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="stylee.css"/>  


  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Day - v4.6.0
  * Template URL: https://bootstrapmade.com/day-multipurpose-html-template-for-free/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope-fill"></i><a href="mailto:contact@example.com">SP.SLN@sln.cl</a>
        <i class="bi bi-phone-fill phone-icon"></i> +X XXXXXXXX
      </div>
      <div class="social-links d-none d-md-block">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
      </div>
    </div>
  </section>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.php">Service Provider SLN</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="index.php">Inicio</a></li>
          <li><a class="nav-link scrollto" href="iniciar.php">Iniciar Sesión</a></li>
          <li><a class="nav-link scrollto" href="Registro.php">Registrar</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

<main id="main" style="background-image: url('https://wallpapersmug.com/download/1920x1080/c066e0/blue-abstract-wave-flow-minimalist.jpg');" >
<?php
 
if (isset($_POST['register'])) {
	//se establecen las variables para guardar el registro
    $username = $_POST['username'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $rut = $_POST['rut'];
    $tipo="2";
    //validacion ruts duplicados
    $query = $connection->prepare("SELECT * FROM usuarios WHERE Rut=:rut");
    $query->bindParam("rut", $rut, PDO::PARAM_STR);
    $query->execute();
 
    if ($query->rowCount() > 0) {
        echo '<p class="error">El rut ingresado ya esta registrado!</p>';
    }
    //validacion existencia de ruts de clintes
    $query2 = $connection->prepare("SELECT * FROM clientesinternos WHERE Rut=:rut");
    $query2->bindParam("rut", $rut, PDO::PARAM_STR);
    $query2->execute();
     if ($query2->rowCount() !== 0) {

        //validacion de nombres de usuarios
      $query3 = $connection->prepare("SELECT * FROM usuarios WHERE NombreUsuario=:username");
      $query3->bindParam("username", $username, PDO::PARAM_STR);
      $query3->execute();

        if ($query3->rowCount() == 0) {

            if ($query->rowCount() == 0) {
            	//se prepara los datos para hacer el insert en la base de datos.
        $query = $connection->prepare("INSERT INTO usuarios(NombreUsuario,NumeroTelefonico,Correo,Contraseña,Rut,Usuario_tipo) VALUES (:username,:telefono,:correo,:password_hash,:rut,:tipo)");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("telefono", $telefono, PDO::PARAM_STR);
        $query->bindParam("correo", $correo, PDO::PARAM_STR);
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("rut", $rut, PDO::PARAM_STR);
        $query->bindParam("tipo", $tipo, PDO::PARAM_STR);
        
        $result = $query->execute();
 
        if ($result) {
            header("location:iniciar.php");
        } else {
            echo '<p class="error">Algo fallo</p>';
        }
    }
}else{ echo '<p class="error">El usuario ingresado ya esta registrado!</p>';}
}else{ 
    echo '<p class="error">El Rut ingresado no existe </p>';
}
 
}
 
?>}




<form method="post" action="" name="signin-form">
<section id="about" class="about">  
      <div class="container">
          <div class="section-title">
          <span>Registrate.</span>
          </div>
       <div class="row">
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
            <p class="fst-italic">
                <p class="fst-italic" style="color:#FDFEFE";>Nombre de Usuario</p>
                <input type="text" onkeypress="return noespeciales(event);" name="username" class="form-control" pattern="[a-zA-Z0-9]+" minlength="10" maxlength="25" required />

                <p class="fst-italic" style="color:#FDFEFE";>Télefono</p>
                <input type="text" onkeypress="return telefonos(event);" name="telefono"  class="form-control" minlength="9" maxlength="15" required />

                <p class="fst-italic" style="color:#FDFEFE";>Rut (Sin puntos y con guión, Ej: 12345678-9)</p>
                <input type="text" onkeypress="return Solonumeros(event);" name="rut"  class="form-control" minlength="10" maxlength="15" required />

                <p class="fst-italic" style="color:#FDFEFE";>Correo</p>
                <input type="email" onkeypress="return noespeciales2(event);" name="correo" class="form-control" minlength="10" maxlength="40" required />

                <p class="fst-italic" style="color:#FDFEFE";>Contraseña</p>
                <input type="password" onkeypress="return Contraseñas(event);" name="password" class="form-control" placeholder="Clave" minlength="10" maxlength="20" required>
                <br>
                <br>
                <input type="submit" name="register" value="Registrar">
          </div>
        </div>
    </div>
    </section>
</form>

</main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6">
            <div class="footer-info">
              <h3>SLN</h3>
              <p>
                A108 Adam Street <br>
                NY 535022, USA<br><br>
                <strong>Phone:</strong> +1 5589 55488 55<br>
                <strong>Email:</strong> info@example.com<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Day</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/day-multipurpose-html-template-for-free/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="validar.js"></script>

</body>

</html>


<?php
ob_end_flush();
?>