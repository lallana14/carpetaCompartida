<?php

$cadenaCorreos = $_POST['correos'] ?? "";

$correos = explode(",", $cadenaCorreos);

$resultado = [];

foreach ($correos as $correo) {

    $correo = trim($correo);

    // Comprobar que contiene @
    if (strpos($correo, "@") === false) {
        continue;
    }

    // Separar usuario y dominio
    $partes = explode("@", $correo, 2);

    $usuario = $partes[0];
    $dominio = $partes[1];

    // Si el dominio no existe, creamos un array
    if (!isset($resultado[$dominio])) {
        $resultado[$dominio] = [];
    }

    // Añadir usuario al dominio
    $resultado[$dominio][] = $usuario;
}

echo "<h2>Resultado:</h2>";
echo "<pre>";
print_r($resultado);
echo "</pre>";

?>
