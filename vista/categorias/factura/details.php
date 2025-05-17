<?php

$nucleo = 'ventas';
$title = 'Ventas Realizadas';

include('../../js/restric.php');

extract($_REQUEST);

try{

$lista = "SELECT DISTINCT f.id AS id_facturas,
f.factura,
pr.nombre AS nombre_product,
pe.pay_price AS precio_venta,
pe.quantity,
f.metodo,
f.date AS modified,
c.cedula,
c.nombre AS nombre_cliente,
pe.pay_price * pe.quantity AS subtotal,
pe.pay_price * d.valor AS cambio ,
u.nombre AS nombre_usuario,
d.valor as dolar 
FROM facturas f,dolar d,pedidos pe,producto pr,cliente c,usuarios u 
WHERE pe.id_facturas = f.id AND 
f.factura=$fac AND
f.id_cliente=c.id AND
pe.product_id= pr.id AND
f.id_usuarios = u.id AND
f.id_dolar = d.id;";
 

$respuesta = mysqli_query($conex, $lista);
$pruebo = mysqli_num_rows($respuesta);

}catch (mysqli_sql_exception | Exception $e) {
    
   ?>

  <script>

    window.location = "../home/home.php?alert=noreci";

  </script>

  <?php
}
?>

<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Detalles de Recibo</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table">

              <thead class="text-primary">

                <th># de Recibo</th>
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
              
              $total = 0;
              $totalBS = 0;
              $metodo = "";              
              while ($data = mysqli_fetch_array($respuesta)) {

                $cedula = 0;

                echo "<tr>";
                echo "<td>REC000".$data['factura']."</td>";
                echo "<td>".$data['nombre_product']."</td>";
                echo "<td>".$data['precio_venta']."</td>";
                echo "<td>BS " . number_format($data['cambio'], 2, '.', ',') . "</td>";
                echo "<td>".$data['quantity']."</td>";
                echo "<td>".$data['metodo']."</td>";
                echo "<td>".$data['modified']."</td>";
                echo "<td>".$data['nombre_usuario']."</td>";
                echo "<td>".$data['nombre_cliente']."<br> ".$data['cedula']."</td>";
                echo "</tr>";

                $total += $data["subtotal"];
                $totalBS += $data['cambio'] * $data['quantity'];
                $metodo = $data['metodo'];
             
              }  ?>
            
            </table>

            <table class="table">
                <tr>
                <td class="text-primary"><b>Total BS</b>  <?=number_format($totalBS, 2, '.', ',')?></td>
                <td class="text-primary"><b>Total</b> USD <?=number_format($total, 2, '.', ',')?></td>
            
            </table>

            <?php
            if( $metodo == "Abonos"){

              $abonos = "SELECT * FROM credits WHERE id_factura = $id";
              $respuestaAbonos = mysqli_query($conex, $abonos);            
              ?>
              <h4 class="card-title">Detalles de Abonos</h4>
              <table class="table">
                <thead class="text-primary">
                  <th>Fecha</th>
                  <th>Metodo</th>
                  <th>Monto</th>
                </thead>
                <?php
                while ($dataAbonos = mysqli_fetch_array($respuestaAbonos)) {

                  ?>
                  <tr>
                  <td><?=$dataAbonos['fecha']?></td> 
                  <td><?=$dataAbonos['metodo']?></td>                               
                  <td>USD <?=number_format($dataAbonos['amount'], 2, '.', ',')?></td>
                  </tr>

                  <?php
                 
                }
                ?>
              </table>            
          <?php  }

            ?>

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