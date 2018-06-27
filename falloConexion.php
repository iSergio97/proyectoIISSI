<?php
    session_start();

	//$falloConexion = $_SESSION["falloConexion"];
	unset($_SESSION["falloConexion"]);

	if (isset ($_SESSION["destino"])) {
		$destino = $_SESSION["destino"];
		unset($_SESSION["destino"]);
	} else
		$destino = "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/fondo.css" />
  <title>Se acaba de producir un problema</title>
</head>
<body>
<?php
include_once("cabecera.php");
?>
	<div>
		<h2>Lo sentimos</h2>
		<?php if ($destino<>"") { ?>
		<p>Ocurrió un problema durante el procesado de los datos. Pulse <a href="<?php echo $destino ?>">aquí</a>
       para volver a la página anterior.</p>
		<?php } else { ?>
		<p>Ocurrió un problema para acceder a la base de datos. Vuelva a la página principal. </p>
		<?php } ?>
    <form action="indexLog.php">
       <input type="submit" value="Página principal" />
   </form>
	</div>

	<div class='excepcion'>
		<!-- <?php echo "Información relativa al problema: ".$excepcion ?> -->
  	</div>

</body>
</html>
