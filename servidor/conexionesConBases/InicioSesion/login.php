<?php
    require_once __DIR__ . "/conexion.php";
    session_start();

    if(isset($_SESSION['rol'])){

    }

    if($_SERVER['REQUEST_METHOD' === 'POST']){
        if(isset($_POST['usuario']) && isset($_POST['contraseña'])&& !empty($_POST['usuario']) && !empty($_POST['contraseña'])){
            $nombreUsuario = trim($_POST['usuario']);
            $password = trim($_POST['contraseña']);
            if($nombreUsuario === "" || $password === ""){
                echo "Falta usuario o contraseña";
            }else{
                $pdo = conectar();
                $consulta = $pdo->prepare(
                    'SELECT Id, Nombre_Usuario, Contrasena FROM usuarios WHERE Nombre_Usuario = :nombre'
                );
                $consulta ->execute(['nombre' => $nombreUsuario]);
                $usuario  = $consulta->fetch();

                if($usuario !== false && $usuario['Contrasena'] === $password){
                    $consulta  = $pdo->prepare(
                        'SELECT Id_Usuario FROM cliente WHERE Id_Usuario = :id'
                    );
                    $consulta->execute(['id' => $usuario['Id']]);
                    $premisosCliente = $consulta->fetch();

                    if($permisosCliente){
                        header('Location:biblioteca.php');
                        exit;
                    }else{
                        $consulta = $pdo->prepare(
                            'SELECT Id_Usuario FROM bibliotecarios WHERE Id_Usuario = :id'
                        );
                        $consulta->execute(['id' => $usuario['Id']]);
                        $permisosAdmin = $consulta->fetch();

                        if($permisosAdmin){
                            header('Location:gestionBiblioteca.php');
                            exit;
                        }else{
                            echo "Usuario sin permisos";
                        }
                    }
                }else{
                    echo "Usuario o contraseña erroneos";
                }
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio de Sesión</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>