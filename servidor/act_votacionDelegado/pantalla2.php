<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla 2</title>
</head>
<body>
    <!-- •	Esta pantalla recibe el número de alumnos introducido en el paso anterior.
•	Deberá mostrar una matriz que contenga a todos los alumnos. La matriz debe ser lo más cuadrada posible. Pista: Puedes utilizar la raíz cuadrada (sqrt) y funciones de redondeo (round) para calcular el número de filas y columnas necesarias.
•	Cada celda de la matriz representará a un alumno (Ej: "Alumno 1", "Alumno 2", etc.).
•	Junto al nombre de cada alumno deberá aparecer una entrada con el voto que ha emitido dicho alumno de entre: Voto en blanco, Candidato 1, Candidato 2, Candidato 3 y Candidato 4.
•	Voto aleatorio inicial: Por defecto, cada alumno debe tener asignada una intención de voto aleatoria. Para ello, utiliza un array con los posibles candidatos y la función array_rand() o rand() de PHP para preseleccionar una de las opciones en el HTML.
•	El usuario podrá modificar manualmente cualquier voto en la pantalla antes de enviarlo.
•	Al final de la matriz, habrá un botón: "Realizar Votación".
•	Se deben enviar todos los datos de voto de cada alumno de forma segura y anónima. -->

    <table border="1">
            <?php
                if (isset($_POST['alumnos'])) {
                    $numAlumnos = $_POST['alumnos'];
                    $matriz = calcularMatriz($numAlumnos);// Llamamos a la función para calcular el número de filas y columnas
                    $filas = $matriz[0];// Obtenemos el número de filas
                    $columnas = $matriz[1];// Obtenemos el número de columnas
                    echo "<h2>Matriz de Alumnos</h2>";//titulo antes de la tabla
                    echo "";
                    for ($j = 0; $j < $columnas; $j++) {//recorremos las columnas
                        echo "<tr>";//separamos por filas
                        for ($i = 1; $i <= $filas; $i++) {//recorremos las filas hasta llegar al maximo de alumnos por fila 
                            $alumnoIndice = $j * $filas + $i;//calculamos el indice del alumno en la matriz
                            if ($alumnoIndice <= $numAlumnos) {
                                echo "<td>Alumno ".$alumnoIndice.":" ."<input type='text' name='voto".$alumnoIndice."' value='".darVotoAleatorio()."'></td>";//damos un valor aleatorio al voto del alumno por defecto y mostramos el campo de texto para que el usuario pueda modificarlo
                            }
                        }
                        echo "</tr>";
                    }
                    
                } else {
                    echo "<tr><td colspan='2'>No se ha recibido el número de alumnos.</td></tr>";//caso especial en el que no se ha recibido el número de alumnos
                }
            ?>
    </table>

    <form action="pantalla3.php" method="post"><!-- creamos el formulario que enviará los datos a pantalla3.php -->
        <button type="submit">Realizar Votación</button><!-- mostramos un botón para realizar la votación -->
    </form>

</body>
</html>

<?php
    function calcularMatriz($numAlumnos){//funcion que calcula el número de filas y columnas necesarias para mostrar la matriz de alumnos
        if($numAlumnos <= 0){//si el número de alumnos es menor o igual a 0, devolvemos 0 filas y 0 columnas
            return array(0, 0);
        } else {
            $filas = ceil(sqrt($numAlumnos));//con sqrt calculamos la raiz cuadrada, asi sacamos la matriz mas caudrada posible
            $columnas = ceil($numAlumnos / $filas);//con ceil se redondea hacia arriba el numero 
            return array($filas, $columnas);
        }
    }

    function darVotoAleatorio(){//funcion que devuelve un voto aleatorio de entre los posibles candidatos
        $candidatos = array("Voto en blanco", "Candidato 1", "Candidato 2", "Candidato 3", "Candidato 4");//lista de posiubles opciones de voto
        return $candidatos[array_rand($candidatos)];//con arrar_rand() seleccionamos un elemento aleatorio del array y lo devolvemos
    }

    $votos = array();//creamos un array para almacenar los votos emitidos por los alumnos y mandarlos a pantalla3.php
    foreach ($_POST as $key => $value) {//recorremos todos los datos recibidos mediante el método POST
        if (strpos($key, 'voto') === 0) {//comprobamos si la clave del array empieza con 'voto', lo que indica que es un voto emitido por un alumno
            $votos[$key] = $value;//almacenamos el valor del voto emitido por el alumno en el array de votos
        }
    }
?>
//Mario Lallana Campos
//DAW2 - IES Virgen del Espino
//Ejercicio de votación de delegado de clase
//7 de octubre de 2026