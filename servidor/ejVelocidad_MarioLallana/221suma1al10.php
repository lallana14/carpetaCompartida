<?php

function suma1hasta10(){//creamos la funcion suma1hasta10
    $cont = 1;//contador para vere por que número vamos
    $sumaTotal = 0;//acumulador para ir almacenando los valores sumados
    while($cont <=10){//condicion: saldra del bucle cuando el cont sea 11 
        $sumaTotal += $cont;
        $cont++;
    }

    return $sumaTotal;//devolvemos el valor
}

//llamamos a la funcion y comprobamos que vaya bien
$valor = suma1hasta10();
echo $valor;
?>