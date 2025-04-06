<?php

#Create Invoice Number

function GetFac() : int{

   $db = new clasedb();
   $conex = $db->conectar();
   $sql_get_last_id ="SELECT MAX(factura) as last FROM pedidos";
   
   try{
   
   $fac_query= mysqli_query($conex, $sql_get_last_id);

   $last_fac = mysqli_fetch_array($fac_query);

   $fac_num = $last_fac['last'];

   if($fac_num == null){ $fac_num = 0; }

   $fac_num++;

   return $fac_num;
   
   }catch(mysqli_sql_exception $e){
        
    echo "". $e->getMessage() ."";

   }finally{

    mysqli_close($conex);

   }

   return 0;

}

function isLoged() : bool{

   session_start();

   if(isset($_SESSION["id"]) && $_SESSION["logueado"] == "Si"){ 

      #is Loged

      return true;

    } 

    return false;

}

function has_privi( array $privi , string $name, string $nucleo) : bool{

   foreach($privi as $p){
    
      if( $p['name'] === $name && $p['nucleo'] === $nucleo ){
                
         return true;

         
      }
   }

   return false;
}


function limpiarCadena($valor) {
	$valor=addslashes($valor);
	$valor = str_ireplace("<script>", "", $valor);
	$valor = str_ireplace("</script>", "", $valor);
	$valor = str_ireplace("SELECT * FROM", "", $valor);
	$valor = str_ireplace("DELETE FROM", "", $valor);
	$valor = str_ireplace("UPDATE", "", $valor);
	$valor = str_ireplace("INSERT INTO", "", $valor);
	$valor = str_ireplace("DROP TABLE", "", $valor);
	$valor = str_ireplace("TRUNCATE TABLE", "", $valor);
	$valor = str_ireplace("--", "", $valor);
	$valor = str_ireplace("^", "", $valor);
	$valor = str_ireplace("[", "", $valor);
	$valor = str_ireplace("]", "", $valor);
	$valor = str_ireplace("\\", "", $valor);
	$valor = str_ireplace("=", "", $valor);
	return $valor;
}

