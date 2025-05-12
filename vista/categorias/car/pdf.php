<?php 
extract($_REQUEST);

include "../../../controladores/Utils.php";
require('../../fpdf/fpdf.php');
include("../../../modelos/clasedb.php");

if(!isLoged()){ header('../index.php?alert=inicia'); }



$db = new clasedb();

$conex = $db->conectar();

#found the dolar value

$sql4 = "SELECT * FROM `dolar` ORDER BY `dolar`.`valor` DESC";

$res4 = mysqli_query($conex, $sql4);
$rows = mysqli_num_rows($res4);

if ($rows > 0) {
  $dolar = mysqli_fetch_object($res4);
  $valor = $dolar->valor;
} else { ?>
  <script type="text/javascript">

    window.location = 'clienpagos.php?errordolar'

  </script>


<?php }


$sql2 = "SELECT
pe.modified,
pe.metodo,
c.nombre,
c.telefono, 
c.cedula 

FROM pedidos pe,cliente c

WHERE pe.estatus='pago' AND pe.cliente_id=c.id";


$sql = "SELECT pe.quantity,
 pe.modified,
 pe.metodo,
 pe.pay_price AS precio_venta, 
 c.nombre,
 c.telefono, 
 c.cedula, 
 pe.pay_price * pe.quantity AS subtotal, 
 pr.nombre AS nombre_item, 
 pe.pay_price * d.valor AS cambio 
 
 FROM pedidos pe,producto pr,cliente c, dolar d
 
 WHERE pe.estatus='pago' AND pe.cliente_id=c.id AND pe.product_id=pr.id";

$res = mysqli_query($conex, $sql);
$rows = mysqli_num_rows($res);

$res2 = mysqli_query($conex, $sql2);
$rows2 = mysqli_num_rows($res2);


$cliente = mysqli_fetch_object($res2);
$nombre = $cliente->nombre;
$cedula = $cliente->cedula;
$telefono = $cliente->telefono;
$modified = $cliente->modified;
$metodo = $cliente->metodo;


if ($rows > 0 || $rows2 > 0) {


  $pdf = new FPDF($orientation = 'P', $unit = 'mm', array(45, 350));
  $pdf->AddPage();
  $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
  $textypos = 5;
  $pdf->setY(2);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "InventPoint Sistem C.A");
  $pdf->SetFont('Arial', '', 5);    //Letra Arial, negrita (Bold), tam. 20

  $textypos += 6;

  $pdf->setX(2);
  $pdf->Cell(5, $textypos, 'Datos del cliente');
  $textypos += 6;
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, 'Nombre : ' . $nombre . '');
  $pdf->setX(2);
  $textypos += 6;
  $pdf->Cell(5, $textypos, 'telefono : ' . $telefono . '');
  $pdf->setX(2);
  $textypos += 6;
  $pdf->Cell(5, $textypos, '' . utf8_decode("Fecha y Hora") . ': ' . $modified . '');
  $pdf->setX(2);
  $textypos += 6;

  $pdf->Cell(2, $textypos, '' . utf8_decode("Cédula") . ': ' . $cedula . '');
  $pdf->setX(2);
  $textypos += 6;

  $pdf->Cell(2, $textypos, '' . utf8_decode("Método") . ': ' . $metodo . '');

  $to = 0;

  $total = 0;
  $perro = 0;
  $total_neto = 0;
  $off = $textypos + 6;
  $pdf->Ln(3);
  $pdf->SetFont('Arial', '', 4);
  $pdf->setX(1);
  $pdf->Cell(3, $textypos, 'CANT-NOMBRE                                        PRECIO($)      TOTAL($)');

  while ($datos = mysqli_fetch_array($res)) {

    $total = $datos['precio_venta'] * $datos['quantity'];
    $total_neto += $total;
    $perro += $datos['cambio'] * $datos['quantity'];
    $to += $perro;
    $pdf->setX(2);

    $pdf->SetFont('Arial', '', 3);
    $pdf->Cell(5, $off, '' . $datos['quantity'] . '');

    $pdf->setX(4);
    $pdf->Cell(35, $off, strtoupper(substr('' . $datos['nombre_item'] . '', 0, 12)));
    $pdf->setX(25);
    $pdf->Cell(11, $off, "" . number_format('' . $datos['precio_venta'] . '', 2, ".", ","), 0, 0, "R");
    $pdf->setX(32);
    $pdf->Cell(11, $off, "" . number_format($total, 2, ".", ","), 0, 0, "R");
    $pdf->setX(32);
    $total += $datos['subtotal'];


    $off += 6;
  }
  $textypos = $off + 6;


  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "TOTAL: ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "(USD) " . number_format($total_neto, 2, ".", ","), 0, 0, "R");
  $pdf->Ln(3);
  $pdf->setX(2);
  $pdf->Cell(5, $textypos, "TOTAL: ");
  $pdf->setX(38);
  $pdf->Cell(5, $textypos, "BS " . number_format($perro, 2, ".", ","), 0, 0, "R");
  $pdf->setX(2);
  $pdf->Cell(5, $textypos + 6, '                                        GRACIAS POR TU COMPRA ');


  $pdf->Output('' . $nombre . ' #' . $modified . '.pdf', 'd');


} else { ?>

  <script type="text/javascript">

    window.location = 'clienpagos.php?errorgen'

  </script>

<?php }

?>