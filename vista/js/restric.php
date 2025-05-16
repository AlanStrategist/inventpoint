<?php

include("../../../modelos/clasedb.php");
include "../../../controladores/Utils.php";

if (!isLoged()) {
	
	header('location:../../../index.php?alert=inicia');
}

date_default_timezone_set('America/Caracas');

$hoy = date('Y-m-d');

try {

	$db = new clasedb();

	$conex = $db->conectar();
    
	//View Expired

	$sql_e = "SELECT expired FROM pays ORDER BY id DESC Limit 1";
	
	$res_e = mysqli_query($conex, $sql_e);
   
	$data=mysqli_fetch_array($res_e);

	if ($data["expired"] <= $hoy ) {

		header('Location:../../../index.php?alert=error_venci');

		return;

	}  
	
	//LogIn
	$id_usuario = $_SESSION['id'];

	$sql = "SELECT tipo_usuario FROM usuarios WHERE id=" . $_SESSION['id'] . " AND estatus='activo'";

	$res = mysqli_query($conex, $sql);

	if ($res) {

		$rol = mysqli_fetch_object($res);

		$tipo_usuario = $rol->tipo_usuario;

		if($tipo_usuario == "" | $tipo_usuario == null) { 

			header('Location:../../../index.php?alert=errorv');

			return;
		}

		include '../headerbtn.php';
	}

}catch( mysqli_sql_exception | Exception $e){
	echo "Error: " . $e->getMessage();
	//header('Location:../../../index.php?alert=inicia');

}finally{

	//mysqli_close($conex);
}







