<div class="modal fade" id="inha<?=$nam?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="exampleModalLabel">               Inhabilitar <?=$data['nombre']?> <i class='far fa-2x fa-eye-slash'></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p align="justify">¿Esta seguro de que desea <strong>inhabilitar</strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
        <a class="btn btn-info" href='../../../controladores/ControladorProducto.php?operacion=Estatus&estatus=inhabilitado&id=<?=$data['id']?>'><i class="fas fa-check"></i></a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ha<?=$nam?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="exampleModalLabel">Habilitar <?=$data['nombre']?> <i class='far fa-2x fa-eye'></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p align="justify">¿Esta seguro de que desea <strong>habilitar</strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
        <a class="btn btn-info" href='../../../controladores/ControladorProducto.php?operacion=Estatus&estatus=habilitado&id=<?=$data['id']?>'><i class="fas fa-check"></i></a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="stock<?=$nam?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="exampleModalLabel">Modificar cantidad de <strong><?=$data['nombre']?></strong> <i class='far fa-2x fa-boxes'></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
          <form name="form1" method="POST" class="form-inline" action="../../../controladores/ControladorProducto.php" >
           
            
            <div class="input-group mb-2 mr-md-2">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="far fa-box"></i></div>
              </div>
              
              <input type="number" name='stock' min="1" max="5000" class="form-control" value="<?=$data['stock']?>">
            </div>
          
              <input type="hidden" name="operacion" value='Mod_Stock'>
              <input type="hidden" name="id" value="<?=$data['id']?>">
            
            <button type="submit" class="btn btn-primary btn-lg mb-2">Modificar Cantidad</button>
          
          </form>



      </div>
    
    </div>
  </div>
</div>
