<?php

extract($_REQUEST);

include("../modelos/clasedb.php");
include "Utils.php";

if(!isLoged()){	header(" Location: ../index.php?alert=inicia "); return; }

class ControladorPedido
{
	public function menu()
	{

		extract($_POST);

		$id_usuario = $_SESSION['id'];

		try{

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

				$facNum = GetFac();

				while ($data = mysqli_fetch_array($respuesta)) {

					if ($data['restante'] < 0) { 
						
						header("Location: ../vista/categorias/car/carro.php?alert=nostock");
						
						return;
					
					}

					if ($fecha_credi == '') {

							$sql2 = "INSERT INTO `pedidos` (`id`,`factura`, `id_usuario`, `product_id`,`cliente_id`, `modified`,`estatus`,`quantity`,`metodo`,`fecha`,`fecha_credi`) VALUES (NULL," . $facNum . "," . $data['user_id'] . ",'" . $data['product_id'] . "','" . $id_cliente . "',CURRENT_TIMESTAMP,'pago','" . $data['quantity'] . "','" . $metodo . "',CURRENT_DATE,NULL)";

						} else {
							$metodo = 'Credito';

							$sql2 = "INSERT INTO `pedidos` (`id`, `factura`,`id_usuario`, `product_id`,`cliente_id`, `modified`,`estatus`,`quantity`,`metodo`,`fecha`,`fecha_credi`) VALUES (NULL," . $facNum . "," . $data['user_id'] . ",'" . $data['product_id'] . "','" . $id_cliente . "',CURRENT_TIMESTAMP,'credito','" . $data['quantity'] . "','Credito',CURRENT_DATE,'" . $fecha_credi . "')";
						}

						$fino = mysqli_query($conex, $sql2);

						if (!$fino) {

							header("Location: ../vista/categorias/car/carro.php?alert=error");

							return;

						}

						$sql3 = "UPDATE producto SET stock=" . $data['restante'] . " WHERE `id`=" . $data['product_id'] . "";

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

							$loc = $metodo == 'Credito' ? "Location: ../vista/categorias/car/todo_dia.php?alert=credit" : "Location: ../vista/categorias/car/clienpagos.php?alert=pedido"; 
							
							header($loc);

		}catch(mysqli_sql_exception | Exception $e) {
			
			header("Location: ../vista/categorias/car/carro.php?alert=no");
		}
		finally{

			mysqli_close($conex);
		}
		

	}//fin de la funcion

	public function aprobar()
	{
		extract($_REQUEST);
		extract($_POST);

		$db = new clasedb();
		$conex = $db->conectar();
		$sql = "UPDATE pedidos SET metodo='$metodo', estatus='pago',fecha=CURRENT_DATE WHERE id='$id'";

		$res = mysqli_query($conex, $sql) or die;
		("Algo ha ido mal en la aprobación de los datos del carrito a la base de datos");

		header("Location: ../vista/categorias/car/clienpagos.php?alert=donefac");

	}//fin de funcion aprobar

	public function notificar()
	{
		if (empty($_SESSION['id'])) {
			header("Location: ../index.php?inicia");
		} else {
			$id_usuario = $_SESSION['id'];

		}

		extract($_REQUEST);
		extract($_POST);

		$db = new clasedb();
		$conex = $db->conectar();



		$estatus = "facturado";

		$sql = "UPDATE pedidos SET estatus='$estatus' WHERE id_usuario='$id_usuario'";


		$res = mysqli_query($conex, $sql) or die;
		("Algo ha ido mal en la eliminacion de los datos del pago ");

		header("Location: ../vista/categorias/carro/productos.php?alert=donefac");

	}


	public function borrar()
	{
		

		extract($_REQUEST);

		try{

		$db = new clasedb();
		$conex = $db->conectar();

		//tomo la cantidad y la repongo en el stock
		$query = "SELECT pedidos.factura,.pedidos.product_id,pedidos.quantity FROM pedidos WHERE id=$id";

		$ros = mysqli_query($conex, $query);
		$count = mysqli_num_rows($ros);

		if (!($count > 0)) {

			header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

			return;

		}

		$rows = mysqli_fetch_array($ros);

		$sql2 = "SELECT producto.stock FROM producto WHERE id=" . $rows['product_id'];

		$rus = mysqli_query($conex, $sql2);

		if (!$rus) {
			
			header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

			return;

		}

		$rows2 = mysqli_fetch_array($rus);

		$stock = $rows['quantity'] + $rows2['stock'];

		$sql3 = "UPDATE producto SET stock=$stock WHERE id=" . $rows['product_id'];

		$ras = mysqli_query($conex, $sql3);

		if (!$ras) {

			header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

			return;
		}

		//Remove item of the sale

		$sql = "DELETE FROM pedidos WHERE product_id=" . $rows['product_id'];

		$res = mysqli_query($conex, $sql);

		if (!$res) {

			header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

			return;

		}else{
			
			header("Location: ../vista/categorias/car/clienpagos.php?alert=deletevent");
			
			return;
		}
					
	} catch (mysqli_sql_exception | Exception $e) {	

		header("Location: ../vista/categorias/car/clienpagos.php?alert=errorven");

	}finally{

		mysqli_close($conex);

	}

	}

	public function notificarad()
	{
		if (empty($_SESSION['id'])) {
			header("Location: ../index.php?inicia");
		} else {
			$id_usuario = $_SESSION['id'];

		}

		extract($_REQUEST);
		extract($_POST);

		$db = new clasedb();
		$conex = $db->conectar();



		$estatus = "facturado";

		$sql = "UPDATE pedidos SET estatus='$estatus' WHERE id_usuario='$id_usuario'";


		$res = mysqli_query($conex, $sql) or die;
		("Algo ha ido mal en la eliminacion de los datos del pago ");

		header("Location: ../vista/categorias/car/productos.php?notificacion");

	}
	public function pago()
	{
		extract($_REQUEST);
		header("Location: ../vista/categorias/car/metodo.php?id=" . $id);
	}

	public function factura()
	{
		$db = new clasedb();
		$conex = $db->conectar();



		header("Location: ../vista/categorias/car/facturado.php");


		//mandar datos codificados a la dirección de la función header
	}




	public function empleadofact()
	{
		$db = new clasedb();
		$conex = $db->conectar();

		$sql = "SELECT * FROM pedidos WHERE estatus='facturado'";//mostrar
		$res = mysqli_query($conex, $sql);

		$campos = mysqli_num_fields($res);
		$filas = mysqli_num_rows($res);

		$i = 0;

		$datos[] = array();

		while ($data = mysqli_fetch_array($res)) {
			for ($j = 0; $j < $campos; $j++) {
				$datos[$i][$j] = $data[$j];
			}
			$i++;
		}

		if (isset($_GET['entregado'])) {


			header("Location: ../vista/categorias/carro/facturado.php?filas=" . $filas . "&campos=" . $campos . "&data=" . serialize($datos) . "&entregado=entregado");
		} else {

			header("Location: ../vista/categorias/carro/facturado.php?filas=" . $filas . "&campos=" . $campos . "&data=" . serialize($datos));
		}

		//mandar datos codificados a la dirección de la función header
	}

	public function details(){

		extract($_REQUEST);

		header("Location: ../vista/categorias/factura/details.php?id=".$id."");

	}

	static function controlador($operacion)
	{

		$pro = new ControladorPedido();
		switch ($operacion) {


			case 'aprobar':
				$pro->aprobar();
				break;

			case 'menu'://que guarda realza el registro de la compra
				$pro->menu();
				break;

			case 'empleadofact'://que guarda realza el registro de la compra
				$pro->empleadofact();
				break;

			case 'notificar'://que guarda realza el registro de la compra
				$pro->notificar();
				break;

			case 'notificarad'://que guarda realza el registro de la compra
				$pro->notificarad();
				break;

			case 'pago'://que guarda realza el registro de la compra
				$pro->pago();
				break;

			case 'borrar'://que guarda realza el registro de la compra
				$pro->borrar();
				break;
			case 'factura'://que guarda realza el registro de la compra
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