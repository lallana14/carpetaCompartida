<?php
// libro.php (VERSIÓN VULNERABLE PARA CLASE - MULTIPLES RESULTADOS)

require_once 'conexion.php';

// 1. Capturamos el ID (ISBN) de la URL. Si no existe, asignamos null
$ISBN_recibido = $_GET['id'] ?? null;

// Cambiamos $libro (singular) por un array $libros (plural)
$libros = [];
$error = null;

if ($ISBN_recibido) {
    try {
        $conexion = conectar();

        // VULNERABILIDAD: Concatenación directa de la entrada del usuario.
        $sql = "SELECT ISBN, Titulo, Id_Autor FROM libros WHERE ISBN = '" . $ISBN_recibido . "'";
        
        $stmt = $conexion->query($sql);

        // CAMBIO CLAVE: Usamos fetchAll() para atrapar TODAS las filas que devuelva MySQL
        $libros = $stmt->fetchAll();

        // Comprobamos si el array está vacío
        if (empty($libros)) {
            $error = "No se ha encontrado ningún libro con esos datos.";
        }

    } catch (PDOException $e) {
        $error = "Error SQL: " . $e->getMessage();
    }
} else {
    $error = "No se ha especificado qué libro quieres ver.";
}

// 3. Salida HTML (Vista)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Libro (Vulnerable)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .tarjeta { border: 1px solid #ccc; padding: 20px; max-width: 400px; border-radius: 8px; margin-top: 20px; background: #fdfdfd;}
        .error { color: red; font-weight: bold; margin-top: 20px; }
        .volver { display: inline-block; margin-top: 20px; padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .debug-sql { background: #1e1e1e; color: #5ce6cd; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 14px;}
        .contador { font-size: 1.1em; margin-top: 20px; color: #555; }
    </style>
</head>
<body>
    <h1>Demostración de Inyección SQL</h1>

    <div class="debug-sql">
        <span style="color:#888;">// Consulta ejecutada en el servidor:</span><br>
        SELECT ISBN, Titulo, Id_Autor FROM libros WHERE ISBN = '<span style="color:#ff7b72;"><?= htmlspecialchars($ISBN_recibido) ?></span>'
    </div>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif (!empty($libros)): ?>
        
        <!-- Mostramos cuántas filas ha devuelto la consulta -->
        <div class="contador">
            Se han devuelto <strong><?= count($libros) ?></strong> fila(s).
        </div>

        <!-- CAMBIO CLAVE: Recorremos el array con un bucle foreach -->
        <?php foreach ($libros as $libro): ?>
            <div class="tarjeta">
                <h2><?= htmlspecialchars($libro['Titulo']) ?></h2>
                <p><strong>ISBN:</strong> <?= htmlspecialchars($libro['ISBN']) ?></p>
                <p><strong>Id_Autor:</strong> <?= htmlspecialchars($libro['Id_Autor']) ?></p>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>

    <br>
    <a href="index.php" class="volver">← Volver al catálogo</a>

</body>
</html>