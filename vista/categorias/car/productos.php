<?php
$nucleo = 'Ventas';
$title = 'Realizar una venta';

include('../../js/restric.php');
include('../../../modelos/ClassAlert.php');

extract($_REQUEST);

if( isset($alert) && $alert == "add"){ $al = new ClassAlert("Agregado !<br>","","primary"); }

else if( isset($alert) && $alert == "nostock"){ $al = new ClassAlert("No Stock!<br>","No hay la suficiente cantidad del producto","danger"); }

else if( isset($alert) && $alert == "error"){ $al = new ClassAlert("Error!<br>","No se registraron los cambios","danger"); }

else if( isset($alert) && $alert == "rem"){ $al = new ClassAlert("Removido!<br>","","primary"); }

else if( isset($alert) && $alert == "ac"){ $al = new ClassAlert("Cantidad actualizada!<br>","","primary"); }

else if( isset($alert) && $alert == "save"){ $al = new ClassAlert("Venta almacenada con exito<br>","","primary"); }


try{

// show all products

$query = "SELECT DISTINCT p.id,
p.cod_barra,
p.nombre,
p.stock,
u.nombre as ubicacion,
ca.nombre as categorias,
ROUND( p.precio + ( (p.precio * p.porcentaje) / 100),2) AS precio,
ROUND( p.precio + ( (p.precio * p.porcentaje) / 100),2) * ".$valor." AS cambio 

FROM producto p,categorias ca , ubicacion u 

WHERE p.stock > 0 AND 
p.id_categorias = ca.id AND 
p.id_ubicacion = u.id AND
p.estatus = 'habilitado'";

$respuesta = mysqli_query($conex, $query);
$pruebo = mysqli_num_rows($respuesta);

$dat = [];

//fill the array

while($data = mysqli_fetch_array($respuesta)) { $dat[] = $data; }


}catch(mysqli_sql_exception | Exception $e ){

  $respuesta = false;

}finally{

  mysqli_close($conex);

}

if ($respuesta) {


  ?>

  <body>

    <div class="content">
      <div class="row">
        <div class="col-md-12">

          <?php if(isset($al)){ echo $al->Show_Alert(); } ?>

          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Realizar una Venta </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table">

                  <thead class="text-primary">

                    <th class="textAlignLeft">Código de barra</th>

                    <th class="textAlignLeft">Nombre</th>

                    <th class="textAlignLeft">Categoria</th>

                    <th class="textAlignLeft">Ubicación</th>

                    <th class="textAlignLeft">Stock</th>

                    <th>Precio (USD)</th>

                    <th class="textAlignLeft">Precio (BS)</th>

                    <th style="width:5em;">Cantidad</th>

                    <th>Acciones</th>

                  </thead>

                  <?php
                   $chiguire = 0;

                   foreach ($dat as $data) {
                    
                    $cedula = 0;

                    echo "<tr>";
                    echo "<td>".$data['cod_barra']. "</td>";
                    echo "<td>". $data['nombre']."</td>";
                    echo "<td>".$data['categorias']."</td>";
                    echo "<td>". $data['ubicacion']."</td>";
                    echo "<td>".$data['stock']."</td>";
                    echo "<td>&#36;" . number_format($data['precio'], 2, '.', ',') . "</td>"; echo "</td>";
                    echo "<td>BS  " . number_format($data['cambio'], 2, ',', '.') . "</td>";
                    ?>

                      <form name="form<?=$chiguire?>" method="POST" action="../../../controladores/controladorcarrito.php">

                        <input type="hidden" name="id" value="<?= $data['id'] ?>">

                        <input type="hidden" name="operacion" value="agregar">
                        <?php
                        echo "<td>";
                        echo "<input type='number' min='1' max='".$data['stock']."' name='quantity' value='1' class='form-control' /></td>";
                        echo "<td><input  class='btn-lg btn-primary text-white' type='submit' value='Agregar'></td>";
                                                                                




                                                                                ?>
                    </form>

                    <?php


                    $chiguire++;
                  }

                  ?>
                </table>
              </div>
            </div>
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

<?php } else {
  ?>
  <script type="text/javascript">
    alert('Error al generar listado');
    window.location = '../home/home.php'
  </script>
  <?php
}
include('../footerbtn.php'); ?>