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
    <title>eGym</title>
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
                   <b>Comodidad y conveniencia: </b>Hacer ejercicio en casa te brinda la comodidad de no tener que desplazarte a un gimnasio. Puedes adaptar tu horario de entrenamiento según tus necesidades y realizarlo en cualquier momento que te resulte conveniente. No tienes que preocuparte por el tráfico, los horarios de clase o las limitaciones de tiempo.<br><br>

                   <b>Ahorro económico: </b>Hacer deporte en casa puede ser más económico a largo plazo. No tienes que pagar una membresía de gimnasio mensual o cuotas adicionales por clases especializadas. Además, no necesitas invertir en equipos costosos, ya que hay muchas rutinas de ejercicio que puedes realizar con tu propio peso corporal o con equipamiento básico y accesible.<br><br>

                    <b>Privacidad y comodidad: </b>Al hacer ejercicio en casa, tienes la ventaja de tener total privacidad. No tienes que preocuparte por la presencia de otras personas, lo que puede resultar especialmente beneficioso si te sientes cohibido o inseguro al hacer ejercicio en público.
                </p>
            </section>
            <section>
                <img src="resources/imagenes/indexSection1.jpg" alt="ejercicio plancha">
            </section>
        </article>
        <article id="article2">
            <h2 class="none">article 2</h2>
            <section id="flex-container-index">
                <div class="card-dificultad">
                    <img src="resources/imagenes/indexSection2Principiante.jpg" alt="principiante">
                    <span>Principiante</span>
                    <p>Recuerda, cada campeón comenzó como un principiante, y tú estás en el camino para convertirte en uno. Habrá momentos en los que te sentirás agotado, desmotivado o incluso tentado a rendirte. Pero permíteme recordarte que dentro de ti hay una fuerza inquebrantable, una determinación que te llevará más allá de tus límites.</p>
                </div>
                <div class="card-dificultad">
                    <img src="resources/imagenes/indexSection2Intermedio.jpg" alt="principiante">
                    <span>Intermedio</span>
                    <p>No te compares con los demás, tu único competidor eres tú mismo(a). Cada persona tiene su propio ritmo de progreso, y lo importante es que estás dando lo mejor de ti en cada entrenamiento y en cada competencia. Celebra tus avances y aprende de tus errores, ya que cada experiencia te brinda la oportunidad de mejorar.</p>
                </div>
                <div class="card-dificultad">
                    <img src="resources/imagenes/indexSection2Avanzado.jpg" alt="principiante">
                    <span>Avanzado</span>
                    <p>No importa cuánto tiempo hayas estado involucrado(a) en el deporte, lo que importa es tu dedicación y tu pasión por mejorar. Cada día que te levantas y te esfuerzas por ser un poco mejor, estás marcando la diferencia. Aprecia y celebra cada pequeño logro en tu camino, ya que son los cimientos para construir grandes triunfos en el futuro.</p>
                </div>
            </section>

            </div>
        </article>
        <article id="article3">
            <h2>Deportes</h2>
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
                            <p class="descripcion">' . $registro['descripcion'] . '</p>
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
            <h2 class="none">contactanos</h2>
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
                <h3 class="none">foto</h3>
                <img src="resources/imagenes/contactanos.jpg" alt="secretaria">
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
            <span>Miquel Rodrigo Navarro | ©Copyright | www.egym.com | v.01</span>
        </div>
    </footer>
</body>

</html>
