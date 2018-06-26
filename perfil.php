<?php
session_start();

//Importamos las librerías para escribir en la BD
require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");

if (isset($_SESSION["login"])) {
	$user_name = $_SESSION["login"];
  $_SESSION["errores"] = null;
} else {
	Header("Location: indexLog.php");
}

$conexion = crearConexionBD();
$nombre=nombre($conexion, $user_name);
$apellidos = apellidos($conexion, $user_name);
$dni = dni($conexion, $user_name);
$telefono = telefono($conexion, $user_name);
$email= email($conexion, $user_name);
$direccion = direccion($conexion, $user_name);
$contraseña=contraseña($conexion, $user_name);
$fecha_nacimiento=fechaNacimientoMostrar($conexion, $user_name);
 ?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>

	<link rel="stylesheet" href="css/fondo.css">
    <meta charset="utf-8">
    <title>Perfil</title>
  </head>
  <body>
<?php
include_once("cabecera.php");
?>
    <strong>Nombre de usuario:</strong> <?php if(isset($user_name)) echo $user_name; else echo "La sesión no recupera el nombre del perfl";  ?>
		<br>
		<strong>Nombre:</strong> <?php if(isset($user_name)) echo $nombre; else echo "La sesión no recupera el nombre ";  ?>
		<br>
		<strong>Apellidos:</strong> <?php if(isset($user_name)) echo $apellidos; else echo "La sesión no recupera los apellidos";  ?>
		<br>
		<strong>DNI:</strong> <?php if(isset($user_name)) echo $dni; else echo "La sesión no recupera el DNI";  ?>
		<br>
		<strong>Teléfono:</strong> <?php if(isset($user_name)) echo $telefono; else echo "La sesión no recupera el telefono";  ?>
		<br>
		<strong>Email:</strong> <?php if(isset($user_name)) echo $email; else echo "La sesión no recupera el email";  ?>
		<br>
		<strong>Dirección:</strong> <?php if(isset($user_name)) echo $direccion; else echo "La sesión no recupera la direccion";  ?>
		<br>
		<strong>Fecha de nacimiento:</strong> <?php if(isset($user_name)) echo $fecha_nacimiento; else echo "La sesión no recupera la fecha de nacimiento";  ?>
		<br>
		<p>Haga click <a href="modificacion_usuario.php">aquí</a>para modificar su perfil</p>
		<div id="logout">
 <button><a href="indexLog.php">Página principal</a></button>

</div>
  </body>
</html>
