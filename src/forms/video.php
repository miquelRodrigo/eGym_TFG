<?php
//importar clase video
require_once('../clases/video.php');

//se guardan inputs del formulario
$deporte = $_POST['deporte'];
$dificultad = $_POST['dificultad'];
$nombreVideo = $_POST['nombreVideo'];
$video = $nombreVideo . '.<mp4';

//se guarda video en servidor
$ruta = '../../resources/videos/';
$ficheroSubido = $ruta . basename($video);
if (isset($_FILES['video'])) {
    move_uploaded_file($_FILES['video']['tmp_name'], $ficheroSubido);
}
// se instancia clase video
$video = new Video($nombreVideo, $video, $dificultad, $nombreClase);

$video->insert();
header('Location: ../../index.php');