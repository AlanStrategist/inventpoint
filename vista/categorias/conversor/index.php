<?php

$nucleo = 'Productos';
$title = "Tasa de Cambio";
include('../../js/restric.php');
include('../../../modelos/ClassAlert.php');

extract($_REQUEST);

if( isset($alert) && $alert == "error"){ $al = new ClassAlert("Error al almacenar el tipo de cambio !<br>","","danger"); }

else if( isset($alert) && $alert == "exito"){ $al = new ClassAlert("Se ha registrado el dolar<br>","","primary"); }


$lista = "SELECT dolar.valor,dolar.fecha,usuarios.nombre,usuarios.correo FROM dolar,usuarios WHERE dolar.id_usuario=usuarios.id";
$respuesta = mysqli_query($conex, $lista);
$pruebo = mysqli_num_rows($respuesta);

if (!($pruebo > 0)) {

  header("Location: ../home/home.php?alert=nodolar");

}

?>

<div class="content">
  <div class="row">
    <div class="col-md-12">
    <?php  if(isset($al)){ echo $al->Show_Alert(); } ?>
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Lista de los valores del dolar</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table">

              <thead class="text-primary">
                <th><small>Valor del Dolar</small></th>
                <th><small>Fecha</small></th>
                <th><small>Usuario que <br> realizo la conversion</small></th>


              </thead>

              <?php

              while ($data = mysqli_fetch_array($respuesta)) {

                echo "<tr>";
                echo "<td>".$data['valor']."</td>";
                echo "<td>".$data['fecha']."</td>";
                echo "<td>".$data['nombre']."<br>".$data['correo']."</td>";
                echo "</tr>";

              }

               ?>

            </table>
          </div>
        </div>
      </div>
    </div>
    </body>

    </html>
    <script type="text/javascript">
      $(document).ready(function () {
        $('#example').DataTable();
      });
    </script>
    <?php include('../footerbtn.php'); ?>