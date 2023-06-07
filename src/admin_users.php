<?php
session_start();
require_once('clases/usuario.php');
$usuario = unserialize($_SESSION['user']);
$arrayUsers = $usuario->arrayUsers();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin_users</title>
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
        <article>
            <h2>ADMINISTRACIÓN DE USUARIOS</h2>
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>IBAN</th>
                        <th>Tipo de usuario</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <?php
                // se muestra la información de todos los usuarios en una tabla
                foreach ($arrayUsers as $user) {
                    echo
                    '
                    <tr>
                        <td><img src="../resources/fotos_usuarios/' . $user->imagenUsuario . '.png" alt="userImage" id="user-image"></td>
                        <td>' . $user->nombreUsuario . ' ' . $user->apellido1 . ' ' . $user->apellido2 . '</td>
                        <td>' . $user->mail . '</td>
                        <td>' . $user->iban . '</td>
                        <td>' . $user->tipo_usuario . '</td>
                        <td>
                            <form method="post" action="#">
                                <input type="hidden" name="dni" value="' . $user->dni . '">
                                <button type="submit" name="eliminar">Eliminar</button>
                            </form>
                        </td>
                    <tr>
                    ';
                }

                // se procesa el formulario para eliminar al usuario seleccionado y borrar la foto
                if (isset($_POST['eliminar'])) {
                    $usuario->delete($_POST['dni']);
                    unlink('../resources/fotos_usuarios/' . $usuario->imagenUsuario . '.png');
                    header('Location: ../admin_users.php');
                }
                ?>
                </tbody>
            </table>
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