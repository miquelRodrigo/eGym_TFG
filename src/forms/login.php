<?php
session_start();
//importar clase usuario
require_once('../clases/Usuario.php');

//se guardan los inputs del formulario
$email = $_POST['email'];
$cotraseña = $_POST['password'];

//variables globales para login
$correcto = false;
$usuario;

// parámetros db
$host = 'localhost';
$dbname = 'egym';
$user = 'admin';
$password = 'admin';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password, $options);

// consulta select
try {
    $select = $conexion->prepare('SELECT dni, nombreUsuario, apellido1, apellido2, contraseña, 
    mail, imagenUsuario, tipoUsuario
    FROM usuarios where mail = :mail');

    $select->bindParam(':mail', $email);
    $select->execute();
    // si existe el mail verificamos contraseña
    while ($registro = $select->fetch()) {
        // si la contraseña es correcta se crea sesion usuario
        if (password_verify($cotraseña, $registro['contraseña'])) {
            $usuario = new Usuario(
                $registro['dni'],
                $registro['nombreUsuario'],
                $registro['apellido1'],
                $registro['apellido2'],
                $registro['contraseña'],
                $registro['mail'],
                $registro['imagenUsuario'],
                $registro['tipoUsuario']
            );
            $_SESSION['user'] = serialize($usuario);
            header('Location: ../../index.php');
        } else { // si no redirije a login otra vez
            header('Location: ../register_login.html');
        }
    }
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
}
