<?php

extract($_REQUEST);
$title='Listado de Productos'; //nombre de la vista
$nucleo = 'Productos';
include '../../js/restric.php';
include('../../../modelos/ClassAlert.php');

if( isset($alert) && $alert == "modisi"){ $al = new ClassAlert("Modificaci&oacute;n exitosa !<br>","","warning"); }

else if( isset($alert) && $alert == "modino"){ $al = new ClassAlert("Error al modificar!<br>","Verifique su conexion a internet","danger"); }

else if( isset($alert) && $alert == "status"){ $al = new ClassAlert("Estatus Modificado!<br>","","warning"); }

else if( isset($alert) && $alert == "error"){ $al = new ClassAlert("Error!<br>","No se registraron los cambios","danger"); }


$lista     = "SELECT p.id,p.cod_barra,p.nombre, p.precio, p.porcentaje,p.stock,p.estatus, c.nombre AS categorias, u.nombre AS ubicacion FROM producto p,categorias c, ubicacion u where c.id = p.id_categorias AND u.id = p.id_ubicacion";
$respuesta = mysqli_query($conex, $lista);
$pruebo    = mysqli_num_rows($respuesta);

if ($clave == '' || $pruebo < 0 || $valor == 0) {?>

  <script type=text/javascript>
alert('Error al generar el listado');
window.location=../home/home.php;

  </script>


<?php } else {
    ?>



    <body>

      <div class=content>
        <div class=row>
          <div class=col-md-12>

          <?php  if(isset($al)){ echo $al->Show_Alert(); } ?>

            <div class=card>
              <div class=card-header>
                <h4 class=card-title>Productos registrados</h4>
              </div>
                <div class=card-body>
                  <div class=table-responsive>
                  <table id=example class=table>

       <thead class=text-primary>

  <th><strong><i class='far fa-2x fa-barcode-alt' title="Código de barra"></i></strong></th>
  <th><strong>Nombre</strong></th>
  <th><strong>Precio</strong></th>
  <th><strong>Precio para vender</strong></th>
  <th><strong>Existencia</strong></th>
  <th><strong>Ganancia</strong></th>
  <th><strong>Categoria</strong></th>
  <th><strong>Ubicación</strong> </th>
  <th><strong>Modificar</strong> </th>
  <th><strong>Estatus</strong></th>

       </thead>

<?php

    $nam = 0;

    while ($data = mysqli_fetch_array($respuesta)) {

        $nam++;
        
        $porc=$data['precio']*$data['porcentaje']/100;
        $precio_venta=$porc+$data['precio'];


        ?>


         <tr>
         <td>

        <?=$data['cod_barra']?>

         </td>

         <td>

         <?=$data['nombre']?>

        </td>

         <td>

        <?=number_format($data['precio'], 2, '.', ',')?> $
        <hr>
        <?=number_format($data['precio'] * $valor, 2, ',', '.')?> Bs

         </td>

         <td>

        <?=number_format($precio_venta, 2, '.', ',')?> $
        <hr>
        <?=number_format($precio_venta * $valor, 2, ',', '.')?> Bs

        </td>

         <td>
        <?=$data['stock']?> unidad(es) <a href="" data-toggle='modal' data-target='#stock<?=$nam?>' title="¿Modificar cantidad en existencia del producto?" ><i class='far fa-2x fa-pen text-primary'></i></a>
        </td>


         <td>

         <?=$data['porcentaje']?> %

         </td>

         
        
        <td>
         <?=$data['categorias']?>
        </td>

         <td>

         <?=$data['ubicacion']?>

         </td>




   <td>

    <a title='Modificar' href='../../../controladores/controladorproducto.php?operacion=modificar&id=<?=$data['id']?>'href=''><i class='far fa-2x fa-edit'></i></a>

   </td>
   <td>

          <?php

        if ($data['estatus'] == 'habilitado' ) {
            
            
?>

  <a title='Habilitado ¿Desea inhabilitar?' data-toggle="modal" data-target="#inha<?=$nam?>" href='' ><i class='far fa-2x fa-eye text-success'></i></a>

<?php 


        } elseif ($data['estatus'] == 'inhabilitado') {
            
           ?>

  <a title='Inhabilitado ¿Desea habilitar?' data-toggle="modal" data-target="#ha<?=$nam?>" href='' ><i class='far fa-2x fa-eye-slash text-danger'></i></a>

<?php 
        }

        ?>
         </td>
<?php

        include '../modals/modal_productos.php';
    }

}

?>


    </table>
             </div>
              </div>
            </div>
          </div>
    </body>



    <script type=text/javascript>
        $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
<?php include '../footerbtn.php';?>
