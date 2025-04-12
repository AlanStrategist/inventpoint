 
<!-- Modal -->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-info" id="exampleModalLabel">Nueva Categoria <i class="far fa-grip-horizontal"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <form name="cate" class="needs-validation" method="POST" action="../../../controladores/ControladorCategoria.php" novalidate>



          <div class="col-md-11">

            <p>Ingrese una nueva categoria de productos</p>  

            <input type="text" minlength="3" maxlength="100" class="form-control" name="nombre" placeholder="Adornos de cocina" title="Ingrese su nueva ubicación" required="required" autofocus>

            <div class="invalid-feedback">¡No puede haber campos vacios!</div>

          </div>





        </div>
        <div class="modal-footer">


          <input type="hidden" name="operacion" value="guardar">
          <input type="submit" class="btn btn-primary" value="Guardar">

        </form>
      </div>
    </div>
  </div>
</div>
</div>

<?php include('../../js/validacion.php'); ?>