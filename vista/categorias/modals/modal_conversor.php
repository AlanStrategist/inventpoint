<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-info" id="exampleModalLabel">Conversor <i class="far fa-dollar-sign"></i> A
          Bolivares </h5>
        <button type="button" title="Cerrar" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p align="justify"> Esta herramienta hace que los <strong>precios en BS</strong> se actualicen a la nueva
          <strong>taza del dolar</strong> <i class="far fa-2x fa-money-bill-alt"></i>=<i class="far fa-2x fa-sack"></i>
        </p>

        <!-- llamar el Dolar de las apis -->
        <button id="btnCargar" class="btn btn-primary" type="button">Obtener Dolar Actual</button>
        
        <div id="contenidoDinamico"></div>
        <!-- Plasmar en este div con ajax -->

        <form name="form1" class="needs-validation" novalidate="novalidate" method="POST"
          action="../../../controladores/ControladorConversor.php">

          <div class="col-md-11">

            <p>Valor actualmente registrado:</p>
            <input type="number" value="<?= $valor ?>" class="form-control" title="Valor actual" disabled>
            <hr>

            <p>Valor a ingresar:</p>
            <input type="number" min="1" max="10000000" step="0.01" class="form-control" name="dolar"
              placeholder="Ejemplo:45789" title="Ingrese su valor de conversión" required="required" autofocus>

            <div class="invalid-feedback">¡No puede haber campos vacios!</div>

          </div>
      </div>
      <div class="modal-footer">

        <input type="hidden" name="operacion" value="convertir">
        <input type="submit" class="btn btn-primary" value="Convertir">

        </div>
      </form>
    </div>
  </div>
</div>
</div>

<script>
$(document).ready(function() {
    $('#btnCargar').click(function() {
        // Mostrar spinner de carga
        $('#contenidoDinamico').html('<div class="spinner"></div>');
        
        // Deshabilitar botón durante la carga
        $(this).prop('disabled', true).text('Cargando...');
        
        // Hacer la petición AJAX
        $.ajax({
            url: '../../../controladores/apis/CallDolar.php',
            type: 'GET',
            dataType: 'html' // Puede ser 'html', 'json' o 'text'
        })
        .done(function(data) {
            $('#contenidoDinamico').html(data);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            $('#contenidoDinamico').html(
                '<div class="error">Error al cargar: ' + errorThrown + '</div>'
            );
        })
        .always(function() {
            // Restaurar botón
            $('#btnCargar').prop('disabled', false).text('Obtener Dolar');
        });
    });
});
</script>

<?php include('../../js/validacion.php'); ?>