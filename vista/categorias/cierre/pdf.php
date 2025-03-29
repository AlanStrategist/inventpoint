<?php session_start();
extract($_REQUEST);

if (empty($_SESSION['logueado'])) {


  header('location:../../../../index.php?autorizadono');


} elseif ($_SESSION['logueado'] == 'Si') {

  echo "";
}


require('../../fpdf/fpdf.php');


include("../../../modelos/clasedb.php");
$db = new clasedb();

$conex = $db->conectar();

date_default_timezone_set('America/Caracas');

$sql4 = "SELECT * FROM cliente WHERE cedula=" . $cedula . "";
$respue = mysqli_query($conex, $sql4);
$chivo = mysqli_fetch_object($respue);
$nombre = $chivo->nombre;
$telefono = $chivo->telefono;

$cedula = $chivo->cedula;

$tipo = $chivo->tipo;
//Traigo los datos del usuario que voy a colocar en el pdf



$fecha_actual = date("Y-m-d");
//sumo 1 día
$sql422 = "SELECT * FROM `dolar` ORDER BY `dolar`.`valor` DESC";

$res422 = mysqli_query($conex, $sql422);
$rows22 = mysqli_num_rows($res422);

if ($rows22 > 0) {
  $dolar = mysqli_fetch_object($res422);
  $valor = $dolar->valor;
} else {
  echo "";
}

/*

$methods = ["Divisa","Efectivo","Debito","Transferencia"];
$in = 0;

while ($in < count($methods)) {

  $sql_methods = "SELECT pr.nombre,
  ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
  pe.quantity,
  pe.modified,
  u.correo,
  pe.fecha,
  c.cedula,
  ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ,2) * pe.quantity AS subtotal_divisa,
  ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ,2) * ".$valor." AS cambio 

  FROM pedidos pe,cliente c,producto pr,usuarios u 

  WHERE pe.product_id=pr.id AND 
  pe.id_usuario=u.id AND
  pe.cliente_id= c.id AND
  pe.metodo=".$methods[$in]." AND
  pe.estatus='facturado' AND
  pe.fecha= CURRENT_DATE";

  $respuesta = mysqli_query($conex, $sql_methods);



  $in++;

}

*/


$sql2 = "SELECT pr.nombre,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
pe.quantity,
pe.modified,
u.correo,
pe.fecha,
c.cedula,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ,2) * pe.quantity AS subtotal_divisa,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ,2) * ".$valor." AS cambio 

FROM pedidos pe,cliente c,producto pr,usuarios u 

WHERE pe.product_id=pr.id AND 
pe.id_usuario=u.id AND
pe.cliente_id= c.id AND
pe.metodo='Divisa' AND
pe.estatus='facturado' AND
pe.fecha= CURRENT_DATE";

$respuesta = mysqli_query($conex, $sql2);

$que = "SELECT pr.nombre,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
pe.quantity,
pe.modified,
u.correo,
pe.fecha,
c.cedula,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ,2) * pe.quantity AS subtotal,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ,2) * ".$valor." AS cambio 

FROM pedidos pe,cliente c,producto pr,usuarios u 

WHERE pe.product_id=pr.id AND 
pe.id_usuario=u.id AND
pe.cliente_id= c.id AND
pe.metodo='Debito' AND
pe.estatus='facturado' AND
pe.fecha= CURRENT_DATE";

$dev = mysqli_query($conex, $que);

$sql_efectivo = 
"SELECT pr.nombre,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
pe.quantity,
pe.modified,
u.correo,
pe.fecha,
c.cedula,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ,2) * pe.quantity AS subtotal_efectivo,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) ,2) * ".$valor." AS cambio 

FROM pedidos pe,cliente c,producto pr,usuarios u 

WHERE pe.product_id=pr.id AND 
pe.id_usuario=u.id AND
pe.cliente_id= c.id AND
pe.metodo='Efectivo' AND
pe.estatus='facturado' AND
pe.fecha= CURRENT_DATE";

$efectivo = mysqli_query($conex, $sql_efectivo);

$sql_transferencia = "SELECT pr.nombre,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
pe.quantity,
pe.modified,
u.correo,
pe.fecha,
c.cedula,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) * pe.quantity,2) AS subtotal_transferencia,
ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100) * ".$valor.",2) AS cambio 

FROM pedidos pe,cliente c,producto pr,usuarios u 

WHERE pe.product_id=pr.id AND 
pe.id_usuario=u.id AND
pe.cliente_id= c.id AND
pe.metodo='Transferencia' AND
pe.estatus='facturado' AND
pe.fecha= CURRENT_DATE";

$transferencia = mysqli_query($conex, $sql_transferencia);


$pdf = new FPDF($orientation = 'P', $unit = 'mm', array(45, 350));
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 7);    //Letra Arial, negrita (Bold), tam. 20
$textypos = 5;
$pdf->setY(4);
$pdf->setX(4);
$pdf->setX(4);

$off = $textypos + 6;


$pdf->SetFont('Arial', 'B', 5);

$pdf->setX(4);
$pdf->Cell(5, $textypos, 'CANT-NOMBRE               UND       SUB-TOTAL ');
$SUB = 0;


include('cierre_divisa.php');


include('cierre_debito.php');


include('cierre_efectivo.php');


include('cierre_transferencia.php');


$textypos = $off + 6;


$pdf->SetFont('Arial', 'B', 5);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   TOTAL en: USD ");
$pdf->setX(38);
$pdf->Cell(5, $textypos, " " . number_format($SUB, 2, ".", ","), 0, 0, "R");

$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   TOTAL en: Debito");
$pdf->setX(38);
$pdf->Cell(5, $textypos, " " . number_format($perro_otro, 2, ".", ","), 0, 0, "R");

$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   TOTAL en: Efectivo Bs ");
$pdf->setX(38);
$pdf->Cell(5, $textypos, " " . number_format($sub, 2, ".", ","), 0, 0, "R");

$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   TOTAL en: Tran Bs  ");
$pdf->setX(38);
$pdf->Cell(5, $textypos, "" . number_format($sub_trans, 2, ".", ","), 0, 0, "R");


/*

$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   Porcentaje Socio: US ");
$pdf->setX(38);
$pdf->Cell(5, $textypos, " " . number_format($ALE, 2, ".", ","), 0, 0, "R");

$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   Porcentaje Socio: Debito-BS ");
$pdf->setX(38);
$pdf->Cell(5, $textypos, " " . number_format($ALE_otro, 2, ".", ","), 0, 0, "R");

$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   Porcentaje Socio: Efec-BS");
$pdf->setX(38);
$pdf->Cell(5, $textypos, " " . number_format($ALE_e, 2, ".", ","), 0, 0, "R");

$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   Porcentaje Socio: Tran-BS");
$pdf->setX(38);
$pdf->Cell(5, $textypos, " " . number_format($ALE_t, 2, ".", ","), 0, 0, "R");

$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   Total neto en: USD");
$pdf->setX(38);
$pdf->Cell(5, $textypos, " " . number_format($total_ig, 2, ".", ","), 0, 0, "R");


$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   Total neto en: Debi-BS");
$pdf->setX(38);
$pdf->Cell(5, $textypos, "" . number_format($total_ig_otro, 2, ".", ","), 0, 0, "R");

$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   Total neto en: Efec-BS");
$pdf->setX(38);
$pdf->Cell(5, $textypos, " " . number_format($total_ig_e, 2, ".", ","), 0, 0, "R");

$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "   Total neto en: Trans-BS ");
$pdf->setX(38);
$pdf->Cell(5, $textypos, " " . number_format($total_ig_t, 2, ".", ","), 0, 0, "R");

*/

$pdf->Ln(3);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "   Fecha del Cierre ");
$pdf->setX(27);
$pdf->Cell(5, $textypos, '' . strtoupper(substr('' . $fecha_actual . '', 0, 12)));




$pdf->Output('Cierre #' . $fecha_actual . '.pdf', 'd');





































































