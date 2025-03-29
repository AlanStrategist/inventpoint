
<?php
include "../modelos/clasedb.php";
extract($_REQUEST);

class ControladorCategoria
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

            if (isset($alerta)) {

                header("Location: ../vista/categorias/categoria/index.php?clave=" . $clave . "&alerta=" . $alerta);

            } else {
                header("Location: ../vista/categorias/categoria/index.php?clave=" . $clave);

            }
        }

    }

    public function registrar()
    {
        header("Location: ../vista/categorias/categoria/registrar.php"); //redireccionar a la siguiente dirección
    }

    public function guardar()
    {
        session_start();

        if (empty($_SESSION['id'])) {
            header("Location: ../index.php?inicia");
        } else {
            $id_usuario = $_SESSION['correo'];

        }
        extract($_POST);

        $db    = new clasedb();
        $conex = $db->conectar();

        $nomexist  = "SELECT * FROM categorias WHERE nombre='" . $nombre . "'";
        $result    = mysqli_query($conex, $nomexist);
        $nombresbd = mysqli_num_rows($result);

        if ($nombresbd > 0) {

            header("Location: ControladorCategoria.php?operacion=index&alerta=nombredu&autorizo=autorizo");
//si el nombre esta duplicado
        } else {
            $estatus = 'habilitado';

            #gestion de imagen

            $sql = "INSERT INTO `categorias` (`id`, `nombre`) VALUES (NULL, '$nombre');";

            $resultado = mysqli_query($conex, $sql);

            if ($resultado) {

                header("Location: ControladorCategoria.php?operacion=index&alerta=alertacat&autorizo=autorizo");

            } else {

                header("Location: ControladorCategoria.php?operacion=index&alerta=nocat&autorizo=autorizo");
            }
        }
    }
    //fin de funcion guardar
    public function modificar()
    {
        extract($_REQUEST);
        header("Location: ../vista/categorias/categoria/modificar.php?id=" . $id);
    }

    public function guardar_modificacion()
    {
        session_start();

        if (empty($_SESSION['id'])) {
            header("Location: ../index.php?inicia");
        } else {
            $id_usuario = $_SESSION['correo'];
        }

        extract($_POST);

        $db    = new clasedb();
        $conex = $db->conectar();

        $sql = "UPDATE categorias SET id='$id',nombre='$nombre' WHERE id='$id'";

        $resultado = mysqli_query($conex, $sql);

        if ($resultado) {

            header("Location: ControladorCategoria.php?operacion=index&modisi&autorizo=autorizo")
            ; #
        } else {

            header("Location: ControladorCategoria.php?operacion=index&modino&autorizo=autorizo");
        }
    }

    public static function controlador($operacion)
    {

        $pro = new ControladorCategoria();
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
			window.location="ControladorCategoria.php?operacion=index";
		</script>
	<?php
break;
        }

    }
}

ControladorCategoria::controlador($operacion);

?>