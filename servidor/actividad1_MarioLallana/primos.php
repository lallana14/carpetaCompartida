<?php

function esPrimo($num){//funcion para comprobar si un numero es primo
    $cont = $num-1;//empezamos a buscar divisores en un numero menos del dado
    $primo = true;//por defecto true
    while($cont>1 && $primo){//comprobar que el contador sea mayor que 1 (divisor de todos) y que primo sea true (si fuera falso ya ase habria encontrado un divisor)
        if($num%$cont==0){//mirar si es divisor
            $primo = false;//si tiene divisor el numero ya no será primo
        }
        $cont --;//hacemos decrecer el contador porque hemos empezado arriba
    }
    return $primo;//devolveremos true(si es primo) o false(si no es primo)
}

function primosHastaN($N) {
    $num = 2;//empezamos en 2 porque el 1 por definicion no es primo
    while($num<=$N){//bucle hasta llegar al numero que queramos
        if(esPrimo($num)){//mirar si un numero es primo
            echo "El número ".$num." es primo\n";
        }
        $num++;//sumo 1 al contador
    }
}

primosHastaN(10);

//Mario Lallana Campos
//IES Virgen del Espino
//DAW 2 - 2026/27
?>
