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
$apellidos = apellidos($conexion, $user_name);
$dni = dni($conexion, $user_name);
$telefono = telefono($conexion, $user_name);
$email= email($conexion, $user_name);
$direccion = direccion($conexion, $user_name);
 ?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/logout.css" />
    <title>Perfil</title>
  </head>
  <body>
<p>    Página para mostrar el perfil del usuario </p>
<div id="logout">
  Pulse <a href="indexLog.php">aquí </a> para volver a la página principal.
</div>
    Nombre de usuario: <?php if(isset($user_name)) echo $user_name; else echo "La sesión no recupera el nombre del perfl";  ?>
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
  </body>
</html>
