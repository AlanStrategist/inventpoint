<?php 

$sql4="SELECT * FROM ubicacion WHERE id=".$data['id_ubicacion'];
$sql5="SELECT * FROM categorias WHERE id=".$data['id_categorias'];

$res4=mysqli_query($conex,$sql4);
$res5=mysqli_query($conex,$sql5);

$ubi=mysqli_num_rows($res4);
$cate=mysqli_num_rows($res5);

if ($ubi==0 || $cate==0) {
  echo "Se hecho a perder";
}else{

  while($date=mysqli_fetch_array($res5)){
       
     $categorias=$date['nombre'];
   }
  while ($dati=mysqli_fetch_array($res4)) {
      
       $ubicacion=$dati['nombre'];
  }


}