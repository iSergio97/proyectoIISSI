<?php

session_start();
if(isset($_REQUEST["IDARTICULO"])) {
  $articulo["IDARTICULO"] = $_REQUEST["IDARTICULO"];
  $articulo["NOMBRE"] = $_REQUEST["NOMBRE"];
  $articulo["TALLA"] = $_REQUEST["TALLA"];
  $articulo["PRECIO"] = $_REQUEST["PRECIO"];
  $articulo["TAGS"] = $_REQUEST["TAGS"];
  $articulo["TIPOARTICULO"] = $_REQUEST["TIPOARTICULO"];
  $articulo["SECCION"] = $_REQUEST["SECCION"];
  $articulo["COLOR"] = $_REQUEST["COLOR"];
  $articulo["TEMPORADA"] = $_REQUEST["TEMPORADA"];

  $_SESSION['articulo']=$articulo;

  if (isset($_REQUEST["modificar"])){
    Header("Location: indexLog.php");
  } else if ($_REQUEST("grabar")) {
    Header("Location: accion_modificar_articulo.php");
  } else {
    Header("Location: añadir_compra.php");
  }
}else {
  //Header("Location: indexLog.php");
  Header("Location: indexLog.php");
}
?>
