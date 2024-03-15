<?php
require_once('src/clases/Deporte.php');
session_start();

if (isset($_SESSION['user'])) {
    $usuario = unserialize($_SESSION['user']);
}

if (isset($_GET['accion'])) {
    session_destroy();
    header('Location: ./index.php');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGym</title>

    <link href="https:cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="src/css/global.css" rel="stylesheet">

    <script src="https:kit.fontawesome.com/1bbcd94d9b.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
            <div class="container-fluid">
                <a href="#" class="navbar-brand mx-4">
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
                                    <i class="fa-solid fa-heart-pulse me-1"></i>Deportes
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDeportesMenu">
                                    <?php
                                    $deportes = Deporte::getAll();

                                    $iconos = [
                                        '<i class="fa-solid fa-hand-fist me-1"></i>',
                                        '<i class="fa-solid fa-person-running me-1"></i>',
                                        '<i class="fa-solid fa-weight-hanging me-1"></i>',
                                        '<i class="fa-solid fa-bicycle me-1"></i>',
                                        '<i class="fa-solid fa-person-swimming me-1"></i>',
                                    ];

                                    for ($i = 0; $i < count($deportes); $i++) {
                                        echo '<li><a class="dropdown-item" href="src/deportes.php?deporte=' . $deportes[$i]['nombre'] . '">' . $iconos[$i] . $deportes[$i]['nombre'] . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./src/calculadora.php">
                                    <i class="fa-solid fa-calculator me-1"></i>Calculadora de calorías
                                </a>
                            </li>
                            <li class="nav-item" style="justify-self: flex-end;">
                                <?php
                                if (isset($_SESSION['user'])) {
                                    echo '<li class="nav-item dropdown">';
                                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarUsuarioMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">'
                                        . $usuario['nombre'] . ' ' . $usuario['apellido1'] . ' ' . $usuario['apellido2'];

                                    echo '<img src="./resources/fotos_usuarios/' . $usuario['dni'] . '.png" alt="imgPerfil" width="30" height="30" style="border-radius: 100%;" class="ms-1">';

                                    echo '</a><ul class="dropdown-menu" aria-labelledby="navbarUsuarioMenu">
                                    <li>
                                    <a class="dropdown-item" href="./src/perfil.php">
                                    <i class="fa-solid fa-address-card me-1"></i>
                                    Perfil</a>';

                                    if ($usuario['tipo'] == 'administrador') {
                                        echo '<a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-user-gear me-1"></i>
                                        Administración de usuarios</a>';
                                    }

                                    echo '<hr />
                                    <div class="text-center"><a class="btn btn-danger" href="index.php?accion=cerrar_sesion"><i class="fa-solid fa-right-from-bracket me-1"></i>Cerrar Sesión</a></div>
                                    </li>
                                </ul>';
                                    echo '</li>';
                                } else {
                                    echo '<a class="nav-link" href="./src/register_login.php">
                                    Iniciar sesión<i class="fa-solid fa-right-to-bracket ms-1"></i>
                                    </a>';
                                }
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav> 
    </header>

    <main>
        <!-- Carrusel -->
        <section>
            <div id="carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./resources/imagenes/indexSection2Principiante.jpg" alt="carruselImagen1" />

                        <div class="container">
                            <div class="carousel-caption text-start">
                                <h1>Example headline.</h1>
                                <p>Some representative placeholder content for the first slide of the carousel.</p>
                                <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./resources/imagenes/indexSection2Intermedio.jpg" alt="carruselImagen2" />

                        <div class="container">
                            <div class="carousel-caption text-start">
                                <h1>Another example headline.</h1>
                                <p>Some representative placeholder content for the second slide of the carousel.</p>
                                <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./resources/imagenes/indexSection2Avanzado.jpg" alt="carruselImagen3" />

                        <div class="container">
                            <div class="carousel-caption text-start">
                                <h1>One more for good measure.</h1>
                                <p>Some representative placeholder content for the third slide of this carousel.</p>
                                <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- Pros -->
        <section class="container text-center">
            <div class="d-flex justify-content-center align-items-center">
                <hr class="w-50 me-3">
                <h2 style="font-size: 3em;">Piensalo</h2>
                <hr class="w-50 ms-3">
            </div>
            <div class="row">
                <article class="col-lg-4">
                    <i class="fa-solid fa-dumbbell d-block fa-6x" style="color: black;"></i>

                    <h3 class="fw-normal">Ejercítate en casa</h3>
                    <p>Hacer ejercicio en casa te brinda la comodidad de no tener que desplazarte a un gimnasio. Puedes adaptar tu horario de entrenamiento según tus necesidades y realizarlo en cualquier momento que te resulte conveniente. No tienes que preocuparte por el tráfico, los horarios de clase o las limitaciones de tiempo.</p>
                </article>
                <article class="col-lg-4">
                    <i class="fa-solid fa-battery-full d-block fa-6x" style="color: black;"></i>

                    <h3 class="fw-normal">Ahorro económico</h3>
                    <p>Hacer deporte en casa puede ser más económico a largo plazo. No tienes que pagar una membresía de gimnasio mensual o cuotas adicionales por clases especializadas. Además, no necesitas invertir en equipos costosos, ya que hay muchas rutinas de ejercicio que puedes realizar con tu propio peso corporal o con equipamiento básico y accesible.</p>
                </article>
                <article class="col-lg-4">
                    <i class="fa-solid fa-shield-halved d-block fa-6x" style="color: black;"></i>

                    <h3 class="fw-normal">Privacidad y comodidad</h3>
                    <p>Al hacer ejercicio en casa, tienes la ventaja de tener total privacidad. No tienes que preocuparte por la presencia de otras personas, lo que puede resultar especialmente beneficioso si te sientes cohibido o inseguro al hacer ejercicio en público.</p>
                </article>
            </div>
        </section>

        <!-- Niveles -->
        <section class="container text-center">
            <div class="d-flex justify-content-center align-items-center">
                <hr class="w-50 me-3">
                <h2 style="font-size: 3em;">Niveles</h2>
                <hr class="w-50 ms-3">
            </div>

            <article class="row">
                <div class="col-md-7 d-flex flex-column justify-content-center">
                    <h3 class="fw-normal lh-1">Principiante</h3>
                    <p class="lead">Recuerda, cada campeón comenzó como un principiante, y tú estás en el camino para convertirte en uno. Habrá momentos en los que te sentirás agotado, desmotivado o incluso tentado a rendirte. Pero permíteme recordarte que dentro de ti hay una fuerza inquebrantable, una determinación que te llevará más allá de tus límites.</p>
                </div>
                <div class="col-md-5">
                    <img width="500" height="500" class="img-fluid mx-auto" src="./resources/imagenes/principiante.png" alt="imagenPrincipiante">
                </div>
            </article>

            <hr class="m-4">

            <article class="row">
                <div class="col-md-7 order-md-2 d-flex flex-column justify-content-center">
                    <h3 class="fw-normal lh-1">Intermedio</h3>
                    <p class="lead">No te compares con los demás, tu único competidor eres tú mismo(a). Cada persona tiene su propio ritmo de progreso, y lo importante es que estás dando lo mejor de ti en cada entrenamiento y en cada competencia. Celebra tus avances y aprende de tus errores, ya que cada experiencia te brinda la oportunidad de mejorar.</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <img width="500" height="500" class="img-fluid mx-auto" src="./resources/imagenes/intermedio.png" alt="imagenIntermedio">
                </div>
            </article>

            <hr class="m-4">

            <article class="row">
                <div class="col-md-7 d-flex flex-column justify-content-center">
                    <h3 class="fw-normal lh-1">Avanzado</h3>
                    <p class="lead">No importa cuánto tiempo hayas estado involucrado(a) en el deporte, lo que importa es tu dedicación y tu pasión por mejorar. Cada día que te levantas y te esfuerzas por ser un poco mejor, estás marcando la diferencia. Aprecia y celebra cada pequeño logro en tu camino, ya que son los cimientos para construir grandes triunfos en el futuro.</p>
                </div>
                <div class="col-md-5">
                    <img width="500" height="500" class="img-fluid mx-auto" src="./resources/imagenes/avanzado.png" alt="imagenAvanzado">
                </div>
            </article>
        </section>

        <!-- Contáctanos -->
        <section class="container text-center">
            <div class="d-flex justify-content-center align-items-center">
                <hr class="w-50 me-3">
                <h2 style="font-size: 3em;">Contáctanos</h2>
                <hr class="w-50 ms-3">
            </div>

            <article class="row">
                <div class="col-md-6 d-flex flex-column justify-content-around align-items-center">
                    <div class="d-flex flex-column">
                        <span class="fs-3">
                            Nuestro teléfono
                            <i class="fa-solid fa-phone" style="color: black;"></i>
                        </span>
                        <span>(+34) 634 199 341</span>
                        <hr class="mt-3">
                    </div>

                    <div class="d-flex flex-column">
                        <span class="fs-3">
                            Nuestro correo
                            <i class="fa-solid fa-envelope" style="color: black;"></i>
                        </span>
                        <span>egym@gmail.com</span>
                        <hr class="mt-3">
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="./resources/imagenes/contactanos.jpg" alt="imagenContacto" width="500" height="500" class="img-fluid mx-auto">
                </div>
            </article>
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
                <a href="https:www.linkedin.com/" target="_blank"><img src="resources/iconos/linkedin.png" alt="linkedin" class="social-icon"></a>
                <a href="https:www.facebook.com/" target="_blank"><img src="resources/iconos/facebook.png" alt="facebook" class="social-icon"></a>
                <a href="https:twitter.com/" target="_blank"><img src="resources/iconos/twitter.png" alt="twitter" class="social-icon"></a>
                <a href="https:www.youtube.com/" target="_blank"><img src="resources/iconos/youtube.png" alt="youtube" class="social-icon"></a>
                <a href="https:www.instagram.com/" target="_blank"><img src="resources/iconos/instagram.png" alt="instagram" class="social-icon"></a>
            </div>
        </div>
        <div class="d-flex p-2 text-black bg-secondary">
            <span>Miquel Rodrigo Navarro | ©Copyright | www.egym.com | v.01</span>
        </div>
    </footer>

    <script src="https:cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
