<?php



$to_t=0;#divisa

$ALE_t=0;#divisa

$total_t =0;
$perro_t =0;
$total_ig_t=0;
  $total_neto_t=0;
   $SUB_transferencia=0;
while($t_datos = mysqli_fetch_array($transferencia)){

  $total_t = $t_datos['precio_venta'] * $t_datos['quantity'];
  $total_neto_t += $total;
  $perro_t+= $t_datos['cambio'] * $t_datos['quantity'];
  $to_t += $perro_t;




  $SUB_transferencia += $t_datos['subtotal_transferencia'];

   $porcentaje_t= 5 * $total_t /100;
    



    $ALE_t += $porcentaje_t;
    $total_neto_t=$total_t - $porcentaje_t ;
$total_ig_t += $total_neto_t;





$pdf->setX(3);

$pdf->SetFont('Arial','B',4);
$pdf->Cell(5,$off,''.$t_datos['quantity'].''); 

 $pdf->setX(4); 
$pdf->Cell(20,$off, ''.strtoupper(substr(''.$t_datos['nombre'].'', 0,12)) );
$pdf->setX(20);
$pdf->Cell(11,$off,  "Trans Bs" .number_format(''.$t_datos['precio_venta'].'',2,".",",") ,0,0,"R");
$pdf->setX(30);
$pdf->Cell(11,$off,  "Bs" .number_format( $total_t,2,".",",") ,0,0,"R");
$pdf->setX(32);
  $total_t += $t_datos['subtotal_transferencia'];


$off+=6; }  

$sub_trans=$SUB_transferencia;



