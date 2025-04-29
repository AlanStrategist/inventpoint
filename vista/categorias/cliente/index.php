<?php
$nucleo = 'Cliente';
$title = 'Lista de Clientes';
include '../../js/restric.php';
include('../../../modelos/ClassAlert.php');

extract($_REQUEST);

if (isset($alert) && $alert == "exito") {
  $al = new ClassAlert("Registro exitoso!<br>", "Se registro el cliente exitosamente", "primary");
} else if (isset($alert) && $alert == "error") {
  $al = new ClassAlert("Error!<br>", "No se registraron los cambios", "danger");
} else if (isset($alert) && $alert == "du") {
  $al = new ClassAlert("Error!<br>", "La c&eacute;dula est&aacute; duplicada", "danger");
}

$lista = "SELECT * FROM cliente";
$respuesta = mysqli_query($conex, $lista);
$pruebo = mysqli_num_rows($respuesta);

$pruebo = 0;

if($pruebo == 0){

  ?>

  <script>

    window.location = "../home/home.php?alert=noclient";

  </script>

<?php

} 

?>

<body>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <?php if (isset($al)) { echo $al->Show_Alert(); } ?>
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
                  <th>Indentificaci&oacute;n</th>
                </thead>

                <?php

                while ($data = mysqli_fetch_array($respuesta)) {

                  ?>
                  <tr>
                  <td><?=$data['nombre']?></td>
                  <td><?=$data['telefono']?></td>
                  
                  <?php

                  $it = "";

                  switch($data['tipo']){

                    case "Venezolano":

                      $it = "<span class='text-primary' title='Venezolano'>V-</span>";

                      break;

                    
                    case "Extranjero":

                      $it = "<span class='text-primary' title='Extranjero'>E-</span>";

                      break;

                    
                    case "RIF":

                      $it = "<span class='text-primary' title='Jur&iacute;dico'>J-</span>";

                      break;  

                  }

                  ?>
                  
                  <td><?=$it?><?=$data['cedula']?></td>

                <?php
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