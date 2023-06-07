<?php
require_once('src/clases/usuario.php');
session_start();

if (isset($_SESSION['user'])) {
    $usuario = unserialize($_SESSION['user']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="src/css/header_footer.css">
    <link rel="stylesheet" href="src/css/index.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div>
            <h1><b>e</b>Gym</h1>
        </div>
        <div>
            <nav>
                <ul>
                    <li class="nav-li">
                        <div class="dropdown">
                            <span>deportes</span>
                            <div class="dropdown-content">
                                <form action="src/deportes.php" method="post">
                                    <input type="hidden" name="deporte" value="Calistenia">
                                    <button type="submit" class="first-option-dropdown button-dropdown">calistenia</button>
                                </form>
                                <form action="src/deportes.php" method="post">
                                    <input type="hidden" name="deporte" value="Boxeo">
                                    <button type="submit" class="button-dropdown">boxeo</button>
                                </form>
                                <form action="src/deportes.php" method="post">
                                    <input type="hidden" name="deporte" value="Cycling">
                                    <button type="submit" class="button-dropdown">cycling</button>
                                </form>
                                <form action="src/deportes.php" method="post">
                                    <input type="hidden" name="deporte" value="Crossfit">
                                    <button type="submit" class="button-dropdown">crossfit</button>
                                </form>
                                <form action="src/deportes.php" method="post">
                                    <input type="hidden" name="deporte" value="Natacion">
                                    <button type="submit" class="button-dropdown">natación</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li class="nav-li"><a href="src/register_login.php" class="link-nav">logear/registrar</a></li>
                </ul>
            </nav>
        </div>
        <div>
            <?php
            if (isset($_SESSION['user'])) {
                echo '<a href="src/perfil.php"><img src="resources/fotos_usuarios/' . $usuario->imagenUsuario . '.png" alt="userImage" id="user-image"></a>';
            } else {
                echo '<img src="resources/fotos_usuarios/user.png" alt="userImage" id="user-image">';
            }
            ?>
        </div>
    </header>

    <main>
        <article id="article1">
            <h2 class="none">article 1</h2>
            <section id="box-section-header">
                <h3>Ejercítate en casa</h3>
                <p>
                    Comodidad y conveniencia: Hacer ejercicio en casa te brinda la comodidad de no tener que desplazarte a un gimnasio. Puedes adaptar tu horario de entrenamiento según tus necesidades y realizarlo en cualquier momento que te resulte conveniente. No tienes que preocuparte por el tráfico, los horarios de clase o las limitaciones de tiempo.<br><br>

                    Ahorro económico: Hacer deporte en casa puede ser más económico a largo plazo. No tienes que pagar una membresía de gimnasio mensual o cuotas adicionales por clases especializadas. Además, no necesitas invertir en equipos costosos, ya que hay muchas rutinas de ejercicio que puedes realizar con tu propio peso corporal o con equipamiento básico y accesible.<br><br>

                    Privacidad y comodidad: Al hacer ejercicio en casa, tienes la ventaja de tener total privacidad. No tienes que preocuparte por la presencia de otras personas, lo que puede resultar especialmente beneficioso si te sientes cohibido o inseguro al hacer ejercicio en público. Puedes usar la ropa que prefieras,</p>
            </section>
            <section>
                <img src="resources/imagenes/indexSection1.jpg" alt="ejercicio plancha">
            </section>
        </article>
        <article id="article2">
            <h2 class="none">article 2</h2>
            <div id="texto"><i>"Superar niveles es el camino hacia la grandeza. Cada obstáculo superado, cada desafío vencido, te acerca un paso más a tus metas y sueños. Cada nivel conquistado es una prueba de tu valentía, determinación y capacidad para superar tus propios límites. No te desanimes ante las dificultades, porque cada una de ellas es una oportunidad para crecer y demostrar de lo que eres capaz. Mantén tu visión clara y tu espíritu indomable. ¡Demuestrales a todos y a ti mismo en lo que puedes llegar a convertirte trabajando desde casa!"</i></div>
            <section id="flex-container-index">
                <div class="avanzado">Avanzado</div>
                <div class="intermedio">Intermedio</div>
                <div class="principiante">Principiante</div>
            </section>

            </div>
        </article>
        <article>
            <h2 class="none">article 3</h2>
            <div id="container-article-3">
                <?php
                // parámetros db
                $host = 'localhost';
                $dbname = 'egym';
                $user = 'admin';
                $password = 'admin';
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                $conexion = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $password, $options);

                try {
                    // se consulta la tabla clases entera
                    $select = $conexion->query('SELECT nombreClase, imagenClase, descripcion FROM clases');
                    $select->execute();
                    // se recorre
                    while ($registro = $select->fetch()) {
                        //se crea una seccion por clase
                        echo
                        '
                        <section class="box">
                            <img src="resources/imagenes/clases/' . $registro['imagenClase'] . '" class="img-article3">
                            <div class="descripcion">
                                <p>' . $registro['descripcion'] . '</p>
                            </div>
                            <span>' . $registro['nombreClase'] . '</span>
                        </section>
                        ';
                    }
                } catch (PDOException $e) {
                    echo 'Falló la conexión: ' . $e->getMessage();
                }
                ?>
            </div>
        </article>
        <article id="article4">
            <h2 class="none">article 4</h2>
            <section>
                <h3>CONTÁCTANOS</h3>
                <div>
                    <span class="negrita">Nuestro telefono</span>
                    <span>(+34) 634 199 341</span>
                </div>
                <div>
                    <span class="negrita">Nuestro correo</span>
                    <span>egym@gmail.com</span>
                </div>
            </section>
            <section>
                <h3>PROPUESTAS</h3>
                <form action="#" method="post">
                    <textarea rows="10" cols="15" name="propuesta" required>Comenta</textarea>
                    <input type="hidden" name="dni" value="<?php echo $usuario->dni ?>">
                    <input type="button" value="Enviar">
                </form>
            </section>
        </article>
    </main>

    <footer>
        <h2 class="none"></h2>
        <div>
            <div id="box-title">
                <h3><b>e</b>Gym</h3>
            </div>
            <div id="box-icons">
                <a href="#"><img src="resources/iconos/linkedin.png" alt="linkedin" class="social-icon"></a>
                <a href="#"><img src="resources/iconos/facebook.png" alt="facebook" class="social-icon"></a>
                <a href="#"><img src="resources/iconos/twitter.png" alt="twitter" class="social-icon"></a>
                <a href="#"><img src="resources/iconos/youtube.png" alt="youtube" class="social-icon"></a>
                <a href="#"><img src="resources/iconos/instagram.png" alt="instagram" class="social-icon"></a>
            </div>
        </div>
        <div id="web-info">
            <span>Miquel Rodrigo Navarro | @Copyright | www.egym.com | v.01</span>
        </div>
    </footer>
</body>

</html>