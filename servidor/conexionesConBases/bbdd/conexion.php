<?php
$conexion = new mysqli("localhost", "usuariomysql", "usuariomysql", "prueba", 3307);
$SQL = "SELECT * FROM gente";
$result = $conexion->query($SQL);
while($fila = $result->fetch_array()){
    echo $fila['nombre'] ." ". $fila['apellidos'] . "<br>";
}
?>