<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla 3</title>
</head>
<body>
    <!-- •	Esta pantalla recibe todos los votos emitidos en el panel anterior.
•	Deberá recorrer los datos recibidos y realizar un recuento de los votos para cada candidato y los votos en blanco.
•	Mostrará por pantalla de forma ordenada los resultados finales: qué candidato ha ganado, cuántos votos tiene cada uno y el número de votos en blanco. -->
    <h2>Resultados de la Votación</h2>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {//comprobamos si se han recibido datos mediante el método POST
            $votos = array();//creamos un array para almacenar los votos emitidos por los alumnos
            foreach ($_POST as $key => $value) {//recorremos todos los datos recibidos mediante el método POST
                if (strpos($key, 'voto') === 0) {//comprobamos si la clave del array empieza con 'voto', lo que indica que es un voto emitido por un alumno
                    $votos[] = $value;//almacenamos el valor del voto emitido por el alumno en el array de votos
                }
            }

            $resultados = contarVotos($votos);//llamamos a contarVotos para obtener el recuento
            echo "<h2>Resultados de la Votación</h2>";//mostramos un título para los resultados de la votación
            echo "<ul>";
            foreach ($resultados as $candidato => $cantidad) {//recorremos resultados
                echo "<li>$candidato: $cantidad votos</li>";//vamos mostrando los resultados de cada candidato y los votos en blanco
            }
            echo "</ul>";

            $ganador = array_search(max($resultados), $resultados);//buscamos el candidato con más votos
            echo "<h3>El ganador es: $ganador con {$resultados[$ganador]} votos.</h3>";//mostra
        } else {
            echo "<p>No se han recibido datos de votación.</p>";
        }
    ?>
</body>
</html>

<?php
    function contarVotos($votos) {
        $resultados = array(//creamos un array para almacenar los resultados de los votos
            "Voto en blanco" => 0,
            "Candidato 1" => 0,
            "Candidato 2" => 0,
            "Candidato 3" => 0,
            "Candidato 4" => 0
        );

        foreach ($votos as $voto) {//con el bucle recorremos todos los votos emitidos por los alumnos
            if (array_key_exists($voto, $resultados)) {//con array_key_exists() comprobamos si el voto emitido por el alumno es uno de los posibles
                $resultados[$voto]++;//sumamo 1 al contador si el voto emitido por el alumno es uno de los posibles
            }
        }

        return $resultados;
    }

?>
//Mario Lallana Campos
//DAW2 - IES Virgen del Espino
//Ejercicio de votación de delegado de clase
//7 de octubre de 2026