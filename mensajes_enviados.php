<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir a la página de inicio de sesión si no está autenticado
    exit;
}

// Obtener ID de usuarios
$idUsuario = $_SESSION['id_usuario'];

// Leer mensajes enviados desde el archivo
$mensajesCSV = fopen(__DIR__ . '/mensajes_aula_virtual.csv', 'r');

$mensajesEnviados = [];
while (($mensajeData = fgetcsv($mensajesCSV)) !== FALSE) {
    if ($mensajeData[0] == $idUsuario) {
        $mensajesEnviados[] = $mensajeData;
    }
}

fclose($mensajesCSV);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mensajes Enviados</title>
    <meta charset="UTF-8">
    <meta name="author" content="Cristian Castro">
    <meta name="description" content="Mensajes Enviados">
</head>

<body>
    <h1>Mensajes Enviados</h1>
    <?php if (empty($mensajesEnviados)) : ?>
        <p>No hay mensajes enviados.</p>
    <?php else : ?>
        <table border="1">
            <tr>
                <th>Destinatario</th>
                <th>Contenido</th>
                <th>Fecha de Envío</th>
            </tr>
            <?php foreach ($mensajesEnviados as $mensaje) : ?>
                <tr>
                    <td><?= $mensaje[1] ?></td>
                    <td><?= $mensaje[3] ?></td>
                    <td><?= $mensaje[4] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>

</html>
