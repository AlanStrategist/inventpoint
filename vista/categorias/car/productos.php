<?php
$nucleo = 'Ventas';
$title = 'Realizar una venta';

include('../../js/restric.php');
include ('../../../modelos/ClassAlert.php');

extract($_REQUEST);

if(isset($alert) && $alert == 'agregado'){ $al = new ClassAlert('Agregado con exito <br>',"Se ha agregado al carrito exitosamente","primary"); }

if(isset($alert) && $alert == 'modisi'){ $al = new ClassAlert('Modificacion Exitosa',"","warning"); }

$quero = "SELECT p.id,p.precio,p.stock,p.id_categorias,p.id_ubicacion,cart_menu.quantity,cart_menu.user_id,p.porcentaje,p.porcentaje * " . $valor . " AS cambio FROM producto p,cart_menu WHERE cart_menu.product_id=p.id AND p.stock > 0";
$response = mysqli_query($conex, $quero);


if (!$response)
  echo "Error en la carga";



// select products from database

$query = "SELECT p.id,p.cod_barra,p.nombre,p.precio,p.stock,p.id_categorias,p.id_ubicacion,p.porcentaje,p.porcentaje * " . $valor . " AS cambio FROM producto p WHERE p.stock > 0";

$respuesta = mysqli_query($conex, $query);
$pruebo = mysqli_num_rows($respuesta);

if ($respuesta) {


  ?>

  <body>

    <div class="content">
      <div class="row">
        <div class="col-md-12">

          <?php if(isset($al)){$al->Show_Alert();}?>

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
                  while ($data = mysqli_fetch_array($respuesta)) {


                    //obtenemos la ubicacion y la categoria ya que al parecer no se puede traer en una sola consulta
                    include('jorgereguero.php');
                    //fin de la broma
                


                    $cedula = 0;

                    echo "<tr>";
                    echo "<td>";



                    ?>     <?= $data['cod_barra'] ?>    <?php
                             echo "</td>";
                             echo "<td>";



                             ?>     <?= $data['nombre'] ?>    <?php
                                      echo "</td>";



                                      echo "<td>";
                                      ?>     <?= $categorias ?>    <?php
                                                echo "</td>";




                                                echo "<td>";
                                                ?>     <?= $ubicacion ?>    <?php
                                                         echo "</td>";






                                                         echo "<td>";
                                                         ?>    <?= $data['stock'] ?>    <?php
                                                                 echo "</td>";


                                                                 echo "<td>&#36;" . number_format($data['porcentaje'], 2, '.', ',') . "</td>";

                                                                 echo "</td>";





                                                                 echo "<td>BS  " . number_format($data['cambio'], 2, ',', '.') . "</td>";





                                                                 if (isset($data['quantity'])) {
                                                                   echo "<td>";

                                                                   echo "<input type='text' name='quantity' min='1' max='".$data['stock']."' value='" . $data['quantity'] . "' disabled class='form-control' />";

                                                                   echo "</td>";

                                                                   echo "<td>";
                                                                   echo "<button class='btn-lg btn-success text-white' disabled>";
                                                                   echo "<i class='far fa-2x fa-cart-arrow-down'></i><strong>¡Agregado!</strong>";
                                                                   echo "</button>";
                                                                   echo "</td>";




                                                                 } else {




                                                                   ?>

                      <form name="form<?= $chiguire ?>" method="POST" action="../../../controladores/controladorcarrito.php">

                        <input type="hidden" name="id" value="<?= $data['id'] ?>">

                        <input type="hidden" name="operacion" value="agregar">
                        <?php
                        echo "<td>";
                        echo "<input type='number' min='1' name='quantity' value='1' class='form-control' />";
                        echo "</td>";
                        echo "<td>";


                        echo "
                      
                      <input  class='btn-lg btn-primary text-white' type='submit' value='Agregar'>";

                        echo "</td>";
                                                                 }




                                                                 ?>
                    </form>

                    <!-- 
   <td><a title="Modificar" href=""><i class="fas fa-pen"> </i></a>
    
    </td>
 -->

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