<?php

session_start();
if(isset($_REQUEST["ID_ARTICULO"])) {
  $articulo["ID_ARTICULO"] = $_REQUEST["ID_ARTICULO"];
  $articulo["NOMBRE"] = $_REQUEST["NOMBRE"];
  $articulo["TALLA"] = $_REQUEST["TALLA"];
  $articulo["TIPOARTICULO"] = $_REQUEST["TIPOARTICULO"];
  $articulo["PRECIO"] = $_REQUEST["PRECIO"];
  $articulo["SECCION"] = $_REQUEST["SECCION"];
  $articulo["COLOR"] = $_REQUEST["COLOR"];
  $articulo["TAGS"] = $_REQUEST["TAGS"];
  $articulo["TEMPORADA"] = $_REQUEST["TEMPORADA"];

  $_SESSION['articulo']=$articulo;
} else {
  Header("Location: categorias.php");
}
?>
