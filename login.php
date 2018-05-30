<?php
session_start();

include_once("gestionBD.php");
include_once("gestionUsuarios.php");

if (isset($_POST['submit'])){
	$user_name= $_POST['user_name'];
	$pass = $_POST['pass'];

	$conexion = crearConexionBD();
	$num_usuarios = consultarDatosUsuario($conexion,$user_name,$pass);
	cerrarConexionBD($conexion);

	if ($num_usuarios == 0) {
		$login = "error";
		echo "El usuario y/o la contraseña no coinciden";
	} else {
		$_SESSION['login'] = $login;
		Header("Location: paginaPrincipal.php");
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
		<div id="login">
			<form action="login.php" method="post">

				<div><label for="user_name"> Nombre de Usuario: </label>
					<input type="text" name="user_name" id="user_name" /> </div>
					<div> <label for="pass"> Contraseña: </label>
					<input type="password" name="pass" id="pass"></div>
					<input type="submit" name="submit" value="submit" />
				</form>
		</div>
			<div id="footer">
				<footer>
				<img src="images/Logo.jpeg" alt="Sweet Modas" width="10%" height="10%">
				<br/>
				&copy; Grupo IISSI 2018
				</footer>
			</div>
	</body>
</html>
