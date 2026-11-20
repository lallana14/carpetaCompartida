<!DOCTYPE html>
<head>

</head>
<body>
    <h1>Edad</h1>
    <p>Introduce tu edad:</p>
    <form method="get" action="">
        <input type="number" name="edad">
        <input type="submit" value="Enviar">
    </form>
</body>
</html>

<?php

if (isset($_GET['edad'])) {
    $edad = $_GET['edad'];

    if($edad >= 0 && $edad < 3){
        echo "Es un bebé";
    }elseif(
        $edad >= 3 && $edad <12){
        echo "Es un niño";
    }elseif($edad >= 12 && $edad <18){
        echo "Es un adolescente";
    }elseif($edad >= 18 && $edad <66){
        echo "Es un adulto";
    }elseif($edad >= 66){
        echo "Es un jubilado";
    }else{
        echo "Edad no válida";
    }
}
?>