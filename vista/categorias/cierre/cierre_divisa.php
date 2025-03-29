<?php



$to=0;#divisa

$ALE=0;#divisa

$total =0;
$perro =0;
$total_ig=0;
  $total_neto=0;
while($datos = mysqli_fetch_array($respuesta)){

  $total = $datos['precio_venta'] * $datos['quantity'];
  $total_neto += $total;
  $perro+= $datos['cambio'] * $datos['quantity'];
  $to += $perro;




  $SUB += $datos['subtotal_divisa'];

   $porcentaje= 5 * $total /100;
    



    $ALE += $porcentaje;
    $total_neto=$total - $porcentaje ;
$total_ig += $total_neto;





$pdf->setX(3);

$pdf->SetFont('Arial','B',5);
$pdf->Cell(5,$off,''.$datos['quantity'].''); 

 $pdf->setX(4); 
$pdf->Cell(20,$off,  strtoupper(substr(''.$datos['nombre'].'', 0,12)) );
$pdf->setX(20);
$pdf->Cell(11,$off,  "$".number_format(''.$datos['precio_venta'].'',2,".",",") ,0,0,"R");
$pdf->setX(30);
$pdf->Cell(11,$off,  "$".number_format( $total,2,".",",") ,0,0,"R");
$pdf->setX(32);
  $total += $datos['subtotal_divisa'];


$off+=6; }



