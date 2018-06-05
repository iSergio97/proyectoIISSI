<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarTiendas.php");
	// if (!isset($_SESSION['login'])) {
	// 	Header("Location: login.php");
	// } else {
		$conexion = crearConexionBD();
		$filas = consultarTodasTiendas($conexion);
	//}

	// SI NO HAY SESIÓN DE USUARIO ABIERTA, REDIRIGIR A LOGIN.PHP
	// EN OTRO CASO:
	// - HAY QUE CREAR LA CONEXIÓN A LA BASE DE DATOS
	// - INVOCAR LA FUNCIÓN DE CONSULTA DE TODOS LOS LIBROS
	//		QUE SE ENCUENTRA EN "GESTIONARLIBROS.PHP"
	//		Y GUARDAR EL RESULTADO EN UNA VARIABLE
	// - CERRAR LA CONEXIÓN

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/listaOrdenada.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <title>Sweet Modas: Lista de Tiendas</title>
</head>

<body>

<?php
	//include_once("cabecera.php");
	//include_once("menu.php");
?>

<main>
	 <nav>
		<div id="enlaces">
			<?php
				for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )
					if ( $pagina == $pagina_seleccionada) { 	?>
						<span class="current"><?php echo $pagina; ?></span>
			<?php }	else { ?>
						<a href="consulta_tiendas.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
			<?php } ?>
		</div>

		<form method="get" action="consulta_tiendas.php">
			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>
			Mostrando
			<input id="PAG_TAM" name="PAG_TAM" type="number"
				min="1" max="<?php echo $total_registros;?>"
				value="<?php echo $pag_tam?>" autofocus="autofocus" />
			entradas de <?php echo $total_registros?>
			<input type="submit" value="Cambiar" class="btn btn-info">
		</form>
	</nav>
	<div id="logout">
  Pulse <a href="indexLog.php">aquí </a> para volver a la página principal.
</div>
	<?php
		foreach($filas as $fila) {

	?>


	<article class="tiendas">
		<form method="post" action="controlador_tiendas.php">
			<div class="fila_tienda">
				<div class="datos_tienda">

					<input id="OID_TIENDA" name="OID_TIENDA"

						type="hidden" value="<?php echo $fila["OID_TIENDA"]; ?>"/>

					<input id="NOMBRETIENDA" name="NOMBRETIENDA"

						type="hidden" value="<?php echo $fila["NOMBRETIENDA"]; ?>"/>

					<input id="LOCALIZACION" name="LOCALIZACION"

						type="hidden" value="<?php echo $fila["LOCALIZACION"]; ?>"/>

					<input id="HORARIO" name="HORARIO"

						type="hidden" value="<?php echo $fila["HORARIO"]; ?>"/>

					<!-- Controles de los campos que quedan ocultos:
						OID_LIBRO, OID_AUTOR, OID_AUTORIA, NOMBRE, APELLIDOS -->
				<?php
					if ( isset($tiendas) and $tiendas['OID_TIENDA']==$fila['OID_TIENDA']) { ?>
						<!-- Editando título -->
							<input type="text" id="TIENDA" name="TIENDA" value="<?php echo $fila['TIENDA']; ?>"/>
						<?php }	else {
							echo "<h3>".$fila['OID_TIENDA']."</h3>"."     ";
							echo $fila['NOMBRETIENDA']."    ";
							echo $fila['LOCALIZACION'];
							?>
						<!--	<input type="text" id="TITULO" name="TITULO" value="<?php echo $fila['TITULO']; ?>"/>
						 mostrando título -->
				<?php } ?>

				</div>


				</div>
			</div>
		</form>
	</article>

	<?php } ?>
</main>

<?php
	include_once("pie.php");
?>

</body>
</html>
