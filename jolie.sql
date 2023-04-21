-- Database: jolie

-- DROP DATABASE IF EXISTS jolie;

CREATE DATABASE jolie
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Spanish_Spain.1252'
    LC_CTYPE = 'Spanish_Spain.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;
	
	
CREATE TABLE producto(
	id_producto serial not null,
	id_categoria int not null,
	nombre_producto varchar(60) not null,
	descripcion_producto varchar(200) not null,
	precio_producto numeric(5,2) not null,
	imagen_producto varchar(100) not null,
	idestado_producto int not null,
	id_usuario int not null,
	id_talla int not null,
	id_imagen int not null,
	CONSTRAINT pk_producto PRIMARY KEY (id_producto)
);
SELECT*FROM producto;

CREATE TABLE usuario(
	id_usuario serial not null,
	nombre_usuario varchar(50) not null,
	apellido_usuario varchar(50) not null,
	usuario varchar(50) not null,
	clave_usuario varchar(50) not null,
	estado_usuario boolean not null,
	idtipo_usuario int not null,
	CONSTRAINT pk_usuario PRIMARY KEY (id_usuario)
);
SELECT*FROM usuario;

CREATE TABLE categoria(
	id_categoria serial not null,
	categoria varchar(40) not null,
	CONSTRAINT pk_categoria PRIMARY KEY (id_categoria)
);
SELECT*FROM categoria;

CREATE TABLE estado_producto(
	idestado_producto serial not null,
	estado_producto varchar(40) not null,
	CONSTRAINT pk_estado_producto PRIMARY KEY (idestado_producto)
);
SELECT*FROM estado_producto;

CREATE TABLE tipo_usuario(
	idtipo_usuario serial not null,
	tipo_usuario varchar(50) not null,
	CONSTRAINT pk_tipo_usuario PRIMARY KEY (idtipo_usuario)
);
SELECT*FROM tipo_usuario;

CREATE TABLE imagen(
	id_imagen serial not null,
	imagen varchar(100) not null,
	CONSTRAINT pk_imagen PRIMARY KEY (id_imagen)
);
SELECT*FROM imagen;

CREATE TABLE talla(
	id_talla serial not null,
	talla varchar(5) not null,
	CONSTRAINT pk_talla PRIMARY KEY (id_talla)
);
SELECT*FROM talla;

CREATE TABLE cliente(
	id_cliente serial not null,
	nombre_cliente varchar(50) not null,
	apellido_cliente varchar(50) not null,
	dui_cliente varchar(50) not null,
	correo_cliente varchar(50) not null,
	telefono_cliente varchar(9) not null,
	nacimiento_cliente date not null,
	direccion_cliente varchar(50) not null,
	estado_cliente boolean not null,
	CONSTRAINT pk_cliente PRIMARY KEY (id_cliente)
);
SELECT*FROM cliente;

CREATE TABLE pedido(
	id_pedido serial not null,
	id_cliente int not null,
	fecha_pedido date not null,
	direccion_pedido varchar(250) not null,
	idestado_pedido int not null,
	CONSTRAINT pk_pedido PRIMARY KEY (id_pedido)
);
SELECT*FROM pedido;

CREATE TABLE detalle_pedido(
	id_detalle serial not null,
	id_pedido int not null,
	id_producto int not null,
	cantidad int not null,
	precio_producto numeric(5,2) not null,
	CONSTRAINT pk_detalle PRIMARY KEY (id_detalle)
);

SELECT*FROM detalle_pedido;
SELECT*FROM producto;

CREATE TABLE estado_pedido(
	idestado_pedido serial not null,
	estado_pedido varchar(40) not null,
	CONSTRAINT pk_estado_pedido PRIMARY KEY (idestado_pedido)
);
SELECT*FROM estado_pedido;

CREATE TABLE valoracion(
	id_valoracion serial not null,
	nombre_cliente varchar(50) not null,
	calificacion_producto int not null,
	comentario_producto varchar(250) not null,
	correo_cliente varchar(50) not null,
	fecha_comentario date not null,
	id_detalle int not null,
	CONSTRAINT pk_valoracion PRIMARY KEY (id_valoracion)
);
SELECT*FROM valoracion

ALTER TABLE producto
ADD CONSTRAINT fk_usuario
FOREIGN KEY (id_usuario)
REFERENCES usuario(id_usuario)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE producto
ADD CONSTRAINT fk_estado_producto
FOREIGN KEY (idestado_producto)
REFERENCES estado_producto(idestado_producto)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE producto
ADD CONSTRAINT fk_categoria
FOREIGN KEY (id_categoria)
REFERENCES categoria(id_categoria)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE producto
ADD CONSTRAINT fk_imagen
FOREIGN KEY (id_imagen)
REFERENCES imagen(id_imagen)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE producto
ADD CONSTRAINT fk_talla
FOREIGN KEY (id_talla)
REFERENCES talla(id_talla)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE usuario
ADD CONSTRAINT fk_tipo_usuario
FOREIGN KEY (idtipo_usuario)
REFERENCES tipo_usuario(idtipo_usuario)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE pedido
ADD CONSTRAINT fk_cliente
FOREIGN KEY (id_cliente)
REFERENCES cliente(id_cliente)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE detalle_pedido
ADD CONSTRAINT fk_pedido
FOREIGN KEY (id_pedido)
REFERENCES pedido(id_pedido)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE detalle_pedido
ADD CONSTRAINT fk_producto
FOREIGN KEY (id_producto)
REFERENCES producto(id_producto)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE pedido
ADD CONSTRAINT fk_estado_pedido
FOREIGN KEY (idestado_pedido)
REFERENCES estado_pedido(idestado_pedido)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE valoracion
ADD CONSTRAINT fk_detalle
FOREIGN KEY (id_detalle)
REFERENCES detalle_pedido(id_detalle)
ON DELETE CASCADE
ON UPDATE CASCADE;

-----CONSULTAS CO-EVALUACION
-----CONSULTAS TABLAS UNICAS
SELECT precio_producto, descripcion_producto FROM producto;
SELECT usuario, clave_usuario FROM usuario;
SELECT id_categoria, imagen_producto, nombre_producto FROM producto;
-----CONSULTAS MULTITABLAS
SELECT categoria, talla, nombre_producto FROM categoria, talla, producto;
SELECT apellido_usuario, descripcion_producto FROM usuario, producto;
SELECT imagen, categoria, precio_producto FROM imagen, categoria, producto;



-----INSERCIONES-----
insert into estado_pedido (estado_pedido) values ('Enviado');
insert into estado_pedido (estado_pedido) values ('En espera');
insert into estado_pedido (estado_pedido) values ('Cncelado');
insert into estado_pedido (estado_pedido) values ('En proceso');

insert into talla (talla) values ('XS');
insert into talla (talla) values ('S');
insert into talla (talla) values ('M');
insert into talla (talla) values ('L');
insert into talla (talla) values ('XL');

insert into imagen (imagen) values ('.png');
insert into imagen (imagen) values ('.jpg');

insert into tipo_usuario (tipo_usuario) values ('Administrador');
insert into tipo_usuario (tipo_usuario) values ('Gerente');

insert into estado_producto (estado_producto) values ('Nuevo');
insert into estado_producto (estado_producto) values ('En revisión');
insert into estado_producto (estado_producto) values ('Agotado');

insert into categoria (categoria) values ('Recién ingresados');
insert into categoria (categoria) values ('Hoodies y conjuntos');
insert into categoria (categoria) values ('En tendencia');
insert into categoria (categoria) values ('Colleción Jolie');
insert into categoria (categoria) values ('Recién ingresados');
insert into categoria (categoria) values ('Camisas');
insert into categoria (categoria) values ('Vestidos');
insert into categoria (categoria) values ('Shorts');
insert into categoria (categoria) values ('Pantalones');
insert into categoria (categoria) values ('Faldas');
insert into categoria (categoria) values ('Tops');

insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Katya', 'Sánchez', 'katya', '123', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Fatima', 'Fuentes', 'fatima', '321', 'true', '2');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Gerges', 'Mclain', 'Geor', '432', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Gerson', 'Molina', 'Ger', '123', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Hazel', 'Magarin', 'Hazel', '432', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Gabriela', 'Ramírez', 'Gabs', '765', 'true', '2');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Lilian', 'Estrada', 'Lili', '745', 'true', '2');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Jeante', 'Sánchez', 'jean', '754', 'true', '2');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Katherine', 'Castro', 'kath', '985', 'true', '2');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Merary', 'López', 'Mera', '968', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Maybeline', 'Casco', 'May', '532', 'false', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Jonathan', 'Tobar', 'Jhon', '876', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Justin', 'Ramírez', 'Jus', '987', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Deris', 'Urquilla', 'ur', '654', 'false', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Emmanuel', 'Torres', 'Emm', '647', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Carlos', 'Torres', 'Charlie', '535', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Jason', 'Sánchez', 'Jason', '865', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Samuel', 'Estrada', 'Samu', '964', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Odett', 'Casco', 'Odette', '654', 'true', '1');
insert into usuario (nombre_usuario, apellido_usuario, usuario, clave_usuario, estado_usuario, idtipo_usuario) values ('Bryan', 'Barahona', 'Bry', '854', 'true', '2');

insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('1', 'Short', 'De nueva colección', '62', '.jpg', '1', '1', '1', '1');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('2', 'camisa', 'Recién ingresados', '60', '.jpg', '1', '2', '2', '2');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('3', 'Vestido', 'Con nueva oferta', '80', '.jpg', '3', '2', '3', '3');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('4', 'Vestido', 'Recién ingresados', '100', '.jpg', '2', '1', '1', '1');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('5', 'conjunto', 'En oferta', '40', '.jpg', '2', '1', '1', '2');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('6', 'Falda', 'Nuevos productos', '100', '.jpg', '2', '1', '1', '3');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('7', 'Hoodie', 'De las mejores telas', '70', '.jpg', '1', '1', '1', '1');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('8', 'Conjunto', 'Nuevas tallas', '80', '.jpg', '1', '2', '2', '2');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('9', 'Vestido', 'Recien ingresado', '100', '.jpg', '2', '2', '3', '3');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('10', 'Pantalones cargo', 'En tendencia', '75', '.jpg', '1', '1', '1', '1');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('11', 'Camisetas', 'En descuento', '40', '.jpg', '1', '1', '1', '2');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('1', 'Blusas', 'Mejor calidad', '50', '.jpg', '2', '1', '2', '3');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('10', 'short', 'Nueva tendencia', '15', '.jpg', '3', '2', '3', '1');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('11', 'Conjunto', 'Mejor calidad', '45', '.jpg', '1', '2', '1', '2');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('9', 'Camiseta', 'Nuevos diseños', '30', '.jpg', '1', '2', '1', '3');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('11', 'Blusa', 'Nuevo ingreso', '50', '.jpg', '1', '2', '1', '1');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('9', 'Blusa', 'Nuevo ingreso', '50', '.jpg', '1', '2', '1', '2');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('10', 'Falda', 'Nuevos estilos', '60', '.jpg', '1', '1', '2', '3');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('1', 'jeans', ' nuevos diseños', '40', '.jpg', '1', '2', '3', '1');
insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('10', 'Hoodies', ' nuevos colores', '85', '.jpg', '2', '2', '2', '2');


insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Carlos', 'Sánchez', '067269136', 'carlossanchez@gmail.com', '25749862', '7-7-1999', 'Lot. Las americas etapa 1', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Lilian', 'Estrada', '1578624156', 'lilian.estrada@gmail.com', '14578962', '5-7-2000', 'Lot. Las americas etapa 1', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Erika', 'Estrada', '215789546', 'erikaestrada@gmail.com', '12478564', '5-10-2000', 'Calle 5, po. 14, Av Escalon', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('María', 'Ramírez', '128745695', 'mariaramirez@gmail.com', '45789625', '3-12-2000', 'Lot 13, av canderveg via constitucion', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Gldys', 'Estrada', '657894561', 'gldysestrada@gmail.com', '98565746', '8-2-2000', 'AV constitucion, casa 6', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Erick', 'Ramirez', '658941568', 'erickramirez@gmail.com', '658456247', '9-10-2000', 'AV constitucion, casa 12', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Rene', 'Landaverde', '357894156', 'renelandaverde@gmail.com', '6845621474', '10-12-2000', 'Col. escalon, casa 12', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Yanci', 'Ramirez', '65489632', 'yancinath@gmail.com', '657426684', '3-4-2000', 'Lot. Jabalí, casa 1', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Jorge', 'Pimentel', '4578964113', 'jorgepimentel@gmail.com', '46875635', '15-7-2000', 'Lot. El cambio, casa 12', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Flor', 'Ramirez', '456875123', 'florram@gmail.com', '15487896', '30-8-2000', 'Lot. las americas etapa 2', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Maybeline', 'Casco', '154486823', 'may23@gmail.com', '65789548', '21-4-2000', 'Lot. El jabali etapa 2', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Omar', 'Corquin', '458751685', 'omarcorquin@gmail.com', '45157896', '30-4-2000', 'Col. Colombia, Nejapa', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Alma', 'Ramirez', '458796254', 'almaram@gmail.com', '65983247', '15-6-1985', 'Lot. rimavera, casa 7', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Genesis', 'Argumedo', '4582362263', 'Genesis889@gmail.com', '45159865', '6-8-1986', 'Lot. las americas etapa 2', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Daniel', 'Castillo', '659875456', 'Dani92@gmail.com', '65841235', '7-5-1995', 'Col. Valle verde casa 5', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Balmore', 'Castro', '1561255225', 'balmo5432@gmail.com', '6547522652', '2000-08-30', 'Lot. las americas etapa 2', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Sara', 'Mendez', '153256252', 'saramendez@gmail.com', '69636562', '1986-06-13', 'AV Versalles, casa 18', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Silvia', 'Guevara', '214587632', 'silviaguevara43@gmail.com', '63458752', '1987-04-10', 'Residencial Marsella, 7', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Emiliano', 'Henriquez', '452178963', 'emi313@gmail.com', '65287536', '1988-10-25', 'Lot. el cambio pol. 14 casa 6', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Steven', 'Henriquez', '657236412', 'steve287@gmail.com', '67616548', '11-5-1989', ' AV Versalles pol 14 casa 6', 'true');
insert into cliente (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, estado_cliente)
values ('Enrique', 'Guevara', '6541265921', 'Enrique324@gmail.com', '68746562', '1990-04-21', 'Av marsella csa 7', 'true');


insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('1', '5-5-2023', 'Av marsella csa 7', '1');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '5-2-2022', 'AV Versalles pol 14 casa 6', '2');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '7-2-2022', 'Lot. el cambio pol. 14 casa 6', '3');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('1', '8-2-2022', 'Lot. el cambio pol. 14 casa 6', '4');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('1', '8-2-2022', 'Lot. el cambio pol. 10 casa 6', '1');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '8-2-2022', 'Lot. el cambio pol. 11 casa 78', '2');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('1', '5-5-2023', 'Av marsella csa 5', '1');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '5-2-2022', 'AV Versalles pol 11 casa 15', '2');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('1', '7-2-2022', 'Lot. el cambio pol. 10 casa 45', '3');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '8-2-2022', 'Lot. el cambio pol. 8 casa 12', '1');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('1', '8-2-2022', 'Lot. el cambio pol. 24 casa 16', '1');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '8-2-2022', 'Lot. el cambio pol. 10 casa 58', '2');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('1', '5-5-2023', 'Av marsella csa 75', '3');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('1', '5-2-2022', 'AV Versalles pol 10 casa 65', '4');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('1', '7-2-2022', 'Lot. el cambio pol. 7 casa 65', '1');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('1', '8-2-2022', 'Lot. el cambio pol. 40 casa 45', '2');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '5-4-2022', 'Lot. el cambio pol. 105 casa 67', '1');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '5-7-2022', 'Lot. el cambio pol. 15 casa 50', '1');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '5-9-2022', 'Lot. el las americas pol. 87 casa 25', '2');
insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '5-10-2022', 'Lot. Versalles pol. 10 casa 85', '1');

insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '19');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('2', '2', '2', '25');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '3', '3', '54');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '19');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('2', '2', '2', '59');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('2', '3', '2', '45');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('2', '2', '1', '76');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('2', '2', '1', '48');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('2', '2', '2', '55');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '45');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '156');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '3', '1', '94');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '26');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '45');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '68');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '54');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '45');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '46');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('1', '2', '1', '98');
insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('2', '3', '2', '78');



---LITERAL 1
-----GROUP BY, ORDER BY Y JOIN-----
--1-Mostrar los productos que se han vendido segun su cantidad en forma ascendente
select v.nombre_producto, h.cantidad
from detalle_pedido h
inner join producto v on h.id_producto=v.id_producto
group by h.id_producto, v.nombre_producto, h.cantidad
order by h.cantidad asc

 

--2-Mostrar el nombre de los clientes y la fecha en la que realizaron una compra
select v.nombre_cliente, v.apellido_cliente, h.fecha_pedido
from pedido h
inner join cliente v on h.id_cliente=v.id_cliente
group by h.id_cliente, v.nombre_cliente, v.apellido_cliente, h.fecha_pedido
order by h.fecha_pedido asc

 

--3-Mostrar el nombre de usuario ordenado de manera descendente, guiarse del tipo de usuario
select v.tipo_usuario, h.nombre_usuario
from usuario h
inner join tipo_usuario v on h.idtipo_usuario=v.idtipo_usuario
group by h.idtipo_usuario, v.tipo_usuario, h.nombre_usuario
order by h.nombre_usuario asc

--LITERAL 2
-----PROCEDIMIENTO ALMACENADO-----
---Registrar un pedido
CREATE PROCEDURE RegistrarPedido
(
Nombre int,
Fecha date,
Direccion varchar(250),
Estado int
)
LANGUAGE SQL
as
$$
INSERT INTO pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
VALUES (Nombre,Fecha,Direccion,Estado)
$$;
CALL RegistrarPedido('1', '5-2-2023', 'Av constitucion csa 7', '1');
select * from pedido

---LITERAL 3
--Total de dinero dependiento la cantidad de productos
select precio_producto, cantidad, precio_producto*cantidad from detalle_pedido;

--LITERAL 4
--Apellido de los usuarios que sean Vestido (like)
select * from producto where nombre_producto like 'Vestido%';

--LITERAL 5
--Muestra la cantidad total de los usuarios registrados en la tabla usuario
select count(usuario) as "Usuarios registrados" from usuario; 

--LITERAL 6
--1-Mostrar usuario dependiendo su tipo de usuario
select nombre_usuario, apellido_usuario, usuario, tipo_usuario from usuario u
inner join tipo_usuario s on s.idtipo_usuario = u.idtipo_usuario where  u.idtipo_usuario=2
group by u.id_usuario, u.nombre_usuario, u.apellido_usuario, s.tipo_usuario

--2-Mostrar productos que están en espera
select fecha_pedido, direccion_pedido, id_pedido
from pedido u
inner join estado_pedido s on s.idestado_pedido = u.idestado_pedido
where estado_pedido = 'En espera' 
group by u.id_pedido, u.fecha_pedido, u.direccion_pedido, u.idestado_pedido

--3-Mostrar todos los productos segun una talla especifica
select nombre_producto, descripcion_producto, precio_producto
from producto u
inner join talla s on s.id_talla = u.id_talla
where talla = 'S'
group by u.id_producto, u.nombre_producto, u.descripcion_producto, u.precio_producto

SELECT*FROM pedido 
--4-Mostrar la dirección de un rango de fechas específicas
select direccion_pedido, idestado_pedido
from pedido u
inner join detalle_pedido s on s.id_detalle = u.id_pedido
where fecha_pedido between '2022-02-5' and '2023-2-8'
group by u.id_pedido, u.fecha_pedido, u.idestado_pedido

--5-Mostrar datos específicos de productos donde la cantidad sea mayor a 2
select direccion_pedido, idestado_pedido, fecha_pedido
from pedido u
inner join detalle_pedido s on s.id_pedido = u.id_pedido
where cantidad >=1
group by u.id_pedido, u.fecha_pedido, u.idestado_pedido, u.direccion_pedido

SELECT*FROM detalle_pedido
SELECT*FROM pedido

---LITERAL 7
--Pedidos realizados en un rango de fechas. 
select * from pedido where fecha_pedido between '2022-12-05' and '2023-10-12';

--Clientes nacidos en un rango de fechas. 
select * from cliente where nacimiento_cliente between '1980-10-05' and '1999-10-12';

--Pedidos realizados durante la mitad del año 2022. 
select * from pedido where fecha_pedido between '2022-1-1' and '2022-7-1';


SELECT*FROM detalle_pedido
SELECT*FROM pedido
SELECT*FROM producto
SELECT*FROM cliente
SELECT*FROM usuario
SELECT*FROM tipo_usuario
SELECT*FROM estado_pedido
SELECT*FROM producto
SELECT*FROM detalle_pedido
SELECT*FROM pedido
SELECT*FROM estado_producto

---Agregar 2 valoraciones qu ecorrespondan a un producto de una nueva talla
insert into talla (talla) values ('XXL');

select*from talla

insert into producto (id_categoria, nombre_producto, descripcion_producto, precio_producto, imagen_producto, idestado_producto, id_usuario, id_talla,id_imagen)
values ('1', 'Hoodie', 'Coleccion recien ingresada', '36', '.jpg', '1', '1', '6', '1');

select*from producto

insert into pedido (id_cliente, fecha_pedido, direccion_pedido, idestado_pedido)
values ('2', '13-04-2023', 'Instituto Tecnico Ricaldone', '1');

select*from pedido

insert into detalle_pedido (id_pedido, id_producto, cantidad, precio_producto)
values ('31', '50', '1', '36');

select*from detalle_pedido

insert into valoracion(nombre_cliente, calificacion_producto, comentario_producto, correo_cliente, fecha_comentario, id_detalle)
values('Lilian Estrada', '10', 'La tela es de  muy buena calidad', 'lilian.estrada@gmail.com', '13-04-2023', '23');
insert into valoracion(nombre_cliente, calificacion_producto, comentario_producto, correo_cliente, fecha_comentario, id_detalle)
values('Lilian Estrada', '10', 'La compra en linea cumple los estandares de envio', 'lilian.estrada@gmail.com', '13-04-2023', '23');

select*from valoracion

--Actualizar la categoría de los productos que correspondan a pedidos con id estado 2 y 3
UPDATE producto SET id_categoria=4  WHERE id_producto in (2, 3);

---Eliminar los pedidos que tengan valoraciónes realizadas
delete from pedido where id_pedido=31;
