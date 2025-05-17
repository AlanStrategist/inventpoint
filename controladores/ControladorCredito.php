<?php
include "../modelos/clasedb.php";
include './Utils.php';

if(!isLoged()){

    header("Location: ../index.php?alert=inicia");
    
    exit();
}

if (isset($_REQUEST['operacion'])) { $operacion = $_REQUEST['operacion']; }
 
class ControladorProducto
{

    public function List_Client()
    {       
        if (isset($alert)) {

            header("Location: ../vista/categorias/credits/List_Client.php?alert=" . $alert);

        } else {
            
            header("Location: ../vista/categorias/credits/List_Client.php");

        }
        
    }

    public function details_ab()
    {       
        if (isset($_REQUEST['id_factura'])) {
            
            $id_factura = $_REQUEST['id_factura'];

            header("Location: ../vista/categorias/credits/view_pays.php?id_factura=" . $id_factura);

        } else {
            
            header("Location: ../vista/categorias/car/todo_dia.php?alert=error");
            return;

        }
        
    }

    public function abonar()
    {       
        extract($_POST);

        try{

            $db = new clasedb();
            $conex = $db->conectar();

            if(!isset($monto)){
                
                header("Location: ../vista/categorias/car/todo_dia.php?alert=error");

                return;
            }

            if($abono > $monto){

                header("Location: ../vista/categorias/car/todo_dia.php?alert=error");

                return;

            }
           
            $sql = "INSERT INTO `credits`(`id`, `amount`, `metodo`, `ref`, `fecha`,`id_factura`) VALUES (NULL,$abono,'$metodo','',CURRENT_TIMESTAMP(),$id_factura)";
            $res = mysqli_query($conex, $sql);
       
            if (!$res) {

                header("Location: ../vista/categorias/car/todo_dia.php?alert=error");

                return;

            }

            if( $monto == $abono){

                $sql = "UPDATE `facturas` SET `estatus`= 'Facturado' WHERE id = '$id_factura'";
                $res = mysqli_query($conex, $sql);
                
                if (!$res) {

                    header("Location: ../vista/categorias/car/todo_dia.php?alert=error");

                    return;

                }

                header("Location: ../vista/categorias/car/todo_dia.php?alert=Pagado");
                
                return;

            }

            header("Location: ../vista/categorias/car/todo_dia.php?alert=save");

        
        }catch(Exception | mysqli_sql_exception $e){
           
            echo $sql;
            
            header("Location: ../vista/categorias/car/todo_dia.php?alert=error");
            
            return;

        }finally{

            mysqli_close($conex);

        }
        
    }
    public static function controlador($operacion)
    {

        $pro = new ControladorProducto();
        switch ($operacion) {

            case 'List_Client':
                $pro->List_Client();             
                break;
            case 'abonar':
                $pro->abonar();             
                break; 

            case 'details_ab':
                $pro->details_ab();             
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