<?php 

session_start();
include("../modelos/clasedb.php");
extract($_REQUEST);


class ControladorBitacora
{


public function menui() {


	$db=new clasedb();
	$conex=$db->conectar();
	
	$sql="SELECT * FROM bitacora WHERE accion='Inserto' ";//mostrar
	$res=mysqli_query($conex,$sql);
	
	$campos=mysqli_num_fields($res);
	$filas=mysqli_num_rows($res);
	
	$i=0;
	
	$datos[]=array();

	while($data=mysqli_fetch_array($res)) {
		for($j=0;$j<$campos;$j++) {
			$datos[$i][$j]=$data[$j];
		}
		$i++;
		}
	
		header("Location: ../vista/categorias/bitacora/menui.php?filas=".$filas."&campos=".$campos."&data=".serialize($datos));//mandar datos codificados a la dirección de la función header
	}
static function controlador($operacion) {
	
		$pro=new ControladorBitacora();
		switch($operacion) {
			
		case 'menui':	
		$pro->menui();
		break;
		
	    default: 
		?>

		<script type="text/javascript">
			alert("sin ruta, no existe");
			window.location="../home.php";
		</script>
	<?php
	break;
	       }
     } 
}//cierro el controladorpedido 
ControladorBitacora::controlador($operacion);
//se tiene que destruir los datos en cart_items una vez que se presione pagar ?>