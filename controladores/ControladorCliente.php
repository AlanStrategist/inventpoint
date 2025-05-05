<?php

include "../modelos/clasedb.php";
include './Utils.php';

if(!isLoged()){
    
    header("Location: ../index.php?alert=inicia");
    
    exit();
}

extract($_REQUEST);

class ControladorCliente
{
    public function index()
    {
        extract($_REQUEST);
        
        $loc = isset($alert) ? "Location: ../vista/categorias/cliente/index.php?&alert=" . $alert : "Location: ../vista/categorias/cliente/index.php";

        header($loc);
        
    }

    public function registrar()
    {   


        header("Location: ../vista/cliente/cliente/registrar.php"); //redireccionar a la siguiente dirección
    }

    public function guardar()
    {
        extract($_POST);

        $_SESSION['id'] = $id_usuario;

        try{

        $db = new clasedb();
        $conex = $db->conectar();

        $nomexist = "SELECT * FROM cliente WHERE cedula='" . $cedula . "'";
        $result = mysqli_query($conex, $nomexist);
        $nombresbd = mysqli_num_rows($result);

        if ($nombresbd > 0) {

            header("Location: ControladorCliente.php?operacion=index&alert=du");

            return;

        } 

        $sql = "INSERT INTO `cliente`(`id`, `nombre`, `tipo`, `cedula`, `telefono`, `id_usuario`) VALUES (NULL,'$nombre','$tipo','$cedula','$telefono','$id_usuario')";

        $resultado = mysqli_query($conex, $sql);

        if (!$resultado) {

            header("Location: ControladorCliente.php?operacion=index&alert=error");

            return;

        } 
        
        header("Location: ControladorCliente.php?operacion=index&alert=exito");

        }catch(Exception $e){

            header("Location: ControladorCliente.php?operacion=index&alert=error");

        }finally{

            mysqli_close($conex);

        }   
    }


    public function update()
    {
        extract($_REQUEST);

        header("Location: ../vista/categorias/cliente/modificar.php?id=".$id."");

    }

    public function save_update()
    {
        extract($_POST);

        $_SESSION['id_usuario'] = $id_usuario;

        try{

        $db = new clasedb();
        $conex = $db->conectar();

        $sql = "UPDATE cliente SET nombre='$nombre', tipo='$tipo', cedula='$cedula', telefono='$telefono', id_usuario='$id_usuario' WHERE id='$id'";

        $resultado = mysqli_query($conex, $sql);

        if (!$resultado) {

            header("Location: ControladorCliente.php?operacion=index&alert=error");

            return;

        } 
        
        header("Location: ControladorCliente.php?operacion=index&alert=exito");

        }catch(Exception $e){

            header("Location: ControladorCliente.php?operacion=index&alert=error");

        }finally{

            mysqli_close($conex);

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
            
            case 'update':
                $pro->update();
                break;

            case 'save_update':
                $pro->save_update();
                break;

            default:
                ?>

                <script type="text/javascript">
                    alert("sin ruta, no existe");
                    window.location = "ControladorCliente.php?operacion=index";
                </script>
                <?php
                break;
        }

    }
}

ControladorCliente::controlador($operacion);

?>