<?php

extract($_REQUEST);

$title = "Inicio";
$nucleo = 'home';
include '../../js/restric.php';
include('../../../modelos/ClassAlert.php');

if( isset($alert) && $alert == "nodolar"){ $al = new ClassAlert("Error en registro del dolar!<br>","","danger"); }

elseif( isset($alert) && $alert == "errorpriv"){ $al = new ClassAlert("Este usuario no posee los permisos para ingresar a esa vista!<br>","Modifique los permisos en <a href='../../../controladores/ControladorRegistro.php?operacion=index'>aqui</a>","warning"); }

$conex = $db->conectar();

$que = "SELECT * FROM producto WHERE stock < 1"; //mostrar
$strong = mysqli_query($conex, $que);
$reg = mysqli_num_rows($strong);

$admin = "SELECT * FROM usuarios WHERE tipo_usuario='admin'"; //mostrar
$gato_sin = mysqli_query($conex, $admin);
$admin_ac = mysqli_num_rows($gato_sin);

$empleo = "SELECT * FROM usuarios WHERE tipo_usuario='empleado'"; //mostrar
$empleo_sin = mysqli_query($conex, $empleo);
$empleo_ac = mysqli_num_rows($empleo_sin);

$cred = "SELECT * FROM pedidos WHERE fecha_credi='$hoy' AND metodo='Credito'"; //mostrar
$credi = mysqli_query($conex, $cred);
$rowsen = mysqli_num_rows($credi);

if( isset($alert) && $alert == "sinprivis"){ $al = new ClassAlert("No tiene permiso de realizar esa acci&oacute;n!<br>","Contacte al desarrollador","primary"); }

?>



 <!--Librerias para los charts --> 
<script src="../../../modelos/Chart.js-2.9.3/dist/Chart.min.js"></script>
<script src="../../../modelos/Chart.js-2.9.3/samples/utils.js"></script>

<style>
  canvas {
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
</style>
<main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-1 mb-3 border-bottom">
    <div class="container-fluid ">

      <!-- Page Heading -->

      <?php  if(isset($al)){ echo $al->Show_Alert(); } ?>

      <!-- Content Row -->
      <div class="row">

        <?php if ($rowsen > 0) { ?>

          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Tienes <?= $rowsen ?> créditos pendientes </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

              <span aria-hidden="true">&times;</span>

            </button>
          </div>
        <?php } ?>
      
        <div class="row">
          

          <div class="col-md-6">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Estadisticas de ventas</h5>
                <h4 class="card-title">Los productos mas vendidos</h4>
              </div>
              <div class="card-body">
                <div class="chart-area">



                  <canvas id="myChart"></canvas>

                  <?php include '../../js/graficas/pie.php' ?>




                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="fas fa-clock"></i> Historial de ventas
                </div>
              </div>
            </div>
          </div>




          <div class="col-md-6">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Estadisticas de ventas</h5>
                <h4 class="card-title">Método de pago mas usado</h4>
              </div>
              <div class="card-body">
                <div class="chart-area">

                  <canvas id="myChart2"></canvas>

                  <?php include '../../js/graficas/dona.php'; ?>

                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="fas fa-clock"></i> Historial de ventas
                </div>
              </div>
            </div>
          </div>

        </div>


        <div class="row">

          <div class="col-md-12 ">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Estadisticas de ventas</h5>
                <h4 class="card-title">Compradores mas leales</h4>
              </div>
              <div class="card-body">
                <div class="chart-area">



                  <canvas id="myChart3"></canvas>

                  <?php include '../../js/graficas/polar.php' ?>


                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <i class="fas fa-clock"></i> Historial de ventas
                </div>
              </div>
            </div>
          </div>


</main>




<?php include '../footerbtn.php'; ?>