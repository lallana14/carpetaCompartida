<?php
$cadenaCorreos = "  Juan.Perez@GMAIL.com, maria88@hotmail.com ,  CARLOS@yahoo.es, ana.gomez@gmail.com, luis@HOTMAIL.com  ";

echo "<h3>Clasificador de Correos</h3>";

// 1. Separamos la cadena por comas
$listaCorreos = explode(',', $cadenaCorreos);

// Array asociativo vacío para guardar los grupos
$correosPorServidor = [];

// 2. Recorremos cada correo
foreach ($listaCorreos as $correo) {
    
    // 3. Limpiamos espacios en blanco al inicio y al final
    $correoLimpio = trim($correo);
    
    // 4. Separamos por el símbolo @
    // $partes[0] será el usuario y $partes[1] será el servidor
    $partes = explode('@', $correoLimpio);
    
    // Validamos que realmente se haya separado en dos partes (que había un @)
    if (count($partes) === 2) {
        
        // 5. Pasamos todo a minúsculas
        $usuario = strtolower($partes[0]);
        $servidor = strtolower($partes[1]);
        
        // 6. Lógica de agrupación en array asociativo
        // Si el servidor aún no existe como clave en nuestro array, lo inicializamos como array vacío
        if (!isset($correosPorServidor[$servidor])) {
            $correosPorServidor[$servidor] = [];
        }
        
        // Añadimos el usuario al array de su servidor correspondiente
        $correosPorServidor[$servidor][] = $usuario;
    }
}

// 7. Mostramos el resultado
// Usamos <pre> y print_r para ver la estructura del array de forma limpia
echo "<pre>";
print_r($correosPorServidor);
echo "</pre>";

/* 
Salida esperada por pantalla:
Array
(
    [gmail.com] => Array
        (
            [0] => juan.perez
            [1] => ana.gomez
        )

    [hotmail.com] => Array
        (
            [0] => maria88
            [1] => luis
        )

    [yahoo.es] => Array
        (
            [0] => carlos
        )
)
*/
?>