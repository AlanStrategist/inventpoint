<?php
include "../modelos/clasedb.php";

extract($_REQUEST);

class ControladorUsuarios
{
    public function index()
    {
        extract($_REQUEST);

        if (!isset($alert)) {
            $alert = "";
        }

        header("Location: ../vista/categorias/usuarios/index.php?alert=" . $alert);
    }

    public function registrar()
    {
        header("Location: ../vista/categorias/usuarios/registrar.php");
    }

    public function guardar()
    {
        extract($_POST);

        try {

            $db = new clasedb();
            $conex = $db->conectar();

            $nomexist = "SELECT * FROM usuarios WHERE correo ='" . $correo . "' OR cedula = " . $cedula;
            $result = mysqli_query($conex, $nomexist);
            $nombresbd = mysqli_num_rows($result);

            if ($nombresbd > 0) {

                header("Location: ../vista/categorias/usuarios/registrar.php?alert=dup");

                return;
            }

            if ($clave != $clave_repetir) {

                header("Location: ../vista/categorias/usuarios/registrar.php?alert=nocon");

            }

            $clave = hash('sha256', $clave);

            //Insert user

            $sql = "INSERT INTO usuarios VALUES (NULL,'" . $cedula . "','" . $correo . "','" . $nombre . "','" . $clave . "','" . $tipo_usuario . "','" . $estatus . "')";

            $resultado = mysqli_query($conex, $sql);

            if (!$resultado) {

                header("Location: ControladorUsuarios.php?operacion=index&alert=error");

                return;
            }

            //Get User Id

            $sql_user = "SELECT id FROM usuarios WHERE cedula=" . $cedula;

            $query_user = mysqli_query($conex, $sql_user);

            if (!$query_user) {

                header("Location: ControladorUsuarios.php?operacion=index&alert=erroruser");

                return;
            }

            $data_user = mysqli_fetch_array($query_user);

            $id = $data_user["id"];

            //Insert privileges
            $insert = "";

            foreach ($privi as $key => $value) {

                $sql_2 = "INSERT INTO usuarios_has_privileges (id, id_usuarios, id_privileges) VALUES (NULL," . $id . "," . $value . ");";

                $insert .= $sql_2;

            }

            $query_privs = mysqli_multi_query($conex, $insert);

            if (!$query_privs) {

                header("Location: ControladorUsuarios.php?operacion=index&alert=errorprivs");

                return;
            }

            header("Location: ControladorUsuarios.php?operacion=index&alert=si");


        } catch (mysqli_sql_exception | Exception $e) {

            header("Location: ControladorUsuarios.php?operacion=index&alert=error");

        } finally {

            mysqli_close($conex);

        }
    }

    public function Update()
    {
        extract($_REQUEST);

        if($id == "" ){
           
            header("ControladorUsuarios.php?operacion=index&alert=errorUp");
        }

        header("Location: ../vista/categorias/usuarios/modificar.php?id=" . $id);
    }

    public function Save_Update()
    {
        extract($_POST);

        try{

        $db = new clasedb();

        $conex = $db->conectar();

        $sql = "UPDATE usuarios SET nombre=' ".$nombre. " ',correo='".$correo."',cedula='".$cedula."' WHERE id=".$id;

        $res = mysqli_query($conex, $sql);

        if ( !$res ) {

            header("Location: ControladorUsuarios.php?operacion=index&alert=errorUp");

            return;

        }
        
        header("Location: ControladorUsuarios.php?operacion=index&alert=sucessUp");

        }catch( mysqli_sql_exception | Exception $e) {

           header("Location: ControladorUsuarios.php?operacion=index&alert=errorUp");

        }finally{

            mysqli_close($conex);
        }

    } //fin de la funcion

    public function Rol()
    {
        extract($_REQUEST);

        try{

        $db = new clasedb;
        $conex = $db->conectar();   
        $sql = "UPDATE usuarios SET tipo_usuario='$rol' WHERE id=" . $id;

        $res = mysqli_query($conex, $sql);
        
        if ($res) {

            header("Location: ControladorUsuarios.php?operacion=index&alert=rol");

            return;
        }

    }catch(Exception | mysqli_sql_exception $e) {

        header("Location: ControladorUsuarios.php?operacion=indexl&alert=error");

    }finally{

        mysqli_close($conex);
    }

    }
    public function Status()
    {
        extract($_REQUEST);

        try{

        $db = new clasedb;
        $conex = $db->conectar();   
        $sql = "UPDATE usuarios SET estatus='$estatus' WHERE id=" . $id;

        $res = mysqli_query($conex, $sql);
        
        if ($res) {

            header("Location: ControladorUsuarios.php?operacion=index&alert=status");

            return;
        }

    }catch(Exception | mysqli_sql_exception $e) {

        header("Location: ControladorUsuarios.php?operacion=indexl&alert=error");

    }finally{

        mysqli_close($conex);
    }
    }

    public function View_Privs()
    {
        extract($_REQUEST);

        header("Location: ../vista/categorias/usuarios/update_privileges.php?id=" . $id);

    }

    public function Update_Privs()
    {
        extract($_REQUEST);

        try {

            $db = new clasedb();
            $conex = $db->conectar();

            if ($privi == null) {

                header("Location: ../vista/categorias/usuarios/update_privileges.php?&alert=sin&id=" . $id);

                return;
            }

            $sql_user = "SELECT id FROM usuarios WHERE id=" . $id;

            $query_user = mysqli_query($conex, $sql_user);

            if (!$query_user) {

                header("Location: ControladorUsuarios.php?operacion=index&alert=erroruser");

                return;
            }

            $data_user = mysqli_fetch_array($query_user);

            $id = $data_user["id"];

            //Delete all privileges of user

            $sql_del = "DELETE from usuarios_has_privileges where id_usuarios=".$id;

            $del = mysqli_query($conex, $sql_del);

            if(!$del){

                header("Location: ControladorUsuarios.php?operacion=index&alert=errorprivis");

                return;
            }
            
            //Insert privileges
            $insert = "";

            foreach ($privi as $key => $value) {

                $sql_2 = "INSERT INTO usuarios_has_privileges(id, id_usuarios, id_privileges)VALUES(NULL," . $id . "," . $value . ");";
                
                $insert .= $sql_2;

            }

            $query_privs = mysqli_multi_query($conex, $insert);

            if (!$query_privs) {

                header("Location: ControladorUsuarios.php?operacion=index&alert=errorprivs");

                return;
            }

            header("Location: ControladorUsuarios.php?operacion=index&alert=siprivis");


        } catch (mysqli_sql_exception | Exception $e) {
  
           header("Location: ControladorUsuarios.php?operacion=index&alert=error");

        } finally {

            mysqli_close($conex);

        }
    }


    public static function controlador($operacion)
    {

        $pro = new ControladorUsuarios();
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
            case 'Update':
                $pro->Update();
                break;
            case 'Save_Update':
                $pro->Save_Update();
                break;

            case 'Rol':
                $pro->Rol();
                break;
            case 'Status':
                $pro->Status();
                break;
            case 'View_Privs':
                $pro->View_Privs();
                break;

            case 'Update_Privs':
                $pro->Update_Privs();
                break;

            default:
                ?>


                <script type="text/javascript">
                    alert("sin ruta, no existe");
                    window.location = "ControladorUsuarios.php?operacion=index";
                </script>

                <?php
                break;
        }

    }
}

ControladorUsuarios::controlador($operacion);

?>