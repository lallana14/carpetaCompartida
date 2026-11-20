<?php
function quienSoy($edad) {
    if($edad < 3) {
        echo "bebé\n";
    }elseif($edad >= 3 && $edad <12) {
        echo "niño\n";
    }elseif($edad >= 12 && $edad < 18) {
        echo "adolescente\n";
    }elseif($edad >= 18 && $edad < 66) {
        echo "adulto\n";
    }else {
        echo "jubilado\n";
    }
}

quienSoy(2);
quienSoy(10);
quienSoy(15);
quienSoy(30);
quienSoy(70);
?>