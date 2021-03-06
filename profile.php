<?php
ob_start();

include("Conexion.php");
session_start();
error_reporting(0);
//validacion de sesion y tipo de usuario 
$NombreU = $_SESSION['NombreU'];
$TIPOu=$_SESSION['ID'];

if (!isset($NombreU)) {
  header("location: iniciar.php");

}

if ($TIPOu==2) {
  header("location: Servicios.php");
}
//se verifica que se este recibiendo la variable nik.
$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
if (!isset($nik)) {
  header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Gestor de visitas <?php echo $NombreU ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
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


      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="index.php">Inicio</a></li>
          <li class="nav-link scrollto"><a href="Lista.php">Lista de visitas</a></li>
          <li><a class="nav-link scrollto"href="add.php">Agregar visita</a></li>
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
 

  <main id="main">

<div class="container">
    <div class="content">
      <h2>Datos de visita &raquo; Perfil</h2>
      <hr />
      
      <?php
      //secuencia sql encargada d mostra todos los datos cuyo id sea igual al nik
      
      $sql = mysqli_query($con, "SELECT * FROM visitas WHERE IDvisita='$nik'");
      // se cuentan los datos y validan los datos
      if(mysqli_num_rows($sql) == 0){
        header("Location: Lista.php");
      }else{
        //se pasan lso datos a una variable llamada row
        $row = mysqli_fetch_assoc($sql);

      }
      
      //se muestran los datos utilando una tabla
      ?>
      
      <table class="table table-striped table-condensed">
        <tr>
          <th width="20%">Visita Numero</th>
          <td><a href="detallevisita.php?id=<?php echo $row['IDvisita'];?>"> <?php echo $cantidad_datos?><?php echo $row['IDvisita']; ?></a></td>
        </tr>
        <tr>
          <th>Nombre del cliente</th>
          <td ><?php echo $row['NombreCliente']; ?></td>
        </tr>
        <tr>
          <th>Comuna</th>
          <td><?php echo $row['comuna']; ?></td>
        </tr>
        <tr>
          <th>rutcliente</th>
          <td><?php echo $row['rutcliente']; ?></td>
        </tr>
        <tr>
          <th>direccion</th>
          <td><?php echo $row['direccion']; ?></td>
        </tr>
        <tr>
          <th>Estado</th>
          <td>
            <?php 
              if ($row['Estado']=="Asignada") {
                echo "Asignada";
              } else if ($row['Estado']=="Pendiente"){
                echo "Pendiente";
              }
            ?>
          </td>
        </tr>
        <tr>
          <th>Detalle</th>
          <td><?php echo $row['Detalle']; ?></td>
        </tr>

        <?php 
        //se pregunta si el estado es asignado
        if ($row["Estado"]=="Asignada") {
          //en caso de que el seatado es asignado,se ejecuta una secuencia sql que se encarga de traer todos los datos de la asignacion

          $query=mysqli_query($con,"SELECT usuarios.Correo, usuarios.NumeroTelefonico,jornada.Matricula, usuarios.NombreUsuario, usuarios.Rut,jornada.nombreusuario,jornada.Fecha, jornada.nombreusuario, vehiculos.estacionamiento FROM jornada 
INNER JOIN vehiculos ON vehiculos.patente=jornada.Matricula 
INNER JOIN usuarios ON jornada.nombreusuario=usuarios.NombreUsuario where numerovisita='$nik'");
          //se verifica que existan datos
          if(mysqli_num_rows($query) == 0){


          ?>
         <tr>
          <th>Error</th>
          <td><?php echo "Error interno" ?></td>
        </tr>
        <?php

      }else{
        //se pasan los datos a una variable llamada Datosjornada
        $DatosJornada = mysqli_fetch_assoc($query);



        // se muestran los datos utilizando una tabla

        ?>



        <tr>
          <th>Usuario encargado</th>
          <td> <a href="Perfilusuariolist.php?nusuario=<?php echo $DatosJornada['NombreUsuario']; ?>"><?php echo $DatosJornada['NombreUsuario']; ?></a></td>
        </tr>

        <tr>
          <th>Correo</th>
          <td><?php echo $DatosJornada['Correo']; ?></td>
        </tr>

        <tr>
          <th>Rut</th>
          <td><?php echo $DatosJornada['Rut']; ?></td>
        </tr>

        
        <tr>
          <th>Numero de telefono</th>
          <td><?php echo $DatosJornada['NumeroTelefonico']; ?></td>
        </tr>

        
        
        <tr>
          <th>Vehiculo asignado</th>
          <td><?php echo $DatosJornada['Matricula']; ?></td>
        </tr>

         <tr>
          <th>Lugar estacionamiento</th>
          <td><?php echo $DatosJornada['estacionamiento']; ?></td>
        </tr>
        <tr>
          <th>Horario visita</th>
          <td><?php echo $DatosJornada['Fecha']; ?></td>
        </tr>





        






          <?php





      }

          
        }

        ?>
        
      </table>
      
      <a onclick="history.back();" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Regresar</a>
      <br></br>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6">
            <div class="footer-info">
              <h3>Day</h3>
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

</body>

</html>


<?php
ob_end_flush();
?>