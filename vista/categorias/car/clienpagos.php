<?php
$nucleo = 'ventas';
$title = "Ventas sin culminar";

include('../../js/restric.php');

include('../../../modelos/ClassAlert.php');

extract($_REQUEST);

if( isset($alert) && $alert == "pedido"){ $al = new ClassAlert("Se ha realizado un pedido !<br>","Verifique los resultados y culmine la venta","primary"); }

else if( isset($alert) && $alert == "errorven"){ $al = new ClassAlert("Error al realizar la venta!<br>","Contacte al desarrollador","danger"); }

else if( isset($alert) && $alert == "deletevent"){ $al = new ClassAlert("Venta Removida!<br>","Se ha removido la venta, se repusieron los stocks necesarios","warning"); }

else if( isset($alert) && $alert == "donefac"){ $al = new ClassAlert("Pedido creado exitosamente!<br>","Verifique los resultados y culmine la venta","primary"); }

else if( isset($alert) && $alert == "culm"){ $al = new ClassAlert("No se ha realizado la venta!<br>","Existen a&uacute;n ventas sin culminar","warning"); }

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


if (!($valid > 0)) { ?>

  <br>
  <div class='alert alert-danger'>
  <strong>No hay ventas pendientes <i class='fad fa-smile'></i> </strong>
  </div>

<?php

}else{

  //start table
  ?>

  <div class="content">
    <div class="row">
      <div class="col-md-12">
      <?php if(isset($al)){ echo $al->Show_Alert(); } ?>
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
                  <th class="textAlignLeft">Remover</th>
                  
                </thead>

                <?php

                $total = 0;
                $total_bs = 0;
                $cedula = 0;
               
                while ($pedido = mysqli_fetch_array($respuesta)) {

                  $cedula = $pedido['cedula'];

                  ?>
                  <tr>
                  <td><div class='product-nombre'><?=$pedido['nombre']?></div></td>
                  <td> <div class='product-nombre'><?=$pedido['precio_venta']?></div></td>           
                  <td><div class='product-nombre'><?=$pedido['quantity']?></div></td>
                  <td>&#36;<?=number_format($pedido['subtotal'], 2, '.', ',')?></td>
                  <td>BS<?=number_format($pedido['cambio'], 2, '.', ',')?></td>         
                  <td><div class='product-nombre'><?=$pedido['nombre_cliente']?><br><?=$pedido['telefono']?></td>                 
                  <td><div class='product-nombre'>
                  <?php echo $pedido['metodo'] == 'Debito' ? 'D&eacute;bito': $pedido['metodo']; ?>
                  </td>
                  <td><a href='../../../controladores/ControladorPedido.php?operacion=borrar&id=<?=$pedido['id_pedidos']?>'><i title='Eliminar Item' class='fas fa-2x fa-times'></i></a> </td>
                  </tr>

                  <?php

                  $total += $pedido['subtotal'];
                  $valor_cambio = $pedido['cambio'] * $pedido['quantity'];
                  $total_bs += $valor_cambio;
                 } ?>
                
              </table>
                
                <table class="table">
                  <tr>
                    <td class="text-primary">
                      <strong>Total(USD) <?=number_format($total, 2, '.', ',')?>$</strong></td>
                    <td class="text-primary">
                      <strong>Total(BS) <?=number_format($total_bs, 2, '.', ',')?> BS</strong>
                    </td>
                  </tr>
                  <tr>                  
                   <td><a href='pdf.php?cedula=<?= $cedula ?>' class='btn btn-success'><i class='fad fa-file-pdf'></i>Imprimir</a></td>
                   <td><a href='../../../controladores/ControladorPedido.php?operacion=notificar' class='btn btn-info'><i class='fad fa-check-double'></i>Guardar venta</a></td>
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