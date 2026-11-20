<?php
// Necesitamos la conexión a la BBDD para la función obtenerLibros() (NUEVO)
require_once __DIR__ . '/conexion.php';

function registrarAcceso($nombreUsuario): int{
    $cookieAccesos = 'accesos_' . $nombreUsuario;

    if(!isset($_COOKIE[$cookieAccesos])) {
        $accesosAnteriores = null;
    }else{
        $accesosAnteriores = (int)$_COOKIE[$cookieAccesos];
       // $accesosAnteriores = filter_var($accesosAnteriores, FILTER_VALIDATE_INT);
    }

    //Esto sustituye al código if else de arriba
    //$accesosAnteriores = isset($_COOKIE[$cookieAccesos]) ? (int)$_COOKIE[$cookieAccesos] : null;

    if($accesosAnteriores === null){
        $accesos = 1;
    } else {
        $accesos = $accesosAnteriores + 1;
    }

    //Cookie normal
    //setcookie($cookieAccesos, $accesos, time() + (30*24*60*60), '/'); // 86400 = 30 dias en segundos

    $opciones30 = [
        'expires' => time() + 30*24*60*60, // 30 días
        'path' => '/',
        'secure' => false, // Se enviará a través de HTTP y HTTPS
        'httponly' => true, // No accesible desde JavaScript
        'samesite' => 'Strict', // Evita el envío de la cookie en solicitudes de terceros
    ];

    setcookie($cookieAccesos, $accesos, $opciones30);

    return $accesos;
}

// Devuelve el nombre de la cookie de visitas de un usuario.

function nombreCookieVisitas(string $nombreUsuario): string{
    return 'visitas_' . preg_replace('/[^A-Za-z0-9_]/', '_', $nombreUsuario);
}

// Lee la cookie del usuario y la devuelve como array [ISBN => veces].
function obtenerVisitas(string $nombreUsuario): array{
    $nombreCookie = nombreCookieVisitas($nombreUsuario);

    if(!isset($_COOKIE[$nombreCookie])){
        return [];
    }

    // true = convertir el JSON en array asociativo
    $datos = json_decode($_COOKIE[$nombreCookie], true);

    // La cookie la puede editar el usuario: si no es un array válido, la ignoramos
    if(!is_array($datos)){
        return [];
    }

    // Nos aseguramos de que cada contador sea un entero >= 0
    $visitas = [];
    foreach($datos as $isbn => $veces){
        $visitas[$isbn] = max(0, (int)$veces);
    }

    return $visitas;
}

// suma 1 a las visitas de ese libro, guarda la cookie y devuelve el nuevo total.
function registrarVisitaLibro(string $nombreUsuario, string $isbn): int{
    $nombreCookie = nombreCookieVisitas($nombreUsuario);

    // 1. Cargamos lo que ya había en la cookie
    $visitas = obtenerVisitas($nombreUsuario);

    // 2. Sumamos 1 al libro visto (si es la primera vez, parte de 0)
    $visitas[$isbn] = ($visitas[$isbn] ?? 0) + 1;

    // 3. Volvemos a convertir el array en JSON para guardarlo en la cookie
    //    JSON_FORCE_OBJECT asegura que siempre sea {"isbn":n}, nunca una lista
    $valor = json_encode($visitas, JSON_FORCE_OBJECT);

    // 4. Guardamos la cookie 30 días (mismas opciones que la de accesos)
    setcookie($nombreCookie, $valor, [
        'expires'  => time() + 30*24*60*60,
        'path'     => '/',
        'secure'   => false,     // false para poder probar con http://localhost
        'httponly' => true,      // JavaScript no puede leerla
        'samesite' => 'Strict',
    ]);

    // 5. setcookie() solo afecta a la PRÓXIMA petición. Actualizamos $_COOKIE
    //    para que, si se vuelve a leer en esta misma página, ya esté al día.
    $_COOKIE[$nombreCookie] = $valor;

    return $visitas[$isbn];
}

// Devuelve todos los libros de la BBDD para mostrarlos en el listado.
function obtenerLibros(): array{
    $conexion = conectar();
    return $conexion->query('SELECT ISBN, Titulo FROM libros ORDER BY Titulo')->fetchAll();
}
