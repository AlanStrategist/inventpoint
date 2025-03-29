<?php 

$nucleo='ventas';
include('../../js/restric.php');  
include('../alertas/alertas.php');
    


$sql7="SELECT DISTINCT pe.id,
 pr.nombre,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta ,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) * ".$valor." ,2) AS cambio,
pe.quantity, 
pe.metodo,
c.cedula,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100)* pe.quantity,2) AS subtotal 
  
FROM pedidos pe,producto pr ,cliente c 

WHERE pe.metodo='credito' AND 
pe.cliente_id=c.id AND 
pe.product_id=pr.id AND 
pe.fecha_credi= CURRENT_DATE";


$respuesta=mysqli_query($conex,$sql7);
$valid=mysqli_num_rows($respuesta);


if($valid>0){
     
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
   
$total=0;
$total_bs=0;
while($pedido=mysqli_fetch_array($respuesta)) {
   
   $cedula=0;
   $cedula=$pedido['cedula'];

        echo "<tr>";
            echo "<td>";
                        
                         

                      ?> <div class='product-nombre'><?=$pedido['nombre']?></div><?php
            echo "</td>";
                                 echo "<td>";
                        ?> <div class='product-nombre'><?=$pedido['precio_venta']?></div> <?php 
 echo "</td>";
                           
                             



                        
            echo "<td>";
                      ?> <div class='product-nombre'><?=$pedido['quantity']?></div><?php
        echo "</td>";
    
                         
 echo "<td>&#36;" . number_format($pedido['subtotal'], 2, '.', ',') . "</td>";
         
                echo "</td>";
                   echo "<td>";
                        
                      ?> <div class='product-modified'><?=$pedido['cambio']?></div><?php

            echo "</td>";
            $total += $pedido['subtotal'];


        $valor_cambio=$pedido['cambio']*$pedido['quantity'];
        $total_bs += $valor_cambio;
             echo "<td>";
          
            ?> <div class='product-nombre'><?=$pedido['cedula']?></div><?php
        echo "</td>";


        echo "<td>";
          
      ?> <div class='product-nombre'><?=$pedido['metodo']?></div><?php
        echo "</td>";
  
             echo "<td>"; 

             ?>

             <a title="Modificar" data-toggle="modal" data-target="#exampleModalcliente"><i class="fas fa-pen"> </i></a>
            <div class="modal fade" id="exampleModalcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       
      <div class="modal-body">
         <form name="formpavo" method='POST' action='../../../controladores/controladorpedido.php'>
    
    
 <h5 class="modal-title text-info" id="exampleModalLabel">Tipo de Pago <i class="fad  fa-coins"></i></h5>


    






<select name="metodo" class="form-control" id="metodo">
<option value="Efectivo">Efectivo</option> 
<option value="Débito">Débito</option> 
<option value="Divisa">Divisa</option> 
<option value="Transferencia">Transferencia</option>
 
    </select>
  


  <div class="modal-footer">  
      

  <input type="hidden" name="operacion" value="aprobar">
  
  <input type="text" name="id" value="<?php echo $pedido['id']; ?>">
  <input  class="btn btn-sm btn-success text-white" type="submit" value="Registrar Compra">
    
  </div>

  



       
      </div>
    </div>
  </div>
</div>


   
       
      
         </form>



             <?php
             echo "</td>";
         echo "</tr>";

          }
     


                       
    echo "</table>";         
}else{

    echo "<br>";
    echo "<div class='alert alert-danger'>";
    echo "<strong>No hay ventas que mostrar <i class='fad fa-sad-tear'></i> </strong>";
    echo "</div>";
}

?>
 <script type="text/javascript">
        $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
    <?php
include 'footer.php';

 ?>