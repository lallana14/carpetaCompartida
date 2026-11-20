<?php
// Comprueba la contraseña: acepta hashes de password_hash() y, por compatibilidad,
// las contraseñas antiguas guardadas en texto plano (que no son un hash).
function verificarContrasena(string $introducida, string $guardada): bool {
    if (password_get_info($guardada)['algo'] !== null) {
        return password_verify($introducida, $guardada);
    }
    return hash_equals($guardada, $introducida);
}

// Cuenta los inicios de sesión de un usuario (una cookie por usuario)
function contarAcceso(string $usuario): int {
    $nombre = 'accesos_' . $usuario;

    if (isset($_COOKIE[$nombre])) {
        $accesos = (int)$_COOKIE[$nombre] + 1;   // ya existía: sumo 1
    } else {
        $accesos = 1;                            // primera vez
    }

    setcookie($nombre, $accesos, time() + 30*24*60*60, '/');
    return $accesos;
}

// Cuenta las veces que un usuario ha visto un libro (una cookie por usuario y libro)
function contarVisitaLibro(string $usuario, string $isbn): int {
    $nombre = 'visitas_' . $usuario . '_' . $isbn;

    if (isset($_COOKIE[$nombre])) {
        $visitas = (int)$_COOKIE[$nombre] + 1;
    } else {
        $visitas = 1;
    }

    setcookie($nombre, $visitas, time() + 30*24*60*60, '/');
    return $visitas;
}
?>
