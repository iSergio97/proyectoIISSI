<?php
session_start();

//Importamos las librerías para escribir en la BD
require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");

if (isset($_SESSION["login"])) {
	$user_name = $_SESSION["login"];
  $_SESSION["errores"] = null;
}
$conexion = crearConexionBD();
 ?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/logout.css" />
    <title></title>
  </head>
  <body>
    <main>
    <div id="logout">
			<a href="logout.php"> <button type="button"> Cerrar Sesión</button></a>
    </div>

		<div id="barra">
			<p><a href="categorias.php">Categorías</a>		<a href="perfil.php">Perfil</a>		Buscador: <input type="text"> <button type="submit">Buscar </button>
 <a href="consulta_empleados.php">Empleados</a>
			</p>
		</div>
		<!-- Barra con: Categorías || Perfil || Buscador -->
  </main>
  </body>
</html>
