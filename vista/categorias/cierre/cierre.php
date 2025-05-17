<?php
$nucleo = 'ventas';
$title = 'Cierre del d&iacute;a';

include '../../js/restric.php';

$sql7 = "SELECT pr.nombre,
pe.pay_price AS precio_venta,
pe.quantity,
f.date as modified,
f.factura,
u.correo, 
c.cedula,
c.nombre AS nombre_cliente,
u.nombre AS nombre_usuario,
pe.pay_price * pe.quantity AS subtotal,
pe.pay_price * d.valor AS cambio 

FROM pedidos pe ,cliente c,producto pr,usuarios u , dolar d, facturas f

WHERE pe.product_id=pr.id AND 
f.id_cliente= c.id AND 
f.estatus='Facturado' AND 
f.id_usuarios=u.id AND 
f.id_dolar=d.id AND 
DATE(f.date)=CURRENT_DATE AND
pe.id_facturas=f.id";

$respuesta = mysqli_query($conex, $sql7);
$agarro = mysqli_num_rows($respuesta);

if ($agarro > 0) {

  //start table
  ?>

  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Ventas del Dia</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table">

                <thead class="text-primary">
                  <th>Nombre</th>
                  <th>Precio Unitario en $</th>
                  <th >Cantidad</th>
                  <th >Precio total en $</th>
                  <th >Precio Unitario en BS</th>
                  <th >Cliente</th>
                  <th >Vendedor@</th>
                </thead>
                  <?php

                  $total = 0;
                  $valor_cambio_final = 0;

                  while ($pedido = mysqli_fetch_array($respuesta)) {

                    $cedula = $pedido['cedula'];

                    ?>
                    <tr>
                      <td>
                        <div class='product-nombre'><?= $pedido['nombre'] ?></div>
                      </td>
                      <td>
                        <div class='product-nombre'><?= $pedido['precio_venta'] ?></div>
                      </td>
                      <td>
                        <div class='product-nombre'><?= $pedido['quantity'] ?></div>
                      </td>
                      <td>&#36; <?= number_format($pedido['subtotal'], 2, '.', ',') ?></td>
                      <td>BS <?= number_format($pedido['cambio'], 2, '.', ',') ?></td>
                      <td>
                        <div class='product-nombre'><?= $pedido['nombre_cliente'] ?> <br> <?= $pedido['cedula'] ?></div>
                      </td>
                      <td>
                        <div class='product-nombre'><?= $pedido['nombre_usuario'] ?> <br><?= $pedido['correo'] ?></div>
                      </td>
                    </tr>

                    <?php

                    $total += $pedido['subtotal'];


                    $valor_cambio = $pedido['cambio'] * $pedido['quantity'];


                    $valor_cambio_final += $valor_cambio;

                  }

                  $total_neto = $total;

                  ?>

                  </table>
                  
                  <table class="table">                 
                    <tr>
                    <td class="text-success">Total $(USD): <b><?= number_format($total_neto, 2, '.', ',')?></b></td>
                    <td></td>
                    <td class="text-success">Total BS: <b><?= number_format($valor_cambio_final, 2, '.', ',')?></b></td>
                    <td><a href='pdf.php?cedula=<?= $cedula ?>' class='btn btn-success'> <i
                          class='fad fa-file-pdf'></i><span class='glyphicon glyphicon-shopping-cart'></span>Imprimir</a></td>
                   </tr>
                  </table>


              
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
} else {

  echo "<br>";
  echo "<div class='alert alert-danger'>";
  echo "<strong>No hay ventas el dia de hoy</strong>";
  echo "</div>";
}
?>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#example').DataTable();
    });
  </script>

  <?php
  include '../footerbtn.php';

  ?>