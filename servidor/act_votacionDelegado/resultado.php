<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    echo 'Este archivo debe recibir datos mediante POST';
    exit;
}

if(!isset($_POST['votos']) || empty($_POST['votos'])){
    http_response_code(400);
    echo 'Debes introducir votos validos';
    exit;
}else{
    $votos = $_POST['votos'];
}

$recuentoCandidatos = [];
$votosBlanco = 0;


foreach($votos as $voto){
    $voto = trim($voto);

    if(strcmp($voto,'Blanco') == 0){
        $votosBlanco++;
    }else{
        if(!isset($recuentoCandidatos[$voto])){
            $recuentoCandidatos[$voto] = 1;
        }else{
            $recuentoCandidatos[$voto]++;
        }
        
    }
}

echo 'Votos en blanco: ' . $votosBlanco . '<br>';
// echo 'Recuento: '.print_r($recuentoCandidatos) .'<br>';

$maximoVotos = max($recuentoCandidatos);
echo 'Máximo de votos: ' . $maximoVotos . '<br>';
$ganadores = [];
foreach($recuentoCandidatos as $candidato => $voto){
    if($voto == $maximoVotos){
        $ganadores[] = $candidato;
    }
}

if($votosBlanco > $maximoVotos){
    echo 'El ganador es: Blanco';
}else if(count($ganadores) > 1){
    echo 'Los ganadores son: ' . implode(', ', $ganadores);
}else{
    echo 'Ganador: ' . $ganadores[0];
}

?>