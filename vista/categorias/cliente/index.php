<?php
$nucleo = 'Cliente';
$title = 'Lista de Clientes';
include '../../js/restric.php';
include('../../../modelos/ClassAlert.php');

extract($_REQUEST);

if( isset($alert) && $alert == "exito"){ $al = new ClassAlert("Registro exitoso!<br>","Se registro el cliente exitosamente","primary"); }

else if( isset($alert) && $alert == "error"){ $al = new ClassAlert("Error!<br>","No se registraron los cambios","danger"); }

else if( isset($alert) && $alert == "du"){ $al = new ClassAlert("Error!<br>","La c&eacute;dula est&aacute; duplicada","danger"); }



if ($clave == '') { ?>

  <script type="text/javascript">
    alert('No se puede listar,no hay autorización');
    window.location = "../home/home.php";

  </script>


<?php } else {

  $lista = "SELECT * FROM cliente";
  $respuesta = mysqli_query($conex, $lista);
  $pruebo = mysqli_num_rows($respuesta);
  ?>

  <body>

    <div class="content">
      <div class="row">
        <div class="col-md-12">
        <?php  if(isset($al)){ echo $al->Show_Alert(); } ?>
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Clientes Registrados</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table">

                  <thead class="text-primary">


                    <th>Nombre</th>
                    <th>Teléfono </th>
                    <th>Cédula</th>

                  </thead>

                  <?php

                  while ($data = mysqli_fetch_array($respuesta)) {

                    $cedula = 0;

                    echo "<tr>";
                    echo "<td>";

                    ?>     <?= $data['nombre'] ?>    <?php
                             echo "</td>";

                             echo "<td>";

                             ?>    <?= $data['telefono'] ?>    <?php
                                     echo "</td>";

                                     echo "<td>";
                                     ?>C.I <?= $data['cedula'] ?>
                    <?php
                    echo "</td>";

                  }

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
<?php include '../footerbtn.php'; ?>