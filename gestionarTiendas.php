<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de tiendas de la capa de acceso a datos 		
     * #==========================================================#
     */
function consultarTodasTiendas($conexion) {
	$consulta = "SELECT * FROM TIENDAS";
    return $conexion->query($consulta);
}
    
?>