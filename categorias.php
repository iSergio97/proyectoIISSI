<?php
session_start();

require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");
require_once("paginacion_consulta.php");

if (isset($_SESSION["libro"])){
	$libro = $_SESSION["libro"];
	unset($_SESSION["libro"]);
}

if(isset($_SESSION['paginacion'])) {
	$paginacion=$_SESSION['paginacion'];
}
$pagina_seleccionada = isset($_GET['PAG_NUM'])?$_GET['PAG_NUM']:
			(isset($paginacion)? $paginacion['PAG_NUM']:1);

$pag_tam = isset($_GET['PAG_TAM'])?$_GET['PAG_TAM']:
			(isset($paginacion)? $paginacion['PAG_TAM']:10);

unset($_SESSION['paginacion']);

if ($pagina_seleccionada < 1) $pagina_seleccionada = 1;
if ($pag_tam < 1) $pag_tam = 5;

$conexion = crearConexionBD();

$query= 'SELECT NOMBRE, TALLA, PRECIO, TAGS FROM ARTICULOS';

$total_registros = total_consulta( $conexion, $query );
$total_paginas=(int) $total_registros / $pag_tam;
if($total_registros % $pag_tam != 0) {
	$total_paginas+1;
}
// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
$paginacion['PAG_NUM'] = $pagina_seleccionada;
$paginacion['PAG_TAM'] = $pag_tam;
$_SESSION['paginacion'] = $paginacion;

$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);

cerrarConexionBD($conexion);
 ?>


<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sweet Modas: Categorías</title>
  </head>
  <body>
  Página para mostrar los artículos organizados por categorías
	<main>
		<div id="enlaces">

			<?php
			for ($pagina = 1; $pagina <= $total_paginas; $pagina++) {
			 if ($pagina == $pagina_seleccionada) {
				 echo $pagina;
			 }else {
					?>
				 <a href="consulta_libros.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
				 <?php
			 }
			}
?>
</div>

<form method="get" action="consulta_libros.php">
	<!-- Formulario que contiene el número y cambio de tamaño de página -->
	<input type="hidden" name="PAG_NUM"
	value="<?php echo $pagina_seleccionada; ?>"
	/>
	Mostrando
	<input type="number" name="PAG_TAM"
	min="1" max="<?php echo $total_registros; ?>" /> de <?php echo $total_registros; ?> entradas
	<input type="submit" value="Enviar"/>
</form>
</nav>
<?php
	foreach($filas as $fila) {
?>
<article class="articulos">
<form method="post" action="controlador_articulos.php">
	<div class="fila_articulo">
		<div class="datos_articulo">
			<input type="hidden" name="ID_ARTICULO" value="<?php echo $fila["ID_ARTICULO"]; ?>">
			<input type="hidden" name="NOMBRE" value="<?php echo $fila["NOMBRE"]; ?>">
			<input type="hidden" name="TALLA" value="<?php echo $fila["TALLA"]; ?>">
			<input type="hidden" name="TIPOARTICULO" value="<?php echo $fila["TIPOARTICULO"]; ?>">
			<input type="hidden" name="PRECIO" value="<?php echo $fila["PRECIO"]; ?>">
			<input type="hidden" name="SECCION" value="<?php echo $fila["SECCION"]; ?>">
			<input type="hidden" name="COLOR" value="<?php echo $fila["COLOR"]; ?>">
			<input type="hidden" name="TAGS" value="<?php echo $fila["TAGS"]; ?>">
			<input type="hidden" name="TEMPORADA" value="<?php echo $fila["TEMPORADA"]; ?>">

<?php
if (isset($libro) and ($libro["ID_ARTICULO"] == $fila["ID_ARTICULO"])) {
	?>
	<h3><input id="nombre" name="nombre" type="text" value="<?php echo $fila["NOMBRE"]; ?>"/>	</h3>
	<h4><?php echo $fila["NOMBRE"]." ".$fila["TAGS"]; ?></h4>

<?php}  else { ?>
	<input id="NombreArticulo" name="NombreArticulo" type="hidden" value="<?php echo "Nombre: ".$fila['NOMBRE']; ?>" />
	<div class="na"> <b><?php echo $fila['NOMBRE'] ?> </b></div>
<?php
}
?>
		</div>
	</div>
</article>
		</div>
	</main>
  </body>
</html>
