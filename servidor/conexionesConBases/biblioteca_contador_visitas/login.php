<?php
    require_once __DIR__ . '/conexion.php';

    session_start();

    if(isset($_SESSION['rol'])){
        if($_SESSION['rol']==='cliente'){
            header('Location: biblioteca.php');
            exit;
        }
        if($_SESSION['rol']==='admin'){
            header('Location: gestionBiblioteca.php');
            exit;
        }    

        //session_regenerate_id(true);
        //$_SESSION['nombre_usuario'] = $nombreUsuario;
        //$_SESSION['rol'] = 'cliente';
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if((isset($_POST['usuario']) && isset($_POST['contrasena']))
            && !empty($_POST['usuario']) && !empty($_POST['contrasena'])){

            $nombreUsuario = trim($_POST['usuario']);
            $password = trim($_POST['contrasena']);
            if($nombreUsuario === '' || $password === ''){
                $error = 'Falta usuario o contraseña';
            }else{
                $pdo = conectar();
                $consulta = $pdo->prepare(
                    'SELECT Id, Nombre_Usuario, Contrasena FROM usuarios WHERE Nombre_Usuario = :nombre'
                );
                $consulta->execute(['nombre' => $nombreUsuario]);
                $usuario = $consulta->fetch();

                if( $usuario !== false && $usuario['Contrasena'] === $password){
                    $consulta = $pdo->prepare(
                        'SELECT Id_Usuario FROM clientes WHERE Id_Usuario = :id'
                    );
                    $consulta->execute(['id' => $usuario['Id']]);
                    $permisosCliente = $consulta->fetch();

                    if($permisosCliente){
                        session_regenerate_id(true);
                        $_SESSION['nombre_usuario'] = $nombreUsuario;
                        $_SESSION['rol'] = 'cliente';

                        header('Location: biblioteca.php');
                        exit;
                    }else{
                        $consulta = $pdo->prepare(
                            'SELECT Id_Usuario FROM bibliotecarios WHERE Id_Usuario = :id'
                        );
                        $consulta->execute(['id' => $usuario['Id']]);
                        $permisosAdmin = $consulta->fetch();
                        
                        if($permisosAdmin){
                            session_regenerate_id(true);
                            $_SESSION['nombre_usuario'] = $nombreUsuario;
                            $_SESSION['rol'] = 'admin';

                            header('Location: gestionBiblioteca.php');
                            exit;
                        }
                    }

                }else{
                    $error = 'Usuario o contraseña erroneos';
                }
            }
    
        }
    }

?>

<!DOCTYPE html>
<head>
    <title>Inicio de sesión</title>
</head>
<body>
    <h1>Inicio de sesión</h1>

    <?php if(isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- forma alternativa de mostrar el error --> 
    <?php /* if(isset($error)){
        echo '<p style="color: red;">' . $error . '</p>';
    } */ ?>
    
    <form method="POST" action="login.php">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br><br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>