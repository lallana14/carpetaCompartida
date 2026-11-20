<?php

$usuario_recibido = $_POST ['usuario'];
$password_recibida = $_POST ['password'];

$usuario_correcto = 'admin';
$password_correcto = '1234';

if($usuario_recibido == $usuario_correcto  && $password_recibida == $password_correcto){
    header("Location: exito.html");
}else{
    echo"<h2>Error de acceso</h2>";
    echo"<p>El usuario o la contraseña son incorrectos</p>";
    echo "<a href='index.html'>Volver al inicio";
}

?>