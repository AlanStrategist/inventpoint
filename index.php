<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="icon" type="icon" href="vista/icos/logo.webp">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    InventPoint - Gestión de Ventas
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
  <!--     Fonts and icons     -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> -->
  <!-- CSS Files -->
  <link href="vista/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="vista/assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="vista/assets/demo/demo.css" rel="stylesheet" />

  <link href="vista/estilos/sss.css" rel="stylesheet">

  <link href="vista/estilos/fontawesome/css/all.min.css" rel="stylesheet">
</head>

<body class="offline-doc">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
    <div class="container">
      <!--  <div class="navbar-wrapper">
       <div class="navbar-toggle">
         <button type="button" class="navbar-toggler">
           <span class="navbar-toggler-bar bar1"></span>
           <span class="navbar-toggler-bar bar2"></span>
           <span class="navbar-toggler-bar bar3"></span>
         </button>
       </div>
       <a class="navbar-brand" href="#pablo">Portal Web</a>
     </div> -->


      <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
      </button>
       <div class="collapse navbar-collapse justify-content-end" id="navigation">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../examples/dashboard.html">
         No tienes Cuenta?
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://github.com/creativetimofficial/now-ui-dashboard/issues" target="_blank">
      Olvidaste tu contraseña?
          </a>
        </li>
      </ul>
    </div> -->
    </div>
  </nav>
  <!-- End Navbar -->

  
  <?php 
    
  extract($_REQUEST);

  include('modelos/ClassAlert.php');

  if( isset($alert) && $alert == "noexiste"){  $al = new ClassAlert("Error al ingresar!<br>","Verifique su correo y/o clave","danger"); }

  else if( isset($alert) && $alert == "inicia"){ $al = new ClassAlert("Inicie sesion para continuar!<br>","","warning"); }

  else if( isset($alert) && $alert == "closef"){ $al = new ClassAlert("Vuelva pronto!<br>","Cerr&oacute; sessi&oacute;n correctamente","primary"); }
  
  else if( isset($alert) && $alert == "error"){ $al = new ClassAlert("Error al cerrar sesion!<br>","Comuniquese con el desarrollador","danger"); }

  else if( isset($alert) && $alert == "errorv"){ $al = new ClassAlert("Error!<br>","El usuario ingresado no tiene un rol v&aacute;lido, Comuniquese con el desarrollador","danger"); }

  else if( isset($alert) && $alert == "errorquiz"){ $al = new ClassAlert("Error!<br>","Error al obtener las preguntas del usuario, contacte al desarrollador","danger"); }

  else if( isset($alert) && $alert == "lock"){ $al = new ClassAlert("Su usuario ha sido bloqueado!<br>","Se ha llegado al limite de intentos al responder las preguntas de seguridad del usuario, contacte al desarrollador","danger"); }

  else if( isset($alert) && $alert == "url"){ $al = new ClassAlert("Alerta m&aacute;xima!<br>","Se ha intentado vulnerar el sistema, llamen a la policia y al desarrollador","danger"); }

  else if( isset($alert) && $alert == "new"){ $al = new ClassAlert("Inicie sesi&oacute;n con su nueva clave!<br>","","primary"); }

  else if( isset($alert) && $alert == "error_venci"){ $al = new ClassAlert("Ha vencido el plazo de uso!<br>","Contacte al desarrollador para seguir disfrutando del servicio","danger"); }

  ?>

  <div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" style="background-image: url('vista/assets/img/bg5.jpg');"></div>
    <div class="container text-center">

    <?php if(isset($al)){ echo $al->Show_Alert(); } ?>

      <div class="col-lg-8 ml-auto mr-auto">
        <div class="card">
          <div class="card-header">

            <label>
              <h3>InventPoint</h3>
            </label>


            <div class="d-flex justify-content-end social_icon">

              <span><img class="img rounded-circle" src="vista/icos/logo.webp" width="60" height="60"
                  fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false"></span>
            </div>
          </div>
          <!--para la configuracion de la posicion del formulario en pantalla -->
          <form name="form3" action="controladores/ControladorLogin.php" method="POST" class="form-signin">


            <div class="input-group form-group col-lg-12">

              <div class="input-group-prepend">
                <span class="input-group-text text-danger"><i class="fas fa-id-card"></i></span>
              </div>

              <input type="email" class="form-control text-center " name="correo" placeholder="ejem:juan@gmail.com"
                title='Coloque su correo electrónico' required="required">
            
            
          </div>

            <div class="input-group form-group col-lg-12">

              <div class="input-group-prepend">
                <span class="input-group-text text-danger"><i class="fas fa-key "></i></span>
              </div>

              <input type="password" id="password" class="form-control text-center" name="clave"
                placeholder="Contraseña" required="required" minlength="1" maxlength="15" title="Mostrar Contraseña">
               
            </div>





            <!--Esto no va
  <div class="row align-items-center remember">
            <input type="radio" name="tipo_usuario"  value="admin" title="admin">Administrador
          </div> -->
            <!-- <div class="row align-items-center remember">
            <input type="radio" name="tipo_usuario" placeholder="Contraseña" required="required" value="cliente" title="cliente">Cliente
          </div> -->


            <input type="hidden" name="operacion" value="login">

            <div class="form-group">

              <input type="submit" value="Ingresar" class="btn btn-primary">
              
            </div>
            <span>Olvid&oacute; su clave? <a href="controladores/ControladorLogin.php?operacion=olvido">Recuperar usuario</a></span>
          </form>



        </div>
      </div>
    </div>
  </div>
  <footer class="footer">
    <div class=" container-fluid ">
      <nav>
        <ul>

          <!-- <li>
            <a href="http://presentation.creative-tim.com">
              About Us
            </a>
          </li>
          <li>
            <a href="http://blog.creative-tim.com">
              Blog
            </a>
          </li> -->
        </ul>
      </nav>
      <div class="copyright" id="copyright">
        &copy;
        <script>
          document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
        </script> Designed by <a href="https://www.RomGoDevelop.com" target="_blank">RomGoDevelop</a>.
      </div>
    </div>
  </footer>
  <!--   Core JS Files   -->
  <script src="vista/assets/js/core/jquery.min.js"></script>
  <script src="vista/assets/js/core/popper.min.js"></script>
  <script src="vista/assets/js/core/bootstrap.min.js"></script>
  <script src="vista/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
</body>

</html>