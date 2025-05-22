<?php
extract($_REQUEST);
$title = 'Registro de usuarios';
$nucleo = 'Usuarios';

include '../../js/restric.php';

if (!has_privi($privs, "List", "Producto")) {

  ?>
  <script type="text/javascript">
    window.location = "../home/home.php?alert=errorpriv"
  </script>

  <?php
}

try {

  $sql = "SELECT * FROM privileges";

  $result = mysqli_query($conex, $sql);

} catch (mysqli_sql_exception $e) {

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
          <form action="../../../controladores/ControladorUsuarios.php" class="needs-validation" name="form"
            method="post" novalidate>

            <div class="row">
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="email">Correo electrónico:</label>

                  <input type="email" class="form-control input-lg" name="correo" title="Ingrese su correo electrónico"
                    placeholder="ejm:carl@gmail.com" minlength="1" maxlength="25" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe ingresar un correo válido!</div>

                </div>
              </div>


              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="CI">Cédula</label>

                  <input type="text" class="form-control input-lg" name="cedula"
                    title="Ingrese su cédula,no ingrese caracteres especiales: $,/,()...'" placeholder="ejm:1334"
                    minlength="6" maxlength="15" pattern="[0-9]+" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe ingresar una cédula válida!</div>

                </div>
              </div>
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="name">Nombre: </label>

                  <input type="text" class="form-control input-lg" name="nombre"
                    title="No use comas,puntos, ni numeros,tampoco caracteres especiales'$,%./,(),[],=.etc.'"
                    placeholder="ejm:usuario1334" minlength="6" maxlength="25" pattern="[0-9a-zA-Z\s]+"
                    required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios,Ingrese un nombre válido!</div>
                </div>
              </div>
              </div>
              
              <hr>

              <h5 class="title"> Creaci&oacute;n de clave</h5>

              <div class="row">
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="Clave">Clave</label>
                  <input type="password" class="form-control input-lg" name="clave" minlength="5"
                    placeholder="*********" pattern="^[a-zA-Z0-9 !@#$%^&*()_+=\[\]{};':&quot;\\|,.<>\/?]*$"
                    required="required">

                  <div id="password-strength" class="mt-2">
                    <div class="progress">
                      <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                    <small id="password-strength-text" class="form-text"></small>
                  </div>

                </div>
              </div>
           
            
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label class="text-primary" for="repeat">Repita la clave</label>
                  <input type="password" class="form-control input-lg" name="clave_repetir" minlength="5"
                    placeholder="Repita contraseña" pattern="^[a-zA-Z0-9 !@#$%^&*()_+=\[\]{};':&quot;\\|,.<>\/?]*$"
                    required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡Debe coincidir con el campo anterior!</div>

                </div>
              </div>
            </div>
            
            <hr>

            <h5 class="title">Pistas de recuperaci&oacute;n de usuario</h5>

            <div class="col-md-12 pr-1">
              <div class="form-group">
                <label class="text-primary" for="fhint">Pista #1</label>
                <input type="text" class="form-control input-lg" name="quiz1" minlength="5" maxlength="100"
                  placeholder="Nombre de mi perro" pattern="[0-9a-zA-Z\s]+" required="required">

                <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                <div class="invalid-feedback">¡Debe tener un formato valido !</div>

                <label class="text-primary" for="shint">Respuesta #1</label>
                <input type="text" class="form-control input-lg" name="fhint" minlength="5" maxlength="15"
                  placeholder="Firulays" pattern="[0-9a-zA-Z\s]+" required="required">

                <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                <div class="invalid-feedback">¡Debe tener un formato valido !</div>

                <label class="text-primary" for="fhint">Pista #2</label>
                <input type="text" class="form-control input-lg" name="quiz2" minlength="5" maxlength="100"
                  placeholder="Nombre de mi bisabuelo" pattern="[0-9a-zA-Z\s]+" required="required">

                <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                <div class="invalid-feedback">¡Debe tener un formato valido !</div>

                <label class="text-primary" for="shint">Respuesta #2</label>
                <input type="text" class="form-control input-lg" name="shint" minlength="5" maxlength="15"
                  placeholder="Eustaquio" pattern="[0-9a-zA-Z\s]+" required="required">

                <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                <div class="invalid-feedback">¡Debe tener un formato valido !</div>

              </div>
            </div>

            <hr>

            <h5 class="title">Permisos dentro del sistema</h4>

              <table class="table">
                <thead>
                  <th>Nucleo</th>
                  <th>Descripci&oacute;n</th>
                  <th>Asignar</th>
                </thead>
                <tr>
                  <?php while ($row = mysqli_fetch_array($result)) {

                    echo "<tr>";
                    echo "<td>" . $row['nucleo'] . "</td>";

                    echo "<td>" . $row['descrip'] . "</td>";

                    echo "<td> <input name=privi[] type='checkbox' value=" . $row['id'] . " </td>";

                  }

                  ?>

                </tr>


              </table>


              <input type="hidden" name="tipo_usuario" value="empleado">
              <input type="hidden" name="estatus" value="activo">

              <input type="hidden" name="operacion" value="guardar">
              <div class="col-md-8">
                <input type="reset" class="btn btn-info " value="Resetear">
                <input type="submit" class="btn btn-primary pull-left" value="Registrar">


              </div>




          </form>
        </div>
      </div>
    </div>






    <?php

    include '../../js/validacion.php';
    include '../footerbtn.php'; ?>

    <script>
      $(function () {
        function strengthLevel(clave) {
          let strength = 0;
          if (clave.length >= 8) strength++;
          if (/[A-Z]/.test(clave)) strength++;
          if (/\d/.test(clave)) strength++;
          if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(clave)) strength++;
          return strength;
        }

        function updateStrengthBar(clave) {
          const level = strengthLevel(clave);
          const $bar = $('#password-strength-bar');
          const $text = $('#password-strength-text');
          let color = '', text = '', width = '0%';

          if (clave.length === 0) {
            $bar.removeClass().addClass('progress-bar').css('width', '0%');
            $text.text('Vacio');
            return;
          }

          switch (level) {
            case 1:
            case 2:
              color = 'bg-danger';
              text = 'Débil';
              width = '33%';
              break;
            case 3:
              color = 'bg-warning';
              text = 'Media';
              width = '66%';
              break;
            case 4:
              color = 'bg-success';
              text = 'Fuerte';
              width = '100%';
              break;
          }
          $bar.removeClass().addClass('progress-bar ' + color).css('width', width);
          $text.text('Seguridad: ' + text);
        }

        function claveFuerte(clave) {
          return strengthLevel(clave) === 4;
        }

        $('input[name="clave"]').on('input', function () {
          var clave = $(this).val();
          updateStrengthBar(clave);
          if (!claveFuerte(clave)) {
            this.setCustomValidity('La clave debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.');
          } else {
            this.setCustomValidity('');
          }
        });

        $('input[name="clave_repetir"]').on('input', function () {
          var clave = $('input[name="clave"]').val();
          if ($(this).val() !== clave) {
            this.setCustomValidity('Las contraseñas no coinciden.');
          } else {
            this.setCustomValidity('');
          }
        });

        $('form[name="form"]').on('submit', function (e) {
          var clave = $('input[name="clave"]').val();
          var claveRep = $('input[name="clave_repetir"]').val();
          if (!claveFuerte(clave)) {
            $('input[name="clave"]')[0].reportValidity();
            e.preventDefault();
          }
          if (clave !== claveRep) {
            $('input[name="clave_repetir"]')[0].reportValidity();
            e.preventDefault();
          }
        });
      });
    </script>