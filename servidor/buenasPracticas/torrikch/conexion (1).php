
<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'biblioteca');

define('DB_USER', 'cliente');
define('DB_PASS', 'cliente');

define('DB_ADMIN', 'bibliotecario');
define('DB_ADMIN_PASS', 'bibliotecario');

// Conexión para clientes
function conectar(): PDO {

    $dsn = 'mysql:host=' . DB_HOST .
           ';port=3306;dbname=' . DB_NAME .
           ';charset=utf8mb4';

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
}

// Conexión para administradores
function conectarAdmin(): PDO {

    $dsn = 'mysql:host=' . DB_HOST .
           ';port=3306;dbname=' . DB_NAME .
           ';charset=utf8mb4';

    return new PDO($dsn, DB_ADMIN, DB_ADMIN_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
}

?>
