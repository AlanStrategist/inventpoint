<?php
$nucleo = 'ventas';
$title = "Cr&eacute;dito";

include('../../js/restric.php');

include('../../../modelos/ClassAlert.php');

extract($_REQUEST);

if (isset($alert) && $alert == "save") {
  $al = new ClassAlert("Se ha almacenado el abono correctamente!<br>", "Verifique los resultados y culmine la venta", "primary");
} else if (isset($alert) && $alert == "error") {
  $al = new ClassAlert("Error al registrar el abono!<br>", "Contacte al desarrollador", "danger");

} else if (isset($alert) && $alert == "Pagado") {
  $al = new ClassAlert("Pago exitoso!<br>", "El recibo al que se le acaba de abonar ha sido pagado en su totalidad, aparecera en la vista de recibos", "warning");

}

$sql7 = "SELECT DISTINCT f.id AS id_factura,
f.factura,
f.total,
cl.nombre

FROM facturas f ,cliente cl 
WHERE f.estatus='Credito' 
AND f.id_cliente = cl.id";

$respuesta = mysqli_query($conex, $sql7);
$valid = mysqli_num_rows($respuesta);

if (!($valid > 0)) { ?>

  <br>
  <div class='alert alert-danger'>
    <strong>No hay créditos pendientes <i class='fad fa-smile'></i> </strong>
  </div>

  <?php

} else {

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
            <h4 class="card-title">Créditos</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table">
                <thead class="text-primary">
                  <th class="textAlignLeft"># Recibo</th>
                  <th class="textAlignLeft">Cliente</th>
                  <th class="textAlignLeft">Monto Total</th>
                  <th class="textAlignLeft">Monto Abonado</th>
                  <th class="textAlignLeft">Monto Pendiente</th>
                  <th class="textAlignLeft">Metodo de Pago</th>
                  <th class="textAlignLeft">Monto a Abonar</th>                 
                  <th class="textAlignLeft">Abonar</th>
                </thead>

                <?php

                $abonos = 0;
                $totales = 0;
                $pendientes = 0;

                foreach ($pedidos as $pedido) {

                  ?>
                  <tr>
                    <td>
                      <div class='product-nombre'>REC000<?= $pedido['factura'] ?></div>
                    </td>
                    <td>
                      <div class='product-nombre'><?= $pedido['nombre'] ?></div>
                    </td>
                    <td>
                      <div class='product-nombre'><?= $pedido['total'] ?></div>
                    </td>

                    <?php

                    $sql_ab = "SELECT SUM(c.amount) AS monto FROM credits c GROUP BY c.id_factura HAVING c.id_factura = '" . $pedido['id_factura'] . "'";
                    $res_ab = mysqli_query($conex, $sql_ab);
                    $ab = mysqli_fetch_array($res_ab);

                    if ($ab) {
                      $abono = $ab['monto'];
                    } else {
                      $abono = 0;
                    }

                    ?>
                    <td>&#36;<?= number_format($abono, 2, '.', ',') ?></td>
                    <td>&#36;<?= number_format(($pedido['total'] - $abono), 2, '.', ',') ?></td>

                    <form name="form1" method="post" action="../../../controladores/ControladorCredito.php">

                      <input type="hidden" name="id_factura" value="<?= $pedido['id_factura'] ?>">                   
                      <input type="hidden" name="monto" value="<?= ($pedido['total'] - $abono) ?>">
                      <input type="hidden" name="operacion" value="abonar">
                      
                      <div class="form-group">

                        <td><select name="metodo" class="form-control" id="metodo">
                          <option value="Efectivo">Efectivo BS</option>
                          <option value="Debito">Débito</option>
                          <option value="Divisa">Divisa</option>
                          <option value="Transferencia">Transferencia</option>
                        </select></td>

                        <td><input type="number" class="form-control" name="abono" placeholder="<?= ($pedido['total'] - $abono) ?>" max="<?= $pedido['total'] - $abono ?>" required>
                        </td>
                        <td><input type="submit" class="btn btn-primary" value="Abonar"></td>
                      </div>

                    </form>
                  </tr>

                  <?php

                  $abonos += $abono;
                  $totales += $pedido['total'];
                  $pendientes += ($pedido['total'] - $abono);

                } ?>

              </table>

              <table class="table">
                <tr>
                  <td><div class='product-nombre'>Total Abonado</div></td>
                  <td>
                    <div class='text-success'>&#36;<?= number_format($abonos, 2, '.', ',') ?></div>
                  </td>
                  <td>
                    <div class='product-nombre'>Total Adeudado</div>
                  </td>
                  <td>
                    <div class='text-danger'>&#36;<?= number_format($totales, 2, '.', ',') ?></div>
                  </td>
                  <td>
                    <div class='product-nombre'>Total Pendiente</div>
                  </td>
                  <td>
                    <div class='text-danger'>&#36;<?= number_format($pendientes, 2, '.', ',') ?></div>
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