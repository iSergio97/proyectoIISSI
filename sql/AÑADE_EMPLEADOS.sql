CREATE OR REPLACE PROCEDURE A�ADE_EMPLEADOS(
P_OID IN USUARIOS.OID_USUARIO%TYPE,
P_SUELDO IN EMPLEADOS.SUELDO%TYPE,
P_FI IN EMPLEADOS.FECHAINICIO%TYPE,
P_FF IN EMPLEADOS.FECHAFIN%TYPE,
P_TIENDA IN EMPLEADOS.OID_TIENDA%TYPE)
IS
BEGIN
UPDATE USUARIOS SET TIPOUSUARIO = 1 WHERE OID_USUARIO = P_OID;

INSERT INTO EMPLEADOS VALUES (P_OID, P_SUELDO, P_FI, P_FF, P_TIENDA);

END;