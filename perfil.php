<?php
session_start();

//Importamos las librerías para escribir en la BD
require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");

if (isset($_SESSION["login"])) {
	$user_name = $_SESSION["login"];
  $_SESSION["errores"] = null;
} else {
	Header("Location: index.php");
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
  	
	<link rel="stylesheet" href="css/listaOrdenada.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <meta charset="utf-8">
    <title>Perfil</title>
  </head>
  <body>
<p>    Página para mostrar el perfil del usuario </p>

    Nombre de usuario: <?php if(isset($user_name)) echo $user_name; else echo "La sesión no recupera el nombre del perfl";  ?>
		<br>
		Nombre: <?php if(isset($user_name)) echo $nombre; else echo "La sesión no recupera el nombre del perfl";  ?>
		<br>
		Apellidos: <?php if(isset($user_name)) echo $apellidos; else echo "La sesión no recupera el nombre del perfl";  ?>
		<br>
		DNI: <?php if(isset($user_name)) echo $dni; else echo "La sesión no recupera el nombre del perfl";  ?>
		<br>
		Teléfono: <?php if(isset($user_name)) echo $telefono; else echo "La sesión no recupera el nombre del perfl";  ?>
		<br>
		Email: <?php if(isset($user_name)) echo $email; else echo "La sesión no recupera el nombre del perfl";  ?>
		<br>
		Dirección: <?php if(isset($user_name)) echo $direccion; else echo "La sesión no recupera el nombre del perfl";  ?>
		<br>
		Fecha de nacimiento: <?php if(isset($user_name)) echo $fecha_nacimiento; else echo "La sesión no recupera el nombre del perfl";  ?>
		<br>
		<button><a href="modificacion_usuario.php">Modificar</a></button>
		<div id="logout">
  Pulse <a href="indexLog.php">aquí </a> para volver a la página principal.
</div>
  </body>
</html>
