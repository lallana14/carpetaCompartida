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
    $año = date("Y");

    echo "La edad introducida es: " . $edad . "<br>";
    echo "En 10 años tendrás " . ($edad + 10) . " años.<br>";
    echo "Hace 10 años tenías " . ($edad - 10) . " años.<br>";
}
?>
