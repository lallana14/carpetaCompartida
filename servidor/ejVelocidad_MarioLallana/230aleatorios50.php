<?php

function aleatorios($N){
    $array = array();
    //el valor $N es una contante que nos dice cuantos numeros aleatorios queremos generar
    for($i = 0;$i < $N; $i++){//llenamos el array con numeros aleatorios entre 1 y 100
        $array[$i] = rand(1, 100);
    }
    
    for($i = 0;$i < $N; $i++){//mostramos por pantalla el array
        echo $array[$i] . " - ";
    }
}
//comprobamos que la funcion vaya bien
aleatorios(50);
?>