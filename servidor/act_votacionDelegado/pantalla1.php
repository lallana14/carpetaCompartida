<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla 1</title>
</head>
<body>
    <!-- Pantalla 1: 
•	Debe mostrar un formulario sencillo que pregunte al usuario: "¿Cuántos alumnos hay en la clase?".
•	Contendrá un campo numérico y un botón para "Comenzar votaciones" que enviará el dato a la siguiente pantalla. 
•	Los datos que se pasen a la segunda pantalla pueden ser visibles y deben permitir que no se pierdan al recargar la página. -->
    
    <form action="pantalla2.php" method="post">
        <!-- creamos el formulario que enviará los datos a pantalla2.php -->
        <label for="alumnos">¿Cuántos alumnos hay en la clase?</label>
        <!-- mostramos un campo numérico para que el usuario introduzca el número de alumnos -->
        <input type="number" id="alumnos" name="alumnos" required>
        <!-- mostramos un botón para comenzar las votaciones -->
        <button type="submit">Comenzar votaciones</button>
    </form>

</body>
</html>

<?php 
    if (isset($_POST['alumnos'])) {
        $alumnos = $_POST['alumnos'];
    } else {
        $alumnos = 0; // Valor por defecto si no se envía el dato
    }
?>
//Mario Lallana Campos
//DAW2 - IES Virgen del Espino
//Ejercicio de votación de delegado de clase
//7 de octubre de 2026