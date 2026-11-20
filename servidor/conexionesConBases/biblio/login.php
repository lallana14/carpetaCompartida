<?php
$conexion = new mysqli("127.0.0.1", "root", "root", "biblioteca", 3307);

if ($conexion->connect_error) {
    die("Error de conexión");
}

$error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        $sql = $conexion->prepare(
            "SELECT Id FROM usuarios
            WHERE Nombre_Usuario = ? AND Contrasena = ?"
        );

        $sql->bind_param("ss", $usuario, $contrasena);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($resultado->num_rows == 1) {
            header("Location: index.php");
            exit;
        }else {
            $error = "Usuario o contraseña incorrectos";
        }

        $sql->close();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Biblioteca</title>
</head>
<body>

    <h2>Iniciar sesión</h2>

    <p style="color: red;">
        <?= htmlspecialchars($error) ?>
    </p>

    <form method="post">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>

        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>

        <br><br>

        <button type="submit">Entrar</button>
    </form>

</body>
</html>