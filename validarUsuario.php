<?php
session_start();

//Con este if comprobamos que hemos llegado a la página tras rellenar el formulario
if (isset($_SESSION["formulario"])) {
	$nuevoUsuario["nombre"] = $_REQUEST["nombre"];
	$nuevoUsuario["apellidos"] = $_REQUEST["apellidos"];
	$nuevoUsuario["dni"] = $_REQUEST["dni"];
	$nuevoUsuario["fecNac"] = $_REQUEST["fecNac"];
	$nuevoUsuario["email"] = $_REQUEST["email"];
	$nuevoUsuario["telefono"] = $_REQUEST["telefono"];
	$nuevoUsuario["direccion"] = $_REQUEST["direccion"];
	$nuevoUsuario["user_name"] = $_REQUEST["user_name"];
	$nuevoUsuario["pass"] = $_REQUEST["pass"];
	$_SESSION["formulario"] = $nuevoUsuario;
} else {
	Header("Location: registro_usuario.php");
}




$errores = validarDatosUsuario($nuevoUsuario);

if (count($errores) > 0) {
	$_SESSION["errores"] = $errores;
	Header("Location: registro_usuario.php");
} else {
	Header("Location: exito_registro_usuario.php");
}

function validarDatosUsuario($nuevoUsuario) {
	// Validación del DNI
	if ($nuevoUsuario["dni"] == "")
		$errores[] = "<p>El DNI no puede estar vacío</p>";
	else if (!preg_match("/^[0-9]{8}[A-Z]{1}$/", $nuevoUsuario["dni"])) {
		$errores[] = "<p>El DNI debe contener 8 números y una letra mayúscula: " . $nuevoUsuario["dni"] . "</p>";
	}

	// Validación del Nombre
	if ($nuevoUsuario["nombre"] == "")
		$errores[] = "<p>El nombre no puede estar vacío</p>";

	// Validación del Email
	if ($nuevoUsuario["email"] == "") {
		$errores[] = "<p>El email no puede estar vacío</p>";
	} else if (!filter_var($nuevoUsuario["email"], FILTER_VALIDATE_EMAIL)) {
		$errores[] = $error . "<p>El email es incorrecto: " . $nuevoUsuario["email"] . "</p>";
	}
	// Valicadión Fecha de nacimiento
	if ($nuevoUsuario["fecNac"] == "") {
		$errores[] = "<p>La fecha de nacimiento no puede estar vacía </p>";
	}

	//Valicadición de los Apellidos
	if ($nuevoUsuario["apellidos"] == "") {
		$errores[] = "<p>Los apellidos no pueden estar vacíos </p>";
	}
	return $errores;
}
?>
