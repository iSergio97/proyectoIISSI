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
