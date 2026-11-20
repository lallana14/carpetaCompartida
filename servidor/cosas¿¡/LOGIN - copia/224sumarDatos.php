<?php

$datos = $_POST["datos"] ?? [];

$total = 0;

foreach ($datos as $dato) {
    $total += $dato;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
</head>

<body>

    <h2>Resultado</h2>

    <p>El total es: <?php echo $total; ?></p>

</body>
</html>
