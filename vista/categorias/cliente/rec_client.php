<?php
$nucleo = 'Cliente';
$title = 'Lista de Clientes';
include '../../js/restric.php';
include('../../../modelos/ClassAlert.php');

$alert = isset($_GET['alert']) ? $_GET['alert'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "";

if (isset($alert) && $alert == "exito") {
  $al = new ClassAlert("Registro exitoso!<br>", "Se registro el cliente exitosamente", "primary");
} else if (isset($alert) && $alert == "error") {
  $al = new ClassAlert("Error!<br>", "No se registraron los cambios", "danger");
} else if (isset($alert) && $alert == "du") {
  $al = new ClassAlert("Error!<br>", "La c&eacute;dula est&aacute; duplicada", "danger");
} else if (isset($alert) && $alert == "modi") {
  $al = new ClassAlert("Modificaci&oacute;n exitosa", "", "warning");
}

if (!has_privi($privs, "List", "Cliente") && !has_privi($privs, "List", "Pedidos")) {

  ?>

  <script>

    window.location = "../home/home.php?alert=sinprivis";

  </script>

  <?php


}

try {

  $lista = "SELECT p.factura, c.nombre from cliente c, pedidos p WHERE c.id = p.cliente_id AND c.id= $id AND p.estatus = 'facturado' ";
  
  $respuesta = mysqli_query($conex, $lista);
  $pruebo = mysqli_num_rows($respuesta);

  if ($pruebo == 0) {
    throw new Exception("No hay compras de este cliente");
  }

} catch (Exception $e) {

  ?>

  <script>

    window.location = "../home/home.php?alert=noclient";

  </script>

  <?php

} finally {

  //mysqli_close($conex);

}

?>

<body>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <?php if (isset($al)) {
          echo $al->Show_Alert();
        } ?>
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
                  <th>Acciones</th>
                  <th>Recibos</th>
                </thead>

                <?php

                while ($data = mysqli_fetch_array($respuesta)) {

                  ?>
                  <tr>
                    <td><?= $data['nombre'] ?></td>
                    <td><?= $data['telefono'] ?></td>

                    <?php

                    $it = "";

                    switch ($data['tipo']) {

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

                    <td><?= $it?><?=$data['cedula'] ?></td>
                    <td class="text-primary">
                      <a href="../../../controladores/ControladorCliente.php?operacion=update&id=<?= $data['id'] ?>"
                        title="Modificar" class="btn btn-primary btn-link btn-sm"><i class="fas fa-pen"></i></a>
                    </td>
                    <td><a href="../../../controladores/ControladorCliente.php?operacion=rec_client&id=<?= $data['id']?>"
                        title="Ver todos los recibos de este cliente" class="btn btn-primary btn-link btn-sm"><i class="fas fa-receipt"></i></td>
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