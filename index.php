<?php
session_start();

require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");
require_once("paginacion_consulta.php");

if (isset($_SESSION["login"])) {
	$user_name = $_SESSION["login"];
  $_SESSION["errores"] = null;
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
if($total_registros % $pag_tam > 0) {
	$total_paginas++;
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
		<link rel="stylesheet" href="css/fondo.css">
  </head>
  <body>
  	<?php
  	include_once("cabecera.php");
	?>
	<main>

<ul class="topnav" id="myTopnav">
	<li><a href="registro_usuario.php"> <button type="button" class="btn btn-info"> Registrarse</button></a></li>
	<li><a href="login.php"><button type="button" class="btn btn-info">Login</button></a></li>
	<li><a href="consulta_tiendas.php">Tiendas</a></button></li>
	<br>
</ul>

		<div id="enlaces">

			<?php
			for ($pagina = 1; $pagina <= $total_paginas; $pagina++) {
			 if ($pagina == $pagina_seleccionada) {
				 echo $pagina;
			 }else {
					?>
				 <a href="index.php?PAG_NUM=<?php echo $pagina; ?>&&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
				 <?php
			 }
			}
?>
</div>

<form method="get" action="index.php">
	<!-- Formulario que contiene el número y cambio de tamaño de página -->
	<input type="hidden" name="PAG_NUM"
	value="<?php echo $pagina_seleccionada; ?>"
	/>
	Mostrando
	<input type="number" name="PAG_TAM"
	min="1" max="<?php echo $total_registros; ?>" /> de <?php echo $total_registros; ?> entradas
	<input type="submit" value="Enviar" class="btn btn-info"/>
	<br>
	<br>

</form>
</nav>





<article class="articulos">
	<form action="controlador_articulos.php" method="post">
		<div class="fila_articulo">
			<div class="datos_articulo">

				<table class="tablaArticulos">

						<tr>
						<th><strong>Nombre</strong>&nbsp;&nbsp;&nbsp;</th>
						<th><strong>Tallas</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
						<th><strong>Precio</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
						<th><strong>Tags</strong></th>
						</tr>
					<?php foreach ($filas as $fila) {
                    ?>
						<tr>
							<td><?php echo $fila['NOMBRE'] ?> </td>
							<td><?php echo $fila['TALLA'] ?></td>
							<td><?php echo $fila['PRECIO'] ?></td>
							<td><?php echo $fila['TAGS'] ?></td>
					<?php }
					 ?>

		</div>

	</form>
</article>
	</main>
	
  </body>
  
</html>
