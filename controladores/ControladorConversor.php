<?php
include("../modelos/clasedb.php");
include "./Utils.php";

if( !isLoged()) { header("Location: ../index.php?alert=inicia");  }

extract($_REQUEST);


class ControladorConversor
{
	public function index()
	{
		extract($_REQUEST);

		header("Location: ../vista/categorias/conversor/index.php?alert=" . $alert);

	}


	public function convertir()
	{   
		extract($_POST);
		
		$id_usuario = $_SESSION["id"];

		try{
		
		$db = new clasedb();
		$conex = $db->conectar();


		$sql4 = "INSERT INTO `dolar` (`id`, `valor`, `fecha`,`id_usuario`) VALUES (NULL, '$dolar',CURRENT_TIMESTAMP,'$id_usuario')";
		$gato = mysqli_query($conex, $sql4);

		if (!$gato) { 

			header("Location: ControladorConversor.php?operacion=index&alert=error");

			return;
		}

		header("Location: ControladorConversor.php?operacion=index&alert=exito");
		
		return;

		} catch (mysqli_sql_exception | Exception $e) {

			header("Location: ControladorConversor.php?operacion=index&alert=error");

		}finally{
			
			mysqli_close($conex);

		}


	}
	//fin de funcion convertir




	static function controlador($operacion)
	{

		$pro = new ControladorConversor();
		switch ($operacion) {

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
					window.location = "ControladorConversor.php?operacion=index";
				</script>
				<?php
				break;
		}

	}
}

ControladorConversor::controlador($operacion);


?>