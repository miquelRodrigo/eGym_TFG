<?php
//importar clase usuario
require_once('../clases/usuario.php');

//guardamos los inputs del formulario
$nombreUsuario = $_POST['nombre'];
$mail = $_POST['email'];
$dni = $_POST['dni'];
$iban = $_POST['iban'];

//comprobamos si los apellidos están seteados
if (isset($_POST['apellido1'])) {
    $apellido1 = $_POST['apellido1'];
} else {
    $apellido1 = "";
}

if (isset($_POST['apellido2'])) {
    $apellido2 = $_POST['apellido2'];
} else {
    $apellido2 = "";
}
//se encripta contraseña
$contraseña_hash = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

//se guarda imagen con nombre del mail + tipo de imagen
$mail_name = substr($mail, 0, strpos($mail, '@'));
$ruta = '../../resources/fotos_usuarios';
if (isset($_FILES['imagen'])) {
    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta . '/' . $mail_name . '.png');
}

//instanciamos clase usuario
$usuario = new Usuario($dni, $nombreUsuario, $apellido1, $apellido2, $contraseña_hash, $iban, $mail, $mail_name, 'principiante', 'principiante', 'principiante', 'principiante', 'principiante', 'usuario');

//subimos a la base de datos
$usuario->insert();
$_SESSION['user'] = serialize($usuario);

header('Location: ../../index.php');
