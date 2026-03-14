<?php
include "../modelos/clasedb.php";
include "./Utils.php";

if( !isLoged())
{
    header("Location: ../index.php?alert=inicia");
    
    return;
}

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
        $cod_barra = $_POST['cod_barra'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $p_venta = $_POST['p_venta'];
        $stock = $_POST['stock'];
        $estatus = $_POST['estatus'];
        $categoria = $_POST['categoria'];
        $ubicacion = $_POST['ubicacion'];
        $medida = $_POST['medida'];
        $id_usuario = $_SESSION['id'];

        try{

        $db = new clasedb();
        $conex = $db->conectar();

        $cod_barra_1 = str_replace("'", "-", $cod_barra);

        $nomexist = "SELECT * FROM producto WHERE nombre='" . $nombre . "' OR cod_barra='" . $cod_barra_1 . "' AND cod_barra != 'N/A' ";

        $result = mysqli_query($conex, $nomexist);
        $nombresbd = mysqli_num_rows($result);

        if ($nombresbd > 0) {

            header("Location: ../vista/categorias/producto/registrar.php?alert=nombredu");

            return;
           
        } 

        // Calc percentage
        
        $porcentaje = ( ( $p_venta - $precio) / $precio) * 100;

        $porcentaje = round($porcentaje, 2);

        //Set Saved Unit

        if($medida == 'gr') {
            
            $stock = $stock * 1000;
            
        }

        $sql = "INSERT INTO `producto` (`id`,`cod_barra`, `nombre`, `precio`,`precio_venta`,`porcentaje`,`stock`, `modified`, `estatus`, `id_categorias`,`id_usuario`,`id_ubicacion`,`id_medida`) VALUES (NULL, '" . $cod_barra_1 . "','$nombre',  '$precio', '$p_venta', '$porcentaje','$stock', CURRENT_TIMESTAMP, '$estatus', '$categoria','$id_usuario','$ubicacion','$medida');";

        $resultado = mysqli_query($conex, $sql);

        if ($resultado) {

            header("Location: ../vista/categorias/producto/registrar.php?alert=exito");

        } else {
            
            header("Location: ../vista/categorias/producto/registrar.php?alert=error");
        }
        
        } catch (Exception $e) {
            
            echo "Error: " . $e->getMessage();

            echo $sql;
            //header("Location: ../vista/categorias/producto/registrar.php?alert=error");
       
       
        }finally{

            mysqli_close($conex);

        }

    }
    
    public function modificar()
    {
        extract($_REQUEST);
        header("Location: ../vista/categorias/producto/modificar.php?id=" . $id);
    }

    public function guardar_modificacion()
    {       
        $id_usuario = $_SESSION['id'];
        
        extract($_POST);

        $db = new clasedb();
        $conex = $db->conectar();
        $cod_barra_1 = str_replace("'", "-", $cod_barra);

        // Calc percentage
        
        $porcentaje = ( ( $p_venta - $precio) / $precio) * 100;

        $porcentaje = round($porcentaje, 2);

        $sql = "UPDATE producto SET id='$id',cod_barra='$cod_barra_1',nombre='$nombre',precio_venta=$p_venta , porcentaje='$porcentaje',stock='$stock',estatus='$estatus',id_categorias='$categoria',id_usuario='$id_usuario',id_ubicacion='$ubicacion' WHERE id='$id'";

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

            header("location: ControladorProducto.php?operacion=index&autorizo=autorizo&alert=error");
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