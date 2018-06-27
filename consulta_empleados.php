<?php
	session_start();
	require_once ("gestionBD.php");
	require_once ("gestionarEmpleados.php");
	require_once ("paginacion_consulta.php");
	require_once ("gestionUsuarios.php");
	if (isset($_SESSION["login"])) {
		$user_name = $_SESSION["login"];
	  $_SESSION["errores"] = null;
	if (isset($_SESSION["empleado"])) {
		$empleado = $_SESSION["empleado"];
		unset($_SESSION["empleado"]);
	}
} else {
	Header("Location: index.php");
}
	// ¿Venimos simplemente de cambiar página o de haber seleccionado un registro ?
	// ¿Hay una sesión activa?
	if (isset($_SESSION["paginacion"]))
		$paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
	$pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);
	if ($pagina_seleccionada < 1) 		$pagina_seleccionada = 1;
	if ($pag_tam < 1) 		$pag_tam = 5;
	// Antes de seguir, borramos las variables de sección para no confundirnos más adelante
	unset($_SESSION["paginacion"]);
	$conexion = crearConexionBD();
	$tipoUsuario = tipoUsuario($conexion, $user_name);
	if($tipoUsuario == 0) {
		Header("Location: errorEmpleados.php");
	}
	// La consulta que ha de paginarse
	$query = 'SELECT USUARIOS.OID_USUARIO, USUARIOS.DNI, USUARIOS.nombreUsuario, USUARIOS.NOMBRE, USUARIOS.APELLIDOS, '
			. 'USUARIOS.EMAIL, USUARIOS.TELEFONO, USUARIOS.DIRECCION, USUARIOS.CONTRASEÑA, USUARIOS.TipoUsuario, '
			. 'USUARIOS.FechaNacimiento, EMPLEADOS.SUELDO, EMPLEADOS.FechaInicio, EMPLEADOS.FechaFin, '
			. 'TIENDAS.OID_TIENDA FROM USUARIOS, EMPLEADOS, TIENDAS '
			. 'WHERE ' . 'EMPLEADOS.OID_USUARIO = USUARIOS.OID_USUARIO AND '
			. 'EMPLEADOS.OID_TIENDA = TIENDAS.OID_TIENDA '
			. 'ORDER BY OID_TIENDA, NOMBRE, APELLIDOS';
	// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes.
	// En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1
	$total_registros = total_consulta($conexion, $query);
	$total_paginas = (int)($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0)		$total_paginas++;
	if ($pagina_seleccionada > $total_paginas)		$pagina_seleccionada = $total_paginas;
	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
	$paginacion["PAG_NUM"] = $pagina_seleccionada;
	$paginacion["PAG_TAM"] = $pag_tam;
	$_SESSION["paginacion"] = $paginacion;
	$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);
	cerrarConexionBD($conexion);
?>


<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" href="css/fondo.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <!-- Hay que indicar el fichero externo de estilos -->
    <link rel="stylesheet" type="text/css" href="css/biblio.css" />
	<!-- <script type="text/javascript" src="./js/boton.js"></script> -->
  <title>Sweet Modas: Lista de Empleados</title>
</head>

<body>
	<?php
	include_once("cabecera.php");
	?>
	<form action="indexLog.php">
		 <input type="submit" value="Página principal" />
 </form>

<main>

	 <nav>

		<div id="enlaces">

			<?php
				for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )
					if ( $pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

			<?php }	else { ?>

						<a href="consulta_empleados.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

			<?php } ?>

		</div>



		<form method="get" action="consulta_empleados.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros; ?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input type="submit" value="Cambiar" class="btn btn-info">

		</form>

	</nav>



	<?php
		foreach($filas as $fila) {
	?>



	<article class="empleado">

		<form method="post" action="controlador_empleados.php">

			<div class="fila_empleado">

				<div class="datos_empleado">

					<input id="OID_USUARIO" name="OID_USUARIO"

						type="hidden" value="<?php echo $fila["OID_USUARIO"]; ?>"/>

					<input id="DNI" name="DNI"

						type="hidden" value="<?php echo $fila["DNI"]; ?>"/>

					<input id="NOMBREUSUARIO" name="NOMBREUSUARIO"

						type="hidden" value="<?php echo $fila["NOMBREUSUARIO"]; ?>"/>

					<input id="NOMBRE" name="NOMBRE"

						type="hidden" value="<?php echo $fila["NOMBRE"]; ?>"/>

					<input id="APELLIDOS" name="APELLIDOS"

						type="hidden" value="<?php echo $fila["APELLIDOS"]; ?>"/>

					<input id="EMAIL" name="EMAIL"

						type="hidden" value="<?php echo $fila["EMAIL"]; ?>"/>

					<input id="TELEFONO" name="TELEFONO"

						type="hidden" value="<?php echo $fila["TELEFONO"]; ?>"/>

					<input id="DIRECCION" name="DIRECCION"

						type="hidden" value="<?php echo $fila["DIRECCION"]; ?>"/>

					<input id="CONTRASEÑA" name="CONTRASEÑA"

						type="hidden" value="<?php echo $fila["CONTRASEÑA"]; ?>"/>

					<input id="TIPOUSUARIO" name="TIPOUSUARIO"

						type="hidden" value="<?php echo $fila["TIPOUSUARIO"]; ?>"/>

					<input id="FECHANACIMIENTO" name="FECHANACIMIENTO"

						type="hidden" value="<?php echo $fila["FECHANACIMIENTO"]; ?>"/>

					<input id="SUELDO" name="SUELDO"

						type="hidden" value="<?php echo $fila["SUELDO"]; ?>"/>

					<input id="FECHAINICIO" name="FECHAINICIO"

						type="hidden" value="<?php echo $fila["FECHAINICIO"]; ?>"/>

					<input id="FECHAFIN" name="FECHAFIN"

						type="hidden" value="<?php echo $fila["FECHAFIN"]; ?>"/>

					<input id="OID_TIENDA" name="OID_TIENDA"

						type="hidden" value="<?php echo $fila["OID_TIENDA"]; ?>"/>



				<?php
					if (isset($empleado) and ($empleado["OID_USUARIO"] == $fila["OID_USUARIO"])) { ?>

						<!-- Editando título -->

						<h3><input id="SUELDO" name="SUELDO" type="text" value="<?php echo $fila["SUELDO"]; ?>"/>	</h3>
						<h3><input id="OID_TIENDA" name="OID_TIENDA" type="text" value="<?php echo $fila["OID_TIENDA"]; ?>" required/>	</h3>
						<h3><input id="TIPOUSUARIO" name="TIPOUSUARIO" type="text" value="<?php echo $fila["TIPOUSUARIO"]; ?>" required/>	</h3>

						<h4><?php echo "DNI: " . $fila["DNI"] . "; Empleado: " . $fila["NOMBRE"] . " " . $fila["APELLIDOS"]; ?></h4>

				<?php }	else { ?>

						<!-- mostrando título -->

						<input id="SUELDO" name="SUELDO" type="hidden" value="<?php echo $fila["SUELDO"]; ?>"/>

						<input id="OID_TIENDA" name="OID_TIENDA" type="hidden" value="<?php echo $fila["OID_TIENDA"]; ?>"/>

						<input id="TIPOUSUARIO" name="TIPOUSUARIO" type="hidden" value="<?php echo $fila["TIPOUSUARIO"]; ?>"/>

						<div class="empleado">DNI: <?php echo $fila["DNI"] . "; Empleado: " . $fila["NOMBRE"] . " " . $fila["APELLIDOS"]; ?></div>

						<div class="sueldo">Sueldo: <?php echo $fila["SUELDO"]; ?></div>

						<div class="oid_tienda">Tienda: <?php echo $fila["OID_TIENDA"]; ?></div>

						<div class="tipousuario">Tipo de Usuario: <?php echo $fila["TIPOUSUARIO"]; ?></div>

				<?php } ?>

				</div>



				<div id="botones_fila">

				<?php if (isset($empleado) and ($empleado["OID_USUARIO"] == $fila["OID_USUARIO"])) { ?>

						<button id="grabar" name="grabar" type="submit" class="editar_fila">

							<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación">

						</button>

				<?php } else { ?>

						<button id="modificar" name="modificar" type="submit" class="editar_fila">

							<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar empleado">

						</button>

				<?php } ?>

					<button id="despedir" name="despedir" type="submit" class="editar_fila">

						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Despedir empleado">

					</button>

				<?php if($fila["TIPOUSUARIO"]==0){?>

					  <button id="recontratar" name="recontratar" type="submit" class="editar_fila">

						  Recontratar

					  </button>
				<?php } ?>

				</div>

			</div>

		</form>

	</article>



	<?php } ?>

</main>



<?php
include_once ("pie.php");
?>

</body>

</html>
