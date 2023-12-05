<?php
session_start();
require 'funciones/funciones.php';

$mostrarFormulario = true; // Variable para controlar la visibilidad del formulario 
$errores = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreUsuario = limpiarDatos("usuario");
    $passwordUsuario = limpiarDatos("password");

    if (empty($nombreUsuario)) {
        $errores[] = "No se introdujo el nombre de usuario";
    } else {
        $nombreUsuario = minusculas($nombreUsuario);
    }

    if (empty($passwordUsuario)) {
        $errores[] = "No se introdujo la contraseña";
    } else {
        $passwordUsuario = md5($passwordUsuario);
    }

    $usuariosCSV = fopen(__DIR__ . '/users_aula_virtual.csv', 'r');

    if ($usuariosCSV) {
        while (($data = fgetcsv($usuariosCSV)) !== FALSE) {
            if (($data[1] === $nombreUsuario) && ($data[2] === $passwordUsuario)) {
                $mostrarFormulario = false;
                $mensaje =  "<p style='color:blue;'>Hola {$data[3]} {$data[4]}</p>";

                // Establecer variables de sesión si el usuario está autenticado
                $_SESSION['id_usuario'] = $data[0];
                $_SESSION['nombre'] = $data[3];
                $_SESSION['perfil'] = $data[5];

                if($_SESSION['perfil'] === 1){
                    $_SESSION['perfil'] = "Profesor";
                }else{
                    $_SESSION['perfil'] = "Alumno";
                }

                // Contar mensajes no leídos
                $mensajesCSV = fopen(__DIR__ . '/mensajes_aula_virtual.csv', 'r');
                $mensajesNoLeidos = 0;

                while (($mensajeData = fgetcsv($mensajesCSV)) !== FALSE) {
                    if ($mensajeData[2] === 'false' && $mensajeData[1] == $_SESSION['id_usuario']) {
                        $mensajesNoLeidos++;
                    }
                }

                $_SESSION['mensajes_sin_leer'] = $mensajesNoLeidos;

                fclose($mensajesCSV);

                break;
            }
        }

        fclose($usuariosCSV);

        if (!$mensaje) {
            $errores[] = "Nombre de usuario y/o contraseña incorrectos o no existe";
        }
    } else {
        $errores[] = "Error de archivo users_aula_virtual.csv";
    }
}

// Verificar si el usuario está autenticado
if (isset($_SESSION['id_usuario'])) {
    $mostrarFormulario = false;
    $mensaje = "<p style='color:blue;'>{$_SESSION['nombre']}<br>{$_SESSION['perfil']}</p>";
}

// Cerrar sesión (logout)
if (isset($_GET['logout'])) {
    session_destroy(); //destruye todas las variables de sesión, lo que efectivamente cierra la sesión del usuario.
    header("Location: {$_SERVER['PHP_SELF']}"); //redirige al usuario de nuevo a la misma página
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="author" content="Cristian castro">
    <meta name="description" content="login">
</head>

<header>
    <div style="display: <?= ($mostrarFormulario) ? "block" : "none"; ?>">
    <h1>Login</h1>    
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <div>
                <label for="nombre">Email </label>
                <input id="nombre" type="text" name="usuario">
            </div>

            <div>
                <label for="password">Contraseña </label>
                <input id="password" type="password" name="password">
            </div>

            <div>
                <input type="submit">
            </div>
        </form>
    </div>

    <div class="navegacion" style="display: <?= ($mostrarFormulario) ? "none" : "block"; ?>">
        <?php if (isset($_SESSION['id_usuario'])) : ?>
        <a href="mensajes_enviados.php">Mensajes enviados</a>
        <a href="mensajes_recibidos.php">Mensajes recibidos(<?= $_SESSION['mensajes_sin_leer'] ?>)</a>
        <a href="?logout">Cerrar Sesión </a>
        <?php else : ?>
            <a href="login.php">Iniciar Sesión</a>
        <?php endif; ?>    
    </div>
    <?php
    echo $mensaje; // reubicarlo!!
    foreach ($errores as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
</header>
</html>