<?php

function moverRobot($movimientos) {
    $encendido = true;//encendido por defecto
    $i = 1;
    foreach($movimientos as $movimiento) {//recorremos el array
        if($movimiento == "Apagar/Encender") {//miramos si pulsa el boton de encedido/apagado
            $encendido = !$encendido;//cambiamos el estado
            if($encendido) {//caso 1: el robot se enciende después de pulsar el boton
                echo $i ." El robot se ha encendido\n";
            }else {//caso 2: el robot estaba encendido antes de pulsar el botón
                echo $i ." El robot se ha apagado\n";
            }
        }elseif($encendido) {//comprobar que el robot está encendido y mostrar el movimiento por pantalla
            echo $i ." " . $movimiento . "\n";
        }else {//el robot esta apagado (no mostramos el movimiento por pantalla)
            echo $i ." El robot está apagado\n";
        }
        $i++;//incrementamos 1 el contador de movimientos
    }
}

function crearMovimientos($numMovs) {
    $movimientos = [$numMovs];//crea el array con longitud $numMovs
    $posiblesMovimientos = ["Avanzar", "Mover a la derecha", "Mover a la izquierda", "Retroceder", "Apagar/Encender"];//5 posibles casos
    for($i = 0; $i < $numMovs; $i++) {//i lo usaremos para recorrer el vector que hemos creado
        $movimientos[$i] = $posiblesMovimientos[rand(0, 4)];//damos valor a cada una de las posiciones del vector
        //echo "Movimiento ".($i + 1).": ".$movimientos[$i]."\n";//muestra como se ha rellenado el array
    }
    echo "\n";
    return $movimientos;//devuelve el array con los movimientos aleatorios
}

//comprobamos
$movimientos = crearMovimientos(10);
moverRobot($movimientos);

//Mario Lallana Campos
//IES Virgen del Espino
//DAW 2 - 2026/27
?>