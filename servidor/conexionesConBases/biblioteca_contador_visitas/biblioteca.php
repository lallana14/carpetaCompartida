<?php
require_once __DIR__ . '/funciones.php';
//Importante hacerlo al principio del archivo
session_start();

// CORREGIDO: antes comprobaba 'admin' y un cliente entraba en un bucle de
// redirecciones (login -> biblioteca -> login -> ...). Esta página es la del cliente.
if(!isset($_SESSION['rol']) || $_SESSION['rol']!=='cliente'){
    header('Location: login.php');
    exit;
}

$accesos = registrarAcceso($_SESSION['nombre_usuario']);

// NUEVO: libros para el listado y las visitas que ESTE usuario lleva de cada uno
$libros = [];
$error = null;
try{
    $libros = obtenerLibros();
}catch(PDOException $e){
    $error = 'Error en la base de datos: ' . $e->getMessage();
}
$visitas = obtenerVisitas($_SESSION['nombre_usuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cliente</title>
</head>
<body>
    <h1>Soy cliente</h1>
    <p>Has accedido <?php echo $accesos; ?> veces a la biblioteca</p>

    <!-- NUEVO: listado de libros con el contador de visitas de cada uno -->
    <h2>Libros</h2>
    <?php if($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif(empty($libros)): ?>
        <p>No hay libros disponibles</p>
    <?php else: ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Veces visto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($libros as $libro): ?>
                    <tr>
                        <td>
                            <a href="libro.php?id=<?= urlencode($libro['ISBN']) ?>">
                                <?= htmlspecialchars($libro['Titulo']) ?>
                            </a>
                        </td>
                        <!-- Si el libro no está en la cookie, nunca lo ha visto: 0 -->
                        <td><?= $visitas[$libro['ISBN']] ?? 0 ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
