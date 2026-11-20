<?php

function esPrimo($num){
    $cont = $num-1;
    $primo = true;
    while($cont>1 && $primo){
        if($num%$cont==0){
            $primo = false;
        }
        $cont --;
    }
    return $primo;
}

function primosHastaN($N) {
    $num = 2;

    while($num<=50){
        if(esPrimo($num)){
            echo "El número ".$num." es primo\n";
        }
        $num++;
    }
}

primosHastaN(10);
?>