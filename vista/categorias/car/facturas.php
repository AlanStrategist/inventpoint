<?php

$nucleo = 'ventas';
$title = 'Facturas';

include('../../js/restric.php');


$lista = "SELECT pe.id,pe.factura,pe.modified AS fecha FROM pedidos pe WHERE pe.estatus = 'facturado' GROUP BY pe.factura ORDER BY pe.factura";

$respuesta = mysqli_query($conex, $lista);
$pruebo = mysqli_num_rows($respuesta);

?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Facturas Emitidas</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table">

                            <thead class="text-primary">
                                <th> # Factura</th>
                                <th> Fecha de emisi&oacute;n</th>
                                <th> Ver detalles</th>
                            </thead>

                            <?php

                            while ($data = mysqli_fetch_array($respuesta)) {

                                $cedula = 0;

                                echo "<tr>";
                                echo "<td>FAC000".$data["factura"]."</td>";
                                echo "<td>".$data['fecha']. "</td>";
                                echo "<td> <a title='Ver detalles' href='../../../controladores/ControladorPedido.php?operacion=details&id=".$data['id']."'><i class='far fa-3x fa-eye'></i></a></td>";
                                
                            }

                            ?>
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