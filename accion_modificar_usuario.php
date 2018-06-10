<?php	
	session_start();	
	
	if (isset($_SESSION["login"])) {
		$user_name = $_SESSION["login"];
		unset($_SESSION["login"]);
		
		require_once("gestionBD.php");
		require_once("gestionUsuarios.php");
		require_once("validarUsuario.php");
		
		if (isset($_SESSION["formulario"])) {
			$usuarioModificado["dni"]=$_REQUEST["dni"];
			$usuarioModificado["nombre"] = $_REQUEST["nombre"];
			$usuarioModificado["apellidos"] = $_REQUEST["apellidos"];
			$usuarioModificado["fecNac"] = $_REQUEST["fecNac"];
			$usuarioModificado["email"] = $_REQUEST["email"];
			$usuarioModificado["telefono"] = $_REQUEST["telefono"];
			$usuarioModificado["direccion"] = $_REQUEST["direccion"];
			$usuarioModificado["user_name"] = $_REQUEST["user_name"];
			$usuarioModificado["pass"] = $_REQUEST["pass"];
			$_SESSION["formulario"] = $usuarioModificado;
		} else {
			Header("Location: modificacion_usuario.php");
		}

		$conexion = crearConexionBD();		
		$errores = validarDatosUsuario($usuarioModificado);
		$excepcion = modificar_usuario($conexion, $user_name, $usuarioModificado["dni"], $usuarioModificado["user_name"], $usuarioModificado["nombre"], $usuarioModificado["apellidos"],
									   $usuarioModificado["email"], $usuarioModificado["telefono"], $usuarioModificado["direccion"], $usuarioModificado["pass"],
									   $usuarioModificado["fecNac"]);
		cerrarConexionBD($conexion);

		if (count($errores) > 0 && $excepcion<>"") {
			$_SESSION["errores"] = $errores;
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"]="modificacion_usuario.php";
			Header("Location: excepcion.php");
		} else {
			Header("Location: perfil.php");
		}
		
		// $conexion = crearConexionBD();		
		// $excepcion = modificar_usuario($conexion, $user_name, $usuarioModificado["dni"], $usuarioModificado["user_name"], $usuarioModificado["nombre"], $usuarioModificado["apellidos"],
									   // $usuarioModificado["email"], $usuarioModificado["telefono"], $usuarioModificado["direccion"], $usuarioModificado["pass"],
									   // $usuarioModificado["fecNac"]);
		// cerrarConexionBD($conexion);
// 			
		// if ($excepcion!="") {
			// $_SESSION["excepcion"] = $excepcion;
			// $_SESSION["destino"] = "modificacion_usuario.php";
			// Header("Location: excepcion.php");
		// }
		// else
			// Header("Location: indexLog.php");
} 
else Header("Location: modificacion_usuario.php"); // Se ha tratado de acceder directamente a este PHP
?>
