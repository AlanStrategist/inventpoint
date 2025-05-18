<?php
extract($_REQUEST);
require('../../fpdf/fpdf.php');
include("../../../modelos/clasedb.php");
include "../../../controladores/Utils.php";

if (!isLoged()) {
  header("Location ../../../index.php?alert=inicia");
}

try {

  date_default_timezone_set('America/Caracas');


  $db = new clasedb();

  $conex = $db->conectar();

  $sql_ab = "SELECT c.amount,c.metodo,c.fecha,f.factura FROM credits c , facturas f WHERE date(fecha) = CURRENT_DATE AND c.id_factura = f.id";
  $res_ab = mysqli_query($conex, $sql_ab);
  $row_ab = mysqli_num_rows($res_ab);

  if ($row_ab > 0) {

    while ($data = mysqli_fetch_array($res_ab)) {
      $abonos[] = $data;
    }

  } else {
    $abonos = array();
  }

  //Query to get the data

  $sql = "SELECT pr.nombre,
pe.pay_price AS precio_venta,
pe.quantity,
f.id AS id_factura,
f.date as modified,
f.metodo,
f.estatus,
f.factura,
f.fecha_credi,
u.correo, 
c.cedula,
c.nombre AS nombre_cliente,
u.nombre AS nombre_usuario,
d.valor,
pe.pay_price * pe.quantity AS subtotal,
pe.pay_price * d.valor AS cambio 

FROM pedidos pe ,cliente c,producto pr,usuarios u , dolar d, facturas f

WHERE pe.product_id=pr.id AND 
f.id_cliente= c.id AND  
f.id_usuarios=u.id AND 
f.id_dolar=d.id AND 
DATE(f.date)=CURRENT_DATE AND
pe.id_facturas=f.id";

  $res = mysqli_query($conex, $sql);
  $row = mysqli_num_rows($res);

  if ($row == 0) {

    header("Location: ./cierre.php?alert=error");
    exit();
  }

  $items = array();
  $net_USD = 0;
  $methods = ["Divisa", "Efectivo", "Debito", "Transferencia", "Abonos"];

  //Net By Method 
  $net_methods = [
    "Divisa" => 0,
    "Efectivo" => 0,
    "Debito" => 0,
    "Transferencia" => 0,
    "Abonos" => 0
  ];



  while ($data = mysqli_fetch_array($res)) {

    $net_methods[$data['metodo']] += $data['subtotal']; //Save net by method
    $net_USD += $data['subtotal'];
    $valor = $data['valor'];
    $items[] = $data;
    $fecha_actual = $data['modified'];

  }

  $net_Ab = 0;
  foreach ($abonos as $data) {

    $net_methods[$data['metodo']] += $data['amount']; //Save net by method
    $net_Ab += $data['amount'];

  }

  //PDF Header

  $pdf = new FPDF($orientation = 'P', $unit = 'mm', array(45, 350));
  $pdf->AddPage();

  // *** Nueva cabecera "Cierre de Operaciones" ***
  $pdf->SetFont('Arial', 'B', 8);
  $pdf->Cell(0, 5, 'Cierre de Operaciones', 0, 1, 'C');
  $pdf->Ln(5); // Añade un pequeño espacio después de la cabecera

  $pdf->SetFont('Arial', 'B', 7);     //Letra Arial, negrita (Bold), tam. 20

  $textypos = 5;

  $pdf->setY(12); // Ajusta la posición Y para dejar espacio a la nueva cabecera
  $pdf->setX(4);
  $pdf->setX(4);

  $off = $textypos + 6;

  $pdf->SetFont('Arial', 'B', 5);

  $pdf->setX(4);
  $pdf->Cell(5, $textypos, 'CANT-NOMBRE     UND      SUB-TOTAL ');

  foreach ($methods as $method) {

    foreach ($items as $data) {

      if ($data['metodo'] != $method) {

        continue;
      }

      $pdf->setX(3);
      $pdf->SetFont('Arial', 'B', 5);
      $pdf->Cell(5, $off, '' . $data['quantity'] . '');
      $pdf->setX(4);
      $pdf->Cell(20, $off, strtoupper(substr('' . $data['nombre'] . '', 0, 12)));
      $pdf->setX(20);
      $pdf->Cell(11, $off, ($method != "Divisa" && $method != "Abonos" ? "BS" : "$") . number_format('' . ($method != "Divisa" && $method != "Abonos" ? $data['precio_venta'] * $valor : $data['precio_venta']) . '', 2, ".", ","), 0, 0, "R");
      $pdf->setX(30);
      $pdf->Cell(11, $off, ($method != "Divisa" && $method != "Abonos" ? "BS" : "$") . number_format(($method != "Divisa" && $method != "Abonos" ? (($data['quantity'] * $data['precio_venta']) * $valor) : ($data['quantity'] * $data['precio_venta'])), 2, ".", ","), 0, 0, "R");
      $pdf->setX(32);

      $off += 6;

    }

  }

  $textypos = $off + 6;

  $pdf->SetFont('Arial', 'B', 5);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Divisa ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "$" . number_format($net_methods['Divisa'], 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Debito");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "BS" . number_format($net_methods['Debito'] * $valor, 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Efectivo Bs ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "BS" . number_format($net_methods['Efectivo'] * $valor, 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Tran Bs  ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "BS" . number_format($net_methods['Transferencia'] * $valor, 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Creditos");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "$(" . number_format($net_methods['Abonos'], 2, ".", ",") . ")", 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Abonos a Creditos");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "$" . number_format($net_Ab, 2, ".", ",") . "", 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL CONVERTIDO (USD): ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "$" . number_format($net_USD, 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL CONVERTIDO BS: ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "BS" . number_format(($net_USD * $valor), 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(10);
  $pdf->Cell(5, $textypos, "   Tasa del Dia");
  $pdf->setX(27);
  $pdf->Cell(5, $textypos, "BS" . number_format(($valor), 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(10);
  $pdf->Cell(5, $textypos, "   Fecha del Cierre ");
  $pdf->setX(27);
  $pdf->Cell(5, $textypos, '' . strtoupper(substr('' . $fecha_actual . '', 0, 12)));

  $pdf->Ln(3);
  $pdf->setX(10);
  $pdf->Cell(5, $textypos, "*Total abonos a creditos suma al",0,0,"L");
  
  $pdf->Ln(3);
  $pdf->setX(10);
  $pdf->Cell(5, $textypos, "metodo que coincida",0,0,"L");

  $pdf->Ln(3);
  $pdf->setX(10);
  $pdf->Cell(5, $textypos, "*() en creditos quiere decir que",0,0,"L");
  
  $pdf->Ln(3);
  $pdf->setX(10);
  $pdf->Cell(5, $textypos, "es un monto adeudado no adquirido",0,0,"L");
 
 

  $pdf->Output('Cierre #' . $fecha_actual . '.pdf', 'd');

} catch (Exception $e) {

  echo $e->getMessage();

  //header("Location: ./cierre.php?alert=error");

} finally {

  mysqli_close($conex);

}

?>