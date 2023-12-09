<!DOCTYPE html>
<html lang="es">

<head>
    <title>Login con PHP</title>
    <meta charset="UTF-8">
    <meta name="author" content="Cristian Castro">
    <meta name="description" content="login con PHP">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- líneas para importar Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- hoja de estilos personalizada después de Bootstrap -->
    <link rel="stylesheet" href="tu_estilo.css">

    <!-- script de Bootstrap para el menú de navegación en dispositivos pequeños -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <?php if (isset($_SESSION['id_usuario'])) : ?>
                <!-- Logo -->
                <img src="img/logo.png" alt="Logo" height="30">

                <!-- Botón de colapso para dispositivos pequeños -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Contenido de la barra de navegación -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Bienvenido Paul, Alumno a la izquierda en dispositivos pequeños -->
                    <span class="navbar-text d-block d-lg-none">
                        Bienvenido <?= $_SESSION['nombre'] ?>, <?= $_SESSION['perfil'] ?>
                    </span>

                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="mensajes_enviados.php">Mensajes enviados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mensajes_recibidos.php">Mensajes recibidos
                                (<?= $_SESSION['mensajes_sin_leer'] ?>)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?logout">Cerrar Sesión </a>
                        </li>
                    </ul>

                    <!-- Bienvenido Paul, Alumno a la derecha en dispositivos grandes -->
                    <span class="navbar-text ml-auto d-none d-lg-block">
                        Bienvenido <?= $_SESSION['nombre'] ?>, <?= $_SESSION['perfil'] ?>
                    </span>
                </div>
            <?php else : ?>
                <!-- Logo -->
                <img src="img/logo.png" alt="Logo" height="30">

                <!-- Botón de colapso para dispositivos pequeños -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menú de navegación para no autenticados -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Iniciar Sesión</a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>

</html>