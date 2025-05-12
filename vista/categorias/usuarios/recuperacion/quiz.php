<?php
extract($_REQUEST);

include "../../../../modelos/clasedb.php";
include "../../../../modelos/ClassAlert.php";


if(!isset($trys)){ $trys = 0;}

if(!isset($id)){ 
  
  header("Location: ../../../../index.php?alert=errorquiz");  }

try{

    if($trys >= 5){

        header("Location: ../../../../controladores/ControladorUsuarios.php?operacion=Status&estatus=inactivo&trys=".$trys."&id=".$id);
    }

    $db = new clasedb();

    $conex = $db->conectar();

    $sql = "SELECT u.fhint,u.shint FROM usuarios_preguntas u WHERE id_usuarios=".$id;

    $res = mysqli_query($conex,$sql);

    if(!$res){  

        header("Location: ../../../../index.php?alert=errorquiz"); 

    }

    $row = mysqli_fetch_array($res);
    
}catch(mysqli_sql_exception | Exception $e){

    //echo"".$e->getMessage()."";

    header("Location: ../../../../index.php?alert=errorquiz");

}finally{

    mysqli_close( $conex );

}

if( isset($alert) && $alert == "error"){  $al = new ClassAlert("Error en las respuestas:".$trys."/5!<br>","Al llegar al limite de intentos será bloqueado el usuario y debera contactar al desarrollador para gestionar el desbloqueo","danger"); }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="icon" type="icon" href="../../../icos/logo.webp">
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
  <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../../../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../../../assets/demo/demo.css" rel="stylesheet" />

  <link href="../../../estilos/sss.css" rel="stylesheet">

  <link href="../../../estilos/fontawesome/css/all.min.css" rel="stylesheet">
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

  <div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" style="background-image: url('../../../assets/img/bg5.jpg');"></div>
    <div class="container text-center">

      <?php if (isset($al)) {
        echo $al->Show_Alert();
      } ?>

      <div class="col-lg-8 ml-auto mr-auto">
        <div class="card">
          <div class="card-header">

            <label>
              <h3>InventPoint</h3>
            </label>

            <div class="d-flex justify-content-end social_icon">

              <span><img class="img rounded-circle" src="../../../icos/logo.png" width="60" height="60" fill="none"
                  stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false"></span>
            </div>
          </div>
          <!--para la configuracion de la posicion del formulario en pantalla -->
          <form name="form3" action="../../../../controladores/ControladorUsuarios.php" method="POST" class="form-signin">

          <span><?=$row['fhint']?></span>

            <div class="input-group form-group col-lg-12">
           
              <div class="input-group-prepend">
                <span class="input-group-text text-danger"><i class="fas fa-question"></i></span>
              </div>

              <input type="text" class="form-control text-center " name="res1" placeholder="Respuesta"
                title='Coloque su respuesta' pattern="[0-9a-zA-Z\s]+" required="required">

            
            </div>

            <span><?=$row['shint']?></span>

            <div class="input-group form-group col-lg-12">
           
              <div class="input-group-prepend">
                <span class="input-group-text text-danger"><i class="fas fa-question"></i></span>
              </div>

              <input type="text" class="form-control text-center " name="res2" placeholder="Respuesta"
                title='Coloque su respuesta' pattern="[0-9a-zA-Z\s]+" required="required">

            
            </div>
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="trys" value="<?=$trys?>">
            <input type="hidden" name="operacion" value="View_Quiz">

            <div class="form-group">

              <input type="submit" value="Ingresar" class="btn btn-primary">

            </div>
          
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
  <script src="../../../assets/js/core/jquery.min.js"></script>
  <script src="../../../assets/js/core/bootstrap.min.js"></script>
  <!--<script src="../../../js/plugins/perfect-scrollbar.jquery.min.js"></script>
   Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../../../assets/demo/demo.js"></script>
</body>

</html>