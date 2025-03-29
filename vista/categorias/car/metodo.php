<div class="modal fade" id="exampleModalcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       
      <div class="modal-body">
      	 <form name="formpavo" method='POST' action='../../../controladores/controladorpedido.php'>
    
    
 <h5 class="modal-title text-info" id="exampleModalLabel">Tipo de Pago <i class="fad  fa-coins"></i></h5>

<select name="metodo" class="form-control" id="metodo">
<option value="Efectivo">Efectivo</option> 
<option value="Débito">Débito</option> 
<option value="Divisa">Divisa</option> 
<option value="Transferencia">Transferencia</option>
 
    </select>
  


  <div class="modal-footer">  
      

  <input type="hidden" name="operacion" value="aprobar">
  
  <input type="text" name="id" value="<?php echo $data['id']; ?>">
  <input  class="btn btn-sm btn-success text-white" type="submit" value="Registrar Compra">
    
  </div>

  



       
      </div>
    </div>
  </div>
</div>


   
       
      
         </form>

         