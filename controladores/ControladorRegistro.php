<?php
include "../modelos/clasedb.php";

extract($_REQUEST);

class ControladorRegistro
{

    public function index()
    {
        extract($_REQUEST);
        $autorizo = 'prueba';

        if ($autorizo == '') {
            ?>

            <script type="text/javascript">
                alert('No existe autorización para listar');
                window.Location: '../vista/categorias/home/home.php'
            </script>
            <?php
        } else {

            $clave = 1;

            if (isset($alerta)) {

                header("Location: ../vista/categorias/usuarios/index.php?clave=" . $clave . "&alerta=" . $alerta);

            } else {
                header("Location: ../vista/categorias/usuarios/index.php?clave=" . $clave);

            }
        }

    }

    public function registrar()
    {
        header("Location: ../vista/categorias/registro/registrar.php");
    }

    public function guardar()
    {
        extract($_POST);

        try{

        $db = new clasedb();
        $conex = $db->conectar();

        $nomexist = "SELECT * FROM usuarios WHERE correo ='" . $correo . "' OR cedula = " . $cedula;
        $result = mysqli_query($conex, $nomexist);
        $nombresbd = mysqli_num_rows($result);

        if ($nombresbd > 0) {

            header("Location: ../vista/categorias/registro/registrar.php?alert=dup");

            return;
        } 

        if ($clave != $clave_repetir) {

            header("Location: ../vista/categorias/registro/registrar.php?alert=nocon");

        }

        $clave = hash('sha256', $clave);

        //Insert user

        $sql = "INSERT INTO usuarios VALUES (NULL,'" . $cedula . "','" . $correo . "','" . $nombre . "','" . $clave . "','" . $tipo_usuario . "','" . $estatus . "')";

        $resultado = mysqli_query($conex, $sql);

        if (!$resultado) {

           header("Location: ControladorRegistro.php?operacion=index&alert=error");

           return;
        } 
        
        //Get User Id

        $sql_user = "SELECT id FROM usuarios WHERE cedula=".$cedula;

        $query_user = mysqli_query($conex, $sql_user);

        if(!$query_user){

            header("Location: ControladorRegistro.php?operacion=index&alert=erroruser");

            return;
        }

        $data_user = mysqli_fetch_array($query_user);

        $id = $data_user["id"];

        //Insert privileges
        $insert = "";

        foreach ($privi as $key => $value) {

            $sql_2="INSERT INTO `usuarios_has_privileges`(`id`, `id_usuarios`, `id_privileges`) VALUES (NULL,".$id.",".$value.");";

            $insert .= $sql_2;

        }

        $query_privs = mysqli_query($conex, $insert);

        if (!$query_privs) {
            
            header("Location: ControladorRegistro.php?operacion=index&alert=errorprivs");
            
            return;
        }

        header("Location: ControladorRegistro.php?operacion=index&alert=si");
        
        
        } catch (mysqli_sql_exception | Exception $e) {

            header("Location: ControladorRegistro.php?operacion=index&alert=error");

        }finally {

            mysqli_close($conex);
            
        }
    } 

    public function modificar()
    {
        extract($_REQUEST);
        header("Location: ../vista/registro/modificar.php?id=" . $id);
    }

    public function guardar_modificacion()
    {
        extract($_POST);

        $db = new clasedb();
        $conex = $db->conectar();

        $sql = "UPDATE usuarios SET id='$id',nombre='$nombre',correo='$correo',telefono='$telefono',clave='$clave',tipo_usuarios='$tipo_usuarios',pregunta='$pregunta',respuesta='$respuesta' WHERE id='$id'";

        $resultado = mysqli_query($conex, $sql);

        if ($resultado) {

            ?>
            <script type="text/javascript">
                alert("se modifico con exito");
                window.location = "../index.php";
            </script>


            <?php
        } else {
            if (isset($cambiar)) {
                $sql = "SELECT clave FROM usuarios WHERE id=" . $id_usuario;
                $res = mysqli_query($conex, $sql);
                $row = mysqli_fetch_object($res);
                $clave_anterior = hash('sha256', $clave_anterior);
                if ($clave_repetir = $clave) {
                    $clave = hash('sha256', $clave);
                    $sql = "UPDATE usuarios SET nombre='" . $nombre . "', correo='" . $correo . "',clave='" . $clave . "',tipo_usuario='" . $tipo_usuario . "',pregunta='" . $pregunta . "',respuesta='" . $respuesta . "'WHERE id=" . $id_usuario;
                    $res = mysqli_query($res);
                    if ($res) {

                        ?>
                        <script type="text/javascript">
                            alert('Modificacion exitosa');
                            window.location = "ControladorRegistro.php?operacion=index.php";
                        </script> <?php } else {
                        ?>
                        <script type="text/javascript">
                            alert('Modificacion no exitosa');
                            window.location = "ControladorRegistro.php?operacion=index.php";
                        </script> <?php
                    }

                } else {
                    ?>
                    <script type="text/javascript">

                        alert('Las claves no coinciden');
                        window.location = "ControladorRegistro.php?operacion=index";
                    </script>
                    <?php
                }

            } else {
                ?>
                <script type="text/javascript">
                    alert('La clave anterior no coincide');
                    window.location = "ControladorRegistro.php?operacion=index"
                </script> <?php

            }

        }

        $sql = "UPDATE usuarios SET nombre='" . $nombre . "', correo='" . $correo . "',tipo_usuario='" . $tipo_usuario . "',pregunta='" . $pregunta . "',respuesta='" . $respuesta . "'WHERE id=" . $id_usuario;
        $res = mysqli_num_rows($conex, $sql);
        if ($res) { ?>

            ?>
            <script type="text/javascript">
                alert('Registro Modificado');
                window.location = "ControladorRegistro.php?operacion=index.php";
            </script> <?php } else {
            ?>
            <script type="text/javascript">
                alert('Registro no modificado');
                window.location = "ControladorRegistro.php?operacion=index.php";
            </script> <?php

        }

    } //fin de la funcion

    public function Rol()
    {
        extract($_REQUEST);
        $db = new clasedb;
        $conex = $db->conectar();
        $sql = "UPDATE usuarios SET tipo_usuario='$rol' WHERE id=" . $id;

        $res = mysqli_query($conex, $sql);
        if ($res) {

            header("Location: ControladorRegistro.php?operacion=index&alerta=changerol&autorizo=autorizo");

        } else {

            header("Location: ControladorRegistro.php?operacion=indexl&alerta=no&autorizo=autorizo");
        }
    }
    public function Status()
    {
        extract($_REQUEST);
        $db = new clasedb;
        $conex = $db->conectar();
        $sql = "UPDATE usuarios SET estatus='$status' WHERE id=" . $id;

        $res = mysqli_query($conex, $sql);

        if ($res) {

            header("Location: ControladorRegistro.php?operacion=index&autorizo=autorizo&alerta=status");

        } else {

            header("location: ControladorRegistro.php?operacion=index&autorizo=autorizo&alerta=no");
        }
    } //mysqli_affected_rows($conex): Se utiliza para ver si ha habido un cambio
    //especifico en el campo de una tabla. ejem, se hace una modificación y se
    //inserta el mismo campo

    public static function controlador($operacion)
    {

        $pro = new ControladorRegistro();
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

            case 'Rol':
                $pro->Rol();
                break;
            case 'Status':
                $pro->Status();
                break;

            default:
                ?>


                <script type="text/javascript">
                    alert("sin ruta, no existe");
                    window.location = "ControladorRegistro.php?operacion=index";
                </script>

                <?php
                break;
        }

    }
}

ControladorRegistro::controlador($operacion);

?>