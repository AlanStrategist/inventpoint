
<?php
include "../modelos/clasedb.php";
extract($_REQUEST);

class ControladorCliente
{
    public function index()
    {
        extract($_REQUEST);

        if ($autorizo == '') {
            ?>

        <script type="text/javascript">
            alert('No existe autorización para listar');
            window.Location:'../vista/categorias/home/home.php'
        </script>
    <?php
} else {

            $clave = 1;

            if (isset($alert)) {

                header("Location: ../vista/categorias/cliente/index.php?clave=" . $clave . "&alert=" . $alert);

            } else {
                header("Location: ../vista/categorias/cliente/index.php?clave=" . $clave);

            }
        }

    }

    public function registrar()
    {
        header("Location: ../vista/cliente/cliente/registrar.php"); //redireccionar a la siguiente dirección
    }

    public function guardar()
    {
        session_start();

        if (empty($_SESSION['id'])) {
            header("Location: ../index.php?alerta=inicia");
        } else {
            $id_usuario = $_SESSION['id'];

        }
        extract($_POST);

        $db    = new clasedb();
        $conex = $db->conectar();

        $nomexist  = "SELECT * FROM cliente WHERE cedula='" . $cedula . "'";
        $result    = mysqli_query($conex, $nomexist);
        $nombresbd = mysqli_num_rows($result);

        if ($nombresbd > 0) {

            header("Location: ControladorCliente.php?operacion=index&alert=du&autorizo=autorizo");

        } else {

            $sql = "INSERT INTO `cliente`(`id`, `nombre`, `tipo`, `cedula`, `telefono`, `id_usuario`) VALUES (NULL,'$nombre','$tipo','$cedula','$telefono','$id_usuario')";

            $resultado = mysqli_query($conex, $sql);

            if ($resultado) {

                header("Location: ControladorCliente.php?operacion=index&alert=exito&autorizo=autorizo");

            } else {

               header("Location: ControladorCliente.php?operacion=index&alert=error&autorizo=autorizo");
            }
        }
    }
   

    public static function controlador($operacion)
    {

        $pro = new ControladorCliente();
        switch ($operacion) {

            case 'index':

                $pro->index();
                break;

            case 'registrar':
                $pro->registrar();
                break;
            case 'guardar':
                $pro->guardar();
                break;
            default:
                ?>

		<script type="text/javascript">
			alert("sin ruta, no existe");
			window.location="ControladorCliente.php?operacion=index";
		</script>
	<?php
break;
        }

    }
}

ControladorCliente::controlador($operacion);

?>