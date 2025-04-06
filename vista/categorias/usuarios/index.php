<?php
extract($_REQUEST);

$title = 'Lista de usuarios';
$nucleo = 'usuarios';
include('../../js/restric.php');
include("../../../modelos/ClassAlert.php");

if (!has_privi($privs, "List", "Producto")) {

  ?>
  <script type="text/javascript">
    window.location = "../home/home.php?alert=errorpriv"
  </script>

  <?php
}

try {

  $conex = $db->conectar();

  $lista = "SELECT * FROM usuarios";

  $respuesta = mysqli_query($conex, $lista);

  $pruebo = mysqli_num_rows($respuesta);

  while ($dato = mysqli_fetch_array($respuesta)) {

    $dat[] = $dato;
  }

} catch (mysqli_sql_exception $e) {

  ?>
  <script type="text/javascript">
    window.location = "../home/home.php?alert=errorpriv"
  </script>

  <?php

} finally {

  mysqli_close($conex);

}

if( isset($alert) && $alert == "errorprivis"){ $al = new ClassAlert("Error en la agregaci&oacute;n de privilegios!<br>","","danger"); }

else if( isset($alert) && $alert == "erroruser"){ $al = new ClassAlert("Error al consultar usuario!<br>","Verifique su conexion a internet","danger"); }

else if( isset($alert) && $alert == "sin"){ $al = new ClassAlert("No se ha actualizado ning&uacute;n privilegio!<br>","","danger"); }

else if( isset($alert) && $alert == "error"){ $al = new ClassAlert("Error!<br>","No se registraron los cambios","danger"); }

else if( isset($alert) && $alert == "rol"){ $al = new ClassAlert("Se ha cambiado el rol del usuario!<br>","","warning"); }

else if( isset($alert) && $alert == "si"){ $al = new ClassAlert("Registro exitoso,Se ha registrado el usuario!<br>","Se han concedido los permisos","warning"); }

else if( isset($alert) && $alert == "sucessUp"){ $al = new ClassAlert("Agregaci&oacute;n exitosa de permisos!<br>","","primary"); }

else if( isset($alert) && $alert == "errorUp"){ $al = new ClassAlert("Error en la modificaci&oacute;n!<br>","","danger"); }

else if( isset($alert) && $alert == "siprivis"){ $al = new ClassAlert("Privilegios agregados exitosamente!<br>","","primary"); }


?>

<body>

  <div class="content">
    <div class="row">
      <div class="col-md-12">
      <?php if (isset($al)) { echo $al->Show_Alert();} ?>
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
                  <td>Permisos del usuario</td>
                  <td>Estatus</td>
                  <td>Modificar Datos de Usuario</td>
                </thead>

                <?php
                
                $nam = 0;

                foreach ($dat as $data) {
                  
                  ?>

                  <tr>
                  <td><?=$data['correo']?></td>
                  <td><?=$data['nombre']?> <br> <?=$data['cedula']?></td>
                  
                  <?php

                  if($data['id'] != $_SESSION['id']){

                  echo "<td>";
                  echo $data['tipo_usuario'] == 'admin' ? "<a href='#' data-toggle='modal' data-target='#RolEm".$nam."'><i
                  class='far fa-3x fa-user-headset text-danger' title='Administrador ¿Desea cambiar su Rol?'></i></a>"
                  : "<a href='#' data-toggle='modal' data-target='#RolAd".$nam."'><i
                  class='far fa-3x fa-user-hard-hat  text-info' title='Empleado ¿Desea cambiar su Rol?'></i></a>";
                  ?></td>
                  
                  <td><a href='../../../controladores/ControladorUsuarios.php?operacion=View_Privs&id=".$data['id']."'><i class='fas fa-2x fa-eye'></i> </a></td>

                  <?php
                  echo "<td>";
                  echo $data['estatus'] == "activo" ? "<a href='#' data-toggle='modal' data-target='#I".$nam."'><i class='fas fa-2x fa-thumbs-down text-danger' title='Inhabilitar usuario'></i></a>"
                  : "<a href='#' data-toggle='modal' data-target='#H".$nam."'><i class='fas fa-2x fa-thumbs-up text-success ' title='Activar usuario'></i></a>";
                  echo "</td>";

                  }else{
                    ?>
                    
                    <td></td>
                    <td></td>
                    <td></td>

                    <?php

                  }        
                    ?>
                  
                  <td>
                    <a href='../../../controladores/ControladorUsuarios.php?operacion=Update&id=<?=$data['id']?>'> <i class='fas fa-2x fa-pen'></i> </a>
                  </td>

                  <?php

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