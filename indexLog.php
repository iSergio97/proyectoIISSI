<?php
session_start();

require_once ("gestionBD.php");
require_once ("gestionUsuarios.php");
require_once("paginacion_consulta.php");

if (isset($_SESSION["login"])) {
	$user_name = $_SESSION["login"];
  $_SESSION["errores"] = null;
} else {
  Header("Location: index.php");
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
		<link rel="stylesheet" href="css/listaOrdenada.css">
  </head>
  <body>
	<main>

<ul>
	<li><a href="logout.php"><button type="button">Cerrar sesión</button></a></li>
	<li><a href="consulta_tiendas.php">Tiendas</a></button></li>
  <li><a href="consulta_empleados.php">Empleados</a></li>
  <li>
  <a href="perfil.php">Perfil</a>
</li>
	<br>
</ul>

		<div id="enlaces">

			<?php
			for ($pagina = 1; $pagina <= $total_paginas; $pagina++) {
			 if ($pagina == $pagina_seleccionada) {
				 echo $pagina;
			 }else {
					?>
				 <a href="indexLog.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
				 <?php
			 }
			}
?>
</div>

<form method="get" action="indexLog.php">
	<!-- Formulario que contiene el número y cambio de tamaño de página -->
	<input type="hidden" name="PAG_NUM"
	value="<?php echo $pagina_seleccionada; ?>"
	/>
	Mostrando
	<input type="number" name="PAG_TAM"
	min="1" max="<?php echo $total_registros; ?>" /> de <?php echo $total_registros; ?> entradas
	<input type="submit" value="Enviar"/>
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
						<th><strong>Editar artículo</strong></th>
						<th><strong>Añadir al carrito</strong></th>
						</tr>
					<?php foreach ($filas as $fila) {
                    ?>
                    	<?php
					if (isset($articulo) and ($articulo["idArticulo"] == $fila["idArticulo"])) { ?>
						<tr>
							<td><h3><input id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $fila['NOMBRE']; ?>"/>	</h3> </td>
							<td><h3><input id="TALLA" name="TALLA" type="text" value="<?php echo $fila['TALLA']; ?>"/>	</h3></td>
							<td><h3><input id="PRECIO" name="PRECIO" type="text" value="<?php echo $fila['PRECIO']; ?>"/>	</h3></td>
							<td><h3><input id="TAGS" name="TAGS" type="text" value="<?php echo $fila['TAGS']; ?>"/>	</h3></td>
							<td>	<button id="grabar" name="grabar" type="submit" class="editar_fila">
									<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación artículo">
								</button>
							</td>
							<td><img src="images/carritoCompra.png" width="30px"/><input type="number" /><a href="cesta.php">Añadir a la cesta</a>
						</td>
						<?php }	else { ?>
							<tr>
							<td><?php echo $fila['NOMBRE'] ?> </td>
							<td><?php echo $fila['TALLA'] ?></td>
							<td><?php echo $fila['PRECIO'] ?></td>
							<td><?php echo $fila['TAGS'] ?></td>
							<td>	<button id="editar" name="editar" type="submit" class="editar_fila">
									<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar artículo">
								</button>
							</td>
							<td><img src="images/carritoCompra.png" width="30px"/><input type="number" /><a href="cesta.php">Añadir a la cesta</a>
						</td>
						<?php } ?>
						</div>

	<?php
 }
	 ?>

 </div>
	</form>
</article>
	</main>
  </body>
</html>
