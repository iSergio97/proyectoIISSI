<?php
session_start();

//Importamos las librerías para escribir en la BD
require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");

if (isset($_SESSION["formulario"])) {
	$nuevoUsuario = $_SESSION["formulario"];
  $user_name = $nuevoUsuario['user_name'];
	$_SESSION["errores"] = null;
} else if (isset($_SESSION['login'])) {
  $usuario = $_SESSION['login'];
  $_SESSION["errores"] = null;
	$_SESSION['loing']=null;
}
$conexion = crearConexionBD();
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
  Pulse <a href="paginaPrincipal.php">aquí </a> para volver a la página principal.
</div>

    Nombre de usuario: <?php if(isset($usuario)) echo $usuario; else echo "La sesión no recupera el nombre del perfl";  ?>
  </body>
</html>
