<?php	
	session_start();
	
	if (isset($_REQUEST["OID_USUARIO"])){
		$empleado["OID_USUARIO"] = $_REQUEST["OID_USUARIO"];
		$empleado["DNI"] = $_REQUEST["DNI"];
		$empleado["NOMBREUSUARIO"] = $_REQUEST["NOMBREUSUARIO"];
		$empleado["NOMBRE"] = $_REQUEST["NOMBRE"];
		$empleado["APELLIDOS"] = $_REQUEST["APELLIDOS"];
		$empleado["EMAIL"] = $_REQUEST["EMAIL"];
		$empleado["TELEFONO"] = $_REQUEST["TELEFONO"];
		$empleado["DIRECCION"] = $_REQUEST["DIRECCION"];
		$empleado["CONTRASEÑA"] = $_REQUEST["CONTRASEÑA"];
		$empleado["TIPOUSUARIO"] = $_REQUEST["TIPOUSUARIO"];
		$empleado["FECHANACIMIENTO"] = $_REQUEST["FECHANACIMIENTO"];
		$empleado["SUELDO"] = $_REQUEST["SUELDO"];
		$empleado["FECHAINICIO"] = $_REQUEST["FECHAINICIO"];
		$empleado["FECHAFIN"] = $_REQUEST["FECHAFIN"];
		$empleado["OID_TIENDA"] = $_REQUEST["OID_TIENDA"];
		
		$_SESSION["empleado"] = $empleado;
			
		if (isset($_REQUEST["modificar"])) Header("Location: consulta_empleados.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_empleado.php");
		else if (isset($_REQUEST["despedir"]))  Header("Location: accion_despedir_empleado.php");
		else if (isset($_REQUEST["recontratar"]))  Header("Location: accion_recontratar_empleado.php"); 
	}
	else 
		Header("Location: consulta_empleados.php");

?>
