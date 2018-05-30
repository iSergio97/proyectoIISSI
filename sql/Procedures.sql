/*****************************************************************************/
/* Procedimiento para la creación de artículos     */
/****************************************************************************/

drop sequence idArticulo;

create sequence idArticulo increment by 1 start with 1;

/

CREATE OR REPLACE PROCEDURE añadeArticulos
  (Nombre varchar2,
  Talla varchar2,
  TipoArticulo number,
  Precio number,
  Seccion number,
  Color varchar2,
  TAGS varchar2,
  Temporada number)
  is
    
BEGIN
insert into Articulos (idArticulo, Nombre, Talla, TipoArticulo, Precio, Seccion, Color,
TAGS, Temporada)
values (idArticulo.nextval, Nombre, Talla, TipoArticulo, Precio, Seccion,
Color, TAGS, Temporada);

end añadeArticulos;

/

/*****************************************************************************/
/* Procedimiento para la creación de artículos     */
/****************************************************************************/

CREATE OR REPLACE PROCEDURE editaArticulos
  (idArticulo_A_MOD in Articulos.idArticulo%TYPE,
   Nombre_A_MOD in Articulos.Nombre%TYPE,
   Precio_A_MOD in Articulos.Precio%TYPE,
   TAGS_A_MOD in Articulos.TAGS%TYPE) IS
BEGIN
   UPDATE ARTICULOS SET Nombre=Nombre_A_MOD,
   Precio=Precio_A_MOD, TAGS=TAGS_A_MOD WHERE idArticulo=idArticulo_A_MOD;
END;
/

/*****************************************************************************/
/* Procedimiento para la creación de artículos     */
/****************************************************************************/

CREATE OR REPLACE PROCEDURE eliminaArticulos
  (idArticulo_A_QUITAR in Articulos.idArticulo%TYPE) IS
BEGIN
   DELETE FROM EstadisticaArticulo WHERE idArticulo=idArticulo_A_QUITAR;
   DELETE FROM Proporciona WHERE idArticulo=idArticulo_A_QUITAR;
   DELETE FROM LineasPedido WHERE idArticulo=idArticulo_A_QUITAR;
   DELETE FROM LineasDevolucion WHERE idArticulo=idArticulo_A_QUITAR;
   DELETE FROM TieneStockEn WHERE idArticulo=idArticulo_A_QUITAR;
   DELETE FROM Articulos WHERE idArticulo=idArticulo_A_QUITAR;
END;
/

/*****************************************************************************/
/* Procedimiento para la creación de un pedido-cabecera                        */
/****************************************************************************/

CREATE OR REPLACE PROCEDURE CrearPedidos (
IDPEDIDO IN PEDIDOS.IDPEDIDO%TYPE,
OID_USUARIO IN PEDIDOS.OID_USUARIO%TYPE
) IS

FechaActual Date;	

BEGIN



select sysdate into FechaActual from dual;

insert into Pedidos values (idpedido, 0, oid_usuario, to_date (fechaactual), 0);


end CrearPedidos;

/

/***************************************************************/
/* Creamos una línea de pedido */
/***************************************************************/

CREATE OR REPLACE PROCEDURE CrearLineaPedido (
P_idPedido in LineasPedidos.idPedido%type,
P_idArticulo in LineasPedidos.idArticulo%type,
P_Cantidad in LineasPedidos.Cantidad%type
) IS

V_lineaPedido number;
V_PrecioUnitario number;
V_PrecioTotal number;

BEGIN


-- Vamos a calcular la línea de pedidos que le corresponde

select nvl(max(numeroLinea), 0) + 1 into V_lineaPedido from LineasPedidos where idPedido = P_idPedido;

-- Extraemos el precio del artículo
select Precio into V_PrecioUnitario from Articulos where idArticulo = P_idArticulo;

--Calculamos el precio total de la línea de pedido
V_PrecioTotal := V_PrecioUnitario * P_Cantidad;

insert into LineasPedidos(idPedido, numeroLinea, idArticulo, Cantidad, PrecioUnitario, Total) values 
(P_idPedido, V_lineaPedido, P_idArticulo, P_Cantidad, V_PrecioUnitario, V_PrecioTotal);

end CrearLineaPedido;

/

/******************************************************************/
/* Procedimiento para la confirmación de un pedido que ha estado  */
/* confeccionando el usuario, seleccionando artículos y cantidad */
/******************************************************************/

CREATE OR REPLACE PROCEDURE ConfirmarPedido (
P_idPedido IN LINEASPEDIDOS.idPedido%TYPE
) IS

V_FechaActual Date;
V_ImporteTotal number;

BEGIN


-- Determino la fecha real del pedido en el momento de la confirmación
select sysdate into V_FechaActual from dual;

-- Calculo el importe total del pedido
Select sum (total) into V_ImporteTotal from lineasPedidos where Idpedido = P_idPedido;


-- actualizo el pedido con los datos definitivos
update Pedidos set fechapedido = TO_DATE(V_Fechaactual), PrecioTotal = V_ImporteTotal, Estado = 1 where IDPEDIDO = P_IDPEDIDO;

end ConfirmarPedido;

/

/***********************************************************/
/** Creación de la cabecera de devoluciones   */
/***********************************************************/

CREATE OR REPLACE PROCEDURE CrearDevolucion (
P_idPedido in Devoluciones.idPedido%type,
P_MotivoDevolucion in Devoluciones.MotivoDevolucion%type
) IS

V_FechaDevolucion Date;
V_IdDevolucion number;

BEGIN


-- Construyo el código de devolución
select NVL (max(iddevolucion),0) + 1 into V_IdDevolucion from devoluciones;

-- determino la fecha de devolucion
select sysdate into V_FechaDevolucion from dual ;


insert into Devoluciones (idDevolucion, fechaDevolucion, motivoDevolucion, estadoDevolucion, importeDevolucion, idPedido)
values (V_IdDevolucion, V_FechaDevolucion, P_MotivoDevolucion,0, 0, P_idPedido);

end CrearDevolucion;

/

/***************************************************************/
/* Creamos una línea de devolución*/
/***************************************************************/
CREATE OR REPLACE PROCEDURE CrearLineaDevolucion (
P_idDevolucion in LINEASDEVOLUCIONES.IDDEVOLUCION%type,
P_idPedido in LINEASDEVOLUCIONES.IDPEDIDO%type,
P_NumeroLinea in LINEASDEVOLUCIONES.NUMEROLINEA%type,
P_CantidadDevuelta in LINEASDEVOLUCIONES.CANTIDAD_DEVUELTA%type
) IS

V_PrecioUnitario number;
V_PrecioTotal number;
V_idArticulo number;

BEGIN

-- Determinamos el ártículo que se está devolviendo
Select idArticulo into V_idArticulo from LINEASPEDIDOS where idPedido = P_idPedido and NUMEROLINEA = P_NumeroLinea;

-- Extraemos el precio del artículo
select Precio into V_PrecioUnitario from Articulos where idArticulo = V_idArticulo;

--Calculamos el precio total de la línea de pedido
V_PrecioTotal := V_PrecioUnitario * P_CantidadDevuelta;

insert into LineasDevoluciones (idDevolucion, idPedido, numeroLinea, Cantidad_Devuelta, PrecioUnitario, Total_devolucion) values 
(P_idDevolucion, P_idPedido, P_NumeroLinea, P_CantidadDevuelta, V_PrecioUnitario, V_PrecioTotal);

end CrearLineaDevolucion;

/

/******************************************************************/
/* Procedimiento para la confirmación de una devolucion que ha estado  */
/* confeccionando el usuario, seleccionando los artículos y cantidad */
/* a devolver de cada uno de ellos                                   */
/******************************************************************/

CREATE OR REPLACE PROCEDURE ConfirmarDevolucion (
P_idDevolucion IN DEVOLUCIONES.IDDEVOLUCION%TYPE
) IS

V_FechaActual Date;
V_ImporteTotal number;

BEGIN


-- Determino la fecha real de la devolución en el momento de la confirmación
select sysdate into V_FechaActual from dual;

-- Calculo el importe total de la devolución
Select sum (total_devolucion) into V_ImporteTotal from lineasdevoluciones where IdDevolucion = P_idDevolucion;

-- actualizo el pedido con los datos definitivos
update Devoluciones set fechadevolucion = TO_DATE(V_Fechaactual), ImporteDevolucion = V_ImporteTotal, EstadoDevolucion = 1 where IDDevolucion = P_idDevolucion;

end ConfirmarDevolucion;

/

/*****************************************************************************/
/* Procedimiento para la creación de usuarios                               */
/****************************************************************************/
drop sequence idUsuario;
create sequence idUsuario;

create or replace procedure NUEVO_USUARIO(
P_DNI IN USUARIOS.DNI%TYPE,
P_USERNAME IN USUARIOS.NOMBREUSUARIO%TYPE,
P_NOM IN USUARIOS.NOMBRE%TYPE,
P_APE IN USUARIOS.APELLIDOS%TYPE,
P_EMAIL IN USUARIOS.EMAIL%TYPE,
P_TELF IN USUARIOS.TELEFONO%TYPE,
P_DIR IN USUARIOS.DIRECCION%TYPE,
P_PASS IN USUARIOS.CONTRASEÑA%TYPE,
P_FECHA_NAC DATE
) IS
BEGIN
    INSERT INTO USUARIOS
    (OID_USUARIO, DNI, NOMBREUSUARIO, NOMBRE, APELLIDOS, EMAIL, TELEFONO, DIRECCION, CONTRASEÑA, TIPOUSUARIO, FECHANACIMIENTO)
    VALUES
    (idUsuario.nextVal, P_DNI, P_USERNAME, P_NOM, P_APE, P_EMAIL, P_TELF, P_DIR, P_PASS, 0, P_FECHA_NAC);

    END;
/

/*****************************************************************************/
/* PROCEDIMIENTO PARA AÑADIR EMPLEAODS                                       */
/*****************************************************************************/

CREATE OR REPLACE PROCEDURE AÑADE_EMPLEADOS(
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

/

/*****************************************************************************/
/* PROCEDIMIENTO PARA DESPEDIR EMPLEADOS                                     */
/*****************************************************************************/

CREATE OR REPLACE PROCEDURE DESPIDE_EMPLEADOS(
OID_Usuario_A_DESPEDIR IN EMPLEADOS.OID_Usuario%TYPE) IS
BEGIN
  UPDATE Empleados SET FechaFin=SYSDATE WHERE OID_Usuario=OID_Usuario_A_DESPEDIR;
  UPDATE Usuarios SET TipoUsuario=0 WHERE OID_Usuario=OID_Usuario_A_DESPEDIR;
  UPDATE Empleados SET Sueldo=NULL WHERE OID_Usuario=OID_Usuario_A_DESPEDIR;
END;
/

/*****************************************************************************/
/* PROCEDIMIENTO PARA VOLVER A CONTRATAR EMPLEADOS DESPEDIDOS                */
/*****************************************************************************/

CREATE OR REPLACE PROCEDURE RECONTRATA_EMPLEADOS(
OID_Usuario_A_RECONTRATAR IN EMPLEADOS.OID_Usuario%TYPE,
Sueldo_A_RECONTRATAR IN EMPLEADOS:Sueldo%TYPE) IS
BEGIN
  UPDATE Empleados SET FechaInicio=SYSDATE WHERE OID_Usuario=OID_Usuario_A_RECONTRATAR;
  UPDATE Empleados SET FechaFin=NULL WHERE OID_Usuario=OID_Usuario_A_RECONTRATAR;
  UPDATE Usuarios SET TipoUsuario=1 WHERE OID_Usuario=OID_Usuario_A_RECONTRATAR;
  UPDATE Empleados SET Sueldo=Sueldo_A_RECONTRATAR WHERE OID_Usuario=OID_Usuario_A_DESPEDIR;
END;
/

/*****************************************************************************/
/* Procedimiento para la inicialización de la base de datos                  */
/****************************************************************************/
drop sequence idTemporada;
create sequence idTemporada;

drop sequence idTienda;
create sequence idTienda;

drop sequence idProveedor;
create sequence idProveedor;

DROP SEQUENCE IDTIPOARTICULO;
CREATE SEQUENCE IDTIPOARTICULO;

DROP SEQUENCE IDSECCION;
CREATE SEQUENCE IDSECCION;

CREATE OR REPLACE PROCEDURE InicializarBD
IS

BEGIN


insert into TEMPORADAS (OID_TEMPORADA,TemporadaARTICULO) values (idTemporada.nextval, 'Primavera');
insert into TEMPORADAS (OID_TEMPORADA,TemporadaARTICULO) values (idTemporada.nextval, 'Verano');
insert into TEMPORADAS (OID_TEMPORADA,TemporadaARTICULO) values (idTemporada.nextval, 'Otoño');
insert into TEMPORADAS (OID_TEMPORADA,TemporadaARTICULO) values (idTemporada.nextval, 'Invierno');
insert into TEMPORADAS (OID_TEMPORADA,TemporadaARTICULO) values (idTemporada.nextval, 'ANUAL');


insert into Tiendas (OID_TIENDA, nombreTienda, LOCALIZACION, Horario) values (idTienda.nextVal, 'Sweet Modas', 'Sevilla', '9:00 - 20:00 ');

insert into Tiendas (OID_TIENDA, nombreTienda, LOCALIZACION, Horario) values (idTienda.nextVal, 'Sweet Modas2', 'Huelva', '10:00 - 21:00 ');

insert into Tiendas (OID_TIENDA, nombreTienda, LOCALIZACION, Horario) values (idTienda.nextVal, 'Sweet Modas3', 'Murcia', '8:00 - 20:30 ');

INSERT INTO PROVEEDORES VALUES (idProveedor.nextVal,'HOLYDAY  SL','MOGUER','95999999');
INSERT INTO PROVEEDORES VALUES (idProveedor.nextVal,'GORROS SL','CUENCA','95999999');
INSERT INTO PROVEEDORES VALUES (idProveedor.nextVal,'CHALECOS SL','MADRID','95999999');

--AÑADIMOS LOS USUARIOS
INSERT INTO USUARIOS VALUES(IDUSUARIO.NEXTVAL, '12345678A','USER1', 'NOMBRE1', 'APELLIDOS1', 'EMAIL1@GMAIL.COM', 123456789, 'DIRECCION 1', 'CONTRASEÑA 1', 0, TO_DATE('1970-01-01', 'YYYY-MM-DD'));
INSERT INTO USUARIOS VALUES(IDUSUARIO.NEXTVAL, '12345678B','USER2', 'NOMBRE2', 'APELLIDOS2', 'EMAIL2@GMAIL.COM', 234567891, 'DIRECCION 2', 'CONTRASEÑA 2', 0, TO_DATE('1970-02-01', 'YYYY-MM-DD'));
INSERT INTO USUARIOS VALUES(IDUSUARIO.NEXTVAL, '12345678C','USER3', 'NOMBRE3', 'APELLIDOS3', 'EMAIL3@GMAIL.COM', 345678912, 'DIRECCION 3', 'CONTRASEÑA 3', 0, TO_DATE('1970-03-01', 'YYYY-MM-DD'));
INSERT INTO USUARIOS VALUES(IDUSUARIO.NEXTVAL, '12345678D','USER4', 'NOMBRE4', 'APELLIDOS4', 'EMAIL4@GMAIL.COM', 456789123, 'DIRECCION 4', 'CONTRASEÑA 4', 0, TO_DATE('1970-04-01', 'YYYY-MM-DD'));


INSERT INTO TIPOARTICULOS VALUES (IDTIPOARTICULO.NEXTVAL, 'CAMISA');
INSERT INTO TIPOARTICULOS VALUES (IDTIPOARTICULO.NEXTVAL, 'CAMISETA');
INSERT INTO TIPOARTICULOS VALUES (IDTIPOARTICULO.NEXTVAL, 'PANTALON');
INSERT INTO TIPOARTICULOS VALUES (IDTIPOARTICULO.NEXTVAL, 'CALZADO');
INSERT INTO TIPOARTICULOS VALUES (IDTIPOARTICULO.NEXTVAL, 'ACCESORIO');
INSERT INTO TIPOARTICULOS VALUES (IDTIPOARTICULO.NEXTVAL, 'FALDA');
INSERT INTO TIPOARTICULOS VALUES (IDTIPOARTICULO.NEXTVAL, 'VESTIDO');

INSERT INTO SECCIONES VALUES(IDSECCION.NEXTVAL, 'HOMBRE');
INSERT INTO SECCIONES VALUES(IDSECCION.NEXTVAL, 'MUJER');
INSERT INTO SECCIONES VALUES(IDSECCION.NEXTVAL, 'NIÑO');
INSERT INTO SECCIONES VALUES(IDSECCION.NEXTVAL, 'OTROS');

end InicializarBD;