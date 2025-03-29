 


        <!-- Modal -->
<div class="modal fade" id="exampleModal10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-info" id="exampleModalLabel">Conversor <i class="far fa-dollar-sign"></i>  </h5>
        <button type="button" title="Cerrar" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <p  align="justify"> Esta herramienta hace que los <strong>precios en BS</strong> se actualicen a la nueva <strong>taza del dolar</strong> <i class="far fa-2x fa-money-bill-alt"></i>=<i class="far fa-2x fa-sack"></i></p>
      

      <form name="form3" class="needs-validation" novalidate="novalidate" method="POST" action="../../../controladores/controladorconversor.php">
        
      <div class="col-md-11">
      
      <p>Valor actualmente registrado:</p>
      <input type="number" value="<?=$valor?>" class="form-control" title="Valor actual" disabled>
       <hr>
      
       <p>Valor a ingresar:</p>
      <input type="number" min="1" max="10000000" class="form-control" name="dolar" placeholder="Ejemplo:45789" title="Ingrese su valor de conversión" required="required" autofocus>
        
       <div class="invalid-feedback">¡No puede haber campos vacios!</div>




      </div>
      

      


      </div>
      <div class="modal-footer">
       
        <input type="hidden" name="estatus" value="Empleado">
        <input type="hidden" name="operacion" value="convertir">
        <input type="submit" class="btn btn-primary" value="Convertir">

      </form>
         </div>
      </div>
    </div>
  </div>
</div>
  
     
<?php include('../../js/validacion.php'); ?>