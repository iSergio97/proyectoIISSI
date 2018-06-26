<?php

function consultarTodosArticulos($conexion) {
  $consulta = "select nombre, Talla, Precio, TipoArticulo from Articulos";
  return $conexion->query($consulta);
}

function editarPerfil($conexion, $perfil) {

  try {
    $stmt=$conexion->prepare('CALL EDITAR_PERFIL(:nombre,
    :apellidos, :email, :telefono, :direccion, :fecnac)');
    $stmt->bindParam(':nombre', $perfil['nombre']);
    $stmt->bindParam(':apellidos', $perfil['apellidos']);
    $stmt->bindParam(':email', $perfil['emal']);
    $stmt->bindParam(':telefono', $perfil['telefono']);
    $stmt->bindParam(':direccion', $perfil['direccion']);
    $stmt->bindParam(':fecnac', $perfil['fecNac']);
    $stmt->execute();
    return "";
  } catch(PDOException $e) {
    return $e->getMessage();
  }
}

function accion_modificar_articulo($conexion, $nombre, $precio, $talla, $tags) {
    try {
      $stmt=$conexion->prepare('CALL ACCION_MODIFICAR_ARTICULO(:NOMBRE, :PRECIO, :TALLA, :TAGS)');
      $stmt->bindParam(':NOMBRE', $nombre);
      $stmt->bindParam(':PRECIO', $precio);
      $stmt->bindParam(':TALLA', $talla);
      $stmt->bindParam(':TAGS', $tags);
      $stmt->execute();
      return "";
    } catch (PDOException $e) {
      return $e->getMessage();
      }
}

 ?>
