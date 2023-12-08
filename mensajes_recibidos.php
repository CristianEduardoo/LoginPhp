<?php
require 'funciones/funciones.php';
$mensajesRecibidos = obtenerMensajesRecibidos();

include 'includes/header.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Mensajes Recibidos</h1>
        <?php if (empty($mensajesRecibidos)) : ?>
            <p>No hay mensajes recibidos.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Remitente</th>
                            <th>Contenido</th>
                            <th>Fecha de Envío</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mensajesRecibidos as $mensaje) : ?>
                            <tr>
                                <td><?= $mensaje[0] ?></td>
                                <td><?= $mensaje[3] ?></td>
                                <td><?= $mensaje[4] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>