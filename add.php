<?php
session_start();

include("Conexion.php");

ob_start();



//validacion de sesion y tipo de usuario 

$NombreU = $_SESSION['NombreU'];
$TIPOu=$_SESSION['ID'];

if (!isset($NombreU)) {
  header("location: iniciar.php");

}

if ($TIPOu==2) {
  header("location: Servicios.php");
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
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="index.php">Inicio</a></li>
          <li class="nav-link scrollto"><a href="Lista.php">Lista de visitas</a></li>
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
          <h2>Datos de la visita &raquo; Agregar visitas</h2>
          <hr />

          <?php

          //Se pregunta si es que esta llegando una variable y se pasa a una variable local



          if (isset($_GET["guardado"]) ) {
          
            $mensaje = $_GET["guardado"];

            //se verifica el contenido de la varible para mostrar un mensaje en caso de er requerido.
            //de esta forma se evitan los duplicados al momento de guardar


            if ($mensaje=="ok") {
              echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
            } else {

            }



          }

          //Al precionar el boton con add se obtiene el texto de los campos de texto.
          if(isset($_POST['add'])){
            $IDvisita        = mysqli_real_escape_string($con,(strip_tags($_POST["IDvisita"],ENT_QUOTES)));
            $NombreCliente         = mysqli_real_escape_string($con,(strip_tags($_POST["NombreCliente"],ENT_QUOTES)));
            $comuna  = mysqli_real_escape_string($con,(strip_tags($_POST["comuna"],ENT_QUOTES))); 
            $rutcliente  = mysqli_real_escape_string($con,(strip_tags($_POST["rutcliente"],ENT_QUOTES))); 
            $direccion       = mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));
            $Estado      = mysqli_real_escape_string($con,(strip_tags($_POST["Estado"],ENT_QUOTES)));
            $Detalle     = mysqli_real_escape_string($con,(strip_tags($_POST["Detalle"],ENT_QUOTES))); 

            //Se prepara la sentencia preparada PDO
                 
                 $cek = $connection->prepare("SELECT * FROM visitas WHERE IDvisita=:IDvisita");
                 $cek->bindParam("IDvisita", $IDvisita, PDO::PARAM_STR);
                 $cek->execute();
                 if($cek->rowCount() == 0){
                  $ins = $connection->prepare("INSERT INTO visitas(NombreCliente, comuna, rutcliente, direccion, Estado, Detalle)
                    VALUES(:NombreCliente,:comuna,:rutcliente,:direccion,:Estado,:Detalle)");

                  $ins->bindParam("NombreCliente", $NombreCliente, PDO::PARAM_STR);
                  $ins->bindParam("comuna", $comuna, PDO::PARAM_STR);
                  $ins->bindParam("rutcliente", $rutcliente, PDO::PARAM_STR);
                  $ins->bindParam("direccion", $direccion, PDO::PARAM_STR);
                  $ins->bindParam("Estado", $Estado, PDO::PARAM_STR);
                  $ins->bindParam("Detalle", $Detalle, PDO::PARAM_STR);

                  $ins = $ins->execute();

                  if($ins){
                    //Para evitar duplicaciones se envia una variable con nombre "guardado" y se recarga la pagina evitando que al acualziar se reenvien los formularios.

                    header("location:add.php?guardado=ok");

                  }else{
                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
                  }

                }else{
                  echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. código exite!</div>';
                }
              }
              ?>

              <form class="form-horizontal" action="" method="post">
                <div class="form-group">

                  <div class="col-sm-2">
                    <input type="hidden" name="IDvisita" class="form-control" placeholder="IDvisita" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">NombreCliente</label>
                  <div class="col-sm-4">
                    <input type="text" onkeypress="return noespeciales(event);" minlength="3" maxlength="25" name="NombreCliente" class="form-control" placeholder="NombreCliente" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">comuna</label>
                  <div class="col-sm-4">
                    <input type="text" onkeypress="return noespeciales2(event);" minlength="3" maxlength="20" name="comuna" class="form-control" placeholder="comuna" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">rutcliente</label>
                  <div class="col-sm-4">
                    <input type="text"onkeypress="return Solonumeros(event);"  minlength="12" maxlength="17"name="rutcliente" class="form-control" placeholder="rutcliente" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">direccion</label>
                  <div class="col-sm-3">
                    <textarea name="direccion" onkeypress="return noespeciales2(event);" minlength="3" maxlength="50" class="form-control" placeholder="direccion" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Estado</label>
                  <div class="col-sm-3">
                    <select name="Estado" class="form-control">


                      <option value="Pendiente">Pendiente</option>

                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Detalle</label>
                  <div class="col-sm-4">
                    <input type="text" onkeypress="return noespeciales2(event);" maxlength="50" name="Detalle" class="form-control" placeholder="Detalle" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">&nbsp;</label>
                  <div class="col-sm-6">
                    <input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
                    <a href="Lista.php" class="btn btn-sm btn-danger">Cancelar</a>
                    <br></br>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="js/bootstrap-datepicker.js"></script>
          <script>
            $('.date').datepicker({
              format: 'dd-mm-yyyy',
            })
          </script>

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
        <script src="validar.js"></script>



      </body>

      </html>


      <?php
      ob_end_flush();
    ?>