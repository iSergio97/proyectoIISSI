<?php	
	session_start();	
	
	if (isset($_SESSION["articulo"])) {
		$articulo = $_SESSION["articulo"];
		unset($_SESSION["articulo"]);
		
		require_once("gestionBD.php");
		require_once("gestionar_prendas.php");
		
		$conexion = crearConexionBD();		
		$excepcion = quitar_articulo($conexion,$articulo["IDARTICULO"]);
		cerrarConexionBD($conexion);
			
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "consulta_articulos.php";
			Header("Location: falloConexion.php");
		}
		else Header("Location: consulta_articulos.php");
	}
	else Header("Location: consulta_articulos.php"); // Se ha tratado de acceder directamente a este PHP
?>
