<?php
$nucleo = 'Productos';
$title = 'Modificar un Producto';

include('../../js/restric.php');

extract($_REQUEST);




$sql = "SELECT * FROM producto WHERE id=" . $id;
$res = mysqli_query($conex, $sql);
$data = mysqli_fetch_array($res);

$sql2 = "SELECT * FROM categorias";
$sql3 = "SELECT * FROM ubicacion";

$res2 = mysqli_query($conex, $sql2);
$resub = mysqli_query($conex, $sql3);


?>


<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Nuevo Producto</h5>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data" size="30"
            action="../../../controladores/ControladorProducto.php?operacion=guardar_modificacion">


            <div class="row">
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label for="cod_barra">Código de barra</label>
                  <input type="text" name="cod_barra" id="cod_barra"
                    title="Con el lector de código de barra coloque el cursor en el campo y realice la lectura"
                    minlength="2" maxlength="20" class="form-control" placeholder="Ejemplo=4559-8766"
                    required="required" value="<?= $data['cod_barra'] ?>">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios!</div>

                </div>
              </div>


              <div class="col-md-3 px-1">
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" name="nombre" title="Coloque el nombre del item que quiere registrar" minlength="3"
                    maxlength="100" class="form-control" placeholder="Kit de tiempo" required="required"
                    value="<?= $data['nombre'] ?>">


                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios! ingrese de 3 a 50 caracteres</div>


                </div>
              </div>


              <div class="col-md-4 pl-1">
                <div class="form-group">
                  <label for="exampleInputEmail1">Precio</label>
                  <input type="number" step="any" name="precio" title="Solo números sin espacios y símbolos" min="1"
                    max="10000" class=" form-control" placeholder="Ejemplo:10" required="required"
                    value="<?= $data['precio'] ?>">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios! ingrese un número del 1 al 10000</div>




                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label>Cantidad en existencia</label>
                  <input type="number" name="stock" min="0" max="1000" class="form-control" placeholder="Ejemplo:2"
                    required="required" value="<?= $data['stock'] ?>">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios!ingrese un número del 0 al 1000</div>



                </div>
              </div>

              <div class="col-md-3 pr-1">
                <div class="form-group">
                  <label>Porcentaje </label>

                  <input type="number" name="porcentaje" title="Coloque el porcentaje de venta de este producto" min="0"
                    max="100" class="form-control" placeholder="Ejemplo:23" required="required"
                    value="<?= $data['porcentaje'] ?>">


                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios! ingrese un número del 1 al 100</div>


                </div>
              </div>




              <div class="col-md-4 pl-1">
                <div class="form-group">

                  <label for="categoria">Categoria</label>

                  <select name="categoria" required="required" class="form-control">

                    <?php

                    $vacio = mysqli_num_rows($res2);

                    if ($vacio > 0) {

                      while ($c = mysqli_fetch_array($res2)) {

                        echo "<option value=" . $c['id'] . "  title='Categoria'>" . $c['nombre'] . "</option>";


                      }
                    } else {
                      echo "<option value=''' title='Debes registrar una categoria de productos'></option>";

                      echo "<option value=''' title='Debes registrar una categoria de productos'>Sin Categorias</option>";
                    }
                    ?>

                  </select>
                </div>
              </div>

            </div>
            <div class="row">

              <div class="col-md-12">
                <div class="form-group">
                  <label for="ubicacion">Empresa</label>
                  <select name="ubicacion" required="required" class="form-control">

                    <?php

                    $vacio2 = mysqli_num_rows($resub);

                    if ($vacio2 > 0) {

                      while ($u = mysqli_fetch_array($resub)) {

                        echo "<option value=" . $u['id'] . "  title='Ubicación'>" . $u['nombre'] . "</option>";

                      }
                    } else {
                      echo "<option value=''' title='Debes registrar la ubicación del producto'></option>";

                      echo "<option value=''' title='Debes registrar la ubicación del producto'>Sin Ubicación</option>";
                    }

                    ?>

                  </select>
                </div>

              </div>

            </div>

            <input type="hidden" name="estatus" value="habilitado">
            <input type="hidden" name="operacion" value="guardar_modificacion">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

            <div class="col-md-8">

              <input class="btn btn-info pull-right" type="reset" name="limpiar" value="Limpiar">
              <input class="btn btn-primary pull-right" type="submit" value="Cargar">

            </div>




          </form>
        </div>
      </div>
    </div>








    <?php

    include('../../js/validacion.php');

    include('../footerbtn.php'); ?>