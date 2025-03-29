<?php 
$nucleo='Clientes';
$title='Registrar Clientes';
include('../../js/restric.php'); 


extract($_REQUEST);


if ($privis['pedidos']==1) {
  
}else{ ?>  


  <script type="text/javascript">
    window.location= "../home/home.php?alerta=sinprivis"
  </script>

  <?php

 }



?>


<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Registro de Cliente</h5>
        </div>
        <div class="card-body">
          <form  enctype="multipart/form-data" class="needs-validation" method="POST" action="../../../controladores/controladorcliente.php" novalidate>

            <div class="row">
              <div class="col-md-5 pr-1">

                <div class="form-group">
                  <label>Nombre Completo</label>
                  <input type="text" name="nombre" title="Nombre completo" minlength="5" maxlength="20" class="form-control" placeholder="Gonzalo González" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios!</div> 

                </div>
              </div>
              <div class="col-md-3 px-1">
                <div class="form-group">
                  <label for='id-card'>Cédula</label>
                  <input type="text" name="cedula" minlength="5" maxlength="23" class="form-control" placeholder="33987654" required="required">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios!</div> 
                </div>
              </div>


              <div class="col-md-4 pl-1">
                <div class="form-group">
                  <label for="exampleInputEmail1">Tipo de Cliente</label>
                  <select  name="tipo"  required="required" class="form-control">

                    <option value="Venezolano"  title="Venezolano">Venezolano/V</option>

                    <option value="Extranjero" title="Extranjero">Extranjero/E</option>

                    <option value="RIF" title="Rif">Jurídico/RIF</option>
                  </select>


                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios!</div> 

                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label><i class="far fa-2x fa-phone text-danger" title="Teléfono"></i> Teléfono</label>
                            
                 <input type="tel" name="telefono" title="Solo números sin espacios y símbolos" min="1" max="10000000" class="form-control" placeholder="Ejemplo=10" required="required" pattern="[0-9]{11}">

                
                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios! el número de telefono debe ser de 11 números, solo se permiten números</div> 
                </div>
                
              </div>


              <input  type="hidden" name="operacion" value="guardar">
              <div class="col-md-8">

                <input class="btn btn-info pull-right" type="reset" name="limpiar" value="Limpiar">
                <input  class="btn btn-primary pull-right" type="submit" value="Cargar">

              </div>

            </form>
          </div>
        </div>
      </div>










      <?php 

      include('../../js/validacion.php');

      include('../footerbtn.php'); ?>
