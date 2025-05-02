<?php

try{

/* ´connect to db */
$db = new clasedb();
$conex = $db->conectar();

/*Config of the hour*/

$hoy = date('Y-m-d');

$off = "SELECT * FROM producto WHERE stock=0";
$void = mysqli_query($conex, $off);
$vac = mysqli_num_rows($void); // See what product it's totally empty

$sql3 = "SELECT * FROM usuarios WHERE id=" . $id_usuario; //mostrar
$res3 = mysqli_query($conex, $sql3);

$date = mysqli_fetch_object($res3);
$nombre = $date->nombre;

$pagos = mysqli_num_rows($res3);

$sql2 = "SELECT producto.nombre,cart_menu.quantity FROM producto,cart_menu WHERE cart_menu.user_id=" . $id_usuario . " AND cart_menu.product_id=producto.id"; //mostrar

$res2 = mysqli_query($conex, $sql2);
$menu = mysqli_num_rows($res2);

$sql3 = "SELECT * FROM producto"; //mostrar

$res3 = mysqli_query($conex, $sql3);
$menu3 = mysqli_num_rows($res3);

$sql4 = "SELECT * FROM `dolar` ORDER BY `dolar`.`valor` DESC";

$res4 = mysqli_query($conex, $sql4);
$rows = mysqli_num_rows($res4);

if ($rows > 0) {

  $dolar = mysqli_fetch_object($res4);
  $valor = $dolar->valor;
}

$sql5 = "SELECT DISTINCT pedidos.factura FROM pedidos WHERE pedidos.metodo='Credito'";
$reste = mysqli_query($conex, $sql5);
$resrows = mysqli_num_rows($reste);

$privi = "SELECT p.id,p.nucleo,p.name FROM privileges p ,usuarios_has_privileges uh ,usuarios u WHERE u.id=".$_SESSION['id']." AND uh.id_usuarios = u.id AND p.id = uh.id_privileges;";
$rescata = mysqli_query($conex, $privi);

$rows_privs = mysqli_num_rows($rescata);

if ($rows_privs <= 0) {

  header(" Location: ../../../index.php?alert=error");

} 

while($privis = mysqli_fetch_array($rescata)){

  $privs[] = $privis;

}

//echo $privi;

}catch(mysqli_sql_exception | Exception $e) {

  header(" Location: ../../../index.php?alert=privs");

}finally {

  //mysqli_close($conex);

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="icon" href="../../icos/logo.webp">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>InventPoint- <?= $title ?>
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
  <!--     Fonts and icons
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" /> -->
  <link rel="stylesheet" href="../../estilos/fontawesome/css/all.min.css">
  <!-- CSS Files -->
  <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../../assets/demo/demo.css" rel="stylesheet" />
  <!-- Datatables-->
  <script src="../../assets/js/core/jquery.min.js"></script>
  <script src="../../estilos/datatables2.js"></script>
  <script src="../../js/datatables1.js"></script>


</head>

<body class="user-profile">
  <div class="wrapper">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      -->
      <div class="logo">
        <a href="#" class="simple-text logo-mini">
          <img class="img rounded-circle" src="../../icos/logo.webp" width="40" height="40" fill="none"
            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true"
            class="mr-2" viewBox="0 0 24 24" focusable="false"> </a>
        <a href="../home/home.php" class="simple-text logo-normal" title="Incio">
          <strong>
            <h5>InventPoint</h5>
          </strong>
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">

          <?php
         if ( has_privi($privs,"List","Producto") ) { ?>

            <li>

              <a id="sidebarDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-forklift"></i>

                <p>Productos</p>

                <div class="dropdown-menu" aria-labelledby="sidebarDropdownLink">



                  <a class="dropdown-item" href="../producto/registrar.php">Registrar nuevo producto</a>

                  <a class="dropdown-item"
                    href="../../../controladores/ControladorProducto.php?operacion=index&autorizo=autorizo">
                    Listado de Productos</a>
                  <hr>
                  <a class="dropdown-item"
                    href="../../../controladores/ControladorProducto.php?operacion=stock&autorizo=autorizo">Listado de
                    productos con <br> <strong>Bajo Stock</strong></a>

                  <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal1" id="openModal11"
                    href="">Ingresar <strong>Valor
                      del dolar | USD</strong></a>

                  <a class="dropdown-item"
                    href="../../../controladores/ControladorConversor.php?operacion=index&autorizo=autorizo">Listar
                    valores ingresados</a>

                </div>
              </a>
            </li>


            <li>


              <a id="sidebarDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-cubes"></i>
                <p>Detalles</p>
                <div class="dropdown-menu" aria-labelledby="sidebarDropdownLink">



                  <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal3" href="">Registrar
                    <strong>Categorias</strong> <br>de Productos</a>

                  <a class="dropdown-item"
                    href="../../../controladores/ControladorCategoria.php?operacion=index&autorizo=autorizo">Lista de
                    Categorias</a>

                  <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal2" href="">Registrar
                    <strong>Ubicaciones</strong><br> para Productos</a>
                  <a class="dropdown-item"
                    href="../../../controladores/ControladorUbicacion.php?operacion=index&autorizo=autorizo">Lista de
                    ubicaciones</a>
                </div>
              </a>
            </li>
          <?php 

          }

          if ( has_privi($privs,"List","Cliente")) {
            ?>

            <li>
              <a id="sidebarDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fad fa-user-friends"></i>
                <p>Clientes</p>
                <div class="dropdown-menu" aria-labelledby="sidebarDropdownLink">
                  <a class="dropdown-item" href="../cliente/registrar.php">Registrar</a>
                  <a class="dropdown-item"
                    href="../../../controladores/ControladorCliente.php?operacion=index&autorizo=autorizo">Lista de
                    Clientes</a>

                </div>
              </a>
            </li>
          <?php } ?> 

          <?php if( has_privi($privs,"List","Pedidos")){ ?>
            <li>
              <a id="sidebarDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fad fa-cash-register"></i>
                <p>Ventas</p>
                <div class="dropdown-menu" aria-labelledby="sidebarDropdownLink">

                  <a class="dropdown-item" href="../car/productos.php">Realizar una venta</a>
                  <a class="dropdown-item" href="../../../controladores/ControladorPedido.php?operacion=factura">Ventas
                    exitosas</a>

                  <a class="dropdown-item" href="../car/clienpagos.php">Ventas sin culminar</a>

                  <a class="dropdown-item" href="../factura/index.php">Recibos</a>

                  <hr>

                  <a class="dropdown-item" href="../car/todo_dia.php">Ver todos los <strong>créditos</strong></a>
                
                </div>
              </a>
            </li>

            <li>
              <a id="sidebarDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fad fa-file-alt"></i>
                <p>Cierre</p>
                <div class="dropdown-menu" aria-labelledby="sidebarDropdownLink">

                  <a class="dropdown-item" href="../cierre/cierre.php">Realizar cierre</a>

                </div>
              </a>
            </li>
            <?php

          }

          if ( has_privi($privs,"List","Usuarios") ) { ?>

            <li>

              <a id="sidebarDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fad fa-user-hard-hat"></i>

                <p>Empleados</p>

                <div class="dropdown-menu" aria-labelledby="sidebarDropdownLink">

                  <a class="dropdown-item" href="../../../controladores/ControladorUsuarios.php?operacion=registrar">Registro de Empleados</a>
                  <a class="dropdown-item"
                    href="../../../controladores/ControladorUsuarios.php?operacion=index">Lista de
                    usuarios</a>
                </div>
              </a>
            </li>

          <?php } ?>

          <li>
              <a id="sidebarDropdownLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fad fa-cogs"></i>
                <p>Respaldo</p>
                <div class="dropdown-menu" aria-labelledby="sidebarDropdownLink">
                  <a class="dropdown-item" href="../respaldo/respaldo/respaldo.php">Respaldar Base de datos</a>
                  <a class="dropdown-item" href="../respaldo/index_files.php">Lista de puntos de restauraci&oacute;n</a>           
               </div>
              </a>
          </li>

          <li class="active-pro">
            <a href="https://www.instagram.com/romgodevelop1/">
              <i class="fad fa-external-link"></i>
              <p>Contactenos</p>
            </a>
          </li>

        </ul>
      </div>
    </div>

    <!-- End of sidebar -->


    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand"><?= $nucleo ?></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <!-- <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="fad fa-search"></i>
                  </div>
                </div>
              </div>
            </form> -->

            <ul class="navbar-nav">
              <!-- <li class="nav-item ">
                <a class="nav-link" href="../car/carro.php">
                   <i class="far  fa-cart-plus"></i>
                      <span class="d-lg-none d-md-block">
                    <p align="justify">Productos en el carrito</p>
                      </span>

                    <p align="justify"><?= $menu ?></p>

                 </a>
               </li> -->

              <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">

                  <i class="fas fa-3x fa-user"></i>

                  <span class="d-lg-none d-md-block"><?= $nombre ?></span>

                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">


                  <a title="Salir del sistema" class="dropdown-item"
                    href="../../../controladores/ControladorLogin.php?operacion=logout"><i
                      class="far fa-2x fa-walking"></i><i class="far fa-2x fa-door-open"></i><strong>Cerrar
                      sesión</strong></a>



                </div>


              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-3x fa-cart-plus"></i>
                  <p>
                    <?= $menu ?>
                    <!-- Quiere decir ue cuando esta pantala completa,no se muestra, de lo contrario,si <span class="d-lg-none d-md-block">
                    <?= $nombre ?></span>-->
                  </p>
                </a>


                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">

                  <?php

                  if ($menu <= 0) {

                    echo " <a class='dropdown-item' href='../car/carro.php'><i class='far fa-3x fa-sad-cry'></i><strong>¡No hay pedidos!</strong></a>";

                  } else {

                    while ($data = mysqli_fetch_array($res2)) {

                      echo " <a class='dropdown-item' href='../car/carro.php'><i class='far fa-3x fa-shopping-cart'></i>" . $data['nombre'] . " <strong class='text-primary'>x</strong> " . $data['quantity'] . "</a>";

                    } ?>

                  </div>


                <?php } ?>

              </li>


              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="far fa-3x fa-credit-card" title="Cuentas por cobrar"></i>
                  <p>
                    <?= $resrows ?>
                    <!-- Quiere decir ue cuando esta pantala completa,no se muestra, de lo contrario,si <span class="d-lg-none d-md-block">
                    <?= $nombre ?></span>-->
                  </p>
                </a>


                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">

                  <?php

                  if ($resrows <= 0) {

                    echo " <a class='dropdown-item' href='../car/carro.php'><i class='far fa-3x fa-sad-cry'></i><strong>¡No hay créditos para hoy!</strong></a>";

                  } else {

                    while ($dato = mysqli_fetch_array($reste)) {

                      echo " <a class='dropdown-item' href='../car/todo_dia.php'><i class='far fa-3x fa-shopping-cart'></i>REC000".$dato['factura'] . "</a>";

                    } ?>

                  </div>


                <?php } ?>





              </li>



              <?php

              if ($vac > 0) { ?>

                <li class="nav-item dropdown">
                  <a class="nav-link"
                    href="../../../controladores/ControladorProducto.php?operacion=stock&autorizo=autorizo"
                    title="Productos Agotados">
                    <i class="far fa-3x fa-ghost" title="Productos Agotados"></i>
                    <p><?= $vac ?>
                      <!-- <span class="d-lg-none d-md-block"> 
                    <?= $nombre ?></span>-->
                    </p>
                  </a>
                </li>

              <?php } 
              
               if( !isset($valor) ){ ?>

                <li class="nav-item">
                <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal1" id="openModal11">
                  <i class="far fa-3x fa-dollar-sign " title="No hay valor del dolar"></i>
                </a>
               </li>

                

               <?php } ?>
            </ul>
          </div>
        </div>
      </nav>


      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>