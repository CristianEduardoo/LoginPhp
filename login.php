<?php
session_start();
require 'funciones/funciones.php';

$mostrarFormulario = true; // Variable para controlar la visibilidad del formulario 
$errores = [];
$mensaje = ""; //devuelve true al ser vacio

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreUsuario = limpiarDatos("usuario");
    $passwordUsuario = limpiarDatos("password");

    // Validar nombre de usuario
    if (empty($nombreUsuario)) {
        $errores[] = "No se introdujo el nombre de usuario";
    } else {
        $nombreUsuario = minusculas($nombreUsuario);
    }

    // Validar contraseña
    if (empty($passwordUsuario)) {
        $errores[] = "No se introdujo la contraseña";
    } else {
        //no pongo la función minusculas, porque se supone que las passwords son sensibles a mayúsculas y minúsculas
        $passwordUsuario = md5($passwordUsuario);
    }

    // Abrir el archivo CSV de usuarios
    $usuariosCSV = fopen(__DIR__ . '/users_aula_virtual.csv', 'r'); //abrimos el archivos CSV de usuarios

    // Procesar el archivo CSV de usuarios
    if ($usuariosCSV) {
        while (($data = fgetcsv($usuariosCSV)) !== FALSE) {
            // Verificar credenciales del usuario
            if (($data[1] === $nombreUsuario) && ($data[2] === $passwordUsuario)) {
                // Autenticación exitosa
                $mostrarFormulario = false;
                $mensaje =  "<p style='color:blue;'>Hola {$data[3]} {$data[4]}</p>";

                // Establecer variables de sesión si el usuario está autenticado
                $_SESSION['id_usuario'] = $data[0];
                $_SESSION['nombre'] = $data[3];
                $_SESSION['perfil'] = $data[5];

                if ($_SESSION['perfil'] === 1) {
                    $_SESSION['perfil'] = "Profesor";
                } else {
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

                break; //salimos del bucle while
            }
        }

        fclose($usuariosCSV);

        // Verificar si se encontraron errores de autenticación
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

include 'includes/header.php';
?>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ($mostrarFormulario) : ?>
                    <h1 class="mb-4">Login</h1>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <div class="form-group">
                            <label for="nombre">Email</label>
                            <input id="nombre" type="text" name="usuario" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input id="password" type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary">
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

<?php
// Mostrar mensajes de error
foreach ($errores as $error) {
    echo "<p style='color:red;'>$error</p>";
}
?>

</html>