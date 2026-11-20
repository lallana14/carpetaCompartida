<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Solo administradores (bibliotecarios) con sesión iniciada
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexion.php';

$autores = [];
$editoriales = [];
$error = null;
$mensaje = '';

// Número de libros a mostrar (1-3), elegido en el desplegable. Si no llega o no es válido, 1.
$cantidad = filter_input(INPUT_GET, 'cantidad', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1, 'max_range' => 3, 'default' => 1]
]) ?: 1;

try {
    $conexion = conectarAdmin();
    
    // Cargamos autores y editoriales para los desplegables
    $autores = $conexion->query("SELECT Id, Nombre, Apellidos FROM autores")->fetchAll();
    $editoriales = $conexion->query("SELECT Id, Nombre FROM editoriales")->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ISBN'])) {
        
        // Recogemos los arrays enviados por el formulario
        $isbns        = $_POST['ISBN'];
        $titulos      = $_POST['Titulo'];          
        $sinopsis     = $_POST['Sinopsis'] ?? [];
        $imagenes     = $_POST['Imagen'] ?? [];    
        $autores_post = $_POST['autores'] ?? [];
        $editoriales_post = $_POST['editoriales'] ?? [];

        // Consulta para agregar libros a la base de datos
        $insertar = "INSERT INTO libros (ISBN, Titulo, Sinopsis, Imagen, Id_Autor, Id_Editorial) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($insertar);
        
        $libros_guardados = 0;

        // Recorremos el array de ISBNs
        for ($i = 0; $i < count($isbns); $i++) {
            // Solo guardamos si tiene ISBN y Título
            if (!empty($isbns[$i]) && !empty($titulos[$i])) {
                
                $stmt->execute([
                    $isbns[$i],
                    $titulos[$i],
                    $sinopsis[$i] ?? '',
                    $imagenes[$i] ?? '',
                    $autores_post[$i],      
                    $editoriales_post[$i]    
                ]);
                $libros_guardados++;
            }
        }
        
        $mensaje = "Se han registrado $libros_guardados libros correctamente en la base de datos.";
    }

} catch (PDOException $e) {
    $error = 'Error en la base de datos: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Alta de libros</title>
</head>
<body>
<header>
    <a href="logout.php">Cerrar sesión</a>
    <h1>Panel de administración</h1>
    <p>Hola <?= htmlspecialchars($_SESSION['nombre_usuario'] ?? 'Usuario') ?>, has iniciado sesión <?= (int)($_SESSION['accesos'] ?? 0) ?> veces.</p>
</header>

<main>
    <h1>Alta de libros</h1>
    
    <!-- Mensajes de éxito o error -->
    <?php if ($mensaje): ?>
        <p style="color: green; font-weight: bold;"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <p style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    
    <!-- Paso 1: elegir cuántos libros se van a añadir (GET: solo cambia lo que se muestra) -->
    <form action="gestionBiblioteca.php" method="get" class="formulario">
        <label>¿Cuántos libros quieres añadir?
            <select name="cantidad" onchange="this.form.submit()">
                <?php for ($n = 1; $n <= 3; $n++): ?>
                    <option value="<?= $n ?>" <?= $n === $cantidad ? 'selected' : '' ?>><?= $n ?></option>
                <?php endfor; ?>
            </select>
        </label>
        <input type="submit" value="Mostrar">
    </form>

    <!-- Paso 2: datos de los libros (POST: guarda en la BD) -->
    <form action="gestionBiblioteca.php?cantidad=<?= $cantidad ?>" method="post" class="formulario">
        <div id="libros">
            <?php for ($indice = 0; $indice < $cantidad; $indice++): ?>
                <fieldset class="libro">
                    <legend>Libro <?= $indice + 1 ?></legend>
                    <label>ISBN: <input type="text" name="ISBN[]" required></label><br>
                    <label>Título: <input type="text" name="Titulo[]" required></label><br>
                    <label>Sinopsis: <br><textarea rows="4" cols="40" name="Sinopsis[]"></textarea></label><br>
                    <label>Imagen (ruta): <input type="text" placeholder="quijote.jpg" name="Imagen[]"></label><br>
                    
                    <label>Autor:
                        <select name="autores[]" required>
                            <option value="">Selecciona un autor</option>
                            <?php foreach ($autores as $autor): ?>
                                <option value="<?= (int)$autor['Id'] ?>">
                                    <?= htmlspecialchars($autor['Nombre'] . ' ' . $autor['Apellidos']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label><br>
                    
                    <label>Editorial:
                        <select name="editoriales[]" required>
                            <option value="">Selecciona una editorial</option>
                            <?php foreach ($editoriales as $editorial): ?>
                                <option value="<?= (int)$editorial['Id'] ?>">
                                    <?= htmlspecialchars($editorial['Nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </fieldset>
            <?php endfor; ?>
        </div>
        <input type="submit" value="Registrar libros">
    </form>
</main>
</body>
</html>