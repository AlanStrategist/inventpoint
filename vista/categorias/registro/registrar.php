<?php
extract($_REQUEST);
$title='Registro de usuarios';
$nucleo = 'Usuarios';

include '../../js/restric.php';

if ($privis['usuarios'] == 1) {

  echo "";

} else {?>

 <script type="text/javascript">
  window.location="../home/home.php?alerta=sinprivi";

</script>

<?php } 

if (isset($alerta) AND $alerta='duplicidad') {
  ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
   Nombre o cédula duplicada <i class="fas fa-copy"></i>
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">

    <span aria-hidden="true">&times;</span>

  </button> 
</div>
<?php 
}


?>

<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Nuevo Empleado</h5>
        </div>
        <div class="card-body">
          <form action="../../../controladores/ControladorRegistro.php" class="needs-validation" name="form" method="post" novalidate>

            <div class="row">

              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="email">Correo electrónico:</label>

                  <input type="email" class="form-control input-lg" name="correo" title="Ingrese su correo electrónico" placeholder="ejm:carl@gmail.com" minlength="1" maxlength="25" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe ingresar un correo válido!</div>

                </div>
              </div>


              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="CI">Cédula</label>

                  <input type="text" class="form-control input-lg" name="cedula" title="Ingrese su cédula,no ingrese caracteres especiales: $,/,()...'" placeholder="ejm:1334" minlength="6" maxlength="15"pattern="[0-9]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe ingresar una cédula válida!</div>

                </div>
              </div>
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="name">Nombre: </label>

                  <input type="text" class="form-control input-lg" name="nombre" title="No use comas,puntos, ni numeros,tampoco caracteres especiales'$,%./,(),[],=.etc.'" placeholder="ejm:usuario1334" minlength="6" maxlength="25"pattern="[0-9a-zA-Z\s]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios,Ingrese un nombre válido!</div>
                </div>
              </div>


              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="Clave">Clave</label>
                  <input type="password" class="form-control input-lg" name="clave"
                  minlength="5" maxlength="15" placeholder="*********" pattern="[0-9a-zA-Z\s]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Ingrese una contraseña válida!</div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="repeat">Repita la clave</label>
                  <input type="password" class="form-control input-lg" name="clave_repetir"
                  minlength="5" maxlength="15" placeholder="Repita contraseña" pattern="[0-9a-zA-Z\s]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe coincidir con el campo anterior!</div>

                </div>

              </div>






              <input type="hidden" name="tipo_usuario" value="empleado">
              <input type="hidden" name="estatus" value="activo">





              <input  type="hidden" name="operacion" value="guardar">
              <div class="col-md-8">
                <input type="submit" class="btn btn-primary pull-right" value="Registrar" >


              </div>




            </form>
          </div>
        </div>
      </div>






      <?php

      include '../../js/validacion.php';
      include '../footerbtn.php';?>









