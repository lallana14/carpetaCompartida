<?php
//crea una cadena y cifrala en +1 de ascii
function cifrar1($cadena){
    for($i = 0; $i< strlen($cadena); $i++){
        $nuevoValor = ord($cadena[$i]);
        $cadena[$i] = chr($nuevoValor + 1);
    }
    return $cadena;
}

echo cifrar1("Bruce Wayne es Batman");

echo ("\n");
function cifrar1ForEach($cadena){
    $nuevaCadena = "";
    foreach(str_split($cadena) as $letra){
        $valorAscii = ord($letra);
        $nuevaCadena = $nuevaCadena.chr($valorAscii+1);
    }
    return $nuevaCadena;
}

echo cifrar1ForEach("abcde");

//Mario Lallana Campos
//IES Virgen del Espino
//DAW 2 - 2026/27
?>