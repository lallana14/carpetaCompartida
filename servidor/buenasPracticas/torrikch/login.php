
<?php

require_once __DIR__ . '/conexion.php';

session_start();

if (isset($_SESSION['rol'])) {

    if ($_SESSION['rol'] === 'cliente') {
        header('Location: biblioteca.php');
        exit;
    }

    if ($_SESSION['rol'] === 'admin') {
        header('Location: gestionBiblioteca.php');
        exit;
    }
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['usuario']) && !empty($_POST['contrasena'])) {

        $nombreUsuario = trim($_POST['usuario']);
        $password = trim($_POST['contrasena']);

        $pdo = conectar();

        $consulta = $pdo->prepare(
            'SELECT Id, Nombre_Usuario, Contrasena
             FROM usuarios
             WHERE Nombre_Usuario = :nombre'
        );

        $consulta->execute(['nombre' => $nombreUsuario]);

        $usuario = $consulta->fetch();

        if ($usuario && $usuario['Contrasena'] === $password) {

            $consulta = $pdo->prepare(
                'SELECT Id_Usuario FROM clientes
                 WHERE Id_Usuario = :id'
            );

            $consulta->execute(['id' => $usuario['Id']]);

            $permisosCliente = $consulta->fetch();

            if ($permisosCliente) {

                session_regenerate_id(true);

                $_SESSION['nombre_usuario'] = $nombreUsuario;
                $_SESSION['rol'] = 'cliente';

                header('Location: biblioteca.php');
                exit;

            } else {

                $consulta = $pdo->prepare(
                    'SELECT Id_Usuario FROM bibliotecarios
                     WHERE Id_Usuario = :id'
                );

                $consulta->execute(['id' => $usuario['Id']]);

                $permisosAdmin = $consulta->fetch();

                if ($permisosAdmin) {

                    session_regenerate_id(true);

                    $_SESSION['nombre_usuario'] = $nombreUsuario;
                    $_SESSION['rol'] = 'admin';

                    header('Location: gestionBiblioteca.php');
                    exit;

                } else {

                    $error = 'El usuario no tiene permisos.';

                }
            }

        } else {

            $error = 'Usuario o contraseña incorrectos.';

        }

    } else {

        $error = 'Introduce usuario y contraseña.';

    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>

    <style>

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
        }

        .form {
            background-color: white;
            padding: 25px;
            width: 100%;
            max-width: 350px;
            box-sizing: border-box;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-title {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4F46E5;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4338CA;
        }

    </style>
</head>

<body>

<form class="form" method="POST" action="login.php">

    <p class="form-title">Inicio de sesión</p>

    <?php if ($error !== ''): ?>

        <p style="color:red; text-align:center;">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>

    <input
        type="text"
        name="usuario"
        placeholder="Introduce tu usuario"
        required
    >

    <input
        type="password"
        name="contrasena"
        placeholder="Introduce tu contraseña"
        required
    >

    <button type="submit">Iniciar sesión</button>

</form>

</body>
</html>
