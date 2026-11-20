
<?php

session_start();

require_once __DIR__ . '/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$pdo = conectarAdmin();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $isbn = trim($_POST['ISBN']);
    $titulo = trim($_POST['Titulo']);
    $sinopsis = trim($_POST['Sinopsis']);
    $idAutor = $_POST['Id_Autor'];
    $idEditorial = $_POST['Id_Editorial'];

    if (!isset($_FILES['Portada']) ||
        $_FILES['Portada']['error'] !== UPLOAD_ERR_OK) {

        $mensaje = 'Selecciona una portada.';

    } elseif ($_FILES['Portada']['size'] > 5 * 1024 * 1024) {

        $mensaje = 'La imagen no puede superar los 5 MB.';

    } else {

        $tipo = mime_content_type($_FILES['Portada']['tmp_name']);

        $extensiones = [
            'image/jpeg' => '.jpg',
            'image/png' => '.png',
            'image/webp' => '.webp'
        ];

        if (!isset($extensiones[$tipo]) ||
            getimagesize($_FILES['Portada']['tmp_name']) === false) {

            $mensaje = 'Formato de imagen no válido.';

        } else {

            $carpeta = __DIR__ . '/portadas/';

            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0755, true);
            }

            $nombreImagen = bin2hex(random_bytes(16))
                          . $extensiones[$tipo];

            $destino = $carpeta . $nombreImagen;

            if (move_uploaded_file(
                $_FILES['Portada']['tmp_name'],
                $destino
            )) {

                $ruta = 'portadas/' . $nombreImagen;

                try {

                    $sql = "INSERT INTO libros
                    (ISBN, Titulo, Sinopsis, Id_Autor, Id_Editorial, Portada)
                    VALUES (?, ?, ?, ?, ?, ?)";

                    $consulta = $pdo->prepare($sql);

                    $consulta->execute([
                        $isbn,
                        $titulo,
                        $sinopsis,
                        $idAutor,
                        $idEditorial,
                        $ruta
                    ]);

                    $mensaje = 'Libro añadido correctamente.';

                } catch (PDOException $e) {

                    unlink($destino);
                    $mensaje = 'Error al guardar. Comprueba los datos y el ISBN.';

                }

            } else {

                $mensaje = 'Error al subir la portada.';

            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Añadir libro</title>
</head>
<body>

<h1>Añadir un libro</h1>

<p><?php echo htmlspecialchars($mensaje); ?></p>

<form method="POST" enctype="multipart/form-data">

    <label>ISBN:</label><br>
    <input type="text" name="ISBN" required>
    <br><br>

    <label>Título:</label><br>
    <input type="text" name="Titulo" required>
    <br><br>

    <label>Sinopsis:</label><br>
    <textarea name="Sinopsis" required></textarea>
    <br><br>

    <label>ID del autor:</label><br>
    <input type="number" name="Id_Autor" min="1" required>
    <br><br>

    <label>ID de la editorial:</label><br>
    <input type="number" name="Id_Editorial" min="1" required>
    <br><br>

    <label>Portada:</label><br>
    <input type="file" name="Portada"
           accept=".jpg,.jpeg,.png,.webp" required>
    <br><br>

    <button type="submit">Añadir libro</button>

</form>

<br>
<a href="gestionBiblioteca.php">Volver al administrador</a>

</body>
</html>
