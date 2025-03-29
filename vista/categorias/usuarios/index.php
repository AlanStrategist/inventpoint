<?php
extract($_REQUEST);
$title = 'Lista de usuarios';
$nucleo = 'usuarios';

include('../../js/restric.php');

if (!($privis['usuarios'] == 1)) {

  ?>
  <script type="text/javascript">
    window.location = "../home/home.php?alert=error"
  </script>

  <?php
}

try{

$conex = $db->conectar();

$lista = "SELECT * FROM usuarios";

$respuesta = mysqli_query($conex, $lista);

$pruebo = mysqli_num_rows($respuesta);

}catch(mysqli_sql_exception $e){

  include("../../../modelos/ClassAlert.php");

  $al = new ClassAlert("Error en la consulta","Recargue la pagina","danger");

}finally{

  //mysqli_close($conex);

}

?>

<body>

  <div class="content">
    <?php if( isset($al) ){ $al->Show_Alert(); } ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Usuarios Registrados</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table">

                <thead class="text-primary">

                  <td>Correo Electrónico</td>
                  <td>Nombre y Cédula</td>
                  <td>Tipo de usuario</td>
                  <td><i class="fas fa-thumbs-up"></i>
                    <i class="fas fa-thumbs-down"></i>
                  </td>
                </thead>

                <?php
                $nam = 0;

                while ($data =  mysqli_fetch_array($respuesta)) {

                  echo "<tr>";
                  echo "<td>";

                  ?>   <?= $data['correo'] ?>  <?php
                       echo "</td>";

                       echo "<td>";

                       ?>   <?= $data['nombre'] ?> <br> <?= $data['cedula'] ?>   <?php

                              echo "</td>";


                              echo "<td>";

                              if ($data['tipo_usuario'] == 'admin') { ?>
                    <a href='#' data-toggle='modal' data-target='#RolEm<?= $nam ?>'><i
                        class='far fa-3x fa-user-headset text-danger' title='Administrador ¿Desea cambiar su Rol?'></i></a>
                  <?php
                              } elseif ($data['tipo_usuario'] == 'empleado') { ?>

                    <a href='#' data-toggle='modal' data-target='#RolAd<?= $nam ?>'><i
                        class='far fa-3x fa-user-hard-hat  text-info' title='Empleado ¿Desea cambiar su Rol?'></i></a>

                  <?php }

                              echo "</td>";

                              echo "<td>";

                              if ($data['estatus'] == 'activo') {


                                if ($data['id'] == $_SESSION['id']) { ?>

                    <?php } else { ?> <a href='#' data-toggle='modal' data-target='#I<?= $nam ?>'><i
                          class='fas fa-2x fa-thumbs-down text-danger' title='Inhabilitar usuario'></i></a>

                    <?php }

                              } elseif ($data['estatus'] == 'inactivo') { ?>

                    <a href='#' data-toggle='modal' data-target='#H<?= $nam ?>'><i
                        class='fas fa-2x fa-thumbs-up text-success ' title='Activar usuario'></i></a>

                  <?php }

                              include '../modals/modal_usuario.php';

                              $nam++;

                }

                ?>




              </table>
</body>

</html>
<script type="text/javascript">
  $(document).ready(function () {
    $('#example').DataTable();
  });
</script>
<?php include('../footerbtn.php'); ?>