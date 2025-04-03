<div class="modal fade" id="I<?=$nam?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="exampleModalLabel">Inhabilitar <i class='far fa-2x fa-user'></i> <i class='far fa-2x fa-times'></i>  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p align="justify">¿Esta seguro de que desea <strong>inhabilitar <?=$data['nombre']?> </strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
        <a class="btn btn-info" href='../../../controladores/ControladorUsuarios.php?operacion=Status&id=<?=$data['id']?>&status=inactivo'><i class="fas fa-check"></i></a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="H<?=$nam?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="exampleModalLabel">Habilitar <i class='far fa-2x fa-user'></i><i class='far fa-2x fa-check'></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p align="justify">¿Esta seguro de que desea <strong>habilitar <?=$data['nombre']?> </strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
        <a class="btn btn-info" href='../../../controladores/ControladorUsuarios.php?operacion=Status&id=<?=$data['id']?>&status=activo'><i class="fas fa-check"></i></a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="RolAd<?=$nam?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="exampleModalLabel">Rol de Usuario <i class='far fa-2x fa-headset'></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p align="justify">¿Esta seguro de que convertir a <strong><?=$data['nombre']?></strong> en administrador?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
        <a class="btn btn-info" href='../../../controladores/ControladorUsuarios.php?operacion=Rol&id=<?=$data['id']?>&rol=admin'><i class="fas fa-check"></i></a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="RolEm<?=$nam?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="exampleModalLabel">Rol de usuario <i class='far fa-2x fa-user-hard-hat'></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p align="justify">¿Esta seguro de que desea convertir a <strong> <?=$data['nombre']?></strong> en <strong>Empleado</strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
        <a class="btn btn-info" href='../../../controladores/ControladorUsuarios.php?operacion=Rol&id=<?=$data['id']?>&rol=empleado'><i class="fas fa-check"></i></a>
      </div>
    </div>
  </div>
</div>
