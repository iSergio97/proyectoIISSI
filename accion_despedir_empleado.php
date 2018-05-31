<?php	
	session_start();	
	
	if (isset($_SESSION["empleado"])) {
		$empleado = $_SESSION["empleado"];
		unset($_SESSION["empleado"]);
		
		require_once("gestionBD.php");
		require_once("gestionarEmpleados.php");
		
		$conexion = crearConexionBD();		
		$excepcion = despedir_empleado($conexion,$empleado["OID_USUARIO"]);
		cerrarConexionBD($conexion);
			
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "consulta_empleados.php";
			Header("Location: excepcion.php");
		}
		else Header("Location: consulta_empleados.php");
	}
	else Header("Location: consulta_empleados.php"); // Se ha tratado de acceder directamente a este PHP
?>
