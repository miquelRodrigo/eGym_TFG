<?php
require_once('clases/usuario.php');
session_start();

if(isset($_SESSION['user'])) {
    $usuario = unserialize($_SESSION['user']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>perfil</title>
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <header>
        <div>
            <a href="../index.php">
                <h1><b>e</b>Gym</h1>
            </a>
        </div>
        <div>
            <nav>
                <ul>
                    <li class="nav-li"><a href="#" class="link-nav">calculadora</a></li>
                    <li class="nav-li">
                        <div class="dropdown">
                            <span>deportes</span>
                            <div class="dropdown-content">
                                <form action="src/deportes.php" method="post">
                                    <input type="hidden" name="deporte" value="Calistenia">
                                    <button type="submit" class="first-option-dropdown button-dropdown">calistenia</button>
                                </form>
                                <form action="deportes.php" method="post">
                                    <input type="hidden" name="deporte" value="Boxeo">
                                    <button type="submit" class="button-dropdown">boxeo</button>
                                </form>
                                <form action="deportes.php" method="post">
                                    <input type="hidden" name="deporte" value="Cycling">
                                    <button type="submit" class="button-dropdown">cycling</button>
                                </form>
                                <form action="deportes.php" method="post">
                                    <input type="hidden" name="deporte" value="Crossfit">
                                    <button type="submit" class="button-dropdown">crossfit</button>
                                </form>
                                <form action="deportes.php" method="post">
                                    <input type="hidden" name="deporte" value="Natacion">
                                    <button type="submit" class="button-dropdown">natación</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li class="nav-li"><a href="#" class="link-nav">mapa web</a></li>
                    <li class="nav-li"><a href="#" class="link-nav">accesibilidad</a></li>
                    <li class="nav-li"><a href="src/register_login.html" class="link-nav">logear/registrar</a></li>
                </ul>
            </nav>
        </div>
        <div>
            <?php
            if (isset($_SESSION['user'])) {
                echo '<a href="perfil.php"><img src="../resources/fotos_usuarios/' . $usuario->imagenUsuario . '.png" alt="userImage" id="user-image"></a>';
            } else {
                echo '<img src="../resources/fotos_usuarios/user.png" alt="userImage" id="user-image">';
            }
            ?>
        </div>
    </header>
    <main>

        <article id="container">
            <h2 class="none">login-reistro</h2>



            <section class="signup login-signup">

                <img src="../resources/fotos_usuarios/<?php
                                                        echo $usuario->imagenUsuario ?>.png" alt="userImage" id="perfil-user-image">
                <div>
                    <span><?php echo $usuario->nombreUsuario ?></span><br>
                    <span><?php echo $usuario->apellido1 . ' ' . $usuario->apellido2 ?></span>
                </div>

            </section>

            <section class="login login-login">
                <div id="sesion">
                    <form method="post" action="#">
                        <button type="submit" name="cerrar_sesion">Cerrar sesión</button>
                        <button type="submit" name="darse_baja">Darse de baja</button>
                        <?php
                        if ($usuario->tipo_usuario == 'administrador') {
                            echo $usuario->tipo_usuario;
                            echo $usuario->dni;
                            echo '<button type="submit" name="administrar_usuarios">Administrar usuarios</button>';
                        }
                        ?>

                    </form>
                    <?php
                    if (isset($_POST['cerrar_sesion'])) {
                        session_destroy();
                        header('Location: ../index.php');
                    } else if (isset($_POST['darse_baja'])) {
                        unlink('../resources/fotos_usuarios/' . $usuario->imagenUsuario . '.png');
                        session_destroy();
                        $usuario->delete($usuario->dni);
                        header('Location: ../index.php');
                    } else if (isset($_POST['administrar_usuarios'])) {
                        header('Location: admin_users.php');
                    }
                    ?>
                </div>
                <div id="linea"></div>
                <div id="niveles">
                    <span><b>Natación</b><?php echo ' ' . $usuario->nivelNatacion ?></span>
                    <span><b>Crossfit</b><?php echo ' ' . $usuario->nivelCrossfit ?></span>
                    <span><b>Cycling</b><?php echo ' ' . $usuario->nivelCycling ?></span>
                    <span><b>Boxeo</b><?php echo ' ' . $usuario->nivelBoxeo ?></span>
                    <span><b>Calistenia</b><?php echo ' ' . $usuario->nivelCalistenia ?></span>
                </div>
            </section>
        </article>




    </main>
    <footer>
        <article>
            <h2 class="none"></h2>
            <section>
                <div id="box-title">
                    <h3><b>e</b>Gym</h3>
                </div>
                <div id="box-icons">
                    <a href="#"><img src="../resources/iconos/linkedin.png" alt="linkedin" class="social-icon"></a>
                    <a href="#"><img src="../resources/iconos/facebook.png" alt="facebook" class="social-icon"></a>
                    <a href="#"><img src="../resources/iconos/twitter.png" alt="twitter" class="social-icon"></a>
                    <a href="#"><img src="../resources/iconos/youtube.png" alt="youtube" class="social-icon"></a>
                    <a href="#"><img src="../resources/iconos/instagram.png" alt="instagram" class="social-icon"></a>
                </div>
            </section>
        </article>
        <article id="web-info">
            <span>Miquel Rodrigo Navarro | @Copyright | www.egym.com | v.01</span>
        </article>
    </footer>
</body>

</html>