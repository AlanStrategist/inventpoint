<?php  
include("../modelos/clasedb.php");
extract($_REQUEST);

  
class ControladorConversor
{
public function index() {
	extract($_REQUEST);
	
	if ($autorizo=='') {?>

		<script type="text/javascript">
			alert('No existe autorización para listar');
			window.Location:'../vista/categorias/home/home.php'
		</script>
	<?php 	
	}else{

		$clave=1;

		
		if (isset($_GET['modisi'])) {

        header("Location: ../vista/categorias/conversor/index.php?clave=".$clave."&modisi=modisi");

		}elseif(isset($_GET['no'])){

	    header("Location: ../vista/categorias/producto/index.php?clave=".$clave."&no=no");

		}elseif(isset($_GET['alerta'])){

	    header("Location: ../vista/categorias/producto/index.php?clave=".$clave."&alerta=alerta");

		}elseif(isset($_GET['modino'])){

	    header("Location: ../vista/categorias/conversor/index.php?clave=".$clave."&modino=modino");

		}elseif(isset($_GET['yahabil'])){

	    header("Location: ../vista/categorias/conversor/index.php?clave=".$clave."&yahabil=yahabil");

		}elseif(isset($_GET['yainhabil'])){

	    header("Location: ../vista/categorias/conversor/index.php?clave=".$clave."&yainhabil=yainhabil");

		}elseif(isset($_GET['habilitado'])){

	    header("Location: ../vista/categorias/conversor/index.php?clave=".$clave."&habilitado=habilitado");

		}elseif(isset($_GET['inhabilitado'])){

	    header("Location: ../vista/categorias/conversor/index.php?clave=".$clave."&inhabilitado=inhabilitado");

		}else{
			header("Location: ../vista/categorias/conversor/index.php?clave=".$clave);

			}
	}

}


	public function convertir(){
		session_start();

if (empty($_SESSION['id'])) {
	header("Location: ../index.php?inicia");
							}else{ 
	$id_usuario=$_SESSION['id'];
								 }
        
		extract($_POST);
		$db=new clasedb();
		$conex=$db->conectar();
		
   
$sql4="INSERT INTO `dolar` (`id`, `valor`, `fecha`,`id_usuario`) VALUES (NULL, '$dolar',CURRENT_TIMESTAMP,'$id_usuario')";
$gato=mysqli_query($conex,$sql4);

if ($gato){
	
    if ($estatus=="Empleado"){ ?>
    <script type="text/javascript">

    window.location='../vista/categorias/cliente/registrar.php?alerta=alerta'
    
    </script>
   
   <?php  }else{
   
   header("Location: ControladorConversor.php?operacion=index&autorizo=autorizo&alerta=alerta");
               }

    }else{ 
header("Location: ControladorConversor.php?operacion=index&autorizo=autorizo&no=no"); 
}

					}
//fin de funcion convertir
	



static function controlador($operacion) {
	
		$pro=new ControladorConversor();
		switch($operacion) {
			
		case 'index':
		
		$pro->index();
		break;
				
		case 'convertir':
			$pro->convertir();
		break;		
		default: 
		?>

		 <script type="text/javascript">
		 	alert("sin ruta, no existe");
		 	window.location="ControladorConversor.php?operacion=index";
		 </script> 
	<?php
	break;
	}

} 
} 

ControladorConversor::controlador($operacion);


?> 