<?php

$cantidad = $_POST["cantidad"] ?? 0;

if ($cantidad <= 0) {
    echo "La cantidad debe ser mayor que 0.";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Introducir datos</title>
</head>

<body>

    <h2>Introduzca los datos</h2>

    <form action="224sumarDatos.php" method="post">

        <?php

        for ($i = 1; $i <= $cantidad; $i++) {

            echo "Dato $i: ";
            echo "<input type='number' name='datos[]' required>";
            echo "<br><br>";

        }

        ?>

        <input type="submit" value="Sumar">

    </form>

</body>
</html>
