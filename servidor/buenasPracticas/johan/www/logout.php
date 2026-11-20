<?php
session_start();

//Metodo para cerrar sesion y destruir la sesion actual
// poco eficiente, pero funcional
// unset($_SESSION['rol]);
// unset($_SESSION['nombre_usuario']);

foreach (array_keys($_SESSION) as $key){
    unset($_SESSION[$key]);

}

session_destroy();

header("Location: login.php");
exit();
?>