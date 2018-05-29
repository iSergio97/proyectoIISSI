<?php	
	session_start();
	
	if (isset($_REQUEST["IDARTICULO"])){
		$articulo["IDARTICULO"] = $_REQUEST["IDARTICULO"];
		$articulo["NOMBRE"] = $_REQUEST["NOMBRE"];
		$articulo["TALLA"] = $_REQUEST["TALLA"];
		$articulo["PRECIO"] = $_REQUEST["PRECIO"];
		$articulo["TIPOARTICULO"] = $_REQUEST["TIPOARTICULO"];
		$articulo["SECCION"] = $_REQUEST["SECCION"];
		$articulo["COLOR"] = $_REQUEST["COLOR"];
		$articulo["TAGS"] = $_REQUEST["TAGS"];
		$articulo["TEMPORADA"] = $_REQUEST["TEMPORADA"];
		$_SESSION["articulo"] = $articulo;
			
		if (isset($_REQUEST["editar"])) Header("Location: consulta_articulos.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: accion_modificar_articulo.php");
		else /* if (isset($_REQUEST["borrar"])) */ Header("Location: accion_borrar_articulo.php"); 
	}
	else 
		Header("Location: consulta_articulos.php");

?>