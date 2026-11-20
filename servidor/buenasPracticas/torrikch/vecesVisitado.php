
<?php

session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Veces visitado</title>
</head>
<body>

<h1>Veces visitado cada libro</h1>

<?php

$hayVisitas = false;

foreach ($_COOKIE as $nombreCookie => $visitas) {

    if (strpos($nombreCookie, 'visitas_') === 0) {

        $datos = explode('_', $nombreCookie);

        array_shift($datos);

        $isbn = array_pop($datos);

        $usuario = implode('_', $datos);

        echo '<p>';

        echo 'Usuario: ' . htmlspecialchars($usuario);
        echo ' | ISBN: ' . htmlspecialchars($isbn);
        echo ' | Veces visitado: ' . htmlspecialchars($visitas);

        echo '</p>';

        $hayVisitas = true;
    }
}

if (!$hayVisitas) {
    echo '<p>No hay visitas registradas.</p>';
}

?>

<a href="gestionBiblioteca.php">Volver</a>

</body>
</html>
