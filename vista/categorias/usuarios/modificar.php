<?php
extract($_REQUEST);
$title='Registro de usuarios';
$nucleo = 'Usuarios';

include '../../js/restric.php';

if ( !has_privi($privs,"List","Producto") ) { 

  ?>
  <script type="text/javascript">
    window.location = "../home/home.php?alert=errorpriv"
  </script>

  <?php
}

try{

  $sql = "SELECT * FROM usuarios WHERE id=".$id;

  $result = mysqli_query($conex,$sql);

  $row = mysqli_fetch_array($result);

}catch(mysqli_sql_exception $e){

  ?>

  <script type="text/javascript">
    window.location = "../home/home.php?alert=errorpriv"
  </script>

  <?php

}

?>
<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Modificar Datos del Empleado</h5>
        </div>
        <div class="card-body">
          <form action="../../../controladores/ControladorUsuarios.php" class="needs-validation" name="form" method="post" novalidate>

            <div class="row">

              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="email">Correo electrónico:</label>

                  <input type="email" class="form-control input-lg" name="correo" value="<?=$row['correo']?>" title="Ingrese su correo electrónico" placeholder="ejm:carl@gmail.com" minlength="1" maxlength="25" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe ingresar un correo válido!</div>

                </div>
              </div>


              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="CI">Cédula</label>

                  <input type="text" class="form-control input-lg" name="cedula" value="<?=$row['cedula']?>" title="Ingrese su cédula,no ingrese caracteres especiales: $,/,()...'" placeholder="ejm:1334" minlength="6" maxlength="15"pattern="[0-9]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe ingresar una cédula válida!</div>

                </div>
              </div>
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="name">Nombre: </label>

                  <input type="text" class="form-control input-lg" name="nombre" value="<?=$row['nombre']?>" title="No use comas,puntos, ni numeros,tampoco caracteres especiales'$,%./,(),[],=.etc.'" placeholder="ejm:usuario1334" minlength="6" maxlength="25"pattern="[0-9a-zA-Z\s]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios,Ingrese un nombre válido!</div>
                </div>
              </div>

              <input  type="hidden" name="id" value="<?=$row['id']?>">
              <input  type="hidden" name="operacion" value="Save_Update">

              <div class="col-md-8">
                <input type="submit" class="btn btn-primary pull-right" value="Registrar">
              </div>

            </form>
          </div>
        </div>
      </div>






      <?php

      include '../../js/validacion.php';
      include '../footerbtn.php';?>