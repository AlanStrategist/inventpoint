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
                  <?php

                  // our table heading
                  echo "<tr>";
                  echo "<th class='textAlignLeft'>Nombre </th>";

                  echo "<th style='width:15em;'>Precio Unitario en $</th>";

                  echo "<th style='width:15em;'>Cantidad</th>";
                  echo "<th style='width:15em;'>Precio total en $</th>";
                  echo "<th style='width:15em;'>Precio Unitario en BS</th>";
                  echo "<th style='width:15em;'>Cliente</th>";
                  echo "<th style='width:15em;'>Vendedor@</th>";

                  echo "</tr>";
                  $total = 0;
                  $valor_cambio_final = 0;
                  while ($pedido = mysqli_fetch_array($respuesta)) {

                    $cedula = 0;
                    $cedula = $pedido['cedula'];

                    echo "<tr>";
                    echo "<td>";



                    ?>
                    <div class='product-nombre'><?= $pedido['nombre'] ?></div><?php
                    echo "</td>";
                    echo "<td>";
                    ?>
                    <div class='product-nombre'><?= $pedido['precio_venta'] ?></div><?php
                    echo "</td>";







                    echo "<td>";
                    ?>
                    <div class='product-nombre'><?= $pedido['quantity'] ?></div><?php
                    echo "</td>";

                    echo "<td>&#36;" . number_format($pedido['subtotal'], 2, '.', ',') . "</td>";

                    echo "</td>";
                    echo "<td>BS " . number_format($pedido['cambio'], 2, '.', ',') . "</td>";

                    $total += $pedido['subtotal'];


                    $valor_cambio = $pedido['cambio'] * $pedido['quantity'];


                    $valor_cambio_final += $valor_cambio;

                    echo "<td>";

                    ?>
                    <div class='product-nombre'><?= $pedido['nombre_cliente'] ?> <br><?= $pedido['cedula'] ?></div><?php
                     echo "</td>";




                     echo "<td>";

                     ?>
                    <div class='product-nombre'><?= $pedido['nombre_usuario'] ?> <br><?= $pedido['correo'] ?></div><?php
                     echo "</td>";
                     echo "</tr>";
                  }
                  //$porcentaje = 5 * $total / 100;

                  $total_neto = $total;


                  echo "<tr>";
                 // echo "<td>";
                 // echo "SubTotal:";
                 // echo "</td>";
                 //echo "<td>$" . number_format($total, 2, '.', ',') . "</td>";
                 
                 // echo "<td>";
                 // echo "Porcentaje Alexis José Romero:";
                 // echo "</td>";
                //echo "<td>$" . number_format($porcentaje, 2, '.', ',') . "</td>";



                  echo "<td>";
                  echo "Total $(USD):";
                  echo "</td>";
                  echo "<td>$" . number_format($total_neto, 2, '.', ',') . "</td>";
                  echo "<td>";
                  echo "</td>";


                  $porcentaje_bol = 5 * $valor_cambio_final / 100;

                  $total_neto_bol = $valor_cambio_final - $porcentaje_bol;


                  echo "<tr>";
                 // echo "<td>Subtotal BS " . number_format($valor_cambio_final, 2, '.', ',') . "</td>";
                 
                 // echo "<td>";
                 // echo "Porcentaje Alexis José Romero: BS  " . number_format($porcentaje_bol, 2, '.', ',') . "</td>";



                  echo "<td>";
                  echo "Total BS:" . number_format($total_neto_bol, 2, '.', ',') . "</td>";
                  echo "<td>";








                  ?> <a href='pdf.php?cedula=<?= $cedula ?>' class='btn btn-success'> <?php






                   echo "<i class='fad fa-file-pdf'></i><span class='glyphicon glyphicon-shopping-cart'></span> Imprimir";
                   echo "</a>";

                   echo "</a>";
                   echo "</td>";

                   echo "</tr>";
                   echo "</table>";
                   ?>

            </div>
          </div>
        </div>
      </div>
      <?php


} else {

  echo "<br>";
  echo "<div class='alert alert-danger'>";
  echo "<strong>No hay pagos realizado</strong>";
  echo "</div>";
}

include '../footerbtn.php';

?>