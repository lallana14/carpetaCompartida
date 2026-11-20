
<?php

function registrarAcceso($nombreUsuario): int {

    $cookie = 'accesos_' . $nombreUsuario;

    $anteriores = isset($_COOKIE[$cookie])
        ? (int) $_COOKIE[$cookie]
        : 0;

    $accesos = $anteriores + 1;

    setcookie($cookie, $accesos, [
        'expires' => time() + 30 * 24 * 60 * 60,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);

    return $accesos;
}


function registrarVisitaLibro($nombreUsuario, $isbn): int {

    $cookie = 'visitas_' . $nombreUsuario . '_' . $isbn;

    $anteriores = isset($_COOKIE[$cookie])
        ? (int) $_COOKIE[$cookie]
        : 0;

    $visitas = $anteriores + 1;

    setcookie($cookie, $visitas, [
        'expires' => time() + 30 * 24 * 60 * 60,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);

    return $visitas;
}

?>
