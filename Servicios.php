<?php
ob_start();


//para GPS
session_start();

//validacion de sesion y tipo de usuario 
$NombreU = $_SESSION['NombreU'];
$TIPOu=$_SESSION['ID'];

if (!isset($NombreU) or $TIPOu==1) {
  header("location: iniciar.php");
}
if ($TIPOu==1) {
  header("location: Admin.php");
}
setlocale(LC_ALL,"es_CL.UTF-8");
date_default_timezone_set('America/Argentina/Buenos_Aires');
//$NombreU="seba1414cc";
include('Conexion.php');
mysqli_set_charset($con, "utf8");
$cantidad_datos=0;
$fechav=date("Y-m-d");
$mañana= date("Y-m-d",strtotime($fechav."+ 1 days"));
$dias3= date("Y-m-d",strtotime($fechav."+ 3 days"));
$dias7= date("Y-m-d",strtotime($fechav."+ 7 days"));





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
          <li><a class="nav-link scrollto active" href="#hero">Inicio</a></li>
          <li class="dropdown"><a href="#services"><span>Servicios</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="ServicioVehiculos.php">Servicios de Vehiculos</a></li>
              <li><a href="ServicioVisitas.php">Servicios de Visitas</a></li>
            </ul>
          </li>

          <li><a class="nav-link scrollto" href="GPS.php">GPS</a></li>

          <li class="dropdown"><a href=""><span>Mi Perfil</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="perfil_usuario.php?nusuario=<?php echo $NombreU;?>"><?php echo $NombreU; ?></a></li>
              <li><a href="salir.php">SALIR</a></li>
            </ul>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

      </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
      <div class="container position-relative" data-aos="fade-up" data-aos-delay="500">
        <h1>Bienvenido a SLN <?php echo $NombreU; ?></h1>
      </div>
    </section><!-- End Hero -->

    <main id="main">

      <!-- ======= About Section ======= -->

      <!-- ======= Services Section ======= -->
      <section id="services" class="services">
        <div class="container" >
          <div class="section-title">
            <span>Visitas</span>
            <h2>Visitas</h2>
            <h3 class="fst-italic">Las siguientes visitas para el usuario <?php echo $NombreU; ?> son</h3>
          </div>
          <div class="row">
            <form class="form-inline" method="get">
              <div class="section-title">
                <select name="filter" class="form-control" onchange="form.submit()">
                  <?php
                  //se crea filtro para los datos a mostrar
                   ?>
                  <option value="0">Filtros de dias para las visitas</option>
                  <?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
                  <option value="1" <?php if($filter == 'Tetap'){ echo 'selected'; } ?>>Ver visitas asignadas para mañana</option>
                  <option value="2" <?php if($filter == 'Kontrak'){ echo 'selected'; } ?>>Ver visitas para los proximos 3 dias</option>
                  <option value="3" <?php if($filter == 'Outsourcing'){ echo 'selected'; } ?>>Ver toda la semana</option>
                </select>
              </div>
            </form>


            <?php


            //query utilizada para obtener los datos de la visitas.
            $query='SELECT visitas.IDvisita,jornada.nombreusuario, visitas.NombreCliente, visitas.direccion, jornada.Matricula, vehiculos.estacionamiento,jornada.Fecha from jornada INNER JOIN visitas ON visitas.IDvisita = jornada.numerovisita INNER JOIN vehiculos ON vehiculos.patente=jornada.Matricula WHERE jornada.nombreusuario="'.$NombreU.'"';;
            $resultado = mysqli_query($con, $query);



            if(!$resultado)
              { die("Error en la consulta!");
          }else {

            while ($data = mysqli_fetch_assoc($resultado)){

              //se pasan los datos del array a las variables establecidas

              $Nvisita = $data['IDvisita'];
              $nombreU = $data['nombreusuario'];
              $matricula = $data['Matricula'];
              $nombrecliente=$data["NombreCliente"];
              $Direccion=$data["direccion"];
              $Estacionamiento=$data["estacionamiento"];
              $fecha = $data['Fecha'];
              $fechav2=Date("Y-m-d",strtotime($fecha));




              //se hace los filtros de los datos
              if($filter==1){
                if ($fechav2 == $mañana) {
                 $cantidad_datos++;



                 ?>
                 <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                  <div class="icon-box">
                    <div class="icon"><i class="bx bx-file"></i></div>
                    <h4><a href="detallevisita.php?id=<?php echo $Nvisita;?>">Visita Numero <?php echo $cantidad_datos?></a></h4>
                    <p>
                      <?php echo "<br> ID de visita asignada: ".$Nvisita;
                      echo "<br>Nombre de usuario: ".$nombreU;
                      echo "<br>Nombre del cliente/empresa: ".$nombrecliente;
                      echo "<br>Vehiculo asignado: ".$matricula; 
                      echo "<br> Lugar de estacionamiento: ".$Estacionamiento; 
                      echo "<br> Direccion: ".$Direccion;
                      echo "<br> Fecha y hora de visita: ".$fecha;
                      ?></p> 
                    </div>
                  </div>
                  <?php

                }

              }
              elseif($filter==2){
                if ($fechav2 <= $dias3 AND $fechav2 >= $fechav) {
                 $cantidad_datos++;



                 ?>
                 <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                  <div class="icon-box">
                    <div class="icon"><i class="bx bx-file"></i></div>
                    <h4><a href="detallevisita.php?id=<?php echo $Nvisita;?>">Visita Numero <?php echo $cantidad_datos?></a></h4>
                    <p>
                      <?php echo "<br> ID de visita asignada: ".$Nvisita;
                      echo "<br>Nombre de usuario: ".$nombreU;
                      echo "<br>Nombre del cliente/empresa: ".$nombrecliente;
                      echo "<br>Vehiculo asignado: ".$matricula; 
                      echo "<br> Lugar de estacionamiento: ".$Estacionamiento; 
                      echo "<br> Direccion: ".$Direccion;
                      echo "<br> Fecha y hora de visita: ".$fecha;
                      ?></p> 
                    </div>
                  </div>
                  <?php

                }

              }
              elseif($filter==3){
                if ($fechav2 <= $dias7 AND $fechav2 >= $fechav ) {
                 $cantidad_datos++;



                 ?>
                 <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                  <div class="icon-box">
                    <div class="icon"><i class="bx bx-file"></i></div>
                    <h4><a href="detallevisita.php?id=<?php echo $Nvisita;?>">Visita Numero <?php echo $cantidad_datos?></a></h4>
                    <p>
                      <?php echo "<br> ID de visita asignada: ".$Nvisita;
                      echo "<br>Nombre de usuario: ".$nombreU;
                      echo "<br>Nombre del cliente/empresa: ".$nombrecliente;
                      echo "<br>Vehiculo asignado: ".$matricula; 
                      echo "<br> Lugar de estacionamiento: ".$Estacionamiento; 
                      echo "<br> Direccion: ".$Direccion;
                      echo "<br> Fecha y hora de visita: ".$fecha;
                      ?></p> 
                    </div>
                  </div>
                  <?php

                }

              }
              elseif ($fechav2 == $fechav) {
                $cantidad_datos++;

                ?>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                  <div class="icon-box">
                    <div class="icon"><i class="bx bx-file"></i></div>
                    <h4><a href="detallevisita.php?id=<?php echo $Nvisita;?>">Visita Numero <?php echo $cantidad_datos?></a></h4>
                    <p>
                      <?php echo "<br> ID de visita asignada: ".$Nvisita;
                      echo "<br>Nombre de usuario: ".$nombreU;
                      echo "<br>Nombre del cliente/empresa: ".$nombrecliente;
                      echo "<br>Vehiculo asignado: ".$matricula; 
                      echo "<br> Lugar de estacionamiento: ".$Estacionamiento; 
                      echo "<br> Direccion: ".$Direccion;
                      echo "<br> Fecha y hora de visita: ".$fecha;
                      ?></p> 
                    </div>
                  </div>
                  <?php
                }
              }
            }
            ?>



          </div>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
        </section><!-- End Services Section -->








      </main><!-- End #main -->

      <!-- ======= Footer ======= -->
      <footer id="footer">
        <div class="footer-top">
          <div class="container">
            <div class="row">

              <div class="col-lg-4 col-md-6">
                <div class="footer-info">
                  <h1>SLN</h1>
                  <p>
                    Calle Falsa 123 <br>
                    Bio Bio, Chile<br><br>
                    <strong>Phone:</strong> +569 987654321<br>
                    <strong>Email:</strong> SP.SLN@sln.cl<br>
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
            &copy; Copyright <strong><span>SLN</span></strong>. TODOS LOS DERECHOS RESERVADOS
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

    </body>

    </html>


    <?php
    ob_end_flush();
    ?>