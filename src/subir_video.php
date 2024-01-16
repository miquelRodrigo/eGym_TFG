<?php
session_start();
require_once('clases/Usuario.php');
$usuario = unserialize($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>subir_video</title>
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/forms.css">
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
                    <li class="nav-li">
                        <div class="dropdown">
                            <span>deportes</span>
                            <div class="dropdown-content">
                                <form action="deportes.php" method="post">
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
                    <li class="nav-li"><a href="register_login.php" class="link-nav">logear/registrar</a></li>
                </ul>
            </nav>
        </div>
        <div>
            <?php
            if (isset($_SESSION['user'])) {
                echo '<img src="../resources/fotos_usuarios/' . $usuario->imagenUsuario . '.png" alt="userImage" id="user-image">';
            } else {
                echo '<img src="../resources/fotos_usuarios/user.png" alt="userImage" id="user-image">';
            }
            ?>
        </div>
    </header>
    <main>
        <article id="container">
            <form method="post" action="forms/video.php" enctype="multipart/form-data">
                <section class="section1-form section1-form-video">
                    <div>
                        <select name="deporte" required>
                            <option disabled selected hidden>Deportes</option>
                            <option value="Boxeo">Boxeo</option>
                            <option value="Crossfit">Crosffit</option>
                            <option value="Cycling">Cycling</option>
                            <option value="Natacion">Natacion</option>
                            <option value="Calistenia">Calistenia</option>
                        </select>
                        <select name="dificultad" required>
                            <option disabled selected hidden>Dificultad</option>
                            <option value="principiante">Principiante</option>
                            <option value="intermedio">Intermedio</option>
                            <option value="avanzado">Avanzado</option>
                        </select>
                    </div>
                    <fieldset>
                        <legend>Archivo:</legend>
                        <input type="file" name="video" placeholder="video" required>
                        <input type="text" name="nombreVideo" placeholder="Nombre del video">
                    </fieldset>
                </section>

                <section class="section2-form-video section2-form">
                    <button type="submit" id="button-video">Subir video</button>
                </section>
            </form>



        </article>
    </main>
    <footer>
        <h2 class="none"></h2>
        <div>
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
        </div>
        <div id="web-info">
            <span>Miquel Rodrigo Navarro | ©Copyright | www.egym.com | v.01</span>
        </div>
    </footer>
</body>

</html>
