<?php
session_start();

// Solo clientes con sesión iniciada
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/funciones.php';

$ISBN_recibido = $_GET['id'] ?? null;
$libro = null;
$error = null;
$visitas = 0;

if ($ISBN_recibido) {
    try {
        $conexion = conectar();

        $stmt = $conexion->prepare("SELECT ISBN, Titulo, Id_Autor FROM libros WHERE ISBN = :isbn");
        $stmt->execute(['isbn' => $ISBN_recibido]);
        $libro = $stmt->fetch();

        if (empty($libro)) {
            $error = 'No se ha encontrado ningún libro con esos datos.';
        } else {
            // Suma una visita de este usuario a este libro
            $visitas = contarVisitaLibro($_SESSION['nombre_usuario'], $libro['ISBN']);
        }
    } catch (PDOException $e) {
        $error = 'Error SQL: ' . $e->getMessage();
    }
} else {
    $error = 'No se ha especificado qué libro quieres ver.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Detalles del libro</title>
</head>
<body>
    <h1>Detalles del libro</h1>

    <?php if ($error): ?>
        <p class="error" style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php else: ?>
        <h2><?= htmlspecialchars($libro['Titulo']) ?></h2>
        <p><strong>ISBN:</strong> <?= htmlspecialchars($libro['ISBN']) ?></p>
        <p><strong>Id_Autor:</strong> <?= htmlspecialchars($libro['Id_Autor']) ?></p>
        <p>Has visto este libro <strong><?= $visitas ?></strong> veces.</p>
    <?php endif; ?>

    <br>
    <a href="index.php">← Volver al catálogo</a>
</body>
</html>
