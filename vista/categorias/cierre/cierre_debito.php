<?php
$total_otro=0;
$total_neto_otro=0;
$perro_otro=0;
$SUB_otro=0;
$to_otro=0;
$porcentaje_otro=0;
$total_ig_otro=0;
$ALE_otro=0;
$total_ig_otro=0;




while($dato = mysqli_fetch_array($dev)){

  $total_otro = $dato['cambio'] * $dato['quantity'];
  $total_neto_otro += $total;
  $perro_otro+= $dato['cambio'] * $dato['quantity'];
  $to_otro += $perro;




  $SUB += $datos['subtotal'];

   $porcentaje_otro= 5 * $total_otro /100;
    



    $ALE_otro += $porcentaje_otro;
    $total_neto_otro=$total_otro - $porcentaje_otro ;
$total_ig_otro += $total_neto_otro;





$pdf->setX(3);

$pdf->SetFont('Arial','B',4);
$pdf->Cell(5,$off,''.$dato['quantity'].''); 

 $pdf->setX(4); 
$pdf->Cell(20,$off,  strtoupper(substr(''.$dato['nombre'].'', 0,12)) );
$pdf->setX(20);
$pdf->Cell(11,$off,  "Deb".number_format(''.$dato['cambio'].'') ,0,0,"R");
$pdf->setX(30);
$pdf->Cell(11,$off,  "Deb".number_format($total_otro) ,0,0,"R");
$pdf->setX(32);
  $total_otro += $dato['subtotal'];


$off+=6; }







