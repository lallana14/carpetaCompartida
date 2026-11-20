<?php
session_start();

// Solo clientes con sesión iniciada
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

$libros = [];
$error = null;

try {
    $conexion = conectar();
    $libros = $conexion->query("SELECT libros.ISBN, libros.Titulo, libros.Imagen FROM libros
    INNER JOIN ejemplares ON ejemplares.ISBN_Libro = libros.ISBN
    where ejemplares.Estado = 'Disponible'
    ORDER BY libros.Titulo")->fetchAll();
} catch (PDOException $e) {
    $error = 'Error en la base de datos: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Biblioteca</title>
</head>
<body>
    <h1>Biblioteca</h1>
    <p>Hola <?= htmlspecialchars($_SESSION['nombre_usuario']) ?>, has iniciado sesión <?= (int)$_SESSION['accesos'] ?> veces.</p>
    <a href="logout.php">CERRAR SESION</a>

    <h2>Libros</h2>

    <?php if ($error): ?>
        <p class="error" style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif (empty($libros)): ?>
        <p>No hay libros disponibles</p>
    <?php else: ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>ISBN</th>
                    <th>Título</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $libro): ?>
                    <tr>
                        <td>
                            <?php if (!empty($libro['Imagen'])): ?>
                                <img src="imagenes/<?= htmlspecialchars($libro['Imagen']) ?>" alt="Portada" width="80">
                            <?php else: ?>
                                Sin imagen
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($libro['ISBN']) ?></td>
                        <td><?= htmlspecialchars($libro['Titulo']) ?></td>
                        <td><a href="libro.php?id=<?= urlencode($libro['ISBN']) ?>">Ver libro</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
