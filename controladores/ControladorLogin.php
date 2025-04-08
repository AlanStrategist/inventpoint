<?php

session_start();

include('../modelos/clasedb.php');
extract($_REQUEST);

class ControladorLogin
{
	static function controlador($operacion)
	{
		$login = new ControladorLogin();
		switch ($operacion) {
			case 'login':
				$login->loguear();
				break;
			case 'olvido':
				$login->olvido();
				break;
			case 'validar_correo':
				$login->validar_correo();
				break;
			case 'respuestas':
				$login->verificar_respuesta();
				break;
			case 'cambiar_clave':
				$login->cambiar_clave();
				break;
			case 'logout':
				$login->logout();
				break;
			case 'view_mail':
				$login->view_mail();
				break;

			default:

				break;
		}
	}

	public function loguear()
	{

		extract($_POST);
		$db = new clasedb();
		$conex = $db->conectar();

		if ($correo == "" || $clave == "") {

			header("Location: ../index.php?vacio");
			
			return;

		} else {
			
			$clave = hash('sha256', $clave);

			try{
			
			$sql = "SELECT * FROM usuarios WHERE correo='" . $correo . "' AND clave='" . $clave . "' AND estatus='activo'";

			$res = mysqli_query($conex, $sql);
			$tipo = mysqli_fetch_array($res);
			
			$_SESSION['id'] = $tipo['id'];
			$_SESSION['logueado'] = 'Si';

			$loc = $tipo['tipo_usuario'] == "admin" ? "Location: ../vista/categorias/home/home.php":"Location: ../vista/categorias/cliente/registrar.php";

			header($loc);
			
			}
			catch (mysqli_sql_exception | Exception $e ) {
				
				header('Location: ../../index.php?alert=error');

			}finally{

				mysqli_close($conex);

			}


		}

	}

	public function logout()
	{

		if ($_SESSION["logueado"] == "Si") {

			session_unset();

			$loc = "";

			$loc = session_destroy() ? "Location: ../index.php?alert=closef" : "Location: ../index.php?alert=error";

			header($loc);

		}
	}
	public function view_mail()
	{	

		extract($_REQUEST);

		try{

			$db = new clasedb();

			$conex = $db->conectar();

			$sql = "SELECT id FROM usuarios WHERE correo='".$correo."' AND estatus='activo'";

			$res = mysqli_query($conex, $sql);
			
			if( !$res ){
               
				header("Location: ../vista/categorias/usuarios/recuperacion/correo.php?alert=noex");

				return;
			}

			$us = mysqli_fetch_array($res);

			header("Location: ../vista/categorias/usuarios/recuperacion/quiz.php?id=".$us['id']);
			

		}catch (Exception | mysqli_sql_exception $e){

			header("Location: ../vista/categorias/usuarios/recuperacion/correo.php?alert=error");

		}finally{

			mysqli_close($conex);
		}
	}

	public function olvido()
	{
		header('location:../vista/categorias/usuarios/recuperacion/correo.php');

	}//fin de la funcion olvido 

	public function validar_correo()
	{
		extract($_POST);
		$db = new clasedb();
		$conex = $db->conectar();
		$sql = "SELECT * FROM usuarios WHERE correo='" . $correo . "'"; //para saber si esta bien aunque no se si tenga un error aquiii por las comillas.//alexandra

		if ($res = mysqli_query($conex, $sql)) {

			if (mysqli_num_rows($res) > 0) {
				while ($data = mysqli_fetch_object($res)) {
					$id_usuario = $data->id;
					$pregunta = $data->pregunta;
					$nombre = $data->nombre;
				}
				header("location:../vista/recuperacion/pregunta.php?id_usuario=" . $id_usuario . "&pregunta=" . $pregunta . "&nombre=" . $nombre);
			} else {

				header("location: ../index.php?no");
			}
		} else {
			echo "error en la BDD";
		}//fin del else
	}//fin de la funcion validar correo
	public function verificar_respuesta()
	{
		extract($_POST);
		$db = new clasedb();
		$conex = $db->conectar();

		$sql = "SELECT * FROM usuarios WHERE respuesta= '" . $respuesta . "' AND id=" . $id_usuario;  //puede que sea respuestas y eso no bromee
		if ($res = mysqli_query($conex, $sql)) {
			if (mysqli_num_rows($res) > 0) {
				#respuets correcta

				?>

				<script type="text/javascript">
					var id_usuario = "<?php echo $id_usuario ?>"
					alert('Respuesta correcta');
					window.location = "../vista/recuperacion/clave_nueva.php?id_usuario=" + id_usuario;
				</script>

				<?php
			} else {
				#respuesta correcta
				header("location: ../index.php?respuestano");
			}
		} else {
			echo "Error en la BDD";


		}
	}//fin de function verificar_respuesta
	public function cambiar_clave()
	{
		extract($_POST);
		if ($clave_nueva == "" || $clave_nueva_confirm == "") {#en caso que venga vacio
			?>
			<script type="text/javascript">
				var id_usuario = "<?php echo $id_usuario ?>";
				alert('Los campos de clave nueva no deben estar vacios');
				window.location = "../vista/recuperacion/clave_nueva.php?id_usuario=" + id_usuario;
			</script>
		<?php
		} else {


			#en modificar en el usuario de claves se hace un checkbox para que desbloque el hast, es decir <input type checkbox name cambiar. onchage "cambiar(this)" value 1> deseo cambiar mi clave.

			#en caso que sean iguales 
			if ($clave_nueva == $clave_nueva_confirm) {
				# en caso que sean iguales 
				$db = new clasedb();
				$conex = $db->conectar();
				$clave_nueva = hash('sha256', $clave_nueva);
				$sql = "UPDATE usuarios SET clave='" . $clave_nueva . "' WHERE id=" . $id_usuario;

				if ($res = mysqli_query($conex, $sql)) {
					#si hubo un error en la conex
					if ($res) {
						header("Location: ../index.php?cambio");
					} else {
						#en caso que falle el update
						header("Location: ../index.php?fallo");


					}

				} else {


					echo "Error en la bd";
				}


			} else {
				?>
				<script type="text/javascript">
					var id_usuario = "<?php echo $id_usuario ?>";
					alert('los campos de clave nueva no coinciden');
					window.location = "../vista/recuperacion/clave_nueva.php?id_usuario=" + id_usuario;

				</script>
			<?php }
		}
	}//fin de la funcion cambiar_clave

}//salgo de controlador login

ControladorLogin::controlador($operacion);

?>