<?php
$nucleo = 'ventas';
$title = 'Cierre del d&iacute;a';

include '../../js/restric.php';

$sql7 = "SELECT pr.nombre,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
pe.quantity,
pe.modified,
u.correo, 
c.cedula,
c.nombre AS nombre_cliente,
u.nombre AS nombre_usuario,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) * pe.quantity AS subtotal,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) * " . $valor . " AS cambio 

FROM pedidos pe ,cliente c,producto pr,usuarios u 

WHERE pe.product_id=pr.id AND 
pe.cliente_id= c.id AND 
pe.estatus='facturado' AND 
pe.id_usuario=u.id AND pe.fecha= CURRENT_DATE";

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
                  <th class='textAlignLeft'>Nombre </th>
                  <th style='width:15em;'>Precio Unitario en $</th>
                  <th style='width:15em;'>Cantidad</th>
                  <th style='width:15em;'>Precio total en $</th>
                  <th style='width:15em;'>Precio Unitario en BS</th>
                  <th style='width:15em;'>Cliente</th>
                  <th style='width:15em;'>Vendedor@</th>

                  <?php 

                  $total = 0;
                  $valor_cambio_final = 0;

                  while ($pedido = mysqli_fetch_array($respuesta)) {

                    $cedula = $pedido['cedula'];

                    ?> 
                   <tr>
                    <td><div class='product-nombre'><?= $pedido['nombre'] ?></div></td>
                    <td><div class='product-nombre'><?= $pedido['precio_venta'] ?></div></td>
                    <td><div class='product-nombre'><?= $pedido['quantity'] ?></div> </td>
                    <td>&#36; <?=number_format($pedido['subtotal'], 2, '.', ',')?></td>
                    <td>BS    <?=number_format($pedido['cambio'], 2, '.', ',')?></td>
                    <td><div class='product-nombre'><?= $pedido['nombre_cliente'] ?> <br> <?= $pedido['cedula'] ?></div></td>
                    <td><div class='product-nombre'><?= $pedido['nombre_usuario'] ?> <br><?= $pedido['correo'] ?></div></td>
                  </tr>

                  <?php 

                    $total += $pedido['subtotal'];


                    $valor_cambio = $pedido['cambio'] * $pedido['quantity'];


                    $valor_cambio_final += $valor_cambio;

                  }
                 
                   $total_neto = $total;

                  ?>

                  <tr>
                    <td>Total $(USD):</td>
                    <td>$ <?=number_format($total_neto, 2, '.', ',')?></td>
                    <td></td>
                    <td>Total BS:<?=number_format($valor_cambio_final, 2, '.', ',')?></td>
                    <td><a href='pdf.php?cedula=<?=$cedula?>' class='btn btn-success'> <i class='fad fa-file-pdf'></i><span class='glyphicon glyphicon-shopping-cart'></span>Imprimir</a></td>
                   
                  </table>                 
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

include '../footerbtn.php';

?>