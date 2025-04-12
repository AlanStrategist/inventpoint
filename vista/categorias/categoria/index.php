<?php
$title = 'Lista de Categorias de productos';
$nucleo = 'Producto';
include('../../js/restric.php');
include('../../../modelos/ClassAlert.php');

extract($_REQUEST);

if( isset($alert) && $alert == "exito"){ $al = new ClassAlert("Registro exitoso !<br>","","primary"); }

else if( isset($alert) && $alert == "modisi"){ $al = new ClassAlert("Modificaci&oacute;n exitosa !<br>","","warning"); }

else if( isset($alert) && $alert == "modino"){ $al = new ClassAlert("Error al modificar!<br>","Verifique su conexion a internet","danger"); }

else if( isset($alert) && $alert == "status"){ $al = new ClassAlert("Estatus Modificado!<br>","","warning"); }

else if( isset($alert) && $alert == "error"){ $al = new ClassAlert("Error!<br>","No se registraron los cambios","danger"); }



if ($clave == '') { ?>

  <script type="text/javascript">
    alert('No se puede listar,no hay autorización');
    window.location = "../home/home.php";

  </script>


<?php } else {


  $lista = "SELECT * FROM categorias";
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
              <h4 class="card-title">Categorias Registradas</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table">

                  <thead class="text-primary">


                    <th>Nombre</th>


                    <th>Acciones</th>

                  </thead>

                  <?php

                  while ($data = mysqli_fetch_array($respuesta)) {

                    $cedula = 0;

                    echo "<tr>";
                    echo "<td>";



                    ?>     <?= $data['nombre'] ?>    <?php
                             echo "</td>";





                             ?>
                    <td><a title="Modificar"
                        href="../../../controladores/ControladorCategoria.php?operacion=modificar&id=<?= $data['id'] ?>"><i
                          class="far fa-2x fa-pencil-alt"> </i></a>

                    </td>
                    </tr>
                    <?php
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
<?php include('../footerbtn.php'); ?>