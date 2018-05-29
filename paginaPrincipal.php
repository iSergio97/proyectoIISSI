<!--
Falta añadir código PHP para mantener la conexión ($_SESSION)
-->
<?php
session_start();

require_once("gestionBD.php");
require_once("paginacion_consulta.php");
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
			<p><a href="categorias.php">Categorías</a>		<a href="perfil.php">Perfil</a>					Buscador: <input type="text"> <button type="submit">Buscar</p>
		</div>
		<!-- Barra con: Categorías || Perfil || Buscador -->
  </main>
  </body>
</html>
