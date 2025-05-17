<?php

$nucleo = 'ventas';
$title = 'Facturas';

include('../../js/restric.php');

try{

$lista = "SELECT f.id,f.factura,f.total, MAX(f.date) AS fecha FROM facturas f WHERE f.estatus = 'Facturado' GROUP BY f.factura ORDER BY f.factura";

$respuesta = mysqli_query($conex, $lista);
$pruebo = mysqli_num_rows($respuesta);

if($pruebo == 0){
    
    throw new Exception("No hay recibos emitidos");
}


}catch (Exception $e) {
    
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
                    <h4 class="card-title">Recibos Emitidos</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table">

                            <thead class="text-primary">
                                <th> # Recibo</th>
                                <th> Fecha de emisi&oacute;n</th>
                                <th> Total</th>
                                <th> Ver detalles</th>
                            </thead>

                            <?php

                            $total = 0;

                            while ($data = mysqli_fetch_array($respuesta)) {                           
                                
                                $total += $data['total'];
                                ?>

                                <tr>
                                <td>REC000<?=$data["factura"]?></td>
                                <td><?=$data['fecha']?></td>
                                <td><?=$data['total']?></td> 
                                <td><a title='Ver detalles' href='../../../controladores/ControladorPedido.php?operacion=details&fac=<?=$data['factura']?>&id=<?=$data['id']?>'><i class='far fa-3x fa-eye'></i></a></td>
                                
                                <?php
                            }

                            ?>
                       </table>

                       <table class="table">                         
                            <tr>
                                <td class="text-success">Total Facturado:&#36;<?=$total?></td> 
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