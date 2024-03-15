<?php
require_once('clases/Usuario.php');
require_once('clases/Deporte.php');
session_start();

if (isset($_SESSION['user'])) {
    $usuario = unserialize($_SESSION['user']);
}

if (isset($_POST['sendCalculadora'])) {
    if ($_POST['sexoRadio'] == 'mujerRadio') {
        $calorias = (65 + (9.6 * $_POST['peso'])) + ((1.8 * $_POST['altura']) - (4.7 * $_POST['edad'])) * $_POST['factorRadio'];
    } else {
        $calorias = (66 + (13.7 * $_POST['peso'])) + ((5 * $_POST['altura']) - (6.8 * $_POST['edad'])) * $_POST['factorRadio'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de calorías</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="css/global.css" rel="stylesheet">

    <script defer type="text/javascript" src="./forms/validacion_formularios.js"></script>
    <script src="https://kit.fontawesome.com/1bbcd94d9b.js" crossorigin="anonymous"></script>
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
                                        echo '<li><a class="dropdown-item" href="deportes.php?deporte=' . $deportes[$i]['nombre'] . '">' . $iconos[$i] . $deportes[$i]['nombre'] . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./calculadora.php">
                                    <i class="fa-solid fa-calculator me-1"></i>Calculadora de calorías
                                </a>
                            </li>
                            <li class="nav-item" style="justify-self: flex-end;">
                                <?php
                                if (isset($_SESSION['user'])) {
                                    echo '<li class="nav-item dropdown">';
                                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarUsuarioMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">'
                                        . $usuario['nombre'] . ' ' . $usuario['apellido1'] . ' ' . $usuario['apellido2'];

                                    echo '<img src="../resources/fotos_usuarios/' . $usuario['dni'] . '.png" alt="imgPerfil" width="30" height="30" style="border-radius: 100%;" class="ms-1">';

                                    echo '</a><ul class="dropdown-menu" aria-labelledby="navbarUsuarioMenu">
                                    <li>
                                    <a class="dropdown-item" href="./perfil.php">
                                    <i class="fa-solid fa-address-card me-1"></i>
                                    Perfil</a>';

                                    if ($usuario['tipo'] == 'administrador') {
                                        echo '<a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-user-gear me-1"></i>
                                        Administración de usuarios</a>';
                                    }

                                    echo '<hr />
                                    <div class="text-center"><a class="btn btn-danger" href="../index.php?accion=cerrar_sesion"><i class="fa-solid fa-right-from-bracket me-1"></i>Cerrar Sesión</a></div>
                                    </li>
                                </ul>';
                                    echo '</li>';
                                } else {
                                    echo '<a class="nav-link" href="./register_login.php">
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

    <main class="mt-5">
        <section class="container shadow-lg p-3 mb-5 bg-white rounder">
            <h2 class="h5 mb-3 text-center"> <b>Calculadora de calorías</b> </h2>
            <hr>

            <form name="frmCalculadora" id="frmCalculadora" method="post" action="#" novalidate>
                <fieldset class="border rounded-3 p-3 mb-3">
                    <legend class="float-none w-auto px-3 h6">Sexo</legend>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexoRadio" id="hombreRadio" required>
                        <label class="form-check-label" for="hombreRadio">
                            Hombre
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexoRadio" id="mujerRadio" required>
                        <label class="form-check-label" for="mujerRadio">
                            Mujer
                        </label>
                    </div>
                    <span id="sexoRadio-info" class="invalid-feedback"></span>
                </fieldset>

                <fieldset class="border rounded-3 p-3 mb-3">
                    <legend class="float-none w-auto px-3 h6">Altura y peso</legend>

                    <div class="d-flex justify-content-between">
                        <div class="input-group mb-3 me-3">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="altura" name="altura" placeholder="altura" required>
                                <label for="altura">Altura</label>
                            </div>
                            <span class="input-group-text">cm</span>
                            <span id="altura-info" class="invalid-feedback"></span>
                        </div>

                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="peso" name="peso" placeholder="altura" required>
                                <label for="peso">Peso</label>
                            </div>
                            <span class="input-group-text">kg</span>
                            <span id="peso-info" class="invalid-feedback"></span>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border rounded-3 p-3 mb-3">
                    <legend class="float-none w-auto px-3 h6">Edad</legend>

                    <div class="form-floating">
                        <input type="number" class="form-control" id="edad" name="edad" placeholder="edad" required>
                        <label for="edad">Edad</label>
                        <span id="edad-info" class="invalid-feedback"></span>
                    </div>
                </fieldset>

                <fieldset class="border rounded-3 p-3 mb-3">
                    <legend class="float-none w-auto px-3 h6">Factor de actividad</legend>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="factorRadio" id="sendentarioRadio" value="1.2" required>
                        <label class="form-check-label" for="sendentarioRadio">
                            Sedentario
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="factorRadio" id="pocoRadio" value="1.375" required>
                        <label class="form-check-label" for="pocoRadio">
                            Poca actividad física (ejercicio de 1 a 3 veces por semana)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="factorRadio" id="moderadoRadio" value="1.55" required>
                        <label class="form-check-label" for="moderadoRadio">
                            Actividad moderada (ejercicio de 4 a 5 veces por semana)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="factorRadio" id="intensoRadio" value="1.725" required>
                        <label class="form-check-label" for="intensoRadio">
                            Actividad intensa (ejercicio de 6 a 7 veces por semana)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="factorRadio" id="proRadio" value="1.9" required>
                        <label class="form-check-label" for="proRadio">
                            Atletas profesionales (entrenamientos de más de 4 horas diarias)
                        </label>
                    </div>
                    <span id="factorRadio-info" class="invalid-feedback"></span>
                </fieldset>

                <button type="submit" name="sendCalculadora" class="btn btn-primary w-100">Calcular</button>
            </form>
        </section>

        <?php
        if (isset($calorias)) {
            echo $calorias;
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
