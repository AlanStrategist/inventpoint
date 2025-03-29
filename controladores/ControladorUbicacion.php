<?php
include("../modelos/clasedb.php");
extract($_REQUEST);


class ControladorUbicacion
{
	public function index()
	{
		extract($_REQUEST);

		if ($autorizo == '') {
			?>

			<script type="text/javascript">
				alert('No existe autorización para listar');
				window.Location: '../vista/categorias/home/home.php'
			</script>
			<?php
		} else {

			$clave = 1;

			if (isset($alert)) {

				header("Location: ../vista/categorias/ubicacion/index.php?clave=" . $clave . "&alert=" . $alert);

			} else {
				header("Location: ../vista/categorias/ubicacion/index.php?clave=" . $clave);

			}
		}

	}


	public function guardar()
	{
		session_start();

		if (empty($_SESSION['id'])) {
			header("Location: ../index.php?alert=inicia");
		} else {
			$id_usuario = $_SESSION['id'];

		}
		extract($_POST);

		$db = new clasedb();
		$conex = $db->conectar();

		$nomexist = "SELECT * FROM ubicacion WHERE nombre='" . $nombre . "'";
		$result = mysqli_query($conex, $nomexist);
		$nombresbd = mysqli_num_rows($result);



		if ($nombresbd > 0) {

			header("Location: ./ControladorUbicacion.php?operacion=index&autorizo=autorizo&alert=du");
			//si el nombre esta duplicado
		} else {


			$sql = "INSERT INTO `ubicacion` (`id`, `nombre`) VALUES (NULL, '$nombre');";

			$resultado = mysqli_query($conex, $sql);

			if ($resultado) {



				header("Location: ControladorUbicacion.php?operacion=index&alert=exito&autorizo=autorizo");

			} else {

				header("Location: ./ControladorUbicacion.php?operacion=index&alert=error&autorizo=autorizo");
			}
		}
	}
	//fin de funcion guardar
	public function modificar()
	{
		extract($_REQUEST);
		header("Location: ../vista/categorias/ubicacion/modificar.php?id=" . $id);
	}


	public function guardar_modificacion()
	{
		session_start();

		if (empty($_SESSION['id'])) {
			header("Location: ../index.php?inicia");
		} else {
			$id_usuario = $_SESSION['id'];
		}

		extract($_POST);

		$db = new clasedb();
		$conex = $db->conectar();


		$sql = "UPDATE ubicacion SET id='$id',nombre='$nombre' WHERE id='$id'";

		$resultado = mysqli_query($conex, $sql);

		if ($resultado) {

			header("Location: ControladorUbicacion.php?operacion=index&alert=modisi&autorizo=autorizo")
			;		 #
		} else {

			header("Location: ControladorUbicacion.php?operacion=index&alert=modino&autorizo=autorizo");
		}
	}


	static function controlador($operacion)
	{

		$pro = new ControladorUbicacion();
		switch ($operacion) {

			case 'index':

				$pro->index();
				break;

			case 'guardar':
				$pro->guardar();
				break;
			case 'modificar':
				$pro->modificar();
				break;
			case 'guardar_modificacion':
				$pro->guardar_modificacion();
				break;

			default:
				?>

				<script type="text/javascript">
					alert("sin ruta, no existe");
					window.location = "ControladorUbicacion.php?operacion=index";
				</script>
				<?php
				break;
		}

	}
}

ControladorUbicacion::controlador($operacion);

//include ('../vista/categorias/footerbtn.php');


?>