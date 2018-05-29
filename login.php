<?php
session_start();
//echo "Hola";
include_once("gestionBD.php");
include_once("gestionUsuarios.php");

if (isset($_POST['Enviar'])){
	$user_name= $_POST['user_name'];
	$pass = $_POST['pass'];

	$conexion = crearConexionBD();
	$num_usuarios = consultarDatosUsuario($conexion,$user_name,$pass);
	cerrarConexionBD($conexion);

	if ($num_usuarios == 0) {
		$login = "error";
	} else {
		$_SESSION['login'] = $user_name;
		Header("Location: paginaPrincipal.php");
		//echo "Acierto";
	}
}
 ?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title></title>
	</head>
	<body>
		<p> Usuario o contraseña inválidas. Haga click <a href="registro_usuario.php">aquí</a> para volver a intentarlo </p>
	</body>
</html>
