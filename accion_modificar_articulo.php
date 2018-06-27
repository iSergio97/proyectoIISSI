<?php
	session_start();

	if (isset($_SESSION["articulo"])) {
		$articulo = $_SESSION["articulo"];
		unset($_SESSION["articulo"]);

		require_once("gestionBD.php");
		require_once("gestionar_prendas.php");

		$conexion = crearConexionBD();
		$excepcion = accion_modificar_articulo($conexion, $articulo["IDARTICULO"], $articulo["NOMBRE"], $articulo["PRECIO"], $articulo["TALLA"], $articulo["TAGS"]);
		cerrarConexionBD($conexion);

		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "indexLog.php";
			Header("Location: falloConexion.php");
		}
		else
			Header("Location: indexLog.php");
	}
	else Header("Location: indexLog.php"); // Se ha tratado de acceder directamente a este PHP
?>
