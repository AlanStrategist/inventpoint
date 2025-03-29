<?php
$nucleo='Producto'; 
$title='Lista de ubicaciones de para productos';

include('../../js/restric.php');

extract($_REQUEST);

include('../alertas/alertas.php');

if ($clave=='') { ?> 

  <script type="text/javascript">
alert('No se puede listar,no hay autorización');
window.location="../home/home.php";

  </script> 

  
<?php }else{
 

 $lista="SELECT * FROM ubicacion";
 $respuesta=mysqli_query($conex,$lista);
 $pruebo=mysqli_num_rows($respuesta);

?>

<script type="text/javascript">
        function eliminar(id) {
            if (confirm("¿Seguro que desea inhabilitar este cliente?")) {
                    window.location="../../../controladores/controladorcliente.php?operacion=eliminar&id="+id;/*revisar id*/
            }
        }

    </script>
        <script type="text/javascript">
        function habilitar(id) {
            if (confirm("¿Seguro que desea habilitar este cliente?")) {
                    window.location="../../../controladores/controladorcliente.php?operacion=habilitar&id="+id;/*revisar id*/
            }
        }
        
    </script>
    <body>
          <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Ubicaciones registradas</h4>
              </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table id="example" class="table">
            
       <thead class="text-primary">


  <th>Nombre</th>
 
  
  <th>Acciones</th>
 
       </thead>

<?php

while($data=mysqli_fetch_array($respuesta)){

 $cedula=0;

        echo "<tr>";
        echo "<td>";
                        
                         

                      ?> <?=$data['nombre']?><?php
            echo "</td>";
            
            



             ?>
<td><a title="Modificar" href="../../../controladores/controladorubicacion.php?operacion=modificar&id=<?=$data['id']?>"><i class="far fa-2x fa-pencil-alt"> </i></a>
    
    </td> </tr>
             <?php
          }
     
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
        $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
<?php include('../footerbtn.php'); ?>