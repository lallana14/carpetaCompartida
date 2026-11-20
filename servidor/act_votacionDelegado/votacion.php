<?php

function gengerarVotoAleatorio($candidatos){
    $indiceAleatorio = array_rand($candidatos);
    
    if($indiceAleatorio == 0){
        return 'Blanco';
    }

    return trim($candidatos[$indiceAleatorio-1]);
}

//comprobamos que el metodos es get
if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    http_response_code(405);
    echo 'Este archivo debe recibir datos mediante GET';
    exit;
}

if(!isset($_GET['numeroAlumnos']) || empty($_GET['numeroAlumnos'])){
    http_response_code(400);
    echo 'Debes indicar el numero de alumnos';
    exit;
}else{
    $numeroAlumnos = (int) $_GET['numeroAlumnos'];
}

if(isset($_GET['nombreCandidatos']) && !empty($_GET['nombreCandidatos'])){
    $candidatos = explode(',',$_GET['nombresCandidatos']);
}else{
    $candidatos = ['Blanco', 'Candidato 1', 'Candidato 2', 'Candidato 3', 'Candidato 4'];
}

$columnas = ceil(sqrt($numeroAlumnos));
$filas = ceil($numeroAlumnos / $columnas);

$contadorAlumnos = 0;

header('Content-Type: text/html; charset=UTF-8');
echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Votación</title></head>';
echo '<body>';
echo '<h1>Votaciones</h1>';

echo '<form action="resultado.php" method="post">';
echo '<table><tbody>';
for($fila = 0; $fila < $filas; $fila++){
    echo '<tr>';
    for($columna = 0; $columna < $columnas; $columna++){
        echo '<td>';
        $contadorAlumnos++;
        if($contadorAlumnos <= $numeroAlumnos){
            $votoAleatorio = gengerarVotoAleatorio($candidatos);
            echo '<label>Alumno ' . $contadorAlumnos;
            echo '<input type=text name="votos['.($contadorAlumnos-1).']" value="' .$votoAleatorio . '" required>';
            echo '</label>';
        }
        echo '</td>';
    }
    echo '</tr>';
}
echo '</tbody></table>';
echo '<br><button type="submit">Enviar votos</button>';
echo '</form>';

for($fila = 0; $fila < $filas; $fila++){
    echo '<tr>';
    for($columna = 0; $columna < $columnas; $columna++){
        if($contadorAlumnos < $numeroAlumnos){
            echo '<td>';
            echo '<label for="alumno' . $contadorAlumnos . '">Alumno ' . ($contadorAlumnos + 1) . '</label>';
            echo '<select name="alumno' . $contadorAlumnos . '" id="alumno' . $contadorAlumnos . '">';
            foreach($candidatos as $candidato){
                echo '<option value="' . $candidato . '">' . $candidato . '</option>';
            }
            echo '</select>';
            echo '</td>';
            $contadorAlumnos++;
        } else {
            echo '<td></td>'; // Celda vacía si no hay más alumnos
        }
    }
    echo '</tr>';
}