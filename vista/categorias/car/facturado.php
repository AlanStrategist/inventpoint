<?php

$nucleo = 'ventas';
$title = 'Ventas Realizadas';

include('../../js/restric.php');


$lista = "SELECT DISTINCT pe.id AS id_pedidos,pr.nombre AS nombre_product,
 ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
 pe.quantity,pe.metodo, pe.modified,c.cedula,
 ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) * pe.quantity AS subtotal,
 ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ) * " . $valor . " AS cambio ,
 c.nombre AS nombre_cliente , u.nombre AS nombre_usuario 
 
 
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
          <h4 class="card-title">Ventas Realizadas</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table">

              <thead class="text-primary">

                <th>Nombre del producto</th>
                <th>Unit. Precio</th>
                <th>Cambio</th>
                <th>Cantidad</th>
                <th>Metodo</th>
                <th>Fecha</th>
                <th>Usuario del Vendedor </th>
                <th>Cliente</th>

              </thead>

              <?php

              while ($data = mysqli_fetch_array($respuesta)) {

                $cedula = 0;

                echo "<tr>";
                echo "<td>".$data['nombre_product']."</td>";
                echo "<td>".$data['precio_venta']."</td>";
                echo "<td>BS " . number_format($data['cambio'], 2, '.', ',') . "</td>";
                echo "<td>".$data['quantity']."</td>";
                echo "<td>".$data['metodo']."</td>";
                echo "<td>".$data['modified']."</td>";
                echo "<td>".$data['nombre_usuario']."</td>";
                echo "<td>".$data['nombre_cliente']."<br> ".$data['cedula']."</td>";

              }  ?>
            
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