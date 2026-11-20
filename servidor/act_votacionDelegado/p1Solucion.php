<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Votación de delegados</h1>
    <form action="votacion.php" method="get">
        <label for="numeroAlumnos">Número de alumnos:</label>
        <input type="number" id="numeroAlumnos" name="numeroAlumnos" required>
        <br><br>
        <label for="nombreCandidatos">Nombres de los candidatos (separados por comas):</label>
        <input type="text" id="nombreCandidatos" name="nombreCandidatos">
        <br><br>
        <button type="submit">Votar</button>
    </form>
</body>
</html>