<?php
require_once('clases/Usuario.php');
if (isset($_SESSION['user'])) {
    session_start();
    $usuario = unserialize($_SESSION['user']);
}

$calorias = "SIN RESULTADO";

//resolución de formulario de calorias
if (isset($_POST['submit'])) {

    //diferenciar entre mujer y hombre
    if ($_POST['sexo'] == 'mujer') {
        $calorias = (65 + (9.6 * $_POST['peso'])) + ((1.8 * $_POST['altura']) - (4.7 * $_POST['edad'])) * $_POST['actividad'];
    } else {
        $calorias = (66 + (13.7 * $_POST['peso'])) + ((5 * $_POST['altura']) - (6.8 * $_POST['edad'])) * $_POST['actividad'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>calculadora</title>
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
                    <li class="nav-li"><a href="#" class="link-nav">logear/registrar</a></li>
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
        <article>
            <h2 class="none">calculadora</h2>
            <div>
                <form method="post" action="#">

                    <fieldset>
                        <legend>Sexo</legend>
                        <input type="radio" id="mujer" name="sexo" value="Mujer" required>
                        <label for="mujer">Mujer</label><br>
                        <input type="radio" id="hombre" name="sexo" value="Hombre">
                        <label for="hombre">Hombre</label><br>
                    </fieldset>
    
                    <fieldset>
                        <legend>Altura y peso</legend>
                        <br><label for="altura">Altura en cm</label><br>
                        <input type="number" id="altura" name="altura" required>
                        <label for="altura">cm</label><br>

                        <br><label for="peso">Peso en kilos</label><br>
                        <input type="number" id="peso" name="peso" required>
                        <label for="peso">kg</label><br>

                        <br><label for="edad">Edad</label><br>
                        <input type="number" id="edad" name="edad" required>
                        <label for="edad">años</label><br>
                    </fieldset>
    
                    <fieldset>
                        <legend>Factor de actividad</legend>
                        <input type="radio" id="sedentario" name="actividad" value="1.2" required>
                        <label for="sedentario">Sedentario</label><br>

                        <input type="radio" id="poco" name="actividad" value="1.375">
                        <label for="poco">Poca actividad física (ejercicio de 1 a 3 veces por semana)</label><br>

                        <input type="radio" id="moderada" name="actividad" value="1.55">
                        <label for="moderada">Actividad moderada (ejercicio de 4 a 5 veces por semana)</label><br>

                        <input type="radio" id="instensa" name="actividad" value="1.725">
                        <label for="instensa">Actividad intensa (ejercicio de 6 a 7 veces por semana)</label><br>

                        <input type="radio" id="profesional" name="actividad" value="1.9">
                        <label for="profesional">Atletas profesionales (entrenamientos de más de 4 horas diarias)</label><br>
                    </fieldset>

                    <input type="submit" value="Calcular" name="submit">                    
                </form>
                <br>
                <p><b><?php echo $calorias; ?></b></p>
                
            </div>
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
