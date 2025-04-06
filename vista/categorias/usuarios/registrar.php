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

  $sql = "SELECT * FROM privileges";

  $result = mysqli_query($conex,$sql);

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
          <h5 class="title">Nuevo Empleado</h5>
        </div>
        <div class="card-body">
          <form action="../../../controladores/ControladorUsuarios.php" class="needs-validation" name="form" method="post" novalidate>

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
           
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="repeat">Repita la clave</label>
                  <input type="password" class="form-control input-lg" name="clave_repetir"
                  minlength="5" maxlength="15" placeholder="Repita contraseña" pattern="[0-9a-zA-Z\s]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe coincidir con el campo anterior!</div>

                </div>
              </div>
              
              <h5>Pistas de recuperaci&oacute;n de usuario</h5>

              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="fhint">Pista #1</label>
                  <input type="text" class="form-control input-lg" name="quiz1"
                  minlength="5" maxlength="100" placeholder="Nombre de mi perro" pattern="[0-9a-zA-Z\s]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe tener un formato valido !</div>

                  <label class="text-primary" for="shint">Respuesta #1</label>
                  <input type="text" class="form-control input-lg" name="fhint"
                  minlength="5" maxlength="15" placeholder="Firulays" pattern="[0-9a-zA-Z\s]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe tener un formato valido !</div>

                  <label class="text-primary" for="fhint">Pista #2</label>
                  <input type="text" class="form-control input-lg" name="quiz2"
                  minlength="5" maxlength="100" placeholder="Nombre de mi bisabuelo" pattern="[0-9a-zA-Z\s]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe tener un formato valido !</div>

                  <label class="text-primary" for="shint">Respuesta #2</label>
                  <input type="text" class="form-control input-lg" name="shint"
                  minlength="5" maxlength="15" placeholder="Eustaquio" pattern="[0-9a-zA-Z\s]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe tener un formato valido !</div>

                </div>
              </div>

              <hr>

              <h5 class="text-primary"> Permisos dentro del sistema</h4>
              
              <table class="table">
                <thead>
                  <th>Nucleo</th>
                  <th>Descripci&oacute;n</th>
                  <th>Asignar</th>
                </thead>
                <tr>
                  <?php while ($row = mysqli_fetch_array($result)) {
                    
                    echo "<tr>";
                    echo "<td>".$row['nucleo']."</td>";
                    
                    echo "<td>".$row['descrip']."</td>";
                    
                    echo "<td> <input name=privi[] type='checkbox' value=".$row['id']." </td>";

                  }
  
                  ?>
              
                </tr>


              </table>
             

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









