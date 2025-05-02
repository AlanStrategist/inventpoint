<?php

extract($_REQUEST);

include("../modelos/clasedb.php");
include "Utils.php";

if(!isLoged()){	header(" Location: ../index.php?alert=inicia "); return; }

class ControladorPedido
{
	public function guardar()
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
		    #verify sales without end

		    $sql_has_p = "SELECT * FROM pedidos WHERE estatus='pago'"; 
			$qu = mysqli_query($conex, $sql_has_p);
		    $num = mysqli_num_rows($qu);

			if( $num > 0) {
				
				header("Location: ../vista/categorias/car/clienpagos.php?alert=culm");

				return;

			}
			
			//Verifies method credito with no date
			
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

		try{

		$db = new clasedb();
		
		$conex = $db->conectar();
		
		$sql = "UPDATE pedidos SET metodo='$metodo', estatus='pago', fecha=CURRENT_DATE WHERE factura=".$factura;

		$res = mysqli_query($conex, $sql) or die;
		
		if (!$res) {

		header("Location: ../vista/categorias/car/clienpagos.php?alert=error");
			
		return;

		}

		header("Location: ../vista/categorias/car/clienpagos.php?alert=donefac");

		}catch(mysqli_sql_exception | Exception $e) {

			header("Location: ../vista/categorias/car/clienpagos.php?alert=error");

		}finally{

			mysqli_close($conex);

		}
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

		$sql = "DELETE FROM pedidos WHERE id=" . $id;

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

	public function notificar()
	{
		
		extract($_REQUEST);
		extract($_POST);

		$id_usuario = $_SESSION['id'];

		try{

		$db = new clasedb();
		$conex = $db->conectar();

		$estatus = "facturado";

		$sql = "UPDATE pedidos SET estatus='$estatus' WHERE id_usuario='$id_usuario'";

		$res = mysqli_query($conex, $sql) or die;
		
		if (!$res) {
		
			header("Location: ../vista/categorias/car/productos.php?alert=errorven");

			return;

		}

		header("Location: ../vista/categorias/car/productos.php?alert=save");

		}catch (mysqli_sql_exception | Exception $e) {

		}finally{

			mysqli_close($conex);
		}
	}
	public function pago()
	{
		extract($_REQUEST);

		header("Location: ../vista/categorias/car/metodo.php?id=" . $id);
	}

	public function factura()
	{
		header("Location: ../vista/categorias/car/facturado.php");
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