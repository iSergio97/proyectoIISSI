<?php

session_start();
if(isset($_REQUEST["ID_ARTICULO"])) {
  $articulo["NOMBRE"] = $_REQUEST["NOMBRE"];
  $articulo["TALLA"] = $_REQUEST["TALLA"];
  $articulo["PRECIO"] = $_REQUEST["PRECIO"];
  $articulo["TAGS"] = $_REQUEST["TAGS"];

  $_SESSION['articulo']=$articulo;

  if (isset($_REQUEST["editar"])){
    Header("Location: indexLogCompra.php");
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
