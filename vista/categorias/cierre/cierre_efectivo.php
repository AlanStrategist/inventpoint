<?php



$to_e=0;#divisa

$ALE_e=0;#divisa

$total_e =0;
$perro_e =0;
$total_ig_e=0;
  $total_neto_e=0;
   $SUB_efectivo=0;
while($e_datos = mysqli_fetch_array($efectivo)){

  $total_e = $e_datos['precio_venta'] * $e_datos['quantity'];
  $total_neto_e += $total;
  $perro_e+= $e_datos['cambio'] * $e_datos['quantity'];
  $to_e += $perro_e;




  $SUB_efectivo += $e_datos['subtotal_efectivo'];

   $porcentaje_e= 5 * $total_e /100;
    



    $ALE_e += $porcentaje_e;
    $total_neto_e=$total_e - $porcentaje_e ;
$total_ig_e += $total_neto_e;





$pdf->setX(3);

$pdf->SetFont('Arial','B',4);
$pdf->Cell(5,$off,''.$e_datos['quantity'].''); 

 $pdf->setX(4); 
$pdf->Cell(20,$off,  strtoupper(substr(''.$e_datos['nombre'].'', 0,12)) );
$pdf->setX(20);
$pdf->Cell(11,$off,  "Efec-Bs".number_format(''.$e_datos['precio_venta'].'',2,".",",") ,0,0,"R");
$pdf->setX(30);
$pdf->Cell(11,$off,  "Bs".number_format( $total_e,2,".",",") ,0,0,"R");
$pdf->setX(32);
  $total += $e_datos['subtotal_efectivo'];


$off+=6; }  

$sub=$SUB_efectivo;



