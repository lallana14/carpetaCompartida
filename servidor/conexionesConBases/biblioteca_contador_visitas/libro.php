<?php
// libro.php (NUEVO) - Muestra un libro y cuenta cuántas veces lo ha visto este usuario.
// Lo usan tanto los clientes como los administradores.
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/funciones.php';

// Importante hacerlo al principio del archivo
session_start();

// Solo pueden entrar usuarios con sesión iniciada (cliente o admin)
if(!isset($_SESSION['rol'])){
    header('Location: login.php');
    exit;
}

// A qué página tiene que volver cada rol
$paginaVolver = ($_SESSION['rol'] === 'admin') ? 'gestionBiblioteca.php' : 'biblioteca.php';

// 1. Capturamos el ISBN de la URL (libro.php?id=XXXX)
$isbn  = $_GET['id'] ?? null;
$libro = null;
$error = null;
$visitas = 0;

if($isbn){
    try{
        $conexion = conectar();

        // Consulta preparada: el ISBN nunca se concatena en el SQL (evita inyección SQL)
        $stmt = $conexion->prepare('SELECT ISBN, Titulo, Id_Autor FROM libros WHERE ISBN = :isbn');
        $stmt->execute(['isbn' => $isbn]);
        $libro = $stmt->fetch();

        if(!$libro){
            $error = 'No se ha encontrado ningún libro con esos datos.';
        }else{
            // 2. El libro existe: sumamos una visita en la cookie de ESTE usuario.
            //    Solo contamos libros que existen, para que nadie llene la cookie
            //    con ISBN inventados escribiendo cualquier cosa en la URL.
            $visitas = registrarVisitaLibro($_SESSION['nombre_usuario'], $libro['ISBN']);
        }
    }catch(PDOException $e){
        $error = 'Error en la base de datos: ' . $e->getMessage();
    }
}else{
    $error = 'No se ha especificado qué libro quieres ver.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del libro</title>
</head>
<body>
    <?php if($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php else: ?>
        <h1><?= htmlspecialchars($libro['Titulo']) ?></h1>
        <p><strong>ISBN:</strong> <?= htmlspecialchars($libro['ISBN']) ?></p>
        <p><strong>Id_Autor:</strong> <?= htmlspecialchars($libro['Id_Autor']) ?></p>

        <p>Has visto este libro <strong><?= $visitas ?></strong> veces</p>
    <?php endif; ?>

    <a href="<?= $paginaVolver ?>">← Volver a la biblioteca</a>
</body>
</html>
