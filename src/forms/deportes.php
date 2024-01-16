<?php
//importar clase usuario
require_once('../clases/Usuario.php');
session_start();
$usuario = unserialize($_SESSION['user']);

//se guardan los inputs del formulario
$nombreClase = $_POST['deporte'];
$nivel = $_POST['nivel'];

echo $nombreClase;
echo $nivel;

//!FIXME
//se comprueba que nivel cambiar
if ($nombreClase == 'Calistenia') {
    $usuario->nivelCalistenia = $nivel;
} else if ($nombreClase == 'Boxeo') {
    $usuario->nivelBoxeo = $nivel;
} else if ($nombreClase == 'Natacion') {
    $usuario->nivelNatacion = $nivel;
} else if ($nombreClase == 'Crossfit') {
    $usuario->nivelCrossfit = $nivel;
} else {
    $usuario->nivelCycling = $nivel;
}

print_r($usuario);
$_SESSION['user'] = serialize($usuario);

header('Location: ../perfil.php');
