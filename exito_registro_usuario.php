<?php
session_start();

//Importamos las librerías para escribir en la BD
require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");

if (isset($_SESSION["formulario"])) {
	$nuevoUsuario = $_SESSION["formulario"];
	$_SESSION["errores"] = null;
} else
	Header("Location: registro_usuario.php");

$conexion = crearConexionBD();
 ?>


 <!DOCTYPE html>
 <html lang="es">
   <head>
     <meta charset="utf-8">
     <title>Sweet Modas: Alta de usuario realizada con éxito</title>
   </head>
   <body>

<?php include_once("cabecera.php") ?>
<main>
  <?php
    if(nuevo_usuario($conexion, $nuevoUsuario)) {
      $_SESSION['login'] = $nuevoUsuario['user_name'];

  ?>
  <h3>Hola <?php echo $nuevoUsuario["user_name"]; ?>,
  gracias por registrarte</h3>
	<div>
		Pulsa <a href="indexLog.php">aquí</a> para acceder a la página principal.
	</div>
  <?php	} else {
    Header("Location: registro_usuario.php");
	}
  ?>
</main>

   </body>
 </html>
