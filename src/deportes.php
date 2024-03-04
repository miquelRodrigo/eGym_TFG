<?php
require_once('clases/Usuario.php');
require_once('clases/Deporte.php');
require_once('clases/Clase.php');
session_start();

if (isset($_SESSION['user'])) {
    $usuario = unserialize($_SESSION['user']);
}
// Información deporte
$deporteActual = Deporte::getByName($_GET['deporte']);

// Información clases
$clases = Clase::getByDeporte($deporteActual['idDeporte']);

// Niveles de deporte
$niveles = ['principiante', 'intermedio', 'avanzado'];

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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $deporteActual['nombre'] ?></title>

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
                                <a class="nav-link" href="./calculadora.php">Calculadora de calorías</a>
                            </li>
                            <li class="nav-item" style="justify-self: flex-end;">
                            <?php
                                if (isset($_SESSION['user'])) {
                                    echo '<a class="nav-link" href="#">'.
                                    $usuario['nombre'] . ' ' . $usuario['apellido1'] . ' ' . $usuario['apellido2']
                                    .'</a>';
                                } else {
                                    echo '<a class="nav-link" href="./src/register_login.php">Iniciar sesión</a>';
                                }
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="mt-5">
        <section>
            <div style="background-image: url('../resources/imagenes/deportes/<?= $deporteActual['imagen'] ?>'); height: 700px;" class="container">
                <h2><b><?= $deporteActual['nombre'] ?></b></h2>
            </div>
        </section>

        <section class="text-center">
            <h2> Clases </h2>

            <div class="d-flex">
                <article class="w-75">
                    <h3 class="none"> Videos </h3>
                    <iframe src="./../index.php" name="video_clase" class="w-100" height="700"></iframe>
                </article>

                <article class="w-25">
                    <h3 class="none"> Niveles </h3>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Principiante
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <?php
                                    foreach ($clases as $clase) {
                                        if ($clase['nivel'] == $niveles[0]) {
                                            echo '<div class="container mb-4 d-flex justify-content-start"><a href="./clases_videos.php?clase=' . $clase['idClase'] . '" target="video_clase">'
                                                . $clase['nombre'] .
                                                '</a></div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    Intermedio
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <?php
                                    foreach ($clases as $clase) {
                                        if ($clase['nivel'] == $niveles[1]) {
                                            echo '<div class="container mb-4 d-flex justify-content-start"><a href="./clases_videos.php?clase=' . $clase['idClase'] . '" target="video_clase">'
                                                . $clase['nombre'] .
                                                '</a></div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                    Avanzado
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <?php
                                    foreach ($clases as $clase) {
                                        if ($clase['nivel'] == $niveles[2]) {
                                            echo '<div class="container mb-4 d-flex justify-content-start"><a href="./clases_videos.php?clase=' . $clase['idClase'] . '" target="video_clase">'
                                                . $clase['nombre'] .
                                                '</a></div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
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
                <a href="https://www.linkedin.com/" target="_blank"><img src="../resources/iconos/linkedin.png" alt="linkedin" class="social-icon"></a>
                <a href="https://www.facebook.com/" target="_blank"><img src="../resources/iconos/facebook.png" alt="facebook" class="social-icon"></a>
                <a href="https://twitter.com/" target="_blank"><img src="../resources/iconos/twitter.png" alt="twitter" class="social-icon"></a>
                <a href="https://www.youtube.com/" target="_blank"><img src="../resources/iconos/youtube.png" alt="youtube" class="social-icon"></a>
                <a href="https://www.instagram.com/" target="_blank"><img src="../resources/iconos/instagram.png" alt="instagram" class="social-icon"></a>
            </div>
        </div>
        <div class="d-flex p-2 text-black bg-secondary">
            <span>Miquel Rodrigo Navarro | ©Copyright | www.egym.com | v.01</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
