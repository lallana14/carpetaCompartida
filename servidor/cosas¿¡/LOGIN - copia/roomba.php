<?php

function moverRobot($movimientos) {
    $encendido = true;
    foreach ($movimientos as $movimiento) {
        if ($movimiento == "Apagar/Encender") {
            $encendido = !$encendido;
            if ($encendido) {
                echo "El robot se ha encendido\n";
            } else {
                echo "El robot se ha apagado\n";
            }
        } elseif ($encendido) {
            echo $movimiento . "\n";
        } else {
            echo "El robot está apagado\n";
        }
    }
}

function crearMovimientos($numMovs) {
    $movimientos = [$numMovs];
    $posiblesMovimientos = ["Avanzar", "Mover a la derecha", "Mover a la izquierda", "Retroceder", "Apagar/Encender"];
    for($i = 0; $i < $numMovs; $i++) {
        $movimientos[$i] = $posiblesMovimientos[rand(0, 4)];
        echo "Movimiento ".($i + 1).": ".$movimientos[$i]."\n";
    }
    echo "\n";
    return $movimientos;
}

$movimientos = crearMovimientos(10);
moverRobot($movimientos);
?>