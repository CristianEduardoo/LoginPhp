<?php

function obtenerMensajesRecibidos() {
    session_start();

    //mesajes recibidos
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php"); // Redirigir a la página de inicio de sesión si no está autenticado
        exit;
    }

    // Obtener ID de usuario
    $idUsuario = $_SESSION['id_usuario'];

    // Leer mensajes recibidos desde el archivo
    $mensajesCSV = fopen(__DIR__ . '/mensajes_aula_virtual.csv', 'r');

    $mensajesRecibidos = [];
    while (($mensajeData = fgetcsv($mensajesCSV)) !== FALSE) {
        if ($mensajeData[1] == $idUsuario) {
            $mensajesRecibidos[] = $mensajeData;
        }
    }

    fclose($mensajesCSV);

    return $mensajesRecibidos;
}

//funciones del login
function limpiarDatos($dato){
    $dato = trim(htmlspecialchars($_POST[$dato]));
    return $dato;
}

function minusculas($dato){
    $dato = strtolower($dato);
    return $dato;
}
