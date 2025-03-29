<?php
session_start();

if(empty($_SESSION['logueado'])){



header('location:index.php?autorizadono');

}

elseif ($_SESSION['logueado']=='Si') {

include ("modelos/clasedb.php");
  $db=new clasedb();
  
  $conex=$db->conectar();
  
  $estatus="cliente";
  
  $id_usuario=$_SESSION['id'];
  
  $sql="SELECT * FROM usuarios WHERE tipo_usuario='".$estatus."'AND id=".$id_usuario." AND estatus='activo'";//mostrar
  $res=mysqli_query($conex,$sql);
  
  $mandalo=mysqli_num_rows($res);
  
if ($mandalo>0) {
  header('location:index.php?autorizadono');




} else{
  echo "";
}

 } ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Administrador</title>
    
    <link rel="icon" href="vista/icos/admin.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/dashboard/">
    <link rel="stylesheet" href="vista/estilos/fontawesome/css/all.min.css">

    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="vista/estilos/bootstrap.min.css">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <link rel="stylesheet" href="vista/estilos/dashboard.css">
     <link rel="stylesheet" href="vista/estilos/sb-admin-2.min.css">
  </head>
  <body>
     <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
  

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="home.php">
          <i class="fas fa-fw fa-home"></i>
          <span>Inicio</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
      
      </div>
     

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-edit"></i>
          <span>Registrar</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Registro de Elementos:</h6>
            <a class="collapse-item" href="vista/categorias/plan/registrar.php">Plan de Reservación</a>
            <a class="collapse-item" href="vista/categorias/banco/registrar.php">Cuenta Bancaria</a>
             <a class="collapse-item" href="vista/categorias/menu/registrar.php">Elementos de la Carta</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-list"></i>
          <span>Listar</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Listar Elementos:</h6>
            <a class="collapse-item" href="controladores/controladorplan.php?operacion=index">Planes de Reservación</a>
            <a class="collapse-item" href="controladores/controladormenu.php?operacion=index">Elementos de Carta</a>
            <a class="collapse-item" href="controladores/controladorbanco.php?operacion=index">Cuentas Bancarias</a>
          
          </div>
        </div>
      </li>

     
           
 <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-piggy-bank"></i>
          <span>Pago</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Estados de Pago:</h6>
            <a class="collapse-item" href="controladores/controladorpago.php?operacion=index">Pagos sin calificar</a>
            <a class="collapse-item" href="controladores/controladorpago.php?operacion=aprobado">Pagos exitosos</a>
             <a class="collapse-item" href="controladores/controladorpago.php?operacion=desaprobado">Pagos rechazados</a>
          </div>
        </div>
      </li>


 <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefourth" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-glass-martini"></i>
          <span>Pedidos</span>
        </a>
        <div id="collapsefourth" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Estados de Pedidos:</h6>
            <a class="collapse-item" href="controladores/controladorpedido.php?operacion=index">Pedidos sin calificar</a>
            <a class="collapse-item" href="controladores/controladorpedido.php?operacion=aprobado">Pedidos exitosos</a>
             <a class="collapse-item" href="controladores/controladorpedido.php?operacion=desaprobado">Pedidos rechazados</a>
          </div>
        </div>
      </li>










 


 <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefiveth" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-file-image"></i>
          <span>Contenido</span>
        </a>
        <div id="collapsefiveth" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Modificar:</h6>
            <a class="collapse-item" href="controladores/controladorcarrusel.php?operacion=index">Imagén del Carrousel</a>
            
          </div>
        </div>
      </li>

 <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsesix" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Mantenimiento</span>
        </a>
        <div id="collapsesix" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Realizar:</h6>
            <a class="collapse-item" href="controladores/controladorregistro.php?operacion=index">Control de Usuario</a>
             <a class="collapse-item" href="controladores/controladorregistro.php?operacion=rol">Rol de Usuario</a>
              <a class="collapse-item" href="vista/categorias/respaldo/respaldo.php">Respaldo de la base  <br>de datos</a>
              
            <a class="collapse-item" href="vista/categorias/respaldo/restaurar.php">Restauración de  <br>la base de datos</a>
          <a class="collapse-item" href="bi.php">Bitácora</a>
          </div>
        </div>
      </li>




      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0 text-white" id="sidebarToggle"><i class="fal fa-1x fa-share"></i></button>
      </div>

    </ul>

<!-- nav bar superior -->
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow"> 

 
       <img class="img rounded-circle" src="vista/i/gran.ico" width="40" height="40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false">
        <div>
       <h1 class="btn-lg bg-dark text-white mr"> Gran Campo</h1>
       <!-- nav bar superior -->


</div>
<!-- botones con numeritos -->

<?php



$db=new clasedb();
  $conex=$db->conectar();
  $estatus="Espera";
  $sql="SELECT * FROM pedidos WHERE estatus='".$estatus."'";//mostrar
  $res=mysqli_query($conex,$sql);

  $numero=mysqli_num_rows($res);
  //que traiga el numero de pagos sin autorizar

   $sql2="SELECT * FROM pago WHERE estatus='Espera'";
  

  $res2=mysqli_query($conex,$sql2);

  $numerop=mysqli_num_rows($res2);


$sql3="SELECT * FROM usuarios WHERE id=".$id_usuario;//mostrar
$res3=mysqli_query($conex,$sql3);

$date=mysqli_fetch_object($res3);
$nombre=$date->nombre;

$pagos=mysqli_num_rows($res3);



  $sql5="SELECT * FROM usuarios WHERE tipo_usuario='cliente' AND estatus='activo'";//mostrar
  $res5=mysqli_query($conex,$sql5);
  
  $mandalo1=mysqli_num_rows($res5);
$sql6="SELECT * FROM usuarios WHERE tipo_usuario='cliente' AND estatus='inactivo'";//mostrar
  $res6=mysqli_query($conex,$sql6);
  
  $mandalo2=mysqli_num_rows($res6);


   ?>




      <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
        
        <a class="btn-lg btn-dark" href="controladores/controladorpedido.php?operacion=index" role="button">
  <i class="fas fa-glass-martini"></i> <span class="badge badge-info"><?=$numero?></span>
</a>

 <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
        
        <a class="btn-lg btn-dark" href="controladores/controladorpago.php?operacion=index" role="button">
  <i class="fas fa-piggy-bank"></i> <span class="badge badge-info"><?=$numerop?></span>
</a>

<!-- botones con numeritos -->


<!-- ELementos de la barra superior -->



<!-- imagen que nos mandaron eliminarla -->


<!-- 
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
         <img class="img rounded-circle" src="../../i/cerrar.png" width="40" height="40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false">
   
   ELementos de la barra superior -->

   </ul>
   </li> 

<ul>


        <!--fecha-->
        <script> 

var mydate=new Date(); 
var year=mydate.getYear(); 
if (year < 1000) 
year+=1900; 
var day=mydate.getDay(); 
var month=mydate.getMonth()+1; 
if (month<10) 
month="0"+month; 
var daym=mydate.getDate(); 
if (daym<10) 
daym="0"+daym; 
document.write("<small><font color='FFFFFF' face='Arial'><b>"+daym+"/"+month+"/"+year+"</b></font></small>") 
  
</script>
<!--fecha-->
<!--Esta es la hora -->

<script type="text/javascript">
function startTime(){
today=new Date();
h=today.getHours();
m=today.getMinutes();
s=today.getSeconds();
m=checkTime(m);
s=checkTime(s);
document.getElementById('reloj').innerHTML=h+":"+m+":"+s;
t=setTimeout('startTime()',500);}
function checkTime(i)
{if (i<10) {i="0" + i;}return i;}
window.onload=function(){startTime();}
</script>
<small id="reloj" class=" btn-sm text-white" ></small>
<!--Esta es la hora -->
  

</ul>



 <div class="btn-group">
<button type="button" href="#" class=" btn-sm bg-dark text-white dropdown-toggle " data-toggle="dropdown" data-toggle="dropdown" aria-expanded="false"><i class="fad fa-user"></i>
 <?=$nombre?>
  </button>


     <div class="dropdown-menu dropdown-menu-right">

<?php 

if (empty($_SESSION["logueado"])) { ?>

   <a class="dropdown-item" href="../../../index.php"><i class="fas fa-door-open"></i>Iniciar sesión</a> 



     <a class="dropdown-item" href="../../registro/registrar.php"><i class="fas fa-edit"></i>Registrarse</a>
  
<?php }else{ ?>
  
       <a class="dropdown-item" href="controladores/controladorlogin.php?operacion=logout"><i class="fa fa-external-link-square"></i>Cerrar sesión</a>
       
        <a class="dropdown-item" href="vista/categorias/carrusel/portal.php"><i class="fab fa-codepen"></i>Ir al Portal</a>
          <a class="dropdown-item" href="vista/ayuda/manual.pdf"><i class="fad fa-info-circle"></i>Ayuda</a>
<?php } ?>

   

</div></div>
</nav>



  <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">

      
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  
     </div>
    <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1> <i class="fad fa-clipboard fa-2x text-gray-300"></i> Ayuda </h1>
           
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h6 mb-0 font-weight-bold text-gray-800">Registrar elemento </div>
                    </div>
                    <div class="col-auto">
                       <a href="vista/ayuda/registro.pdf"title="Ir a la ayuda">
                      <i class="fad fa-hat-chef fa-3x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h6 mb-0 font-weight-bold text-gray-800">Listar elemento</div>
                    </div>
                    <div class="col-auto">
                      <a href="vista/ayuda/listar.pdf"><i class="fad fa-hat-chef fa-3x text-gray-300"title="Ir a la Ayuda"></i><i class="fad fa-ellipsis-v fa-2x text-gray-300" title="Ir a la Ayuda"></i> </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
     

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h6 mb-0 font-weight-bold text-gray-800">Modificar elemento</div>
                    </div>
                    <div class="col-auto">
                       <a href="vista/ayuda/modificar.pdf">
                      <i class="fad fa-hotel fa-3x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h6 mb-0 font-weight-bold text-gray-800">Habilitar/Inhabilitar elemento</div>
                    </div>
                    <div class="col-auto">
                      <a href="vista/ayuda/habi.pdf"><i class="fas fa-hotel fa-3x text-gray-300"title="Ir a la ayuda"></i><i class="fad fa-ellipsis-v fa-2x text-gray-300" title="Ir a la Ayuda"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

       
                   <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h6 mb-0 font-weight-bold text-gray-800">Pedidos:
                      Aprobar/Desaprobar</div>
                    </div>
                    <div class="col-auto">
                      <a href="vista/ayuda/pedi.pdf"><i class="fad fa-credit-card-front fa-3x text-gray-300"></i><i class="fad fa-ellipsis-v fa-2x text-gray-300" title="Ir a la Ayuda"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>








            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h6 mb-0 font-weight-bold text-gray-800">Pago:
                      Aprobar/Desaprobar</div>
                    </div>
                    <div class="col-auto">
                      <a href="vista/ayuda/pago.pdf" title="Ir a la ayuda"><i class="fad fa-thumbs-up fa-3x text-gray-300"></i> <i class="fad fa-ellipsis-v fa-2x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h6 mb-0 font-weight-bold text-gray-800">Manual </div>
                    </div>
                    <div class="col-auto">
                       <a href="vista/ayuda/manualcom.pdf"title="Ir a la ayuda">
                      <i class="fad fa-book fa-3x text-gray-300"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>




  
       
    
        <!--Realizar pantallas una vez se vea como realizar esta acción -->
    
      
    
<!-- barra lateral / botones con sus elementos-->
<!-- Espacio de trabajo -->
 


<script src="vista/js/jquery-3.3.1.slim.min.js" ></script>


      <script src="vista/js/bootstrap.bundle.min.js"></script>
      <script src="vista/js/bootstrap.min.js"></script>
  <script src="vista/js/sb-admin-2.min.js"></script>



  <!-- Core plugin JavaScript-->
  <script src="vista/js/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->

  <!-- Page level plugins -->
  <script src="vista/js/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
<script src="vista/js/popper.min.js"></script>   




</body>

</html>