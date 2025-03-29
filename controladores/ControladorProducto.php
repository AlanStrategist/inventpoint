<?php
include "../modelos/clasedb.php";
extract($_REQUEST);

class ControladorProducto
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

                header("Location: ../vista/categorias/producto/index.php?clave=" . $clave . "&alert=" . $alert);

            } else {
                header("Location: ../vista/categorias/producto/index.php?clave=" . $clave);

            }
        }

    }

    public function stock()
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

                header("Location: ../vista/categorias/producto/stock.php?clave=" . $clave . "&alert=" . $alert);

            } else {
                header("Location: ../vista/categorias/producto/stock.php?clave=" . $clave);

            }
        }

    }

    public function registrar()
    {
        header("Location: ../vista/categorias/producto/registrar.php");
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

        $cod_barra_1 = str_replace("'", "-", $cod_barra);

        $nomexist = "SELECT * FROM producto WHERE nombre='" . $nombre . "' OR cod_barra='" . $cod_barra1 . "' ";

        $result = mysqli_query($conex, $nomexist);
        $nombresbd = mysqli_num_rows($result);

        if ($nombresbd > 0) {

            header("Location: ../vista/categorias/producto/registrar.php?alert=nombredu");
            //si el nombre esta duplicado
        } else {

            $sql = "INSERT INTO `producto` (`id`,`cod_barra`, `nombre`, `precio`, `porcentaje`,`stock`, `modified`, `estatus`, `id_categorias`,`id_usuario`,`id_ubicacion`) VALUES (NULL, '" . $cod_barra_1 . "','$nombre',  '$precio', '$porcentaje','$stock', CURRENT_TIMESTAMP, '$estatus', '$categoria','$id_usuario','$ubicacion');";

            $resultado = mysqli_query($conex, $sql);

            if ($resultado) {

                header("Location: ../vista/categorias/producto/registrar.php?alert=exito");

            } else {
                header("Location: ../vista/categorias/producto/registrar.php?alert=error");
            }
        }
    }
    //fin de funcion guardar
    public function modificar()
    {
        extract($_REQUEST);
        header("Location: ../vista/categorias/producto/modificar.php?id=" . $id);
    }

    public function guardar_modificacion()
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

        $cod_barra_1 = str_replace("'", "-", $cod_barra);

        $sql = "UPDATE producto SET id='$id',cod_barra='$cod_barra_1',nombre='$nombre',precio='$precio',porcentaje='$porcentaje',stock='$stock',estatus='$estatus',id_categorias='$categoria',id_usuario='$id_usuario',id_ubicacion='$ubicacion' WHERE id='$id'";

        $resultado = mysqli_query($conex, $sql);

        if ($resultado) {

            header("Location: ControladorProducto.php?operacion=index&autorizo=autorizo&alert=modisi");

        } else {

            header("Location: ControladorProducto.php?operacion=index&autorizo=autorizo&alert=modino");
        }

    } //todo bello

    public function pago()
    {
        extract($_REQUEST);
        header("Location: ../vista/categorias/car/metodo.php?id=" . $id);
    }

    public function Mod_Stock()
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

        $sql = "UPDATE producto SET stock='$stock' WHERE id='$id'";

        $resultado = mysqli_query($conex, $sql);

        if ($resultado) {

            header("Location: ControladorProducto.php?operacion=index&alert=modisi&autorizo=autorizo")
            ;
        } else {

            header("Location: ControladorProducto.php?operacion=index&alert=modino&autorizo=autorizo");
        }
    }

    public function Estatus()
    {
        extract($_REQUEST);
        $db = new clasedb;
        $conex = $db->conectar();
        $sql = "UPDATE producto SET estatus='$estatus' WHERE id=" . $id;

        $res = mysqli_query($conex, $sql);

        if ($res) {

            header("Location: ControladorProducto.php?operacion=index&autorizo=autorizo&alert=status");

        } else {

            header("location: ControladorProducto.php?operacion=index&autorizo=autorizo&alert=no");
        }
    } //mysqli_affected_rows($conex): Se utiliza para ver si ha habido un cambio
    //especifico en el campo de una tabla. ejem, se hace una modificación y se
    //inserta el mismo campo

    public static function controlador($operacion)
    {

        $pro = new ControladorProducto();
        switch ($operacion) {

            case 'index':

                $pro->index();
                break;

            case 'stock':

                $pro->stock();
                break;

            case 'Mod_Stock':

                $pro->Mod_Stock();
                break;

            case 'pago':

                $pro->pago();
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

            case 'Estatus':
                $pro->Estatus();
                break;

            default:
                ?>

                <script type="text/javascript">
                    alert("sin ruta, no existe");
                    window.location = "ControladorProducto.php?operacion=index&autorizo=autorizo";
                </script>
                <?php
                break;
        }

    }
}

ControladorProducto::controlador($operacion);

?>