<?php
//Ejercicio de correos electronicos: 
//Entrada esperada: $cadenaCorreos = "  Juan.Perez@GMAIL.com, maria88@hotmail.com ,  CARLOS@yahoo.es, ana.gomez@gmail.com, luis@HOTMAIL.com  ";
//Salida esperada:  Array ( [gmail.com] => Array ( [0] => juan.perez [1] => ana.gomez ) [hotmail.com] => Array ( [0] => maria88 [1] => luis ) [yahoo.es] => Array ( [0] => carlos ) ) 

$cadenaCorreos = "  Juan.Perez@GMAIL.com, maria88@hotmail.com ,  CARLOS@yahoo.es, ana.gomez@gmail.com, luis@HOTMAIL.com  ";
function procesarCorreos($cadenaCorreos) {
    $correos = explode(",", $cadenaCorreos);
    $resultado = array();

    foreach ($correos as $correo) {
        $correo = trim(strtolower($correo));
        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            list($usuario, $dominio) = explode("@", $correo);
            if (!isset($resultado[$dominio])) {
                $resultado[$dominio] = array();
            }
            $resultado[$dominio][] = $usuario;
        }
    }

    return $resultado;
}

echo "<pre>";
echo print_r(procesarCorreos($cadenaCorreos));
echo "</pre>";
?>