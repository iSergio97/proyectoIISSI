/*-----------------------------------
----------Borrado de tablas----------
*/-----------------------------------

drop table LineasDevoluciones;
drop table Devoluciones;
drop table LineasPedidos;
Drop table Pedidos;
drop table Participa;
drop table EstadisticaArticulo;
drop table TieneStockEn;
drop table Proporciona;
drop table Articulos;
drop table Secciones;
drop table TipoArticulos;
drop table Sorteos;
drop table Empleados;
drop table Usuarios;
drop table Tiendas;
drop table Proveedores;
drop table Temporadas;

/*-----------------------------------------------
----------Creación de las nuevas tablas----------
*/-----------------------------------------------
create table Temporadas (
OID_Temporada number primary key,
TemporadaArticulo varchar2 (15 byte)
);

create table Proveedores (
OID_Proveedor number primary key,
Nombre varchar2 (40 byte),
Direccion varchar2 (15 byte),
Telefono varchar2 (15 byte)
);

create table Tiendas (
OID_Tienda number primary key,
NombreTienda varchar2 (20 byte),
Localizacion varchar2 (15 byte),
Horario varchar2 (15 byte)
);


create table Usuarios (
OID_Usuario number primary key NOT NULL,
DNI varchar2 (10 byte) NOT NULL,
nombreUsuario varchar2 (200 byte) NOT NULL UNIQUE,
Nombre varchar2 (200 byte) NOT NULL,
Apellidos varchar2 (200 byte) NOT NULL,
email varchar2 (200 byte)NOT NULL UNIQUE,
Telefono number (9,0) NOT NULL,
Direccion varchar2 (200 byte) NOT NULL,
Contraseña varchar2 (200 byte) NOT NULL,
TipoUsuario number NOT NULL,
FechaNacimiento date NOT NULL,
Constraint Usuario_TipoUsuario check (TipoUsuario between 0 and 2)
);

create table Empleados (
OID_Usuario number primary key,
Sueldo number (8,2),
FechaInicio date,
FechaFin date,
OID_Tienda number,
Constraint FK_Empleados_Tienda foreign key (OID_Tienda) references Tiendas(OID_Tienda),
Constraint FK_Empleados_Usuario foreign key (OID_Usuario) references Usuarios (OID_Usuario),
Constraint CHK_FechaContrato check (FechaInicio < FechaFin)
);

create table Sorteos (
OID_Sorteo number primary key,
fechaInicio date,
fechaFin date,
constraint Sorteo_Fechas check (fechaInicio < fechaFin)
);

create table tipoArticulos (
OID_TipoArticulo number primary key,
TipoPrenda varchar2 (15 byte)
);

create table Secciones (
OID_Seccion number primary key,
SeccionArticulo varchar2 (15 byte)
);

create table Articulos (
idArticulo number primary key,
Nombre varchar2 (15 byte),
Talla varchar2 (15 byte),
TipoArticulo number,
foreign key (TipoArticulo) references TipoArticulos(OID_TipoArticulo),
Precio number (5, 2),
Seccion number,
Constraint FK_Articulo_Seccion foreign key (Seccion) references Secciones(OID_Seccion),
Color varchar2 (15 byte),
TAGS varchar2 (40 byte),
Temporada number,
Constraint FK_Articulos_Temp foreign key (Temporada) references Temporadas(OID_Temporada)
);

create table Proporciona (
idArticulo number,
OID_Proveedor,
Cantidad number,
Precio number (6,2),
Constraint PK_Proporciona primary key (idArticulo, OID_Proveedor),
Constraint FK_Proporciona_Art foreign key (idArticulo) references Articulos(idArticulo),
Constraint FK_Proporciona_Prov foreign key (OID_Proveedor) references Proveedores(OID_Proveedor)
);

create table TieneStockEn (
idArticulo number,
foreign key (idArticulo) references Articulos(idArticulo),
Tienda NUMBER,
Stock number,
Constraint FK_TSE_Tienda foreign key (Tienda) references Tiendas(OID_Tienda),
Constraint PK_TSE primary key (idArticulo, Tienda)
);

create table EstadisticaArticulo (
idArticulo number primary key,
constraint FK_EstArt_Art foreign key (idArticulo) references Articulos(idArticulo),
CantidadVendida number,
CantidadDevuelta number,
Constraint EstArt_CantVenYDev check (CantidadVendida >= CantidadDevuelta)
);

create table Participa (
OID_Usuario number,
constraint FK_Participa_Users foreign key (OID_Usuario) references Usuarios(OID_Usuario),
OID_Sorteo number,
constraint FK_Participa_Sorteo foreign key (OID_Sorteo) references Sorteos(OID_Sorteo),
constraint PK_Participa primary key (OID_Usuario, OID_Sorteo)
);

create table Pedidos (
idPedido number primary key,
PrecioTotal number,
OID_Usuario number,
Constraint FK_Pedidos_Users foreign key (OID_Usuario) references Usuarios(OID_Usuario),
FechaPedido date,
Estado number,
Constraint Pedidos_Estado check (Estado between 0 and 2)
);

create table LineasPedidos (
NumeroLinea number,
idPedido number,
Constraint LP_FK_idPed foreign key (idPedido) references Pedidos(idPedido),
idArticulo number,
Constraint LP_FK_idArt foreign key (idArticulo) references Articulos(idArticulo),
Cantidad number,
PrecioUnitario number,
Total number,
Constraint PK_LineasPedido primary key(NumeroLinea, idPedido)
);

create table Devoluciones (
idDevolucion number primary key,
idPedido number,
Constraint FK_Dev_idPedido foreign key (idPedido) references Pedidos(idPedido),
FechaDevolucion date,
MotivoDevolucion varchar2 (500 byte),
EstadoDevolucion number,
Constraint CHK_EstDevolucion check (EstadoDevolucion between 0 and 2),
ImporteDevolucion number (5, 2)
);

create table LineasDevoluciones (
idDevolucion number,
idPedido number,
NumeroLinea number,
Cantidad_Devuelta number (5,2),
PrecioUnitario number (5,2),
Total_Devolucion number (5,2),
constraint LD_PK primary key (idPedido, NumeroLinea, idDevolucion),
constraint LD_FK_idDev foreign key (idDevolucion) references Devoluciones(idDevolucion),
constraint LD_FK_NumLin foreign key (NumeroLinea, idPedido) references LineasPedidos (NumeroLinea, idPedido) enable
);