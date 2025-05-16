<?php

extract($_REQUEST);

include("../modelos/clasedb.php");
include "Utils.php";

if (!isLoged()) {
	header(" Location: ../index.php?alert=inicia ");
	return;
}

class ControladorPedido
{
	public function guardar()
	{
		extract($_POST);

		$id_usuario = $_SESSION['id'];

		try {

			$db = new clasedb();
			$conex = $db->conectar();

			$sql23 = "SELECT * FROM cliente WHERE cedula=" . $cedula . "";
			$response = mysqli_query($conex, $sql23);
			$porsi = mysqli_num_rows($response);

			if ($porsi == 0) {

				header("Location: ../vista/categorias/car/carro.php?alert=cedula");

				return;
			}

			$cliente = mysqli_fetch_object($response);
			$id_cliente = $cliente->id;
			//traigo el id del cliente

			//Verifies Dolar Price

			$sql_dolar = "SELECT * FROM dolar ORDER BY id DESC LIMIT 1";
			$res_dolar = mysqli_query($conex, $sql_dolar);

			if (!$res_dolar) {

				header("Location: ../vista/categorias/car/carro.php?alert=error_dol");

				return;
			}

			$dolar = mysqli_fetch_object($res_dolar);
			$id_dolar = $dolar->id;

			#verify sales without end
			$sql_has_p = "SELECT id FROM facturas WHERE estatus='Pendiente'";
			$qu = mysqli_query($conex, $sql_has_p);
			$num = mysqli_num_rows($qu);

			if ($num > 0) {

				header("Location: ../vista/categorias/car/clienpagos.php?alert=culm");

				return;

			}

			//pido todos los datos de los productos del carrito segun el usuario y calculo la cantidad en existencia

			$sql = "SELECT DISTINCT cm.product_id,cm.user_id,cm.quantity,p.nombre,
		ROUND(p.precio + ( (p.precio * p.porcentaje) / 100),2) AS precio_venta,
		p.stock,(p.stock-cm.quantity) AS restante 

		FROM cart_menu cm,producto p,usuarios u,cliente c 

		WHERE cm.user_id=u.id AND cm.product_id=p.id";

			$respuesta = mysqli_query($conex, $sql);

			if (!$respuesta) {

				header("Location: ../vista/categorias/car/carro.php?alert=error");

				return;
			}

			//Get the invoice number

			$facNum = GetFac();

			// Get total amount and array of products, and data of the sell

			$total = 0;

			$data = array();

			while ($dat = mysqli_fetch_array($respuesta)) {

				$data[] = $dat;

				if ($dat['restante'] < 0) {

					header("Location: ../vista/categorias/car/carro.php?alert=nostock");

					return;

				}

				$total += $dat['precio_venta'] * $dat['quantity'];

			}

			//Insert into the table facturas

			$sql_fac = !isset($fecha_credi) ? "INSERT INTO `facturas`(`id`, `factura`, `total`, `id_cliente`, `id_dolar`,`id_usuarios`, `metodo`, `estatus`, `ref`,`date`,`fecha_credi`) 
		
		VALUES (NULL," . $facNum . "," . $total . "," . $id_cliente . "," . $id_dolar . "," . $id_usuario . ",'" . $metodo . "','Pendiente','',CURRENT_TIMESTAMP(),NULL)" :

				"INSERT INTO `facturas`(`id`, `factura`, `total`, `id_cliente`, `id_dolar`,`id_usuarios`, `metodo`, `estatus`, `ref`,`date`,`fecha_credi`) VALUES 
		
		(NULL," . $facNum . "," . $total . "," . $id_cliente . "," . $id_dolar . "," . $id_usuario . ",'Abonos','Credito','',CURRENT_TIMESTAMP(),'$fecha_credi')";

			$fino = mysqli_query($conex, $sql_fac);

			if (!$fino) {

				header("Location: ../vista/categorias/car/carro.php?alert=error");

				return;

			}

			//Get the id of the invoice

			$sql = "SELECT id FROM facturas WHERE factura=" . $facNum . "";
			$res = mysqli_query($conex, $sql);

			if (!$res) {

				header("Location: ../vista/categorias/car/carro.php?alert=error");

				return;

			}

			$rows = mysqli_fetch_array($res);
			$id_factura = $rows['id'];

			//Insert into the table pedidos by product

			foreach ($data as $d) {

				$sql_ped = "INSERT INTO `pedidos`(`id`, `id_facturas`, `product_id`, `pay_price`, `quantity`) 
			
			    VALUES (NULL," . $id_factura . "," . $d['product_id'] . "," . $d['precio_venta'] . "," . $d['quantity'] . ")";

				$res_ped = mysqli_query($conex, $sql_ped);

				if (!$res_ped) {

					header("Location: ../vista/categorias/car/clienpagos.php?alert=error");

					return;
				}

				$sql3 = "UPDATE producto SET stock=" . $d['restante'] . " WHERE `id`=" . $d['product_id'] . "";

				$pavo = mysqli_query($conex, $sql3);

				if (!$pavo) {

					header("Location: ../vista/categorias/car/clienpagos.php?alert=error");

					return;
				}

			}
			//Vacio el carrito

			$sql4 = "DELETE FROM cart_menu WHERE  `user_id`=" . $id_usuario . "";

			$res = mysqli_query($conex, $sql4);

			if (!$res) {

				header("Location: ../vista/categorias/car/clienpagos.php?alert=error");

				return;
			}

			$loc = $fecha_credi != '' ? "Location: ../vista/categorias/car/todo_dia.php?alert=credit" : "Location: ../vista/categorias/car/clienpagos.php?alert=pedido";

			header($loc);

		} catch (mysqli_sql_exception | Exception $e) {

			//echo $e->getMessage();	

			header("Location: ../vista/categorias/car/carro.php?alert=no");

		} finally {

			mysqli_close($conex);
		}


	}//fin de la funcion

	public function aprobar()
	{
		extract($_REQUEST);
		extract($_POST);

		try {

			$db = new clasedb();

			$conex = $db->conectar();

			$sql = "UPDATE pedidos SET metodo='$metodo', estatus='pago', fecha=CURRENT_DATE WHERE factura=" . $factura;

			$res = mysqli_query($conex, $sql) or die;

			if (!$res) {

				header("Location: ../vista/categorias/car/clienpagos.php?alert=error");

				return;

			}

			header("Location: ../vista/categorias/car/clienpagos.php?alert=donefac");

		} catch (mysqli_sql_exception | Exception $e) {

			header("Location: ../vista/categorias/car/clienpagos.php?alert=error");

		} finally {

			mysqli_close($conex);

		}
	}

	public function borrar()
	{
		extract($_REQUEST);

		try {

			$db = new clasedb();
			$conex = $db->conectar();

			//tomo la cantidad y el producto y lo resto de la factura

			$sql = "SELECT total FROM facturas WHERE id=" . $fac;

			$sql_factura = mysqli_query($conex, $sql);

			if (!$sql_factura) {

				header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

				return;

			}

			$rows = mysqli_fetch_array($sql_factura);

			$total = $rows['total'] - ($q * $cost);

			//Update the total of the invoice

			$sql_up = "UPDATE facturas SET total=$total WHERE id=" . $fac;
			$res = mysqli_query($conex, $sql_up);

			if (!$res) {

				header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

				return;

			}

			//Remove item of the invoice

			$sql_rem = "DELETE FROM pedidos WHERE product_id=" . $product_id . " AND id_facturas=" . $fac;

			$res = mysqli_query($conex, $sql_rem);

			if (!$res) {

				header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

				return;

			}

			//Update the stock of the product

			$sql2 = "SELECT producto.stock FROM producto WHERE id=" . $product_id;

			$rus = mysqli_query($conex, $sql2);

			if (!$rus) {

				header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

				return;

			}

			$rows2 = mysqli_fetch_array($rus);

			$stock = $q + $rows2['stock'];

			$sql3 = "UPDATE producto SET stock=$stock WHERE id=" . $product_id;

			$ras = mysqli_query($conex, $sql3);

			if (!$ras) {

				header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

				return;
			}

			header("Location: ../vista/categorias/car/clienpagos.php?alert=deletevent");

			return;


		} catch (mysqli_sql_exception | Exception $e) {

			echo $e->getMessage();

			//header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

		} finally {

			mysqli_close($conex);

		}

	}

	public function notificar()
	{
		extract($_REQUEST);

		try {

			$db = new clasedb();
			$conex = $db->conectar();

			$sql = "UPDATE facturas SET estatus='Facturado' WHERE id=$id_f";

			$res = mysqli_query($conex, $sql) or die;

			if (!$res) {

				header("Location: ../vista/categorias/car/productos.php?alert=errorven");

				return;

			}

			header("Location: ../vista/categorias/car/productos.php?alert=save");

		} catch (mysqli_sql_exception | Exception $e) {

			header("Location: ../vista/categorias/car/productos.php?alert=errorven");

		} finally {

			mysqli_close($conex);
		}
	}
	public function pago()
	{
		extract($_REQUEST);

		header("Location: ../vista/categorias/car/metodo.php?id=" . $id);
	}
	public function details()
	{

		extract($_REQUEST);

		header("Location: ../vista/categorias/factura/details.php?fac=".$fac."&id=" . $id . "");

	}

	static function controlador($operacion)
	{

		$pro = new ControladorPedido();
		switch ($operacion) {


			case 'aprobar':
				$pro->aprobar();
				break;

			case 'guardar':
				$pro->guardar();
				break;

			case 'notificar':
				$pro->notificar();
				break;

			case 'pago':
				$pro->pago();
				break;

			case 'borrar': // delete items of a sale in pedidos, repos stock in the table products
				$pro->borrar();
				break;

			case 'factura':
				$pro->factura();
				break;

			case 'details': //Show all invoices
				$pro->details();
				break;

			default:
				?>

				<script type="text/javascript">
					alert("sin ruta, no existe");
					window.location = "ControladorPedido.php?operacion=index";
				</script>
				<?php
				break;
		}
	}
}
ControladorPedido::controlador($operacion);
?>