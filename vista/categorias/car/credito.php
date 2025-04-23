<?php

$nucleo = 'ventas';
$title = 'Creditos';
include('../../js/restric.php');

try {

  $sql7 = "SELECT DISTINCT pe.id,
 pr.nombre,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta ,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) * " . $valor . " AS cambio,
pe.quantity, 
pe.metodo,
c.cedula,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100)* pe.quantity,2) AS subtotal 
  
FROM pedidos pe,producto pr ,cliente c 

WHERE pe.metodo='credito' AND 
pe.cliente_id=c.id AND 
pe.product_id=pr.id AND 
pe.fecha_credi= CURRENT_DATE";


  $respuesta = mysqli_query($conex, $sql7);

  $valid = mysqli_num_rows($respuesta);

  if ($valid == 0) {
      
  ?>
    
   <script>

    window.location = "../home/home.php?alert=error";

   </script>
  
  <?php

  }else{

    while ($row = mysqli_fetch_array($respuesta)) { $pedidos[] = $row; }

  }

} catch (mysqli_sql_exception | Exception $e) {

  header("Location: ../home/home.php?alert=error");

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
          <h4 class="card-title">Creditos del Día</h4>
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
                <th>Cédula-RIF</th>
                <th class="textAlignLeft">Método de Pago</th>
              </thead>
              <?php

              $total = 0;
              $total_bs = 0;
              foreach( $pedidos as $pedido ) {

                $cedula = 0;
                $cedula = $pedido['cedula'];

              
                
              ?>

                <tr>
                 <td><div class='product-nombre'><?=$pedido['nombre']?></div></td>
                 <td><div class='product-nombre'><?=$pedido['precio_venta']?></div></td>
                 <td><div class='product-nombre'><?=$pedido['quantity'] ?></div></td>
                 <td>&#36; <?=number_format($pedido['subtotal'], 2, '.', ',')?></td>
                 </td>
                 <td><div class='product-modified'><?= $pedido['cambio']?></div></td>                
                 <td><div class='product-nombre'><?= $pedido['cedula'] ?></div></td>
                 <td><div class='product-nombre'><?= $pedido['metodo'] ?></div></td>
                 <td><a title="Modificar" data-toggle="modal" data-target="#exampleModalcliente"><i class="fas fa-pen"></i></a>
                
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
                              <option value="Débito">Débito</option>
                              <option value="Divisa">Divisa</option>
                              <option value="Transferencia">Transferencia</option>

                            </select>
                            <div class="modal-footer">
                              <input type="hidden" name="operacion" value="aprobar">
                              <input type="text" name="id" value="<?=$pedido['id']?>">
                              <input class="btn btn-sm btn-success text-white" type="submit" value="Registrar Compra">
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                        </form>



                 
                  </td>
                  </tr>

             <?php 
            
             
            $total += $pedido['subtotal'];
            $valor_cambio = $pedido['cambio'] * $pedido['quantity'];
            $total_bs += $valor_cambio;
            
            } ?>
              </table>

            
                <script type="text/javascript">
                  $(document).ready(function () {
                    $('#example').DataTable();
                  });
                </script>
                <?php
                include '../footerbtn.php';

                ?>