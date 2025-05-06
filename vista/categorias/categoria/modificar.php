<?php
$nucleo = 'Productos';
$title = 'Modificar Categoria';
include('../../js/restric.php');


extract($_REQUEST);
$sql = "SELECT * FROM categorias WHERE id=" . $id;
$res = mysqli_query($conex, $sql);
$data = mysqli_fetch_array($res);
?>


<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Modificar categoria</h5>
        </div>
        <div class="card-body">

          <form method="POST" class="needs-validation" enctype="multipart/form-data" size="30"
            action="../../../controladores/ControladorCategoria.php?operacion=guardar_modificacion" novalidate>
            <div class="row">
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label for="cod_barra">Nombre</label>
                  <input type="text" name="nombre" title="Nombre de la categoria" minlength="2" maxlength="20"
                    class="form-control" required="required" value="<?= $data['nombre'] ?>">

                  <div class="valid-feedback">¡Bien! <i class="far fa-2x fa-smile"></i> </div>
                  <div class="invalid-feedback">¡No puede haber campos vacios!</div>

                </div>
              </div>

              </table>
              <br>


              </tbody>
              </table>

              <input type="hidden" name="operacion" value="guardar_modificacion">
              <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
              <div class="col-md-8">


                <input class="btn btn-primary pull-right" type="submit" value="Cargar">

              </div>




          </form>
        </div>
      </div>
    </div>



    <?php include('../footerbtn.php');


    include('../../js/validacion.php');

    ?>