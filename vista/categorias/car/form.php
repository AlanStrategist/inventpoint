<?php

$sql2 = "SELECT * FROM cliente ";
$res2 = mysqli_query($conex, $sql2);
$hoy = date('Y-m-d');
?>
<script type="text/javascript">
  window.onload = function () {
    document.getElementById('credito').onclick = function () {
      if ($(this).prop('checked')) {
        $('#fecha').removeAttr('disabled');

        $('#metodo').attr('disabled', true);
      } else {
        $('#fecha').attr('disabled', true);
        $('#metodo').removeAttr('disabled');

      }
    }
  }

</script>


<td><a class="btn btn-md btn-success text-white" title='Tomar datos para generar una factura' data-toggle="modal"
    data-target="#exampleModalcliente"><strong>Generar Factura</strong></a>

  <!-- Modal -->
  <div class="modal fade" id="exampleModalcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-info" id="exampleModalLabel">Datos del cliente <i class="fad  fa-id-card"></i>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form name="formpavo" class='needs-validation' method='POST'
            action='../../../controladores/controladorpedido.php' novalidate>


            <input type="text" placeholder="Ejemplo:12109387" name="cedula" list="lista" class="form-control"
              required="required">


            <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
            <div class="invalid-feedback">¡Debe ingresar el nombre o CI del cliente!</div>

            <datalist id="lista">
              <?php
              while ($cliente = mysqli_fetch_array($res2)) {
                echo "<option value='" . $cliente['cedula'] . "'>" . $cliente['cedula'] . "|" . $cliente['nombre'] . "</option> ";
              }
              ?>
            </datalist>



            <h5 class="modal-title text-info" id="exampleModalLabel">Tipo de Pago <i class="fad  fa-coins"></i></h5>



            <select name="metodo" class="form-control" id="metodo">
              <option value="Efectivo">Efectivo BS</option>
              <option value="Debito">Débito</option>
              <option value="Divisa">Divisa</option>
              <option value="Transferencia">Transferencia</option>
              <option value="Credito">Credito</option>
            </select>
            <hr>
            <h5>

              <label for="cambiar" class="text-info">¿Pago a crédito? Si</label>

              <input type="checkbox" name="credito" id="credito" value="1">


            </h5>

            <input type="date" name="fecha_credi" id="fecha" min="<?= $hoy ?>" class="form-control" required="required"
              value='<?= $hoy ?>' disabled>


            <div class="modal-footer">


              <input type="hidden" name="operacion" value="guardar">

              <input class="btn btn-sm btn-success text-white" type="submit" value="Registrar Compra">

            </div>




          </form>

          <?php include('../../js/validacion.php');
          ?>


















        </div>



      </div>
    </div>
  </div>
  </div>