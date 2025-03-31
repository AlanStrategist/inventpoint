<?php

$nucleo = 'ventas';
$title = 'Historico de Ventas';

include('../../js/restric.php');


$lista = "SELECT DISTINCT pe.id AS id_pedidos,
 pr.nombre AS nombre_product,
 ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
 pe.quantity,
 pe.metodo,
 pe.modified,
 pe.factura,
c.cedula,
 ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) * pe.quantity AS subtotal,
 ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ) * " . $valor . " AS cambio,
 c.nombre AS nombre_cliente ,
 u.nombre AS nombre_usuario 
 
 
 FROM pedidos pe,producto pr,cliente c,usuarios u 
 
 WHERE pe.estatus='facturado' AND pe.cliente_id=c.id AND pe.product_id=pr.id AND pe.id_usuario=u.id";

$respuesta = mysqli_query($conex, $lista);
$pruebo = mysqli_num_rows($respuesta);


?>

<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Historico de Ventas</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table">

              <thead class="text-primary">
                <th> # Factura</th>
                <th>Nombre del producto</th>
                <th>Unit. Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Metodo</th>
                <th>Hora y Fecha</th>
                <th>Vendedor </th>
                <th>Cliente</th>

              </thead>

              <?php

              $total = 0;
              $cam_end=0;
              while ($data = mysqli_fetch_array($respuesta)) {

                $cedula = 0;

                echo "<tr>";
                echo "<td>FAC00".$data["factura"]."</td>";
                echo "<td>".$data['nombre_product']."</td>";
                echo "<td>USD : ".$data['precio_venta']." <br> BS : ". number_format($data['cambio'], 2, ',', '.') ." </td>";
                echo "<td>".$data['quantity']."</td>";
                echo "<td>USD " . number_format($data['subtotal'], 2, ',', '.') . "</td>";
                echo "<td>".$data['metodo']."</td>";
                echo "<td>".$data['modified']."</td>";
                echo "<td>".$data['nombre_usuario']."</td>";
                echo "<td>".$data['nombre_cliente']."<br> ".$data['cedula']."</td>";

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