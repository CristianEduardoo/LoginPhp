<?php
require 'funciones/funciones.php';
$mensajesEnviados = obtenerMensajesEnviados();

include 'includes/header.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Mensajes Enviados</h1>

        <?php if (empty($mensajesEnviados)) : ?>
            <p>No hay mensajes enviados.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Destinatario</th>
                            <th>Contenido</th>
                            <th>Fecha de Envío</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mensajesEnviados as $mensaje) : ?>
                            <tr>
                                <td><?= $mensaje[1] ?></td>
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