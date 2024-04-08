<?php
require_once('clases/Clase.php');
require_once('clases/Comentario.php');
require_once('clases/Usuario.php');
session_start();

if (isset($_SESSION['user'])) {
    $usuario = unserialize($_SESSION['user']);
}
$claseActual = Clase::getClaseById($_GET['clase']);

if (isset($_POST['sendComentario'])) {
    date_default_timezone_get();

    $dni = $usuario['dni'];
    $comentario = new Comentario($dni, $_POST['comentario'], date('Y-m-d'), $claseActual['idClase']);
    Comentario::insert($comentario);
}

$comentarios = Comentario::getAllByClase($claseActual['idClase']);

// se procesa el formulario para eliminar al usuario seleccionado y borrar la foto
if (isset($_POST['delete'])) {
    Comentario::delete($_POST["idComentario"]);
    header('Location: ./clases_videos.php?clase='.$claseActual['idClase'].'');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases videos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/1bbcd94d9b.js" crossorigin="anonymous"></script>

    <link href="css/global.css" rel="stylesheet">
</head>

<body>
    <main>
        <section>
            <h2 class="none">Video</h2>
            <video class="w-100" height="500" controls>
                <source src="./../resources/videos/<?= $claseActual['video'] ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </section>

        <section class="container">
            <?= '<h2>Comentarios (' . count($comentarios)  . ')</h2>' ?>

            <?php
            if (isset($usuario)) {
            ?>
                <form class="d-flex flex-column" method="post" action="#">
                    <div class="mb-3">
                        <label for="comentario" class="form-label">Añade un comentario</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
                    </div>

                    <button type="submit" name="sendComentario" class="btn btn-primary align-self-end">Comentar</button>
                </form>
            <?php
                if (count($comentarios) == 0) {
                    echo '<h3 class="h5"><b>Se el primero en comentar!!<b></h3>';
                }
            }

            echo '<article class="d-flex justify-content-around flex-wrap">';
            foreach ($comentarios as $comentario) {
                $comentador = Usuario::getUsuarioByDni($comentario['dni']);
                echo '<div class="card mt-5" style="width: 18rem;">';

                if (isset($usuario) && $usuario['tipo'] == 'administrador') {
                    echo '<form method="post" action="#" class="m-2 position-absolute top-0 end-0">
                        <input type="hidden" name="idComentario" value="' . $comentario['idComentario'] . '">
                        <button type="submit" name="delete" class="btn btn-light"><span style="color: #e90707;"> x </span></button>
                    </form>';
                }

                echo '<div class="card-body">
                        <h5 class="card-title">' . $comentador['nombre'] . ' ' . $comentador['apellido1'] . ' ' . $comentador['apellido2'] . '</h5>
                        <h6 class="card-subtitle mb-2 text-muted">' . $comentario['fecha'] . '</h6>
                        <p class="card-text">' . $comentario['texto'] . '</p>
                    </div>
                </div>
                ';
            }
            echo '</article>';
            ?>
        </section>
    </main>
</body>

</html>