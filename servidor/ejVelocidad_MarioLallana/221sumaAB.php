<?php

function sumaAhastaB($a, $b){//creamos la funcion sumaAhastaB
    $sumaTotal = 0;//acumulador para ir almacenando los valores sumados
    while($a <= $b){//condicion: saldra del bucle cuando el $a sea $b+1
        $sumaTotal += $a;
        $a++;
    }

    return $sumaTotal;//devolvemos el valor
}

//llamamos a la funcion y comprobamos que vaya bien
$valor = sumaAhastaB(2, 11);
echo $valor;
?>