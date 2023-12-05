<?php 
require 'funciones/funciones.php'; 

$mensajesRecibidos = obtenerMensajesRecibidos();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mensajes Recibidos</title>
    <meta charset="UTF-8">
    <meta name="author" content="Cristian Castro">
    <meta name="description" content="Mensajes Recibidos">
</head>

<body>
    <h1>Mensajes Recibidos</h1>
    <?php if (empty($mensajesRecibidos)) : ?>
        <p>No hay mensajes recibidos.</p>
    <?php else : ?>
        <table border="1">
            <tr>
                <th>Remitente</th>
                <th>Contenido</th>
                <th>Fecha de Envío</th>
            </tr>
            <?php foreach ($mensajesRecibidos as $mensaje) : ?>
                <tr>
                    <td><?= $mensaje[0] ?></td>
                    <td><?= $mensaje[3] ?></td>
                    <td><?= $mensaje[4] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>

</html>
