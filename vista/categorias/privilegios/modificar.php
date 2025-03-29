<?php 
extract($_REQUEST);
$nucleo='usuarios';
$title='Modificar Privilegios';
include('../../js/restric.php'); 

if ($privis['usuarios']=='Si') {

}else{
  ?>
  <script type="text/javascript">
    window.location= "../home/home.php"
  </script>
  <?php
}

include('../alertas/alertas.php');

#para listar todos los usuarios
$sql  = "SELECT * FROM privilegio WHERE id_usuario=" . $id;
$res  = mysqli_query($conex, $sql);
$data = mysqli_fetch_array($res);
?>

<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Modificar privilegios a un usuario</h5>
        </div>
        <div class="card-body">

          <form action="../../../controladores/controladorprivilegio.php" class="needs-validation" name="f1" id="f1" method="post" novalidate>

            <div class="row">
              <div class="col-md-4 pr-1">
                <div class="form-group">



                  <label for="user">Usuario</label>


                  <?php
                  
                  $name_u='SELECT usuarios.nombre FROM usuarios WHERE id='.$id; 
                  $execute_u=mysqli_query($conex,$name_u);
                  $arra=mysqli_fetch_array($execute_u);  

                  ?>
                  <input type="text" name="nombre" disabled="" id="nombre" minlength="5" maxlength="30" class="form-control"  placeholder="Ejemplo=4559-8766" required="required" value="<?=$arra['nombre']?>" >

                  <?php

                  ?>

                </div>
              </div>


              <div class="col-md-auto">

              </div>

              <div class="col">
                <div class="form-group">
                  <label class="text-center"> Privilegio </label>
                  <br>

                  <input type="checkbox" name="bitacora" title="Las bitacoras registran cada uno de los movimientos dentro del sistema,Acceder a todas las bitacoras" value="si" <?php if ($data['bitacora']){
                    ?>   checked=""<?php
                  } ?>

                  > <i class="far fa-2x fa-list text-info"></i> Bitacora

                  <br>  
                  <input type="checkbox" name="producto" title="Permiso para registrar productos,actualizar la cantidad de existencia, registrar ubicaciones o categorias de productos" value="si"<?php if ($data['producto']){
                    ?>   checked=""<?php
                  } ?> >   <i class="far fa-2x fa-forklift text-info"></i>  Producto

                  <br>  
                  <input type="checkbox" name="pedidos" title="Realizar las ventas dentro del sistema y generar cierres diarios" value="si" <?php if ($data['pedidos']){
                    ?>   checked=""<?php
                  } ?>> <i class="far fa-2x fa-cash-register text-info"></i> Pedidos


                  <br>  
                  <input type="checkbox" name="usuarios" title="Poder registrar usuarios dentro del sistema,tambien asignarle los privilegios a cada uno de los usuarios dentro del sistema " value="si" <?php if ($data['usuarios']){
                    ?>   checked=""<?php
                  } ?>> <i class="far fa-2x fa-user-hard-hat text-info"></i> Usuarios                                                  

                  <br>  
                  <input type="checkbox" name="mantenimiento"  title="Realizar respaldo y restauración de las bases de datos dentro del sistema" value="si" <?php if ($data['mantenimiento']){
                    ?>   checked=""<?php
                  } ?>> <i class="far fa-2x fa-cogs text-info"></i> Mantenimiento

                  <div class="valid-feedback">Bien <i class="fal fa-2x fa-smile"></i></div>
                  <div class="invalid-feedback">¡Debe elegir una opción!</div>


                </div>
              </div>

            </div>

            <input  type="hidden" name="operacion" value="guardar_modificacion">
            <input  type="hidden" name="id" value="<?=$id?>">
            <div class="col-md-8">

              <input type="submit" class="btn btn-primary pull-right" value="Registrar" >

            </div>




          </form>
        </div>
      </div>
    </div>

    <?php include('../../js/validacion.php');
    include('../footerbtn.php') ?>