<?php
require_once('clases/usuario.php');
session_start();
$EstaRegistrado;

if (isset($_SESSION['user'])) {
    $usuario = unserialize($_SESSION['user']);
    $EstaRegistrado = true;
} else {
    $EstaRegistrado = false;
}

// información deporte
require_once('clases/clase.php');
$clase;
// parámetros db
$host = 'localhost';
$dbname = 'egym';
$user = 'admin';
$password = 'admin';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
$conexion = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password, $options);

try {
    $select = $conexion->prepare('SELECT nombreClase, imagenClase, descripcion FROM clases WHERE nombreClase = :nombreClase');
    $select->bindParam(':nombreClase', $_POST['deporte']);
    $select->execute();

    while ($registro = $select->fetch()) {
        $clase = new Clase(
            $registro['nombreClase'],
            $registro['imagenClase'],
            $registro['descripcion']
        );
    }
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
}

//nivel del deporte
$nivel;
if ($EstaRegistrado) {
    if ($clase->nombreClase == 'Calistenia') {
        $nivel = $usuario->nivelCalistenia;
    } else if ($clase->nombreClase == 'Boxeo') {
        $nivel = $usuario->nivelBoxeo;
    } else if ($clase->nombreClase == 'Natacion') {
        $nivel = $usuario->nivelNatacion;
    } else if ($clase->nombreClase == 'Crossfit') {
        $nivel = $usuario->nivelCrossfit;
    } else {
        $nivel = $usuario->nivelCycling;
    }
} else {
    $nivel = 'Regístrate para ver el contenido completo';
}


//niveles de deporte
$niveles = ['Principiante', 'Intermedio', 'Avanzado'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>deporte</title>
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/depotes.css">
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
                    <li class="nav-li"><a href="register_login.php" class="link-nav">logear/registrar</a></li>
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
        <article id="deportes-resumen">
            <h2 class="none">article 1</h2>
            <section id="box-section-header">
                <h3><?php echo $clase->nombreClase ?></h3>
                <p><?php echo $clase->descripcion ?></p>
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
                            <a href="subir_video.php">subir nuevo video</a>
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
                <h2>Principiante</h2>
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
                echo '
                </section>
            </article>
            ';
            }
        } else {
            foreach ($niveles as $lv) { // un article por nivel, 3 en total
                echo
                '
                <article class="niveles-video">
                    <h2>' . $lv . '</h2>
                    <section class="container-cards">
                    ';
                foreach ($clase->videos as $video) { // una card por cada video
                    if (strcasecmp($video->nivel, $lv) == 0) { // cuyo nivel sea igual al del article
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
                    echo '
                    </section>
                </article>
                ';
                }
            }
        }

        ?>
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