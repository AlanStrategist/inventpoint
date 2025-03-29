<?php

include("../modelos/clasedb.php");
include "./Utils.php";

if (!isLoged()) {
	header("Location: ../index.php?alert=inicia");
}

extract($_REQUEST);


class ControladorCarrito
{

	public function registrar()
	{

		header("Location: ../vista/categorias/carrito/registrar.php");
	}


	public function eliminar()
	{
		extract($_REQUEST);

		$user_id = $_SESSION["id"];

		try {

			$db = new clasedb;
			$conex = $db->conectar();
			$sql = "DELETE FROM cart_menu WHERE product_id=" . $id . " AND user_id=" . $user_id . "";

			$res = mysqli_query($conex, $sql);

			if ($res) {

				header("Location: ../vista/categorias/car/carro.php?alert=rem");

			}

		} catch (mysqli_sql_exception $e) {

			header("Location:../vista/categorias/car/carro.php?alert=error");

		} finally {

			mysqli_close($conex);

		}
	}


	public function actualizar()
	{

		extract($_REQUEST);


		extract($_POST);



		$user_id = $_SESSION["id"];

		try {

			$db = new clasedb;
			$conex = $db->conectar();

			$sql = "UPDATE cart_menu SET quantity=" . $quantity . " WHERE product_id=" . $product_id . " AND user_id=" . $user_id . "";

			$res = mysqli_query($conex, $sql);

			if ($res) {


				$loc = $ByCon == "true" ? "Location: ../vista/categorias/car/productos.php?alert=ac" : "Location: ../vista/categorias/car/carro.php?alert=ac";

				header($loc);
			}

		} catch (mysqli_sql_exception $e) {

			header("Location: ../vista/categorias/car/carro.php?alert=error");

		} finally {

			mysqli_close($conex);
		}

	}

	public function agregar()
	{

		#Get Form		
		extract($_POST);

		$user_id = $_SESSION["id"];

		try {

			$db = new clasedb;

			$conex = $db->conectar();

			$created = date('Y-m-d H:i:s');

			#check availability

			$cons = "SELECT producto.stock FROM producto WHERE id=" . $id . " AND stock >= 1 AND stock >= ".$quantity."";

			$resul = mysqli_query($conex, $cons);

			$porsiala = mysqli_num_rows($resul);

			if (!($porsiala > 0)) {
				
				header("Location: ../vista/categorias/car/productos.php?alert=nostock");
				
			}

			#Check if already has in the car

			$sql_check_in_car = "SELECT quantity FROM cart_menu WHERE product_id = " . $id;

			$query_checkin = mysqli_query($conex, $sql_check_in_car);

			$checkin = mysqli_num_rows($query_checkin);

			if ($checkin > 0) {

				#send to method "actualizar" & increment quantity

				$quant = mysqli_fetch_array($query_checkin);

				$quantity += $quant['quantity'];

				$loc = "";

				while ($row = mysqli_fetch_array($resul)) {

					if( $row['stock'] < $quantity ){ header("Location: ../vista/categorias/car/productos.php?alert=nostock"); 
						
					return; //is not have else, must have return;

					} 
				}
			
				header("Location: ./ControladorCarrito.php?operacion=actualizar&quantity=" . $quantity . "&product_id=" . $id . "&ByCon=true");

			} else {

				$sql = "INSERT INTO `cart_menu` ( `id`,`product_id`, `quantity`, `user_id`,`created`) VALUES (NULL, '$id','$quantity','$user_id','$created')";

				$res = mysqli_query($conex, $sql);

				if ($res) {

					header("Location: ../vista/categorias/car/productos.php?alert=add");

				}

			}

		} catch (mysqli_sql_exception | Exception $e) {

			//echo "". $e->getMessage() ."";

			header("location: ../vista/categorias/car/productos.php?alert=error");


		} finally {

			mysqli_close($conex);
		}

	}

	static function controlador($operacion)
	{

		$pro = new ControladorCarrito();
		switch ($operacion) {

			case 'agregar': #listo en teoria

				$pro->agregar();
				break;

			case 'actualizar':
				$pro->actualizar();
				break;
			case 'eliminar':
				$pro->eliminar();
				break;

			default:
				?>

				<script type="text/javascript">
					alert("sin ruta, no existe");
					window.location = "../vista/categorias/home/home.php";
				</script>

				<?php
				break;
		}

	}
}

ControladorCarrito::controlador($operacion);

?>