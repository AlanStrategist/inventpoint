<?php
$nucleo = 'ventas';
$title = 'Cierre del d&iacute;a';

include '../../js/restric.php';

try {

  $sql7 = "SELECT pr.nombre,
pe.pay_price AS precio_venta,
pe.quantity,
f.id AS id_factura,
f.date as modified,
f.metodo,
f.estatus,
f.factura,
f.fecha_credi,
u.correo, 
c.cedula,
c.nombre AS nombre_cliente,
u.nombre AS nombre_usuario,
d.valor,
pe.pay_price * pe.quantity AS subtotal,
pe.pay_price * d.valor AS cambio 

FROM pedidos pe ,cliente c,producto pr,usuarios u , dolar d, facturas f

WHERE pe.product_id=pr.id AND 
f.id_cliente= c.id AND  
f.id_usuarios=u.id AND 
f.id_dolar=d.id AND 
DATE(f.date)=CURRENT_DATE AND
pe.id_facturas=f.id";

  $respuesta = mysqli_query($conex, $sql7);
  $agarro = mysqli_num_rows($respuesta);

  if ($agarro <= 0) {

    throw new Exception("No hay ventas registradas para el d&iacute;a de hoy.");

  }

  $pedidos = array();

  while ($data = mysqli_fetch_array($respuesta)) {

    $pedidos[] = $data;
  }

  $sql_ab = "SELECT c.amount,c.metodo,c.fecha,f.factura FROM credits c , facturas f WHERE date(fecha) = CURRENT_DATE AND c.id_factura = f.id";

  $res_ab = mysqli_query($conex, $sql_ab);

  while ($data_ab = mysqli_fetch_array($res_ab)) {

    $abonos[] = $data_ab;

  }

} catch (Exception $e) {

  ?>

  <script>
    alert("Error en la consulta: <?= $e->getMessage() ?>");
    window.location = '../home.php?alert=error';
  </script>

  <?php


} finally {

  mysqli_close($conex);

}
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
                <th># Recibo</th>
                <th>Producto</th>
                <th>Precio Unitario en $</th>
                <th>Cantidad</th>
                <th>Precio total en $</th>
                <th>Precio Unitario en BS</th>
                <th>M&eacute;todo</th>
                <th>Cliente</th>
                <th>Vendedor@</th>
              </thead>
              <?php

              #net amount in sells
              $total = 0;
              $valor_cambio_final = 0;
              $d_valor = 0;
              foreach ($pedidos as $pedido) {

                $d_valor = $pedido['valor'];
                
                if ($pedido['estatus'] != 'Facturado') {

                  continue;

                }

                ?>
                <tr>
                  <td>
                    <div class='product-nombre'>REC000<?= $pedido['factura'] ?></div>
                  </td>
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
                    <div class='product-nombre'><?= $pedido['metodo'] ?></div>
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
                <td class="text-success">Total $(USD): <b><?= number_format($total_neto, 2, '.', ',') ?></b></td>
                <td></td>
                <td class="text-success">Total BS: <b><?= number_format($valor_cambio_final, 2, '.', ',') ?></b></td>
              </tr>
            </table>

            <!-- Net amount in credits-->

            <h4 class="card-title">Créditos</h4>
            <table class="table" id="pays">
              <thead class="text-primary">
                <th># Recibo</th>
                <th>Producto</th>
                <th>Precio Unitario en $</th>
                <th>Cantidad</th>
                <th>Precio total en $</th>
                <th>Precio Unitario en BS</th>
                <th> Fecha prometida</th>
                <th>Cliente</th>
                <th>Vendedor@</th>
              </thead>
              <?php

              $net_credi = 0;            
              foreach ($pedidos as $d) {

                if ($d['estatus'] != 'Credito') {

                  continue;

                }

                $net_credi += $d['subtotal'];
                

                ?>
                <tr>
                  <td>
                    <div class='product-nombre'>REC000<?= $d['factura'] ?></div>
                  </td>
                  <td>
                    <div class='product-nombre'><?= $d['nombre'] ?></div>
                  <td>
                    <div class='product-nombre'><?= $d['precio_venta'] ?></div>
                  </td>
                  <td>
                    <div class='product-nombre'><?= $d['quantity'] ?></div>
                  </td>
                  <td>&#36; <?= number_format($d['subtotal'], 2, '.', ',') ?></td>
                  <td>BS <?= number_format($d['cambio'], 2, '.', ',') ?></td>
                  <td>
                    <div class='product-nombre'><?= $d['fecha_credi'] ?></div>
                  <td>
                    <div class='product-nombre'><?= $d['nombre_cliente'] ?> <br> <?= $d['cedula'] ?></div>
                  </td>
                  <td>
                    <div class='product-nombre'><?= $d['nombre_usuario'] ?> <br><?= $d['correo'] ?></div>
                  </td>
                </tr>

              <?php } ?>
            </table>
            <table class="table">
              <tr>
                <td class="text-danger">Total $(USD): <b><?= number_format($net_credi, 2, '.', ',') ?></b></td>
                <td></td>
                <td class="text-danger">Total BS: <b><?= number_format($net_credi * $d_valor, 2, '.', ',') ?></b></td>
              </tr>
            </table>

            <!-- Net amount in pays of credits-->
            <h4 class="card-title">Abonos</h4>
            <table class="table" id="abonos">
              <thead class="text-primary">
                <th># Recibo</th>
                <th>Método</th>             
                <th>Abono en $</th>
              </thead>
              <?php

              $net_abonos = 0;

              foreach ($abonos as $ab) {
                $net_abonos += $ab['amount'];
                ?>
                <tr>
                  <td>
                    <div class='product-nombre'>REC000<?=$ab['factura'] ?></div>
                  </td>
                  <td>
                    <div class='product-nombre'><?= $ab['metodo'] ?></div>
                  </td>                
                  <td>&#36; <?= number_format($ab['amount'], 2, '.', ',') ?></td>
                </tr>

              <?php } ?>
              </table>
              <table class="table">
                <tr>
                  <td class="text-success">Total $(USD): <b><?= number_format($net_abonos, 2, '.', ',') ?></b></td>
                  <td></td>
                  <td class="text-success">Total BS: <b><?= number_format($net_abonos * $d_valor, 2, '.', ',') ?></b></td>
                  <td><a href='pdf.php?cedula=254528' class='btn btn-success'> <i class='fad fa-file-pdf'></i><span class='glyphicon glyphicon-shopping-cart'></span>Imprimir</a></td>
                </tr>
              </table>          
        
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  ?>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#example').DataTable();
      $('#pays').DataTable();
      $('#abonos').DataTable();
    });
  </script>

  <?php
  include '../footerbtn.php';

  ?>