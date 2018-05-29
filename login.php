<?php
session_start();

include_once("gestionBD.php");
include_once("gestionUsuarios.php");

if(isset($_POST['Enviar'])){
	$pass = $_POST['pass'];
	$user_name = $_POST['user_name'];

	$conexion = crearConexionBD();
	$num_users_un = consultarDatosUsuario($conexion, $user_name, $pass);
	cerrarConexionBD();

	if ($num_users_email == 0) {
		$login = "error";
	} else {
		$_SESSION['login'] = $user_name;
		Header("Location: pagina_prueba2.php");
	}
}

// if($num_users_un == 0 && $num_users_email == 0) {
// 	$login = 'error';
// } else {
// 	if($num_users_un == 0) {
// 		$_SESSION['login'] = $email;
// 		Header("Location: pagina_prueba2.php");
// 	} else {
// 		$_SESSION['login'] = $user_name;
// 		Header("Location: pagina_prueba2.php");
// 	}
// }
 ?>


 <!DOCTYPE html>
 <html lang="es" dir="ltr">
 	<head>
 		<meta charset="utf-8">
 		<title>Sweet Modas: Login</title>
 	</head>
 	<body>
		<main>
			<?php if (isset($login)) {
				echo "<div class=\"error\">";
				echo "Error en la contraseña o no existe el usuario.";
				echo "</div>";
			}
			?>

			<form action="login.php" method="post">
				<div><label for="email"> Email o nombre de usuario: </label>
					<input type="text/email" name="email_username" id="email" /> </div>
					<div> <label for="pass"> Contraseña: </label>
					<input type="password" name="pass" id="pass"></div>
					<input type="submit" name="Enviar" value="Enviar" />
				</form>

				<br>
				<p>¿No estás registrado? <a href="registro_usuario.php">¡Registrate!</a></p>
			</main>

 	</body>

 </html>
