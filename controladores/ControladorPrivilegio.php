<?php
include "../modelos/clasedb.php";
extract($_REQUEST);

class ControladorPrivilegio
{
    public function index()
    {
        extract($_REQUEST);

        if (isset($autorizo) && $autorizo == '') {
            ?>

            <script type="text/javascript">
             alert('No existe autorización para listar');
             window.Location:'../vista/categorias/home/home.php'
         </script>
         <?php
} else {

            $clave = 1;

            if (isset($alerta)) {

                header("Location: ../vista/categorias/privilegios/index.php?clave=" . $clave . "&alerta=" . $alerta);

            } else {

                header("Location: ../vista/categorias/privilegios/index.php?clave=" . $clave);

            }
        }

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

        $user_exist = 'SELECT * FROM privilegio WHERE id_usuario=' . $user;

        $exist = mysqli_query($conex, $user_exist);
        $rows  = mysqli_num_rows($exist);

        if ($rows > 0) {

            header('location: ../vista/categorias/usuarios/asignar_privilegios.php?alerta=yaasignado');

        } else {

            $sql = "INSERT INTO `privilegio`(`id`, `id_usuario`, `vender`, `reservar`, `hotel`, `usuario`, `restaurant`, `finanzas`,`privilegios`,`publicidad`,`mantenimiento`,`id_user`) VALUES (NULL,'$user','$vender','$reservar','$hotel','$usuario','$restaurant','$finanzas','$privilegios','$publicidad','$mantenimiento','$id_usuario')";

            $res = mysqli_query($conex, $sql);

            if ($res) {
                header('location: ../vista/categorias/usuarios/asignar_privilegios.php?alerta=bello');
            } else {
                header('location: ../vista/categorias/usuarios/asignar_privilegios.php?alerta=malo');
            }
        }

    }



function eliminar()
{
    session_start();

    if (empty($_SESSION['id'])) {
        header("Location: ../index.php?alerta=inicia");
    } else {
        $id_usuario = $_SESSION['id'];
    }

    extract($_REQUEST);
    $db    = new clasedb;
    $conex = $db->conectar();
    $sql   = "UPDATE privilegio SET id='$id',estatus='inhabilitado', id_usuario='$id_usuario'WHERE id='$id'";

    $res = mysqli_query($conex, $sql) or die; ("Algo ha ido mal en la consulta a la base de datos");
    if (mysqli_affected_rows($conex) == 0) {
        header("Location: ControladorPrivilegio.php?operacion=index&autorizo=autorizo&alerta=yainhabil");
    } else {

        header("Location: ControladorPrivilegio.php?operacion=index&autorizo=autorizo&alerta=inhabilitado");

    }
}

function habilitar()
{
    session_start();

    if (empty($_SESSION['id'])) {
        header("Location: ../index.php?inicia");
    } else {
        $id_usuario = $_SESSION['id'];
    }

    extract($_REQUEST);
    $db    = new clasedb;
    $conex = $db->conectar();
    $sql   = "UPDATE privilegio SET id='$id',estatus='habilitado', id_usuario='$id_usuario'WHERE id='$id'";

    $res = mysqli_query($conex, $sql) or die; ("Algo ha ido mal en la consulta a la base de datos");
    if (mysqli_affected_rows($conex) == 0) {
        header("Location: ControladorPrivilegio.php?operacion=index&autorizo=autorizo&alerta=yahabil");

    } else {
        header("Location: ControladorPrivilegio.php?operacion=index&autorizo=autorizo&alerta=habilitado");

    }
}

function modificar()
{
    extract($_REQUEST);
    header("Location: ../vista/categorias/privilegios/modificar.php?id=" . $id);
}

function guardar_modificacion()
{
    session_start();

    if (empty($_SESSION['id'])) {
        header("Location: ../index.php?alerta=inicia");
    } else {
        $id_user = $_SESSION['id'];
    }
    extract($_POST);

    $db    = new clasedb();
    $conex = $db->conectar();

    $sql = "UPDATE `privilegio` SET `id`=$id,`id_usuario`=$id,`bitacora`='$bitacora',`producto`='$producto',`pedidos`='$pedidos',`usuarios`='$usuarios',`mantenimiento`='$mantenimiento' WHERE id_usuario=".$id;

    $resultado = mysqli_query($conex, $sql);

    if ($resultado) {

        header("Location: ControladorPrivilegio.php?operacion=index&alerta=modisi&autorizo=autorizo")
        ;
    } else {

        header("Location: ControladorPrivilegio.php?operacion=index&alerta=modino&autorizo=autorizo");
    }
}
static function controlador($operacion)
{

    $pro = new ControladorPrivilegio();
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

        case 'habilitar':
            $pro->habilitar();
            break;

        case 'eliminar':
            $pro->eliminar();
            break;

        default:
            ?>

            <script type="text/javascript">
             alert("sin ruta, no existe");
             window.location="../index.php";
         </script>
         <?php
break; }
    
    }

}

ControladorPrivilegio::controlador($operacion);

   