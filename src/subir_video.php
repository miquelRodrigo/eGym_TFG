<?php
require_once('clases/Deporte.php');
require_once('clases/clase.php');
session_start();

if (isset($_SESSION['user'])) {
    $usuario = unserialize($_SESSION['user']);
} else {
    header('Location: ./../index.php');
}

if (isset($_GET['accion'])) {
    session_destroy();
    header('Location: ./index.php');
}

if (isset($_POST['sendVideo'])) {
    $nombreClase = $_POST['nombreClase'];
    $deporte = $_POST['deporte'];
    $dificultad = $_POST['dificultad'];
    $nombreVideo =  str_replace(" ", "_", $nombreClase) . '.mp4';


    $clase = new Clase($nombreClase, $nombreVideo, $dificultad, $deporte);
    if (Clase::insert($clase)) {
        $ruta = './../resources/videos';
        move_uploaded_file($_FILES['videoClase']['tmp_name'], $ruta . "/" . $nombreVideo);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>subir video</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="css/global.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/1bbcd94d9b.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
            <div class="container-fluid">
                <a href="./../index.php" class="navbar-brand mx-4">
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
                                        echo '<li><a class="dropdown-item" href="./deportes.php?deporte=' . $deportes[$i]['nombre'] . '">' . $iconos[$i] . $deportes[$i]['nombre'] . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php if (isset($usuario)) {
                                echo '<li class="nav-item">
                                <a class="nav-link" href="./calculadora.php">
                                    <i class="fa-solid fa-calculator me-1"></i>Calculadora de calorías
                                </a>
                                </li>';
                            } ?>
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
                                        echo '
                                        <a class="dropdown-item" href="./subir_video.php">
                                        <i class="fa-solid fa-video me-1"></i>
                                        Subir video</a>
                                        <a class="dropdown-item" href="./admin_users.php">
                                        <i class="fa-solid fa-user-gear me-1"></i>
                                        Administración de usuarios</a>
                                        ';
                                    }

                                    echo '<hr />
                                    <div class="text-center"><a class="btn btn-danger" href="./../index.php?accion=cerrar_sesion"><i class="fa-solid fa-right-from-bracket me-1"></i>Cerrar Sesión</a></div>
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
    <main>
        <section class="mt-5 container col-lg-6 shadow-lg p-3 mb-5 bg-white rounded">
            <h2 class="h5 mb-3 text-center"> <b>Subir nuevo video</b> </h2>
            <hr>

            <form class="row g-3" name="frmSubirVideo" id="frmSubirVideo" method="post" action="#" enctype="multipart/form-data">

                <div class="form-floating col-md-6">
                    <input type="text" class="form-control" id="nombreClase" name="nombreClase" placeholder="nombre" required>
                    <label for="nombreClase">Nombre de la clase</label>
                    <span id="nombreClase-info" class="invalid-feedback"></span>
                </div>

                <select name="deporte" id="deporte" class="form-floating col-md-6">
                    <option value="1">Boxeo</option>
                    <option value="2">Calistenia</option>
                    <option value="3">Crossfit</option>
                    <option value="4">Cycling</option>
                    <option value="5">Natacion</option>
                </select>


                <div class="form-floating col-md-6">
                    <legend class="float-none w-auto px-3 h6">Dificultad de la clase</legend>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="dificultad" id="principiante" value="principiante" required>
                        <label class="form-check-label" for="principiante">
                            Principiante
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="dificultad" id="intermedio" value="intermedio" required>
                        <label class="form-check-label" for="intermedio">
                            Intermedio
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="dificultad" id="avanzado" value="avanzado" required>
                        <label class="form-check-label" for="avanzado">
                            Avanzado
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="videoClase" class="form-label">Archivo de video</label>
                    <input class="form-control" type="file" id="videoClase" name="videoClase" required>
                    <span id="videoClase-info" class="invalid-feedback"></span>
                </div>

                <div>
                    <button type="submit" name="sendVideo" class="btn btn-primary w-100">Subir video</button>
                </div>
            </form>
        </section>
    </main>

    <footer class="w-100" style="background-color: grey;">
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