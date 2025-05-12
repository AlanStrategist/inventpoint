<?php

$nucleo = 'ventas';
$title = 'Historico de Ventas';

include('../../js/restric.php');


$lista = "SELECT DISTINCT pe.id AS id_pedidos,
 pr.nombre AS nombre_product,
 pe.pay_price AS precio_venta,
 pe.quantity,
 pe.metodo,
 pe.modified,
 pe.factura,
 c.cedula,
 d.valor,
 pe.pay_price * pe.quantity AS subtotal,
 pe.pay_price * d.valor AS cambio,
 c.nombre AS nombre_cliente ,
 u.nombre AS nombre_usuario 
 
 
 FROM pedidos pe,producto pr,cliente c,usuarios u, dolar d
 
 WHERE pe.estatus='facturado' AND pe.cliente_id=c.id AND pe.product_id=pr.id AND pe.id_usuario=u.id AND d.id = pe.id_dolar";

$respuesta = mysqli_query($conex, $lista);
$pruebo = mysqli_num_rows($respuesta);


?>

<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Hist&oacute;rico de Ventas</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table">

              <thead class="text-primary">
                <th> # Recibo</th>
                <th>Nombre del producto</th>
                <th>Unit. Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Metodo</th>
                <th>Hora y Fecha</th>
                <th>Tasa del d&iacute;a</th>
                <th>Vendedor </th>
                <th>Cliente</th>

              </thead>

              <?php

              $total = 0;
              $cam_end=0;
              while ($data = mysqli_fetch_array($respuesta)) {

                $cedula = 0;

                ?>

                <tr>
                <td>REC000<?=$data["factura"]?></td>
                <td><?=$data['nombre_product']?></td>
                <td>USD : <?=$data['precio_venta']?> <br> BS : <?=number_format($data['cambio'], 2, ',', '.') ?></td>
                <td><?=$data['quantity']?></td>
                <td>USD<?=number_format($data['subtotal'], 2, ',', '.')?></td>
                <td><?=$data['metodo']?></td>
                <td><?=$data['modified']?></td>
                <td><?=$data['valor']?></td>
                <td><?=$data['nombre_usuario']?></td>
                <td><?=$data['nombre_cliente']?> <br> <?=$data['cedula']?></td>

                <?php

                $total += $data['subtotal'];
                $cam_end += $data['cambio'] * $data['quantity'];

              }  ?>
            
            </table>

            <table class="table">
            <tr>

               <td class="text-primary"><b>Total USD</b> <?=number_format($total, 2, '.', ',')?> </td>
               <td class="text-primary"><b>Total BS</b> <?=number_format($cam_end, 2, '.', ',')?> </td>
          
            </tr>

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