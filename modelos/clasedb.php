<?php
/**
 * 
 */
class clasedb
{
	private $db;

	public function conectar()
	{
		try {

			$this->db = mysqli_connect("localhost", "root", "", "inventario") or die("No se pudo conectar con Mysql");

			if ($this->db->connect_error) {

				// Si hay un error de conexión, redirigir al index.php con un mensaje de error

				header("Location: ../index.php?alert=db");

			}

			return $this->db;

		} catch (Exception $e) {
			// Manejo de excepciones
			
			echo "Error: " . $e->getMessage();
			//header("Location: ../index.php?alert=db");
		}

	}

}