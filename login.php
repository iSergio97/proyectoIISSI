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
		$_SESSION['login'] = $user_name;
		Header("Location: indexLog.php");
	}
}
 ?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" href="css/fondo.css">
		<title></title>
	</head>
	<body>
		<?php
		include_once("cabecera.php");
		?>
		<div id="login">
			<form action="login.php" method="post">

				<div><label for="user_name"> Nombre de Usuario: </label>
					<input type="text" name="user_name" id="user_name" /> </div>
					<div> <label for="pass"> Contraseña: </label>
					<input type="password" name="pass" id="pass"></div>
					<input type="submit" name="submit" value="Conectar" class="btn btn-info" />

				</form>
				<div id="logout">
					<form action="registro_usuario.php">
				 		<input type="submit" value="Haga click aquí para registrarse" />
					</div>
		</div>
			<?php
		include_once("pie.php");
		?>

	</body>
</html>
