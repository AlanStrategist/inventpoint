<?php

$nucleo = 'ventas';
$title = 'Carro de compra';

extract($_REQUEST);

include('../../js/restric.php');
include('../../../modelos/ClassAlert.php');

$db = new clasedb();
$conex = $db->conectar();


if( isset($alert) && $alert == "add"){ $al = new ClassAlert("Agregado !<br>","","primary"); }

else if( isset($alert) && $alert == "nostock"){ $al = new ClassAlert("No Stock!<br>","No hay la suficiente cantidad del producto","danger"); }

else if( isset($alert) && $alert == "error"){ $al = new ClassAlert("Error!<br>","No se registraron los cambios","danger"); }

else if( isset($alert) && $alert == "rem"){ $al = new ClassAlert("Removido!<br>","","primary"); }

else if( isset($alert) && $alert == "ac"){ $al = new ClassAlert("Cantidad actualizada!<br>","","primary"); }

else if( isset($alert) && $alert == "nodate"){ $al = new ClassAlert("Error!<br>","No se ha registrado el credito correctamente, verifica que la casilla que indica el credito est&eacute; seleccionada y con la fecha indicada","danger"); }


// select products in the cart
$query = "SELECT DISTINCT p.id,
p.stock,
p.nombre,
ROUND( p.precio + ( (p.precio * p.porcentaje) / 100),2) AS precio_venta,
 c.quantity ,
 ROUND( p.precio + ( (p.precio * p.porcentaje) / 100),2) * c.quantity AS subtotal ,
 ROUND((p.precio + ( (p.precio * p.porcentaje) / 100) ),2)* " . $valor . " AS cambio 
 FROM cart_menu c,producto p,usuarios u 
 WHERE c.product_id=p.id AND p.stock > 0 AND c.user_id=" . $_SESSION['id'];

$request = mysqli_query( $conex, $query);

// count number of rows returned
$num = mysqli_num_rows($request);

if ( !($num > 0) ){ 

    ?>

     <br>
     <div class='alert alert-danger'>
     <strong>¡No se ha seleccionado ning&uacute;n producto!
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
                        <h4 class="card-title">Culminar una Venta </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table">

                                <thead class="text-primary">                                 
                                    <th class='textAlignLeft'>Nombre</th>
                                    <th>Precio (USD)</th>
                                    <th style='width:15em;'>Cantidad</th>
                                    <th>Sub Total</th>
                                    <th>Acciones</th>
                                </thead>
                                    
                                    <?php

                                    $valor_cambio_final = 0;
                                    $total = 0;

                                    while ( $data = mysqli_fetch_array($request) ) {

                                        ?>
                                         <tr>
                                         <td><div class='product-id' style='display:none;'><?=$data['id']?></div>
                                         <div class='product-nombre'><?=$data['nombre']?></div></td>
                                         <td>&#36;<?=number_format($data['precio_venta'], 2, '.', ',')?></td>
                                         <td>
                                         <form id='myForm' action='../../../controladores/ControladorCarrito.php' method='POST'>
                                            <div class='input-group'>
                                            <input type='number' min='1' max='<?=$data['stock']?>' name='quantity' value='<?=$data['quantity']?>' class='form-control'>
                                            <input type='hidden' name='product_id' value='<?=$data['id']?>'>
                                            <input type='hidden' name='operacion' value='actualizar'>
                                            <span class='input-group-btn'>
                                                <input type='submit' class='btn btn-info update-quantity' >
                                            </span>
                                            </div>
                                          </form>
                                         </td>
                                         <td>&#36;<?=number_format($data['subtotal'], 2, '.', ',')?> </td>
                                         <td>
                                            <a href='../../../controladores/ControladorCarrito.php?operacion=eliminar&id=<?=$data['id']?>' class='btn btn-sm btn-danger' title='Quitar del Pedido'>
                                            <i title='Quitar del Pedido' class='fad fa-2x fa-eraser' ></i>
                                            </a>
                                         </td>
                                         </tr>
                                    
                                    <?php
                                        $total += $data['subtotal'];
                                        $valor_cambio = $data['cambio'] * $data['quantity'];
                                        $valor_cambio_final += $valor_cambio;

                                    } ?>

                                    </table>
                                   
                                    <table class="table">
                                     <tr>
                                        <td><b>Total</b></td>
                                        <td>Bs <?=number_format($valor_cambio_final, 2, '.', ',')?></td>
                                        <td><b>Total</b> USD <?=number_format($total, 2, '.', ',')?></td>
                                        <td> <?php include 'form.php'; ?></td>
                                      </tr>
                                    </table>

                                    <?php } ?> 



                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#example').DataTable();
                                        });
                                    </script>
                                    <?php
                                    include '../footerbtn.php';
                                    ?>