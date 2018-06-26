<?php
session_start();
require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");

if (isset($_SESSION["login"])) {
	$user_name = $_SESSION["login"];
  $_SESSION["errores"] = null;

	$conexion=crearConexionBD();
//	$formulario = $_SESSION['formulario'];
 	$dni = dni($conexion, $user_name);
	$nombre = nombre($conexion, $user_name);
	$apellidos = apellidos($conexion, $user_name);
	$telefono = telefono($conexion, $user_name);
	$fechaNacimiento = fechaNacimientoFormulario($conexion, $user_name);
	$email = email($conexion, $user_name);
	$pass = contraseña($conexion, $user_name);
	$direccion = direccion($conexion, $user_name);

if (isset($_SESSION["errores"]))
	$errores = $_SESSION["errores"];
} else {
	Header("Location: indexLog.php");
}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Sweet Modas: Modificación de perfil</title>
		<link rel="stylesheet" href="css/fondo.css">
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
  	<script src="js/validacion_cliente_alta_usuario.js" type="text/javascript"></script>

		</script>
	</head>

	<body>
<?php
include_once("cabecera.php");
?>
		<script>

			$(document).ready(function() {
				$("#pass").on('keyup', function() {
					passwordColor();
				});
			});
		</script>

		<?php
			// Mostrar los erroes de validación (Si los hay)
			if (isset($errores) && count($errores)>0) {
					echo "<div id=\"div_errores\" class=\"error\">";
				echo "<h4> Errores en el formulario:</h4>";
					foreach($errores as $error) echo $error;
					echo "</div>";
				}
		?>

		<header>
		<h1>Sweet Modas</h1>
		<h2>Modificación de usuarios</h2>
		</header>
<div id="registroUsuario">
		<form  method="get" action="accion_modificar_usuario.php">
		<p><i>Debe rellenar todos los campos para completar el registro</i></p>
		<fieldset class="datos_personales">
		<legend>
		Datos personales
		</legend>
		<div>
		<label for="nombre">
		Nombre
		</label>
		<input id="nombre" name="nombre" type="text" value="<?php echo $nombre; ?>"/>
		</div>

		<div>
		<label for="apellidos">
		Apellidos
		</label>
		<input id="apellidos" name="apellidos" type="text" value="<?php echo $apellidos; ?>"/>
		</div>

		<div>
		<label for="dni">
		DNI (Si no recuerda la letra, haga click <a href="calcularLetraDNI.php" target="_blank">aquí</a>).
		</label>
		<input id="dni" name="dni" type="text" pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))" value="<?php echo $dni; ?>" onclick="calcletra("#dni")"/>
		</div>

		<div>
		<label for="fechaNacimiento">
		Fecha de nacimiento
		</label>
		<input id="fecNac" name="fecNac" type="date" value="<?php echo $fechaNacimiento; ?>"/>
		</div>

		<div>
		<label for="email">
		Email
		</label>
		<input id="email" name="email" type="email" pattern="(^[a-zA-Z0-9]+)@((gmail.)|(hotmail.)|(yahoo.)|(outlook.))?(com|es)" value="<?php echo $email; ?>"/>
	</div>

		<div>
		<label>
		Telefono
	</label for="telefono">
		<input id="telefono" name="telefono" type="tel" pattern="[0-9]{9}" value="<?php echo $telefono; ?>"/>
		</div>

		<div>
		<label>
		Direccion
	</label for="direccion">
		<input id="direccion" name="direccion" type="text" value="<?php echo $direccion; ?>" />
		</div>

		</fieldset>

		<fieldset class="datos_personales">
		<legend>
		Datos de usuario
		</legend>

		<div>
		<label id="nombreUsuario">
		Nombre de usuario
	</label for="user_name">
	<input type="text" id="user_name" name="user_name" value="<?php echo $user_name; ?>" enabled="false">
		</div>

		<div>
		<label>
		Contraseña
	</label for="pass">
		<input id="pass" name="pass" type="password" value="<?php echo $pass; ?>" />
		</div>

		<div>
		<label>
		Confirmar contraseña
	</label for="confirmpass">
		<input id="confirmpass" name="confirmpass" type="password" oninput="passwordConfirmation();" value="<?php echo $pass; ?>" required/>
		</div>

		</fieldset>

		<div><input type="submit" value="Enviar" class="btn btn-info"/></div>

		</form>
	</div>

	<p> Pulse <a href="perfil.php">aquí </a> para acceder a la página de perfil</p>

	
	</body>
</html>
