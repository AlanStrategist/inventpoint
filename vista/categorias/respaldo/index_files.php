<?php

extract($_REQUEST);

$title = 'Listado de Productos'; //nombre de la vista
$nucleo = 'Base de datos';
include '../../js/restric.php';
include('../../../modelos/ClassAlert.php');


if (isset($alert) && $alert == "good") {
    $al = new ClassAlert("Se ha restaurado la base de datos !<br>", "", "primary");
} else if (isset($alert) && $alert == "error") {
    $al = new ClassAlert("Error al restaurar la base de datos!<br>", "Contacte al desarrollador", "danger");
}

?>

<body>
    <div class=content>
        <div class=row>
            <div class=col-md-12>

                <?php if (isset($al)) {
                    echo $al->Show_Alert();
                } ?>

                <div class=card>
                    <div class=card-header>
                        <h4 class=card-title>Puntos de Restauración</h4>
                    </div>
                    <div class=card-body>
                        <div class=table-responsive>
                            <table id=example class=table>

                                <thead class=text-primary>

                                    <th>Archivo</th>
                                    
                                </thead>
                                <tbody>
                                 
                                <?php
                                
                                $ruta ="./respaldo";

                                if (!(is_dir($ruta))) {

                                    echo $ruta . " No es una ruta válida";
                                
                                }

                                if (!($aux = opendir($ruta))) {

                                    echo 'Error al abrir el directorio';
                                }
                                
                                while ( ($archivo = readdir($aux)) !== false) {
                                                                  
                                    if ($archivo != "." && $archivo != ".." && $archivo != "respaldo.php" ) {
                                            
                                            $nombrearchivo = str_replace(".sql", "", $archivo);                                        
                                            $nombrearchivo = str_replace("-", ":", $nombrearchivo);
                                            $ruta_completa = $ruta ."/". $archivo;
                                            
                                            if ((is_dir($ruta_completa))) {
                                               
                                                echo "is dir";
                                            
                                            } else {
                                                    echo '<tr>';
                                                    echo '<td>'.$ruta_completa.'</td>';
                                                    //echo "<td><a href='./Restore.php?restorePoint=".$ruta_completa."'>Restaurar</a></td>";
                                                    echo '</tr>';
                                                }
                                    }
                                 }
                                
                                closedir($aux);
                                                                 
                                ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</body>



<script type=text/javascript>
        $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
<?php include '../footerbtn.php'; ?>