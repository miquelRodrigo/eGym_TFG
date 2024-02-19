<?php
require_once('clases/Usuario.php');
session_start();
$EstaRegistrado;

if (isset($_SESSION['user'])) {
    $usuario = unserialize($_SESSION['user']);
    $EstaRegistrado = true;
} else {
    $EstaRegistrado = false;
}

// información deporte
require_once('clases/Deporte.php');
$deporte = Deporte::getByName($_GET['deporte']);
// parámetros db

//nivel y nombre de la clase
$nivel;
$nombreClase;

/* if ($EstaRegistrado) {
    $usuario = Usuario::getUsuarios_clases($_SESSION['user']->dni, $clase->nombreClase);
    $usuario->execute();
    while ($registro = $usuario->fetch()) {
        $nombreClase = $registro['nombreClase'];
        $nivel = $registro['nivel'];
    }
} else {
    $nivel = 'Regístrate para ver el contenido completo';
} */


//niveles de deporte
$niveles = ['principiante', 'intermedio', 'avanzado'];


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $deporte['nombre'] ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="css/global.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
            <div class="container-fluid">
                <a href="../index.php" class="navbar-brand mx-4">
                    <h1><b>e</b>Gym</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <span class="offcanvas-title" id="offcanvasNavbarLabel"><b>e</b>Gym</span>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDeportesMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Deportes
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDeportesMenu">
                                    <?php
                                    $deportes = Deporte::getAll();

                                    foreach ($deportes as $deporte) {
                                        echo '<li><a class="dropdown-item" href="deportes.php?deporte=' . $deporte['nombre'] . '">' . $deporte['nombre'] . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Calculadora de calorías</a>
                            </li>
                            <li class="nav-item" style="justify-self: flex-end;">
                                <a class="nav-link" href="register_login.php">Iniciar sesión</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <article id="deportes-resumen">
            <section id="box-section-header">
                <img src="../resources/imagenes/clases/<?php echo $clase->imagenClase ?>" alt="box">
                <div>
                    <h2><?php echo $clase->nombreClase ?></h2>
                    <p><?php echo $clase->descripcion ?></p>
                </div>
            </section>
            <section>
                <div>
                    <span><?php echo $nivel ?></span>
                </div>
                <?php
                if (isset($_SESSION['user'])) {
                    if (strcasecmp($usuario->tipo_usuario, 'administrador') == 0) {
                        echo
                        '
                        <div>
                            <a href="subir_video.php" id="no-morado">subir nuevo video</a>
                        </div>
                        ';
                    }
                }

                ?>
            </section>
        </article>
        <?php
        if (!$EstaRegistrado) { // si el usuario no está registrado podrá ver solo los videos de principiante
            echo
            '
            <article class="niveles-video">
            <div>
                <div></div><h2>Principiante</h2><div></div>
            </div>
            <section class="container-cards">
                ';
            foreach ($clase->videos as $video) { // una card por cada video
                if (strcasecmp($video->nivel, 'Principiante') == 0) { // cuyo nivel sea igual al del article
                    echo
                    '
                    <div class="card">
                        <video width="320" height="240" controls>
                            <source src="../resources/videos/' . $video->video . '" type="video/mp4">
                        </video>
                        <h3>' . $video->nombreVideo . '</h3>
                    </div>
                    ';
                }
            }
            echo '
            </section>
        </article>
        ';
        } else {
            foreach ($niveles as $lv) { // un article por nivel, 3 en total
                echo
                '
            <article class="niveles-video">
                <form method="post" action="forms/deportes.php">
                    <input type="hidden" name="deporte" value="' . $clase->nombreClase . '">
                <div>
                    <div></div>
                    <h2>' . $lv . '</h2>
                    <button type="submit" name="nivel" value=' . $lv . ' class="button-lv">Soy nivel ' . $lv . '</button>
                    <div></div>
                </div>
                <section class="container-cards">
                    ';
                foreach ($clase->videos as $video) { // una card por cada video
                    if ($video->nivel == $lv) { // cuyo nivel sea igual al del article
                        echo
                        '
                            <div class="card">
                                <video controls>
                                    <source src="../resources/videos/' . $video->video . '" type="video/mp4">
                                </video>
                                <h3>' . $video->nombreVideo . '</h3>
                            </div>
                            ';
                    }
                }
                echo '
                        </section>
                    </form>
                </article>
                ';
            }
        }

        ?>
    </main>

    <footer style="background-color: grey;">
        <h2 class="none">Footer</h2>
        <div class="d-flex my-5 flex-column text-center justify-content-center">
            <div class="p-0">
                <h3 class="text-black mb-2 fs-1"><b>e</b>Gym</h3>
            </div>
            <div class="container d-flex justify-content-center" style="color: white;">
                <hr style="width: 50%;">
            </div>
            <div>
                <a href="https://www.linkedin.com/" target="_blank"><img src="resources/iconos/linkedin.png" alt="linkedin" class="social-icon"></a>
                <a href="https://www.facebook.com/" target="_blank"><img src="resources/iconos/facebook.png" alt="facebook" class="social-icon"></a>
                <a href="https://twitter.com/" target="_blank"><img src="resources/iconos/twitter.png" alt="twitter" class="social-icon"></a>
                <a href="https://www.youtube.com/" target="_blank"><img src="resources/iconos/youtube.png" alt="youtube" class="social-icon"></a>
                <a href="https://www.instagram.com/" target="_blank"><img src="resources/iconos/instagram.png" alt="instagram" class="social-icon"></a>
            </div>
        </div>
        <div class="d-flex p-2 text-black bg-secondary">
            <span>Miquel Rodrigo Navarro | ©Copyright | www.egym.com | v.01</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
