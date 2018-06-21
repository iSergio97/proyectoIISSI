<?php
	session_start();

	if (isset($_SESSION["login"])) {
		$user_name = $_SESSION["login"];
		//unset($_SESSION["login"]);

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
		}
		$conexion = crearConexionBD();
		$oid_usuario=oidUsuario($conexion, $user_name);
		$errores = validarDatosUsuario($usuarioModificado);
		$excepcion = modificar_usuario($conexion, $usuarioModificado["dni"], $oid_usuario, $usuarioModificado["nombre"], $usuarioModificado["apellidos"],
									   $usuarioModificado["email"], $usuarioModificado["telefono"], $usuarioModificado["direccion"],
									   $usuarioModificado["pass"], $usuarioModificado["fecNac"], $usuarioModificado["user_name"]);

		if (count($errores) > 0 && $excepcion<>"") {
			$_SESSION["errores"] = $errores;
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"]="modificacion_usuario.php";
			Header("Location: falloConexion.php");
		} else {
			Header("Location: perfil.php");
		}
	}else {
		Header("Location: indexLog.php");
	}
?>
