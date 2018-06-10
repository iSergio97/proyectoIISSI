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

function modificar_usuario($conexion,$user_name,$dni,$user_name_new,$nombre,$apellidos,$email,$telefono,$direccion,$contraseña,$fecha_nacimiento) {
	try {
		$stmt=$conexion->prepare('CALL MODIFICA_USUARIO(:Username,:DNI,:Username_NEW,:NOMBRE,:APELLIDOS,:EMAIL,:TELEFONO,:DIRECCION,:CONTRASEÑA,:FECHA_NAC)');
		$stmt->bindParam(':Username',$user_name);
		$stmt->bindParam(':DNI',$dni);
		$stmt->bindParam(':Username_NEW',$user_name_new);
		$stmt->bindParam(':NOMBRE',$nombre);
		$stmt->bindParam(':APELLIDOS',$apellidos);
		$stmt->bindParam(':EMAIL',$email);
		$stmt->bindParam(':TELEFONO',$telefono);
		$stmt->bindParam(':DIRECCION',$direccion);
		$stmt->bindParam(':CONTRASEÑA',$contraseña);
		$stmt->bindParam(':FECHA_NAC',$fecha_nacimiento);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function tipoUsuario($conexion, $user_name) {
	$consulta = "SELECT TIPOUSUARIO FROM USUARIOS WHERE NOMBREUSUARIO=:user_name";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> execute();
	return $stmt -> fetch();
}

function apellidos($conexion, $user_name) {
	$consulta = "SELECT APELLIDOS FROM USUARIOS WHERE NOMBREUSUARIO=:user_name";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> execute();
	return $stmt -> fetchColumn();
}

function nombre($conexion, $user_name) {
	$consulta = "SELECT NOMBRE FROM USUARIOS WHERE NOMBREUSUARIO=:user_name";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> execute();
	return $stmt -> fetchColumn();
}

function email($conexion, $user_name) {
	$consulta = "SELECT EMAIL FROM USUARIOS WHERE NOMBREUSUARIO=:user_name";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> execute();
	return $stmt -> fetchColumn();
}

function telefono($conexion, $user_name) {
	$consulta = "SELECT TELEFONO FROM USUARIOS WHERE NOMBREUSUARIO=:user_name";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> execute();
	return $stmt -> fetchColumn();
}

function dni($conexion, $user_name) {
	$consulta = "SELECT DNI FROM USUARIOS WHERE NOMBREUSUARIO=:user_name";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> execute();
	return $stmt -> fetchColumn();
}

function direccion($conexion, $user_name) {
	$consulta = "SELECT DIRECCION FROM USUARIOS WHERE NOMBREUSUARIO=:user_name";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> execute();
	return $stmt -> fetchColumn();
}

function contraseña($conexion, $user_name) {
	$consulta = "SELECT CONTRASEÑA FROM USUARIOS WHERE NOMBREUSUARIO=:user_name";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> execute();
	return $stmt -> fetchColumn();
}

function fechaNacimientoMostrar($conexion, $user_name) {
	$consulta = "SELECT TO_CHAR(FechaNacimiento,'DD/MM/YYYY') FROM USUARIOS WHERE NOMBREUSUARIO=:user_name";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> execute();
	return $stmt -> fetchColumn();
}

function fechaNacimientoFormulario($conexion, $user_name) {
	$consulta = "SELECT TO_CHAR(FechaNacimiento,'YYYY-MM-DD') FROM USUARIOS WHERE NOMBREUSUARIO=:user_name";
	$stmt = $conexion -> prepare($consulta);
	$stmt -> bindParam(':user_name', $user_name);
	$stmt -> execute();
	return $stmt -> fetchColumn();
}
?>
