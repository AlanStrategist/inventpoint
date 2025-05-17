<?php

$nucleo = 'ventas';

$title = "Cr&eacute;dito";

include('../../js/restric.php');

include('../../../modelos/ClassAlert.php');

$id_factura = $_REQUEST['id_factura'];

$sql7 = "SELECT f.factura,
f.total,
c.amount,
c.metodo,
c.fecha
FROM credits c, facturas f
WHERE c.id_factura = '$id_factura' AND c.id_factura = f.id";

$respuesta = mysqli_query($conex, $sql7);
$valid = mysqli_num_rows($respuesta);

if (!($valid > 0)) { ?>

  <br>
  <div class='alert alert-danger'>
    <strong>No hay abonos en este cr&eacute;dito <i class='fad fa-smile'></i></strong>
  </div>

  <?php

} else {


    $pedidos = array();

  while ($data = mysqli_fetch_array($respuesta)) {

    $pedidos[] = $data;

  }
  //start table
  ?>

  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <?php if (isset($al)) {
          echo $al->Show_Alert();
        } ?>
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Detalles de abonos al crédito REC000<?=$pedidos[0]['factura']?></h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table">
                <thead class="text-primary">
                  <th class="textAlignLeft"># Recibo</th>
                  <th>Monto del abono</th>
                  <th>Metodo de Pago</th>
                  <th>Fecha</th>
                </thead>

                <?php

                $abonos = 0;                      

                foreach ($pedidos as $pedido) {
                    
                    $total_factura = $pedido['total'];
                    $abonos += $pedido['amount'];
                  ?>
                  <tr>
                    <td>
                      <div class='product-nombre'>REC000<?= $pedido['factura'] ?></div>
                    </td>
                    <td>
                      <div class='product-nombre'><?= $pedido['amount'] ?></div>
                    </td>
                    <td>
                      <div class='product-nombre'><?= $pedido['metodo'] ?></div>
                    </td>
                    <td>
                      <div class='product-nombre'><?= $pedido['fecha'] ?></div>
                    </td>
                  </tr>
                    

               <?php } ?>

              </table>

              <table class="table">
                <tr>
                  <td>
                    <div class='product-nombre'>Total Abonado</div>
                  </td>
                  <td>
                    <div class='text-success'>&#36;<?= number_format($abonos, 2, '.', ',') ?></div>
                  </td>     
                  <td>
                    <div class='product-nombre'>Total de Cr&eacute;dito</div>
                  </td>
                  <td>
                    <div class='text-danger'>&#36;<?= number_format($total_factura, 2, '.', ',') ?></div>
                  </td>            
                  <td>
                    <div class='product-nombre'>Total Pendiente</div>
                  </td>
                  <td>
                    <div class='text-danger'>&#36;<?= number_format($total_factura - $abonos, 2, '.', ',') ?></div>
                  </td>
                </tr>

              </table>

            <?php } ?>

            <script type="text/javascript">
              $(document).ready(function () {
                $('#example').DataTable();
              });
            </script>

            <?php
            include '../footerbtn.php'; ?>