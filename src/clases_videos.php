<?php
require_once('clases/Clase.php');
require_once('clases/Comentario.php');

$claseActual = Clase::getClaseById($_GET['clase']);
$comentarios = Comentario::getAllByClase($claseActual['idClase'])
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

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

            <form class="d-flex flex-column">
                <div class="mb-3">
                    <label for="comentario" class="form-label">Añade un comentario</label>
                    <textarea class="form-control" id="comentario" rows="3"></textarea>
                </div>

                <button type="button" class="btn btn-primary align-self-end">Comentar</button>
            </form>

            <?php
            if (count($comentarios) == 0) {
                echo '<h3 class="h5"><b>Se el primero en comentar!!<b></h3>';
            }

            foreach ($comentarios as $comentario) {
                echo $comentario['texto'];
            }
            ?>
        </section>
    </main>
</body>

</html>
