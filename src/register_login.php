<?php
require_once('clases/Deporte.php');
require_once('clases/Usuario.php');
session_start();

$tipoForm = 'email';

if (isset($_POST['email'])) {
    $emailUsuario = $_POST['email'];
    if (Usuario::checkUsuarioByEmail($emailUsuario)) {
        $tipoForm = 'login';
    } else {
        $tipoForm = 'register';
    }
}

if (isset($_POST['sendRegistro'])) {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Se encripta contraseña
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $usuario = new Usuario($dni, $nombre, $apellido1, $apellido2, $pass_hash, $email, $dni . '.png', 'usuario');

    // Subimos a la base de datos
    if (Usuario::insert($usuario)) {
        // Se guarda imagen con nombre del DNI
        $ruta = './../resources/fotos_usuarios';
        move_uploaded_file($_FILES['imgUsuario']['tmp_name'], $ruta . '/' . $dni . '.png');
    }

    // Se crea la sesión
    $_SESSION['user'] = serialize($usuario);

    header('Location: ./../index.php');
}

if (isset($_POST['sendLogin'])) {
    $email = $_POST['emailLogin'];
    $pass = $_POST['passLogin'];

    $usuario = Usuario::getUsuarioByEmail($email);

    if (password_verify($pass, $usuario['pass'])) {
        $_SESSION['user'] = serialize($usuario);
        header('Location: ./../index.php');
    } else {
        echo '<div class="alert alert-danger" role="alert">';
        echo 'La constraseña es incorrecta';
        echo '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="css/global.css" rel="stylesheet">
    <script defer type="text/javascript" src="./forms/validacion_formularios.js"></script>
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
                                <a class="nav-link" href="#">Iniciar sesión</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="mt-5">
        <?php
        if ($tipoForm == 'email') {
        ?>
            <section class="container shadow-lg p-3 mb-5 bg-white rounded">
                <p class="text-center">Registrarse o iniciar sesión</p>
                <hr>
                <h2 class="h5 mb-3"><b>Bienvenido a eGym</b></h2>

                <form name="frmEmail" id="frmEmail" method="post" action="#" novalidate>
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                        <label for="email">Email</label>
                    </div>
                    <span id="email-info" class="invalid-feedback"></span>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Continuar</button>
                </form>
            </section>
        <?php
        }
        ?>

        <?php
        if ($tipoForm == 'register') {
        ?>
            <section class="container shadow-lg p-3 mb-5 bg-white rounded">
                <p class="text-center">Registrarse</p>
                <hr>
                <h2 class="h5 mb-3"><b>Bienvenido a eGym</b></h2>

                <form class="row g-3" name="frmRegister" id="frmRegister" method="post" action="#" enctype="multipart/form-data" novalidate>
                    <input type="email" class="form-control none" id="emailRegister" name="email" value="<?= $emailUsuario ?>">

                    <div class="form-floating col-md-6">
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="pass" required>
                        <label for="pass">Contraseña</label>
                        <span id="pass-info" class="invalid-feedback"></span>
                    </div>

                    <div class="form-floating col-md-6">
                        <input type="password" class="form-control" id="passRep" name="passRep" placeholder="passRep" required>
                        <label for="passRep">Repetir contraseña</label>
                        <span id="passRep-info" class="invalid-feedback"></span>
                    </div>

                    <div class="form-floating col-12">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre" required>
                        <label for="nombre">Nombre</label>
                        <span id="nombre-info" class="invalid-feedback"></span>
                    </div>

                    <div class="form-floating col-md-6">
                        <input type="text" class="form-control" id="apellido1" name="apellido1" placeholder="apellido1" required>
                        <label for="apellido1">Primer apellido</label>
                        <span id="apellido1-info" class="invalid-feedback"></span>
                    </div>

                    <div class="form-floating col-md-6">
                        <input type="text" class="form-control" id="apellido2" name="apellido2" placeholder="apellido2" required>
                        <label for="apellido2">Segundo apellido</label>
                        <span id="apellido2-info" class="invalid-feedback"></span>
                    </div>

                    <div class="form-floating col-md-12">
                        <input type="text" class="form-control " id="dni" name="dni" placeholder="dni" required>
                        <label for="dni">DNI</label>
                        <span id="dni-info" class="invalid-feedback"></span>
                    </div>

                    <div class="col-md-12">
                        <label for="imgUsuario" class="form-label">Imagen de usuario</label>
                        <input class="form-control" type="file" id="imgUsuario" name="imgUsuario" required>
                        <span id="imgUsuario-info" class="invalid-feedback"></span>
                    </div>

                    <div class="col-md-6">
                        <button type="button" class="btn btn-secondary w-100" onclick="location.href='./register_login.php';">Atrás</button>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" name="sendRegistro" class="btn btn-primary w-100">Registrarse</button>
                    </div>
                </form>
            </section>
        <?php
        }
        ?>

        <?php
        if ($tipoForm == 'login') {
        ?>
            <section class="container shadow-lg p-3 mb-5 bg-white rounded">
                <p class="text-center">Iniciar sesión</p>
                <hr>
                <h2 class="h5 mb-3"><b>Bienvenido a eGym</b></h2>

                <form name="frmLogin" id="frmLogin" method="post" action="#" novalidate>
                    <div class="row g-3">
                        <input type="email" class="form-control none" id="emailLogin" name="emailLogin" value="<?= $emailUsuario ?>">

                        <div class="col-md-12 form-floating mb-3">
                            <input type="password" class="form-control" id="passLogin" name="passLogin" placeholder="ejemplo" required>
                            <label for="passLogin">Contraseña</label>
                            <span id="passLogin-info" class="invalid-feedback"></span>
                        </div>

                        <div class="col-md-6">
                            <button type="button" class="btn btn-secondary w-100" onclick="location.href='./register_login.php';">Atrás</button>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="sendLogin" class="btn btn-primary w-100">Iniciar sesión</button>
                        </div>
                    </div>
            </section>
        <?php
        }
        ?>
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
