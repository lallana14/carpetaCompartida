
<?php

session_start();

require_once __DIR__ . '/funciones.php';
require_once __DIR__ . '/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['ISBN'])) {
    header('Location: biblioteca.php');
    exit;
}

$isbn = $_GET['ISBN'];
$nombreUsuario = $_SESSION['nombre_usuario'];

$visitas = registrarVisitaLibro($nombreUsuario, $isbn);

$nombreCookie = 'visitas_' . $nombreUsuario . '_' . $isbn;

$pdo = conectar();

$consulta = $pdo->prepare(
    'SELECT * FROM libros WHERE ISBN = ?'
);

$consulta->execute([$isbn]);

$libro = $consulta->fetch();

if (!$libro) {
    header('Location: biblioteca.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Libro seleccionado</title>
</head>
<body>

<h1>Libro seleccionado</h1>

<h2><?php echo htmlspecialchars($libro['Titulo']); ?></h2>

<?php if (!empty($libro['Portada'])): ?>

    <img
        src="<?php echo htmlspecialchars($libro['Portada']); ?>"
        alt="Portada del libro"
        width="200"
        style="height:auto;"
    >

<?php else: ?>

    <p>Sin portada disponible.</p>

<?php endif; ?>

<p>
    <strong>ISBN:</strong>
    <?php echo htmlspecialchars($libro['ISBN']); ?>
</p>

<p>
    <strong>Sinopsis:</strong>
    <?php echo htmlspecialchars($libro['Sinopsis']); ?>
</p>

<p>Has visto este libro <?php echo $visitas; ?> veces.</p>

<p>
    Nombre de la cookie:
    <?php echo htmlspecialchars($nombreCookie); ?>
</p>

<p>
    Valor anterior recibido:
    <?php
    echo isset($_COOKIE[$nombreCookie])
        ? htmlspecialchars($_COOKIE[$nombreCookie])
        : 'Todavía no existía';
    ?>
</p>

<a href="biblioteca.php">Volver a la biblioteca</a>

</body>
</html>
