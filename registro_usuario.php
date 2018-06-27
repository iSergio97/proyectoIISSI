<?php
session_start();
if (!isset($_SESSION['formulario'])) {
	$formulario['nif'] = "";
	$formulario['nombre'] = "";
	$formulario['apellidos'] = "";
	$formulario['telefono'] = "";
	$formulario['dni'] = "";
	$formulario['fecNac'] = "";
	$formulario['email'] = "";
	$formulario['pass'] = "";
	$formulario['direccion'] = "";
	$formulario['nombreUsuario'] = "";
	$formulario['pass'] = "";
	$_SESSION['formulario'] = $formulario;
} else
	$formulario = $_SESSION['formulario'];
	if (isset($_SESSION["errores"]))
		$errores = $_SESSION["errores"];
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Sweet Modas: Registro</title>
		<!-- <link rel="stylesheet" href="css/tienda.css"> -->
		<link rel="stylesheet" type="text/css" href="css/fondo.css">
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
  	<script src="js/validacion_cliente_alta_usuario.js" type="text/javascript"></script>

		
	</head>

	<body>
			<script>
	
		$(document).ready(function() {
		
			
			$("#pass").on("keyup", function() {
			
				passwordColor();
			});

		});
	</script>
		
	
 	<?php
 	include_once("cabecera.php");
	?>
		

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
		
		<h2>Registro de usuarios</h2>
		</header>
<div id="registroUsuario">
		<form  method="get" action="validarUsuario.php">
		<p><i>Debe rellenar todos los campos para completar el registro</i></p>
		<fieldset class="datos_personales">
		<legend>
		Datos personales
		</legend>
		<div>
		<label for="name">
		Nombre
		</label>
		<input id="nombre" name="nombre"type="text"  value="<?php echo $formulario['nombre']; ?>"/>
		</div>

		<div>
		<label for="apellidos">
		Apellidos
		</label>
		<input id="apellidos" name="apellidos" type="text"  value="<?php echo $formulario['apellidos']; ?>"/>
		</div>

		<div>
		<label for="dni">
		DNI (Si no recuerda la letra, haga click <a href="calcularLetraDNI.php" target="_blank">aquí</a>).
		</label>
		<input id="dni" name="dni" type="text"  pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))" value="<?php echo $formulario['dni']; ?>" onclick="calcletra("#dni")"/>
		</div>

		<div>
		<label for="fechaNacimiento">
		Fecha de nacimiento
		</label>
		<input id="fecNac" name="fecNac" type="date"  value="<?php echo $formulario['fecNac']; ?>"/>
		</div>

		<div>
		<label for="email">
		Email
		</label>
		<input id="email" name="email"  type="email" pattern="(^[a-zA-Z0-9]+)@((gmail.)|(hotmail.)|(yahoo.)|(outlook.))?(com|es)"  value="<?php echo $formulario['email']; ?>"/>
	</div>

		<div>
		<label>
		Telefono
	</label for="telefono">
		<input id="telefono" name="telefono"  type="tel" pattern="[0-9]{9}" value="<?php echo $formulario['telefono']; ?>"/>
		</div>

		<div>
		<label>
		Direccion
	</label for="direccion">
		<input id="direccion" name="direccion" type="text" />
		</div>

		</fieldset>

		<fieldset class="datos_personales">
		<legend>
		Datos de usuario
		</legend>

		<div>
		<label>
		Nombre de usuario
	</label for="user_name">
	<input type="text" id="user_name" name="user_name">
		</div>

		<div>
		<label>
		Contraseña
	</label for="pass">
		<input id="pass" name="pass"  type="password" placeholder="Mínimo 8 caracteres entre letras y dígitos" required oninput="passwordValidation(); "/>
		</div>

		<div>
		<label>
		Confirmar contraseña
	</label for="confirmpass">
		<input id="confirmpass" name="confirmpass"  type="password"  placeholder="Confirmación de contraseña"  oninput="passwordConfirmation();"/>
		</div>

		</fieldset>

		<div><input type="submit" value="Enviar" class="btn btn-info"/></div>

		</form>
	</div>

	<p> Pulse <a href="login.php">aquí </a> para acceder a la página de Login si ya está registrado</p>

	
	</body>
</html>
