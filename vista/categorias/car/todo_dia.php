<?php
$nucleo = 'ventas';
$title = "Cr&eacute;ditos";
include('../../js/restric.php');


$sql7 = "SELECT DISTINCT pe.id,
pe.factura,
pe.fecha,
pe.fecha_credi,
pr.nombre,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ,2) * " . $valor . " AS cambio,
pe.quantity,
pe.metodo,
c.cedula,
c.telefono,
c.nombre AS nombre_cliente,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) * pe.quantity AS subtotal

FROM pedidos pe,producto pr,cliente c 

WHERE pe.metodo='credito' AND pe.cliente_id=c.id AND pe.product_id=pr.id";

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
            <h4 class="card-title">Creditos totales</h4>
            <p>*Los que tienen el campo "fecha del crédito" en <strong>negrita</strong> es porque se deben pagar hoy.</p>

          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table">



                <thead class="text-primary">

                  <th class="textAlignLeft"># Recibo</th>

                  <th class="textAlignLeft">Nombre del producto</th>

                  <th class="textAlignLeft">Precio unitario</th>

                  <th class="textAlignLeft">Precio unitario en Bs</th>

                  <th class="textAlignLeft">Cantidad</th>

                  <th class="textAlignLeft">Precio Total</th>

                  <th class="textAlignLeft">Comprador</th>

                  <th class="textAlignLeft">Método de Pago</th>

                  <th class="textAlignLeft">Fecha del crédito </th>

                  <th class="textAlignLeft">Fecha a Cancelar </th>

                  <th class="textAlignLeft">Pagar crédito</th>

                </thead>

                <?php

                $total = 0;
                $total_bs = 0;
                $fac = 0;
                while ($pedido = mysqli_fetch_array($respuesta)) {

                  $cedula = 0;
                  $cedula = $pedido['cedula'];
                  $fac = $pedido['factura'];
                  $total += $pedido['subtotal'];
                  $valor_cambio = $pedido['cambio'] * $pedido['quantity'];
                  $total_bs += $valor_cambio;

                  ?>

                  <tr>
                    <td>REC000<?= $pedido['factura'] ?></td>
                    <td><?= $pedido['nombre'] ?></td>
                    <td>&#36;<?= number_format($pedido['precio_venta'], 2, '.', ',') ?></td>
                    </td>
                    <td>BS <?= number_format($pedido['cambio'], 2, '.', ',') ?></td>
                    <td><?= $pedido['quantity'] ?></td>
                    <td>&#36;<?= number_format($pedido['subtotal'], 2, '.', ',') ?></td>
                    </td>
                    <td><?= $pedido['nombre_cliente'] . "<br>" . $pedido['telefono'] ?></td>
                    <td>Crédito</td>
                    <td><?= $pedido['fecha'] ?></td>
                    <td>
                      <?= $pedido['fecha_credi'] == $hoy ? "<strong>" . $pedido['fecha_credi'] . "</strong>" : $pedido['fecha_credi'] ?>
                    </td>
                    <td><a title="Registrar pago de este crédito" data-toggle="modal" data-target="#exampleModalcliente"><i
                          class="fas fa-coins"> </i></a>

                      <div class="modal fade" id="exampleModalcliente" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">

                              <div class="modal-body">
                                <form name="formpavo" method='POST' action='../../../controladores/ControladorPedido.php'>
                                  <h5 class="modal-title text-info" id="exampleModalLabel">Tipo de Pago <i
                                      class="fad  fa-coins"></i></h5>
                                  <select name="metodo" class="form-control" id="metodo">
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Debito">Débito</option>
                                    <option value="Divisa">Divisa</option>
                                    <option value="Transferencia">Transferencia</option>
                                  </select>
                                  <div class="modal-footer">
                                    <input type="hidden" name="operacion" value="aprobar">
                                    <input type="hidden" name="factura" value="<?= $pedido['factura'] ?>">
                                    <input class="btn btn-sm btn-success text-white" type="submit" value="Registrar Compra">

                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>                     
                    </td>
                  </tr>
                <?php  } ?>

              </table>

<?php } else {

  ?>

  <br>
  <div class='alert alert-danger'>
  <strong>No hay creditos que mostrar <i class='fad fa-sad-tear'></i> </strong>
  </div>

  <?php } ?>
                    <script type="text/javascript">
                      $(document).ready(function () {
                        $('#example').DataTable();
                      });
                    </script>
                    <?php
                    include '../footerbtn.php';

                    ?>