<?php
session_start();

require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");
require_once("paginacion_consulta.php");

if (isset($_SESSION["login"])) {
	$user_name = $_SESSION["login"];
  $_SESSION["errores"] = null;
}
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Error</title>
    <link rel="stylesheet" href="css/listaOrdenada.css">
    <link rel="stylesheet" href="css/listaOrdenada2.css">
  </head>
  <body>
  	<fieldset>
    Wops, parece que has intenado entrar en una página donde no tenías los permisos necesarios. Haz click <a href="indexLog.php">aquí</a> para volver a la página principal.
    </fieldset>
  </body>
</html>
