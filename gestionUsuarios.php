<?php

function nuevo_usuario($conexion, $usuario) {

		$fechaNacimiento = date('d/m/Y', strtotime($usuario["fecNac"]));

	try {
		//execute NUEVO_USUARIO('DNI', 'NOMBREUSUARIO', 'NOMBRE', 'APELLIDOS', 'EMAIL', 123456789, 'DIRECCION', 'PASS',TO_DATE('10-FEB-1997','DD-MM-YYYY'));
		$creaUsuario = "CALL NUEVO_USUARIO(:dni, :nombreUsuario, :nombre, :apellidos, :email, :telefono, :direccion, :pass, :fecNac)";
		$stmt = $conexion -> prepare($creaUsuario);
		$stmt -> bindParam(':dni', $usuario["dni"]);
		$stmt -> bindParam(':nombreUsuario', $usuario["user_name"]);
		$stmt -> bindParam(':nombre', $usuario["nombre"]);
		$stmt -> bindParam(':apellidos', $usuario["apellidos"]);
		$stmt -> bindParam(':email', $usuario["email"]);
		$stmt -> bindParam(':telefono', $usuario["telefono"]);
		$stmt -> bindParam(':direccion', $usuario["direccion"]);
		$stmt -> bindParam(':pass', $usuario["pass"]);
		$stmt -> bindParam(':fecNac', $fechaNacimiento);
		$stmt -> execute();
		return true;
	} catch (PDOException $e) {
		echo $e -> getMessage();
		return false;
	}
}


function consultarDatosUsuario($conexion, $user_name, $pass) {
	$consulta = "SELECT COUNT (*) AS TOTAL FROM USUARIOS WHERE NOMBREUSUARIO=:user_name AND CONTRASEÑA=:pass";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> bindParam(':pass', $pass);
	$stmt -> execute();
	return $stmt -> fetchColumn();
}
?>