<?php
require_once('src/clases/Deporte.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGym</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="src/css/global.css" rel="stylesheet">
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
                                    Deportes
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDeportesMenu">
                                    <?php
                                    $deportes = Deporte::getAll();

                                    foreach ($deportes as $deporte) {
                                        echo '<li><a class="dropdown-item" href="src/deportes.php?deporte=' . $deporte['nombre'] . '">' . $deporte['nombre'] . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Calculadora de calorías</a>
                            </li>
                            <li class="nav-item" style="justify-self: flex-end;">
                                <a class="nav-link" href="./src/register_login.php">Iniciar sesión</a>
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width: 100px;">
                        <path d="M96 64c0-17.7 14.3-32 32-32h32c17.7 0 32 14.3 32 32V224v64V448c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V384H64c-17.7 0-32-14.3-32-32V288c-17.7 0-32-14.3-32-32s14.3-32 32-32V160c0-17.7 14.3-32 32-32H96V64zm448 0v64h32c17.7 0 32 14.3 32 32v64c17.7 0 32 14.3 32 32s-14.3 32-32 32v64c0 17.7-14.3 32-32 32H544v64c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32V288 224 64c0-17.7 14.3-32 32-32h32c17.7 0 32 14.3 32 32zM416 224v64H224V224H416z" />
                    </svg>

                    <h3 class="fw-normal">Ejercítate en casa</h3>
                    <p>Hacer ejercicio en casa te brinda la comodidad de no tener que desplazarte a un gimnasio. Puedes adaptar tu horario de entrenamiento según tus necesidades y realizarlo en cualquier momento que te resulte conveniente. No tienes que preocuparte por el tráfico, los horarios de clase o las limitaciones de tiempo.</p>
                </article>
                <article class="col-lg-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width: 100px;">
                        <path d="M464 160c8.8 0 16 7.2 16 16V336c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16H464zM80 96C35.8 96 0 131.8 0 176V336c0 44.2 35.8 80 80 80H464c44.2 0 80-35.8 80-80V320c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32V176c0-44.2-35.8-80-80-80H80zm368 96H96V320H448V192z" />
                    </svg>

                    <h3 class="fw-normal">Ahorro económico</h3>
                    <p>Hacer deporte en casa puede ser más económico a largo plazo. No tienes que pagar una membresía de gimnasio mensual o cuotas adicionales por clases especializadas. Además, no necesitas invertir en equipos costosos, ya que hay muchas rutinas de ejercicio que puedes realizar con tu propio peso corporal o con equipamiento básico y accesible.</p>
                </article>
                <article class="col-lg-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 100px;">
                        <path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0zm0 66.8V444.8C394 378 431.1 230.1 432 141.4L256 66.8l0 0z" />
                    </svg>

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
                        <span class="fs-3">Nuestro teléfono
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 20px;">
                                <path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z" />
                            </svg>
                        </span>
                        <span>(+34) 634 199 341</span>
                        <hr class="mt-3">
                    </div>

                    <div class="d-flex flex-column">
                        <span class="fs-3">Nuestro correo
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 20px;">
                                <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                            </svg>
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
