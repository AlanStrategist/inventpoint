<?php
extract($_REQUEST);

$nucleo = 'Privilegios';
$title = 'Lista de privilegios';

include '../../js/restric.php';

if ($privis['usuarios'] == 1) {

} else {
  ?>
  <script type="text/javascript">
    window.location = "../home/home.php"
  </script>
  <?php
}


$lista = "SELECT * FROM privilegio";
$respuesta = mysqli_query($conex, $lista);
$pruebo = mysqli_num_rows($respuesta);

if ($clave == '' || $pruebo == 0) {
  ?>

  <script type="text/javascript">
    alert('No hay elementos para listar');
    window.location = "../home/home.php";

  </script>


<?php } else {

  ?>


  <body>

    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Privilegio de usuarios</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table">

                  <thead class="text-primary">

                    <th>Usuario</th>
                    <th
                      title="Las bitacoras registran cada uno de los movimientos dentro del sistema,Acceder a todas las bitacoras">
                      Bitacora</th>

                    <th
                      title="Permiso para registrar productos,actualizar la cantidad de existencia, registrar ubicaciones o categorias de productos">
                      Productos</th>

                    <th title="Realizar las ventas dentro del sistema y generar cierres diarios">Pedidos</th>

                    <th
                      title="Poder registrar usuarios dentro del sistema,tambien asignarle los privilegios a cada uno de los usuarios dentro del sistema ">
                      Usuarios</th>

                    <th title="Realizar respaldo y restauración de las bases de datos dentro del sistema">Mantenimiento
                    </th>

                    <th title="Modificar"><i class="far fa-2x fa-edit"></i></th>
                  </thead>

                  <?php
                  $num = 0;


                  while ($data = mysqli_fetch_array($respuesta)) {


                    echo "<tr>";

                    echo "<td>";


                    $name_u = 'SELECT usuarios.nombre FROM usuarios WHERE id=' . $data['id_usuario'];
                    $execute_u = mysqli_query($conex, $name_u);
                    while ($nom_u = mysqli_fetch_array($execute_u)) {
                      echo $nom_u['nombre'];
                    }

                    echo "<td>";
                    if ($data['bitacora'] == 1) {
                      echo $data['bitacora'];
                    } else {
                      echo "no";
                    }


                    echo "</td>";

                    echo "<td>";
                    if ($data['producto'] == 1) {
                      echo $data['producto'];
                    } else {
                      echo "no";
                    }


                    echo "</td>";

                    echo "<td>";
                    if ($data['pedidos'] == 1) {
                      echo $data['pedidos'];
                    } else {
                      echo "no";
                    }


                    echo "</td>";

                    echo "<td>";
                    if ($data['usuarios'] == 1) {
                      echo $data['usuarios'];
                    } else {
                      echo "no";
                    }


                    echo "</td>";

                    echo "<td>";
                    if ($data['mantenimiento'] == 1) {
                      echo $data['mantenimiento'];
                    } else {
                      echo "no";
                    }


                    echo "</td>";

                    if ($data['id_usuario'] == $_SESSION['id']) {

                      echo "<td></td>";

                    } else {

                      ?>



                      <td><a title="Modificar"
                          href="../../../controladores/controladorprivilegio.php?operacion=modificar&id=<?= $data['id_usuario'] ?>"
                          href=''><i class="far fa-2x fa-pencil-alt"> </i></a>

                      </td>


                      <?php

                    }



                    $num++;

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