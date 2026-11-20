<?php
require_once 'lib_matematicas.php';
$resultado = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operacion = $_POST['operacion'];
    $a = $_POST['a'];
    $b = $_POST['b'];

    switch ($operacion) {
        case 'sumar':
            $resultado = sumar($a, $b);
            break;

        case 'restar':
            $resultado = restar($a, $b);
            break;

        case 'multiplicar':
            $resultado = multiplicar($a, $b);
            break;

        case 'dividir':
            $resultado = dividir($a, $b);
            break;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
</head>
<body>
    <form method="POST">
        <select name="operacion">
            <option value="sumar">Sumar</option>
            <option value="restar">Restar</option>
            <option value="multiplicar">Multiplicar</option>
            <option value="dividir">Dividir</option>
        </select>
        <input type="number" name="a" placeholder="Primer número">
        <input type="number" name="b" placeholder="Segundo número">
        <button type="submit">Calcular</button>
    </form>
    <?php
        echo "<h2>Resultado: ".$resultado."</h2>";
    ?>
</body>
</html>