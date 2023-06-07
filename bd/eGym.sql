create database eGym;
use eGym;

-- TABLA USUARIOS
create table usuarios (
	dni varchar(9),
	nombreUsuario varchar(30),
	apellido1 varchar(30),
	apellido2 varchar(30),
	contraseña varchar(255) not null,
	iban varchar(24) not null,
    mail varchar(255) not null unique,
    imagenUsuario varchar(50) unique,
	nivelCrossfit enum('principiante', 'intermedio', 'avanzado'),
	nivelCycling enum('principiante', 'intermedio', 'avanzado'),
	nivelCalistenia enum('principiante', 'intermedio', 'avanzado'),
	nivelBoxeo enum('principiante', 'intermedio', 'avanzado'),
	nivelNatacion enum('principiante', 'intermedio', 'avanzado'),
    tipo_usuario enum('usuario', 'administrador'),
	primary key (dni)
);

-- TABLA CLASES
create table clases (
	nombreClase varchar(10),
	imagenClase varchar(50) not null unique,
	descripcion text not null,
    primary key (nombreClase)
);

-- TABLA USUARIOS_CLASES
create table usuarios_clases (
	dniUsuario varchar(9),
    nombreClase varchar(10),
    primary key (dniUsuario, nombreClase),
    constraint FK_USUARIOSCLASES_USUARIOS foreign key (dniUsuario) references usuarios (dni) on delete cascade on update cascade,
    constraint FK_USUARIOSCLASES_CLASES foreign key (nombreClase) references clases (nombreClase) on delete cascade on update cascade
);

-- TABLA VIDEOS
create table videos (
	nombreVideo varchar(50),
    video varchar(50) not null unique,
    nivel enum('principiante', 'intermedio', 'avanzado') not null,
    nombreClase varchar(10),
    primary key (nombreVideo),
    constraint FK_VIDEOS_CLASES foreign key (nombreClase) references clases (nombreClase) on delete cascade on update cascade
);

INSERT INTO videos VALUES 
('boxeo avanzado', 'boxeo_avanzado.mp4', 'avanzado', 'Boxeo'), 
('boxeo intermedio', 'boxeo_intermedio.mp4', 'intermedio', 'Boxeo'), 
('boxeo principiante', 'boxeo_principiante.mp4', 'principiante', 'Boxeo'), 
('calistenia avanzado', 'calistenia_avanzado.mp4', 'avanzado', 'Calistenia'), 
('calistenia intermedio', 'calistenia_intermedio.mp4', 'intermedio', 'Calistenia'), 
('calistenia principiante', 'calistenia_princiante.mp4', 'principiante', 'Calistenia'), 
('crossfit avanzado', 'crossfit_avanzado.mp4', 'avanzado', 'Crossfit'), 
('crossfit intermedio', 'crossfit_intermedio.mp4', 'intermedio', 'Crossfit'), 
('crossfit principiante', 'crossfit_principiante.mp4', 'principiante', 'Crossfit'), 
('cycling avanzado', 'cycling_avanzado.mp4', 'avanzado', 'Cycling'), 
('cycling intermedio', 'cycling_intermedio.mp4', 'intermedio', 'Cycling'), 
('cycling principiante', 'cycling_principiante.mp4', 'principiante', 'Cycling'), 
('natacion avanzado', 'natacion_avanzado.mp4', 'avanzado', 'Natacion'), 
('natacion intermedio', 'natacion_intermedio.mp4', 'intermedio', 'Natacion'), 
('natacion principiante', 'natacion_principiante.mp4', 'principiante', 'Natacion');


-- TABLA COMENTARIOS
create table comentarios (
	idComentario int auto_increment,
    comentario text not null,
    fecha datetime not null,
    dniUsuario varchar(9),
    primary key(idComentario),
    constraint FK_COMENTARIOS_USUARIOS foreign key(dniUsuario) references usuarios (dni) on delete cascade on update cascade
);