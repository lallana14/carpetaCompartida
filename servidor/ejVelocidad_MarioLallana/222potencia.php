<?php

function potenciaFor($base, $exponente){//con el bucle for
    $resultado = 1;
    for($i=0; $i<$exponente; $i++){//condicion: saldra del bucle cuando el $i sea $exponente y sumara 1 a i cada vez que itere
        $resultado *= $base;
    }

    return $resultado;//devolvemos el valor
}
//probamos que vaya bien la funcion
$valor = potenciaFor(2, 4);
echo $valor;

function potenciaWhile($base, $exponente){//con el bucle while
    $resultado = 1;
    $i = 0;
    while($i < $exponente){//condicion: saldra del bucle cuando el $i sea $exponente
        $resultado *= $base;
        $i++;//suma 1 a i cada vez que itere
    }

    return $resultado;//devolvemos el valor
}
//probamos que vaya bien la funcion
$valor = potenciaWhile(2, 4);
echo $valor;

function potenciaDoWhile($base, $exponente){//con el bucle do while
    $resultado = 1;
    $i = 0;
    do{
        $resultado *= $base;
        $i++;//suma 1 a i cada vez que itere
    }while($i < $exponente);//condicion: saldra del bucle cuando el $i sea $exponente

    return $resultado;//devolvemos el valor
}
//probamos que vaya bien la funcion
$valor = potenciaDoWhile(2, 4);
echo $valor;

//deberia darnos el mismo valor para todas las funciones por 
//que estan calculando las misma potencia(mismos datos)
?>