
<?php

session_start();

require_once __DIR__ . '/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit;
}

$pdo = conectar();

$consulta = $pdo->query('SELECT * FROM libros');
$libros = $consulta->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
</head>
<body>

<h1>Biblioteca</h1>

<?php foreach ($libros as $libro): ?>

    <div>

        <h2>
            <?php echo htmlspecialchars($libro['Titulo']); ?>
        </h2>

        <?php if (!empty($libro['Portada'])): ?>

            <img
                src="<?php echo htmlspecialchars($libro['Portada']); ?>"
                alt="Portada"
                width="150"
                style="height:auto;"
            >

        <?php else: ?>

            <p>Sin portada disponible</p>

        <?php endif; ?>

        <br>

        <a href="libro.php?ISBN=<?php echo urlencode($libro['ISBN']); ?>">
            Ver libro
        </a>

    </div>

    <hr>

<?php endforeach; ?>

<a href="logout.php">Cerrar sesión</a>

</body>
</html>
