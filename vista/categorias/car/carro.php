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

    echo "<br>";
    echo "<div class='alert alert-danger'>";
    echo "<strong>¡No se ha seleccionado ning&uacute;n producto!";
    echo "</div>";

}else{

    //start table

    ?>


    <div class="content">
        <div class="row">
            <div class="col-md-12">
            <?php if(isset($al)){ echo $al->Show_Alert(); } ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Culminar una Venta</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table">

                                <thead class="text-primary">
                                    <?php

                                    // our table heading
                                    echo "<th class='textAlignLeft'>Nombre</th>";

                                    echo "<th>Precio (USD)</th>";
                                    echo "<th style='width:15em;'>Cantidad</th>";
                                    echo "<th>Sub Total</th>";
                                    echo "<th>Acciones</th>";
                                    echo "</thead>";


                                    $valor_cambio_final = 0;
                                    $total = 0;


                                    while ( $data=mysqli_fetch_array($request) ) {
                                       
                                        echo "<tr>";
                                        echo "<td>";
                                        echo "<div class='product-id' style='display:none;'>".$data['id']."</div>";
                                        echo "<div class='product-nombre'>".$data['nombre']."</div>";
                                        echo "</td>";
                                        echo "<td>&#36;" . number_format($data['precio_venta'], 2, '.', ',') . "</td>";
                                        echo "<td>";
                                        echo "<form id='myForm' action='../../../controladores/ControladorCarrito.php' method='POST'>";
                                        echo "<div class='input-group'>";
                                        echo "<input type='number' min='1' max='".$data['stock']."'name='quantity' value='".$data['quantity']."' class='form-control'>";
                                        echo "<input type='hidden' name='product_id' value='".$data['id']."'>";
                                        echo "<input type='hidden' name='operacion' value='actualizar'";
                                        echo "<span class='input-group-btn'>";
                                        echo "<input type='submit' class='btn btn-info update-quantity' >";
                                        echo "</span>";
                                        echo "</form>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "<td>&#36;" . number_format($data['subtotal'], 2, '.', ',') . "</td>";
                                        echo "<td>";
                                        echo "<a href='../../../controladores/ControladorCarrito.php?operacion=eliminar&id=".$data['id']."' class='btn btn-sm btn-danger' title='Quitar del Pedido'>";
                                        echo "<i title='Quitar del Pedido' class='fad fa-2x fa-eraser' ></i>";
                                        echo "</a>";
                                        echo "</td>";
                                        echo "</tr>";

                                        $total += $data['subtotal'];
                                        $valor_cambio = $data['cambio'] * $data['quantity'];
                                        $valor_cambio_final += $valor_cambio;

                                    }

                                    echo "</table>";
                                    ?>
                                    <table class="table">

                                        <?php


                                        echo "<tr>";
                                        echo "<td><b>Total</b></td>";

                                        echo "<td>Bs." . number_format($valor_cambio_final, 2, '.', ',') . "</td>";

                                        echo "<td><b>Total</b> USD." . number_format($total, 2, '.', ',') . "</td>";

                                        echo "<td>";
                                        include 'form.php';
                                        echo "</td>";

                                        echo "</tr>";


                                        echo "</table>";
} 


?>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#example').DataTable();
                                        });
                                    </script>
                                    <?php
                                    include '../footerbtn.php';
                                    ?>