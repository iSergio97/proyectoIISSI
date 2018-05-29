<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionar_prendas.php");
	require_once("paginacion_consulta.php");
	
	if (isset($_SESSION["articulo"])){
		$articulo = $_SESSION["articulo"];
		unset($_SESSION["articulo"]);
	}

	// ¿Venimos simplemente de cambiar página o de haber seleccionado un registro ?
	// ¿Hay una sesión activa?
	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"]; 
	$pagina_seleccionada = isset($_GET["PAG_NUM"])? (int)$_GET["PAG_NUM"]:
												(isset($paginacion)? (int)$paginacion["PAG_NUM"]: 1);
	$pag_tam = isset($_GET["PAG_TAM"])? (int)$_GET["PAG_TAM"]:
										(isset($paginacion)? (int)$paginacion["PAG_TAM"]: 5);
	if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
	if ($pag_tam < 1) $pag_tam = 5;
		
	// Antes de seguir, borramos las variables de sección para no confundirnos más adelante
	unset($_SESSION["paginacion"]);

	$conexion = crearConexionBD();
	
	// La consulta que ha de paginarse
	$query = 'SELECT ARTICULOS.IDARTICULO, ARTICULOS.NOMBRE, ARTICULOS.TALLA, ARTICULOS.PRECIO, ARTICULOS.TIPOARTICULO,
	 ARTICULOS.SECCION, ARTICULOS.COLOR, ARTICULOS.TAGS, ARTICULOS.TEMPORADA ' 
		
		.'FROM ARTICULOS'
		
		.'ORDER BY NOMBRE, TALLA, TIPOARTICULO, SECCION, COLOR, TEMPORADA, TAGS, PRECIO';
	
	// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes.
	// En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1
	$total_registros = total_consulta($conexion,$query);
	$total_paginas = (int) ($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0) $total_paginas++; 
	if ($pagina_seleccionada > $total_paginas) $pagina_seleccionada = $total_paginas;
	
	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
	$paginacion["PAG_NUM"] = $pagina_seleccionada;
	$paginacion["PAG_TAM"] = $pag_tam;
	$_SESSION["paginacion"] = $paginacion;
	
	$filas = consulta_paginada($conexion,$query,$pagina_seleccionada,$pag_tam);
	
	cerrarConexionBD($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <!-- Hay que indicar el fichero externo de estilos -->
 <!-- <style>
  body{
  	background-color: red
  }
 </style> -->
  
  <link rel="stylesheet" type="text/css" href="css/biblio.css" />
  <title>Lista de artículos</title>
</head>

<body>

<?php
	include_once("cabecera.php");
?>

<main>
	 <nav>
		<div id="enlaces">
			<?php
				for( $pagina = 1; $pagina <= $total_paginas; $pagina++ ) 
					if ( $pagina == $pagina_seleccionada) { 	?>
						<span class="current"><?php echo $pagina; ?></span>
			<?php }	else { ?>			
						<a href="consulta_articulos.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
			<?php } ?>			
		</div>
		
		<form method="get" action="consulta_articulos.php">
			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>
			Mostrando 
			<input id="PAG_TAM" name="PAG_TAM" type="number" 
				min="1" max="<?php echo $total_registros;?>" 
				value="<?php echo $pag_tam?>" autofocus="autofocus" /> 
			entradas de <?php echo $total_registros?>
			<input type="submit" value="Cambiar">
		</form>
	</nav>

	<?php
		foreach($filas as $fila) {
	?>

	<article class="articulo">
		<form method="post" action="controlador_articulos.php">
			<div class="fila_articulo">
				<div class="datos_articulo">		
					<input id="IDARTICULO" name="IDARTICULO"
						type="hidden" value="<?php echo $fila["IDARTICULO"]; ?>"/>
					<input id="NOMBRE" name="NOMBRE"
						type="hidden" value="<?php echo $fila["NOMBRE"]; ?>"/>
					<input id="TALLA" name="TALLA"
						type="hidden" value="<?php echo $fila["TALLA"]; ?>"/>
					<input id="PRECIO" name="PRECIO"
						type="hidden" value="<?php echo $fila["PRECIO"]; ?>"/>
					<input id="TIPOARTICULO" name="TIPOARTICULO"
						type="hidden" value="<?php echo $fila["TIPOARTICULO"]; ?>"/>
					<input id="SECCION" name="SECCION"
						type="hidden" value="<?php echo $fila["SECCION"]; ?>"/>
					<input id="COLOR" name="COLOR"
						type="hidden" value="<?php echo $fila["COLOR"]; ?>"/>
					<input id="TAGS" name="TAGS"
						type="hidden" value="<?php echo $fila["TAGS"]; ?>"/>
					<input id="TEMPORADA" name="TEMPORADA"
						type="hidden" value="<?php echo $fila["TEMPORADA"]; ?>"/>
						
				<?php
					if (isset($articulo) and ($articulo["IDARTICULO"] == $fila["IDARTICULO"])) { ?>
						<!-- Editando título -->
						<h3><input id="TITULO" name="TITULO" type="text" value="<?php echo $fila["TITULO"]; ?>"/>	</h3>
						<h4><?php echo $fila["PRECIO"]." ".$fila["TALLA"]; ?></h4>
				<?php }	else { ?>
						<!-- mostrando título -->
						<input id="TITULO" name="TITULO" type="hidden" value="<?php echo $fila["TITULO"]; ?>"/>
						<div class="titulo"><b><?php echo $fila["TITULO"]; ?></b></div>
						
				<?php } ?>
				</div>
				
				<div id="botones_fila">
				<?php if (isset($articulo) and ($articulo["IDARTICULO"] == $fila["IDARTICULO"])) { ?>
						<button id="grabar" name="grabar" type="submit" class="editar_fila">
							<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación">
						</button>
				<?php } else {?>
						<button id="editar" name="editar" type="submit" class="editar_fila">
							<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar artículo">
						</button>
				<?php } ?>
					<button id="borrar" name="borrar" type="submit" class="editar_fila">
						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar artículo">
					</button>
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

