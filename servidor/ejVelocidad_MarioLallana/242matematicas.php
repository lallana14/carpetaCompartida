<?php

echo"\nEJERCICIO 1: \n";//calcula el número de dígitos de un número
function digitos($num){
    $cont = 0;
    while($num > 0){//saldra cuando el número sea 0
        $num = (int)($num / 10);//quita el último dígito del número y guarda el nuevo nuemro en la variable $num
        $cont++;//suma 1 al contador por cada iteración (un digito mas)
    }

    return $cont;//devolvemos el numero de digitos del número
}
//comprobamos que la funcion vaya bien
echo digitos(1234);

echo"\nEJERCICIO 2: \n";//devuelve el digito de un número en la posición indicada
function digitoN($num, $pos){
    $array = array();//creamos el array
    $numDigitos = digitos($num);//calculamos el número de dígitos del número
    $i = $numDigitos-1;//valor inicial del contador para ir rellenando el array desde la última posición

    while($i >= 0){
        $array[$i] = $num % 10;//calcula el resto de dividir entre 10 (el último dígito del número) y lo guarda en la posición $i del array
        $num = (int)($num / 10);//quita ese ultimo numero que ya hemos guardado en el array y lo guarda en la variable $num
        $i--;//hacemos que el contador decrezca por cada iteración
    }
    return $array[($pos-1)];//devolvemos el valor
}
//probamos la funcion y comprobamos que vaya bien
echo digitoN(1234, 2);

echo"\nEJERCICIO 3: \n";
function quitaPorDetras($num, $cant){
    for($i = 0; $i < $cant; $i++){//bucle para ir quietando numeros por atras
        $num = (int)($num /10);//quita el último dígito del número y guarda el nuevo nuemro en la variable $num
    }
    return $num;//devolvemos el nuevo valor
}
//probamos que funcione de la forma que queremos
echo quitaPorDetras(3214, 2);

echo"\nEJERCICIO 4: \n";
function quitaPorDelante($num, $cant){

}
?>