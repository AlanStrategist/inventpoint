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

  //Client Data

  $sql4 = "SELECT * FROM cliente WHERE cedula=" . $cedula . "";
  $respue = mysqli_query($conex, $sql4);
  $chivo = mysqli_fetch_object($respue);

  $nombre = $chivo->nombre;
  $telefono = $chivo->telefono;
  $cedula = $chivo->cedula;
  $tipo = $chivo->tipo;

  $fecha_actual = date("Y-m-d");

  $sql_dol = "SELECT valor FROM `dolar` ORDER BY `dolar`.`valor` DESC";

  $res = mysqli_query($conex, $sql_dol);

  $rows = mysqli_num_rows($res);

  if ($rows <= 0) {

    throw new Exception("Error Processing Request", 1);

  }

  $dolar = mysqli_fetch_object($res);
  $valor = $dolar->valor;


  //PDF Header

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
  $pdf->Cell(5, $textypos, 'CANT-NOMBRE             UND        SUB-TOTAL ');

  $methods = ["Divisa", "Efectivo", "Debito", "Transferencia","Abonos"];

  //Net By Method 
  $net_methods = [
    "Divisa" => 0,
    "Efectivo" => 0,
    "Debito" => 0,
    "Transferencia" => 0,
    "Abonos" => 0
  ];

  $net_USD = 0;    //Net ammount USD All sells   

  foreach ($methods as $method) {

    $sql_methods = "SELECT DISTINCT pr.nombre,
    ROUND(pr.precio + ( (pr.precio * pr.porcentaje) / 100),2) AS precio_venta,
    pe.quantity,
    f.date as modified,
    f.metodo,
    u.correo,
    c.cedula,
    pe.pay_price * pe.quantity AS subtotal,
    pe.pay_price * $valor AS cambio 

    FROM pedidos pe,cliente c,producto pr,usuarios u, facturas f 

    WHERE pe.product_id=pr.id AND 
    f.id_usuarios=u.id AND
    f.id_cliente = c.id AND
    f.metodo='".$method."' AND
    f.estatus='Facturado' AND
    pe.id_facturas=f.id AND
    DATE(f.date)= CURRENT_DATE";

    $res = mysqli_query($conex, $sql_methods);

    while ($data = mysqli_fetch_array($res)) {

      $net_USD += $data['subtotal'];
      $net_methods[$method] += $data['subtotal']; //Same thing but that resets by method 

      if ($data['metodo'] != "Divisa" || $data['metodo'] != 'Abonos') {

        $net_methods[$method] = $data["subtotal"] * $valor;

      }

      $pdf->setX(3);
      $pdf->SetFont('Arial', 'B', 5);
      $pdf->Cell(5, $off, '' . $data['quantity'] . '');
      $pdf->setX(4);
      $pdf->Cell(20, $off, strtoupper(substr('' . $data['nombre'] . '', 0, 12)));
      $pdf->setX(20);
      $pdf->Cell(11, $off, ($method != "Divisa" ? "BS" : "$") . number_format('' . ($method != "Divisa" ? $data['precio_venta'] * $valor : $data['precio_venta']) . '', 2, ".", ","), 0, 0, "R");
      $pdf->setX(30);
      $pdf->Cell(11, $off, ($method != "Divisa" ? "BS" : "$") . number_format(($method != "Divisa" ? (($data['quantity'] * $data['precio_venta']) * $valor) : ($data['quantity'] * $data['precio_venta'])), 2, ".", ","), 0, 0, "R");
      $pdf->setX(32);

      $off += 6;

    }

  }

  $textypos = $off + 6;

  $pdf->SetFont('Arial', 'B', 5);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Divisa ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, " " . number_format($net_methods['Divisa'], 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Debito");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, " " . number_format($net_methods['Debito'], 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Efectivo Bs ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, " " . number_format($net_methods['Efectivo'], 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Tran Bs  ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "" . number_format($net_methods['Transferencia'], 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL en: Abonos ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "" . number_format($net_methods['Abonos'], 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL CONVERTIDO (USD): ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "" . number_format($net_USD, 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "   TOTAL CONVERTIDO BS: ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "" . number_format(($net_USD * $valor), 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(10);
  $pdf->Cell(5, $textypos, "   Tasa del Dia");
  $pdf->setX(27);
  $pdf->Cell(5, $textypos, "" . number_format(($valor), 2, ".", ","), 0, 0, "R");

  $pdf->Ln(3);
  $pdf->setX(10);
  $pdf->Cell(5, $textypos, "   Fecha del Cierre ");
  $pdf->setX(27);
  $pdf->Cell(5, $textypos, '' . strtoupper(substr('' . $fecha_actual . '', 0, 12)));
  $pdf->Output('Cierre #' . $fecha_actual . '.pdf', 'd');

} catch (Exception $e) {

  //echo $e->getMessage();

  header("Location: ./cierre.php?alert=error");

} finally {

  mysqli_close($conex);

}



































































