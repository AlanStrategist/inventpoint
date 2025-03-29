<?php
$nucleo = 'ventas';
$title = "Ventas sin culminar";

include('../../js/restric.php');


$sql7 = "SELECT DISTINCT pe.id AS id_pedidos,
 pr.nombre,
 ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
 pe.quantity,
 pe.metodo,
 c.cedula,
 c.telefono,
 c.nombre AS nombre_cliente,
 ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) * pe.quantity AS subtotal,
 ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) * " . $valor . " AS cambio 
 
 FROM pedidos pe,producto pr,cliente c 
 
 WHERE pe.estatus='pago' AND pe.cliente_id=c.id AND pe.product_id=pr.id";


$respuesta = mysqli_query($conex, $sql7);
$valid = mysqli_num_rows($respuesta);


if ($valid > 0) {

  //start table
  ?>

  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Ventas sin culminar</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table">



                <thead class="text-primary">


                  <th class="textAlignLeft">Nombre del producto</th>

                  <th class="textAlignLeft">Precio unitario</th>

                  <th class="textAlignLeft">Cantidad</th>

                  <th class="textAlignLeft">Precio Total en $</th>

                  <th class="textAlignLeft">Precio unitario en Bs</th>

                  <th class="textAlignLeft">Cliente</th>

                  <th class="textAlignLeft">Método de Pago</th>


                </thead>




                <?php

                $total = 0;
                $total_bs = 0;
                $cedula = 0;
                while ($pedido = mysqli_fetch_array($respuesta)) {

                  $cedula = $pedido['cedula'];


                  echo "<tr>";
                  echo "<td>";



                  ?>
                  <div class='product-nombre'>
                    <?= $pedido['nombre'] ?>
                  </div><?php
                  echo "</td>";
                  echo "<td>";
                  ?>
                  <div class='product-nombre'><?= $pedido['precio_venta'] ?></div> <?php
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
                  $total_bs += $valor_cambio;
                  echo "<td>";

                  ?>
                  <div class='product-nombre'><?= $pedido['nombre_cliente'] ?>     <?= $pedido['telefono'] ?></div><?php
                       echo "</td>";


                       echo "<td>";

                       ?>
                  <div class='product-nombre'><?php

                  if ($pedido['metodo'] == 'Debito') {
                    ?> Débito <?php
                  } else {
                    echo $pedido['metodo'];
                  } ?> </div><?php


                    echo "</td>";


                    echo "<td>";


                    ?> <a
                    href="../../../controladores/controladorpedido.php?operacion=borrar&id=<?= $pedido['id_pedidos'] ?>"><i
                      title="Eliminar Venta" class="fas fa-times"></i></a>
                  <?php


                  echo "</td>";

                  echo "</tr>";
                }




                echo "</table>";


                ?>
                <table class="table">
                  <tr>
                    <td></td>
                    <td class="text-primary"><strong> Total Cancelado</strong></td>
                  </tr>
                  <?php





                  echo "<tr>";
                  echo "<td>USD " . number_format($total, 2, '.', ',') . "</td>";
                  echo "<td>BS " . number_format($total_bs, 2, '.', ',') . "</td>";
                  echo "</tr>";
                  echo "<tr>";
                  echo "<td>";
                  echo "<td>";
                  ?> <a href='pdf.php?cedula=<?= $cedula ?>' class='btn btn-success'>
                    <?php






                    echo "<i class='fad fa-file-pdf'></i>Imprimir";
                    echo "</a>";

                    echo "</a>";
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='../../../controladores/controladorpedido.php?operacion=notificarad' class='btn btn-info'>";
                    echo "<i class='fad fa-check-double'></i>Guardar venta";
                    echo "</td>";
                    echo "</tr>";

                    echo "</table>";
} else {

  echo "<br>";
  echo "<div class='alert alert-danger'>";
  echo "<strong>No hay ventas que mostrar <i class='fad fa-sad-tear'></i> </strong>";
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