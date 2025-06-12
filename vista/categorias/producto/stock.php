<?php
$nucleo = 'Productos';
$title = 'Productos Agotados';
$clave = 1;

include('../../js/restric.php');
extract($_REQUEST);

if ($clave == '') { ?>
  <script type="text/javascript"> 
    alert('No se puede listar, no hay autorización');
    window.location = "../home/home.php";
  </script>
<?php

} else {
  $lista = "SELECT producto.id, producto.cod_barra, producto.nombre, producto.precio, producto.porcentaje, producto.stock, producto.modified, producto.estatus, categorias.nombre AS categorias, ubicacion.nombre AS ubicacion 
          FROM producto
          INNER JOIN categorias ON producto.id_categorias = categorias.id
          INNER JOIN ubicacion ON producto.id_ubicacion = ubicacion.id
          WHERE producto.stock <= 0";

  $respuesta = mysqli_query($conex, $lista);
  $pruebo = mysqli_num_rows($respuesta);
?>
  <body>
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Productos Agotados</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="example" class="table">
                  <thead class="text-primary">
                    <tr>
                      <th><i class="far fa-2x fa-barcode" title="Código de barras"></i></th>
                      <th>Nombre</th>
                      <th>Categoria</th>
                      <th>Existencia</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $nam = 0;
                  while ($data = mysqli_fetch_array($respuesta)) {
                  ?>
                    <tr>
                      <td><?= $data['cod_barra'] ?></td>
                      <td><?= $data['nombre'] ?></td>
                      <td><?= $data['categorias'] ?></td>
                      <td>
                        <?= $data['stock'] ?>
                        <a href="#" data-toggle='modal' data-target='#stock<?= $nam ?>' title="¿Modificar cantidad en existencia del producto?">
                          <i class='far fa-2x fa-pen text-primary'></i>
                        </a>
                      </td>
                    </tr>
                    <?php
                      include '../modals/modal_productos.php';
                      $nam++;
                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#example').DataTable();
    });
  </script>
  <?php include('../footerbtn.php'); ?>
<?php
}
?>
