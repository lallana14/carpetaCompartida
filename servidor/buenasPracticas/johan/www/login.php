<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/funciones.php';

session_start();

$error = null;

// Si ya hay sesión iniciada, directo a su página
if (isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] === 'cliente') {
        header('Location: index.php');
        exit;
    }
    if ($_SESSION['rol'] === 'admin') {
        header('Location: gestionBiblioteca.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreUsuario = trim($_POST['usuario'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');

    if ($nombreUsuario === '' || $contrasena === '') {
        $error = 'Falta usuario o contraseña';
    } else {
        try {
            $pdo = conectar();

            $consulta = $pdo->prepare("SELECT Id, Nombre_usuario, contrasena FROM usuarios WHERE Nombre_usuario = :nombre");
            $consulta->execute(['nombre' => $nombreUsuario]);
            $usuario = $consulta->fetch();

            if ($usuario !== false && verificarContrasena($contrasena, $usuario['contrasena'])) {
                // ¿Es cliente?
                $consulta = $pdo->prepare("SELECT Id_Usuario FROM clientes WHERE Id_Usuario = :id");
                $consulta->execute(['id' => $usuario['Id']]);
                $esCliente = $consulta->fetch();

                if ($esCliente) {
                    session_regenerate_id(true);
                    $_SESSION['nombre_usuario'] = $nombreUsuario;
                    $_SESSION['rol'] = 'cliente';
                    $_SESSION['accesos'] = contarAcceso($nombreUsuario);   // contador de inicios de sesión

                    header('Location: index.php');
                    exit;
                } else {
                    // ¿Es bibliotecario?
                    $consulta = $pdo->prepare("SELECT Id_Usuario FROM bibliotecarios WHERE Id_Usuario = :id");
                    $consulta->execute(['id' => $usuario['Id']]);
                    $esAdmin = $consulta->fetch();

                    if ($esAdmin) {
                        session_regenerate_id(true);
                        $_SESSION['nombre_usuario'] = $nombreUsuario;
                        $_SESSION['rol'] = 'admin';
                        $_SESSION['accesos'] = contarAcceso($nombreUsuario);

                        header('Location: gestionBiblioteca.php');
                        exit;
                    } else {
                        $error = 'Este usuario no tiene permisos';
                    }
                }
            } else {
                $error = 'Usuario o contraseña incorrectos';
            }
        } catch (PDOException $e) {
            $error = 'Error en la base de datos: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inicio de sesión</title>
</head>
<body>
    <h1>Inicio de sesión</h1>

    <?php if ($error): ?>
        <p class="error" style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php" class="formulario">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
