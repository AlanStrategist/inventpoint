

        <!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-info" id="exampleModalLabel">Nueva Ubicación <i class="far fa-warehouse-alt"></i></h5>
       
        <button type="button" title="Cerrar" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        
      <form name="form1" class="needs-validation" novalidate="novalidate" method="POST" action="../../../controladores/controladorubicacion.php">
        
      <div class="col-md-11">
      
      <p>Ingrese una nueva ubicación</p>  
      
      <input type="text" minlength="3" maxlength="100" class="form-control" name="nombre" placeholder="Ejemplo:Estante 4" title="Ingrese su nueva ubicación" required="required" autofocus>
        
      <div class="invalid-feedback">¡No puede haber campos vacios!</div>




      </div>
      

      


      </div>
      <div class="modal-footer">
       
        
        <input type="hidden" name="operacion" value="guardar">
        <input type="submit" class="btn btn-primary" value="Registrar">

      </form>
         </div>
      </div>
    </div>
  </div>
</div>
 
<?php include('../../js/validacion.php'); ?>