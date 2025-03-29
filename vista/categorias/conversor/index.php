<?php 
     
$nucleo='Productos';
$title="Tasa de Cambio";
include('../../js/restric.php'); 

extract($_REQUEST);

if ($clave=='') { ?> 

  <script type="text/javascript">
alert('No se puede listar,no hay autorización');
window.location="../home/home.php";

  </script> 

  
<?php }else{
 

 $lista="SELECT dolar.valor,dolar.fecha,usuarios.nombre,usuarios.correo FROM dolar,usuarios WHERE dolar.id_usuario=usuarios.id";
 $respuesta=mysqli_query($conex,$lista);
 $pruebo=mysqli_num_rows($respuesta);

?>

 <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Lista de los valores del dolar</h4>
              </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table id="example" class="table">
            
       <thead class="text-primary">
  <th><small>Valor del Dolar</small></th>
  <th><small>Fecha</small></th>
  
  <th><small>Usuario que <br> realizo la conversion</small></th>


</thead>

<?php

while($data=mysqli_fetch_array($respuesta)){



        echo "<tr>";
        echo "<td>";
                        
                         

                  echo $data['valor'];
            echo "</td>";
            echo "<td>";
                        
                         
  echo $data['fecha'];
            echo "</td>";

            
                                 echo "<td>";
                                 echo $data['nombre'];
                                 echo '<br>';
                       echo $data['correo'];
 echo "</td>";
                           
                        
        echo "</tr>";
                         
          }
     
}


 
 

 ?>

 


    </table>

  </div></div></div>          </div>  
    </body>
</html>
    <script type="text/javascript">
        $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
<?php include('../footerbtn.php'); ?>