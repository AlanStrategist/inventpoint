<?php

include("../../../modelos/clasedb.php");
include "../../../controladores/Utils.php";

if (!isLoged()) {
	header('location:../../../index.php?alert=inicia');
}

try {

	$db = new clasedb();

	$conex = $db->conectar();

	$id_usuario = $_SESSION['id'];

	$sql = "SELECT tipo_usuario FROM usuarios WHERE id=" . $_SESSION['id'] . " AND estatus='activo'";

	$res = mysqli_query($conex, $sql);

	if ($res) {

		$rol = mysqli_fetch_object($res);

		$tipo_usuario = $rol->tipo_usuario;

		if($tipo_usuario == "" | $tipo_usuario == null) { 

			header('location:../../../index.php?alert=errorv');
		}

		include '../headerbtn.php';
	}

}catch( mysqli_sql_exception | Exception $e){

	header('location:../../../index.php?alert=inicia');

}finally{

	//mysqli_close($conex);
}







