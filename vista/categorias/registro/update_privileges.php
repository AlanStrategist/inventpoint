<?php
extract($_REQUEST);
$title = 'Privilegios del usuario';
$nucleo = 'usuarios';

include('../../js/restric.php');

if (!has_privi($privs, "List", "Usuarios")) {

  ?>
  <script type="text/javascript">
    window.location = "../home/home.php?alert=errorpriv"
  </script>

  <?php
}

try {

  $conex = $db->conectar();

  $sql_privi = "SELECT * FROM privileges"; 

  $sql_privi_has_user = "SELECT p.id,p.nucleo,p.name FROM privileges p ,usuarios_has_privileges uh ,usuarios u WHERE u.id=".$id." AND uh.id_usuarios = u.id AND p.id = uh.id_privileges;";

  $res_privi_has_user = mysqli_query($conex, $sql_privi_has_user);

  $res_privis=mysqli_query($conex,$sql_privi);

  if($rows = mysqli_num_rows($res_privi_has_user) > 0){

    while ($dato = mysqli_fetch_array($res_privi_has_user)) {

        $dat[] = $dato;

      }

  }

  while( $all = mysqli_fetch_array($res_privis) ){

    $tod[] = $all;  

  }

} catch (mysqli_sql_exception $e) {

  include("../../../modelos/ClassAlert.php");

  $al = new ClassAlert("Error en la consulta", "Recargue la pagina", "danger");

} finally {

  mysqli_close($conex);

}

?>

<body>

  <div class="content">
    <?php if (isset($al)) { $al->Show_Alert();} ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Permisos del usuario</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table">

                <thead class="text-primary">
                    <th>Nucleo </th>
                    <th>Nombre del permiso</th>
                    <th>Descripci&oacute;n</th>
                    <th>Agregar/Quitar</th>

                </thead>

                <form action='../../../controladores/ControladorRegistro.php' method="post" name="myForm">  
                <?php
                
                $nam = 0;
               
                foreach ($tod as $data) {

                  echo "<tr>";
                  echo "<td> ".$data['nucleo']." </td>";
                  echo "<td> ".$data['name']." </td>";
                  echo "<td> ".$data['descrip']." </td>";
                  
                  $c = "";

                  if($rows != 0) {

                  foreach( $dat as $priv ){

                   if($data['id'] == $priv['id'] ){ $c = "checked=''"; }

                  }

                 }

                  echo "<td> <input name=privi[] type='checkbox' value=".$data['id']." ".$c."> </td>";
                  echo "</tr>";
                   
                }

                ?>
     
                <td><button class="btn btn-primary" type="submit" value="Actualizar" >Actualizar</button></td>
              
               
                 <input type="hidden" name="operacion" value="Update_Privs"/>

                 <input type="hidden" name="id" value="<?=$id?>"/>

                 
              </form>


              </table>
</body>

</html>
<script type="text/javascript">
  $(document).ready(function () {
    $('#example').DataTable();
  });



</script>
<?php include('../footerbtn.php'); ?>