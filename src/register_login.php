<?php
if (isset($_SESSION['user'])) {
    session_start();
    require_once('clases/usuario.php');
    $usuario = unserialize($_SESSION['user']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register_login</title>
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/login.css">
    <script defer src="./forms/register_validation.js"></script>
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
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="signup">
                <form name="signup-form" method="post" action="forms/register.php" enctype="multipart/form-data">
                    <label for="chk">Sign up</label>
                    <div class="div-form">
                        <input type="text" name="nombre" placeholder="Nombre" required>
                        <input type="password" name="contraseña" placeholder="Contraseña" required>
                    </div>
                    <div class="div-form">
                        <input type="text" name="apellido1" placeholder="1º Apellido">
                        <input type="password" name="rep_contraseña" placeholder="Repite la contraseña" required>
                    </div>
                    <div class="div-form">
                        <input type="text" name="apellido2" placeholder="2º Apellido">
                        <input type="text" name="iban" placeholder="IBAN" required>
                    </div>
                    <div class="div-form">
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="text" name="dni" placeholder="DNI" required>
                    </div>
                    <div class="div-form">
                        <input type="file" name="imagen" placeholder="Foto perfil" required>
                    </div>

                    <button type="submit" name="submit">Sign up</button>
                </form>
            </div>

            <div class="login">
                <form name="signup-form" method="post" action="forms/login.php">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button type="submit">Login</button>
                </form>
            </div>
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