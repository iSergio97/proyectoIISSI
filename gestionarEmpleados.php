<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
function consultarTodosEmpleados($conexion) {
	$consulta = "SELECT * FROM USUARIOS, EMPLEADOS, TIENDAS"
		. " WHERE (USUARIOS.OID_USUARIO = EMPLEADOS.OID_USUARIO"
		. "   AND TIENDAS.OID_TIENDA = EMPLEADOS.OID_LIBRO)"
		. " ORDER BY APELLIDOS, NOMBRE";
    return $conexion->query($consulta);
}

function despedir_empleado($conexion,$OidUsuario) {
	try {
		$stmt=$conexion->prepare('CALL DESPIDE_EMPLEADOS(:OidUsuario)');
		$stmt->bindParam(':OidUsuario',$OidUsuario);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function añadir_empleado($conexion,$OidUsuario,$Sueldo,$FechaInicio,$FechaFin,$OidTienda) {
	try {
		$stmt=$conexion->prepare('CALL AÑADE_EMPLEADOS(:OidUsuario,:Sueldo,:FI,:FF,:Tienda)');
		$stmt->bindParam(':OidUsuario',$OidUsuario);
		$stmt->bindParam(':Sueldo',$Sueldo);
		$stmt->bindParam(':FI',$FechaInicio);
		$stmt->bindParam(':FF',$FechaFin);
		$stmt->bindParam(':Tienda',$OidTienda);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function recontratar_empleado($conexion,$OidUsuario,$Sueldo,$OidTienda) {
	try {
		$stmt=$conexion->prepare('CALL RECONTRATA_EMPLEADOS(:OidUsuario,:Sueldo, :Tienda)');
		$stmt->bindParam(':OidUsuario',$OidUsuario);
		$stmt->bindParam(':Sueldo',$Sueldo);
		$stmt->bindParam(':Tienda',$OidTienda);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function modificar_empleado($conexion,$OidUsuario,$Sueldo,$OidTienda,$TipoUsuario) {
	try {
		$stmt=$conexion->prepare('CALL MODIFICA_EMPLEADOS(:OidUsuario,:Sueldo,:Tienda,:TipoUsuario)');
		$stmt->bindParam(':OidUsuario',$OidUsuario);
		$stmt->bindParam(':Sueldo',$Sueldo);
		$stmt->bindParam(':Tienda',$OidTienda);
		$stmt->bindParam(':TipoUsuario',$TipoUsuario);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
    
?>