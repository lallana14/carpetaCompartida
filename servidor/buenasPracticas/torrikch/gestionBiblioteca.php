
<?php

session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/funciones.php';

$accesos = registrarAcceso($_SESSION['nombre_usuario']);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administrador</title>
</head>
<body>

<h1>Soy administrador</h1>

<p>
    Has accedido <?php echo $accesos; ?> veces a la biblioteca.
</p>

<p>
    <a href="anadir_libro.php">Añadir un libro</a>
</p>

<p>
    <a href="vecesVisitado.php">Libros más visitados</a>
</p>

<p>
    <a href="logout.php">Cerrar sesión</a>
</p>

</body>
</html>
