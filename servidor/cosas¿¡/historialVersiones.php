<?php

function compararVersiones($version1, $version2){
    $v1 = explode(".", $version1);
    $v2 = explode(".", $version2);

    for($i = 0; $i < max(count($v1), count($v2)); $i++){
        $num1 = isset($v1[$i]) ? intval($v1[$i]) : 0;
        $num2 = isset($v2[$i]) ? intval($v2[$i]) : 0;

        if($num1 < $num2){
            return -1;
        } elseif ($num1 > $num2){
            return 1;
        }
    }
    return 0;
}

$v1 = "1.2.3";
$v2 = "1.2.4";
$numero = compararVersiones($v1, $v2);

if($numero == -1){
    echo "La versión " . $v1 . " es menor que la versión " . $v2;
} elseif ($numero == 1){
    echo "La versión " . $v1 . " es mayor que la versión " . $v2;
} else {
    echo "Ambas versiones son iguales";
}

//Mario Lallana Campos
//IES Virgen del Espino
//DAW 2 - 2026/27
?>