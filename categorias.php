<?php
session_start();

require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");
require_once("paginacion_consulta.php");

if (isset($_SESSION["login"])) {
	$usuario = $_SESSION["login"];
  $user_name = $usuario["user_name"];
  $_SESSION["errores"] = null;
	$_SESSION["login"]=null;
}


if (isset($_SESSION["articulo"])){
	$articulo = $_SESSION["articulo"];
	unset($_SESSION["articulo"]);
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
				 <a href="categorias.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
				 <?php
			 }
			}
?>
</div>

<form method="get" action="categorias.php">
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
<?php foreach ($filas as $fila) {
//Nombre talla precio tags
?>
<article class="articulos">
	<form action="controlador_articulos.php" method="post">
		<div class="fila_articulo">
			<div class="datos_articulo">
				<input id="nombreArticulo" type="hidden"
				 name="nombreArticulo" value="<?php echo $fila['NOMBRE']; ?>"/>
				 <input id="Talla"type="hidden" name="talla" value="<?php echo $fila['TALLA']; ?>"/>
				 <input id="precio" type="hidden" name="precio" value="<?php echo $fila['PRECIO']; ?>"/>
				 <input id="tags" type="hidden" name="tags" value="<?php echo $fila['TAGS']; ?>"/>

				 <?php

				 if (isset($articulo)) {

				 ?>
				 <?php

			 } else {?>

				<input id="Articulo" type="hidden" name="Articulo" value="<?php  $fila['NOMBRE']?>"/>
			<p>	<div class="nombre"><b><?php echo $fila['NOMBRE']; ?>
					<div class="talla"><b><?php echo $fila['TALLA']; ?>
					<div class="tags"><b><?php echo $fila['TAGS'];?>
						<div class="precio"><b><?php echo $fila['PRECIO'];?>
						</p>

				</div>
				<?php
			 }
				  ?>

			</div>
		</div>

	</form>
</article>
<?php
}
 ?>
	</main>
  </body>
</html>
