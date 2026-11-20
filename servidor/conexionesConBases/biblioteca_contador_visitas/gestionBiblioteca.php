<?php
//Importante hacerlo al principio del archivo
session_start();

if(!isset($_SESSION['rol']) || $_SESSION['rol']!=='admin'){
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/funciones.php';
$accesos = registrarAcceso($_SESSION['nombre_usuario']);

// NUEVO: libros para el listado y las visitas que ESTE usuario (admin) lleva de cada uno.
// El admin tiene su propia cookie "visitas_<su usuario>", separada de la de los clientes.
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
    <title>Administrador</title>
</head>
<body>
    <h1>Soy administrador</h1>
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
                        <td><?= $visitas[$libro['ISBN']] ?? 0 ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
