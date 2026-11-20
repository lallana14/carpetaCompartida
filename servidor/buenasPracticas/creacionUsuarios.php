<?php

$mensaje = ""; // Variable para mostrar avisos de éxito o error en el HTML

// =========================================================================
// PROCESAMIENTO DEL FORMULARIO
// =========================================================================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. Recogida de datos comunes del formulario
    $nombre    = $_POST["nombre"] ?? "";
    $apellidos = $_POST["apellidos"] ?? "";
    $usuario   = $_POST["usuario"] ?? "";
    $password  = $_POST["password"] ?? "";
    
    // Campo Moroso siempre a false (0 en MySQL / TINYINT(1))
    $moroso    = false; // O $_POST["moroso"] ?? 0;

    // Archivo de foto (disponible en $_FILES["foto"] si se ha seleccionado alguno)
    $foto      = $_FILES["foto"] ?? null;

    // Identificador del caso seleccionado (opcional, para probar los 4 en el mismo archivo)
    $caso      = $_POST["caso"] ?? "1";

    try {
        // TODO: Iniciar conexión PDO y configurar ERRMODE_EXCEPTION
        // $dsn = "mysql:host=$host;port=$puerto;dbname=$dbname;charset=utf8mb4";
        // $conexion = new PDO($dsn, $db_user, $db_pass);
        // $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        switch ($caso) {
            case "1":
                // -------------------------------------------------------------
                // CASO 1: Crear un usuario SIN foto
                // -------------------------------------------------------------
                // TODO:
                // - Preparar sentencia INSERT (la columna foto quedará NULL o vacía).
                // - Recuerda encriptar la contraseña con password_hash() si aplica.
                // - Ejecutar con execute([...]).
                break;

            case "2":
                // -------------------------------------------------------------
                // CASO 2: Crear un usuario subiendo la foto como ARCHIVO al servidor
                // -------------------------------------------------------------
                // TODO:
                // - Comprobar que $_FILES["foto"]["error"] === UPLOAD_ERR_OK.
                // - Validar tipo/tamaño y generar una ruta destino (ej. "uploads/" . $nombreArchivo).
                // - Mover el archivo temporal con move_uploaded_file().
                // - Guardar únicamente la RUTA (string) en la base de datos.
                break;

            case "3":
                // -------------------------------------------------------------
                // CASO 3: Crear VARIOS usuarios simultáneamente
                // -------------------------------------------------------------
                // TODO:
                // - Definir un array con varios usuarios (o recoger inputs en formato array: nombre[]).
                // - Opcional: Iniciar transacción ($conexion->beginTransaction()).
                // - Preparar el INSERT una sola vez fuera del bucle.
                // - Enlazar parámetros con bindParam() y recorrer el array ejecutando execute().
                // - Confirmar con commit() (y hacer rollBack() en el catch si falla alguno).
                break;

            case "4":
                // -------------------------------------------------------------
                // CASO 4: Subir la foto como TEXTO directamente a la base de datos
                // -------------------------------------------------------------
                // TODO:
                // - Comprobar que se ha subido la imagen sin errores.
                // - Leer el contenido binario del archivo temporal con file_get_contents($_FILES["foto"]["tmp_name"]).
                // - Convertir el contenido a texto con base64_encode().
                // - Guardar esa cadena de texto en la BD (la columna debe ser LONGTEXT).
                break;
        }

        $mensaje = "Operación del Caso $caso pendiente de implementar.";

    } catch (PDOException $e) {
        // TODO: Si hay una transacción abierta ($conexion->inTransaction()), hacer rollBack().
        $mensaje = "Error de base de datos: " . $e->getMessage();
    }

    $conexion = null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios - Biblioteca</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; padding: 0 20px; }
        form { display: flex; flex-direction: column; gap: 12px; }
        label { font-weight: bold; display: flex; flex-direction: column; gap: 4px; }
        input, select, button { padding: 8px; font-size: 14px; }
        button { background-color: #0056b3; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #004494; }
        .mensaje { padding: 10px; background-color: #eef; border-left: 4px solid #0056b3; margin-bottom: 15px; }
    </style>
</head>
<body>

    <h1>Alta de Usuarios</h1>

    <?php if (!empty($mensaje)): ?>
        <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <!-- IMPORTANTE: enctype="multipart/form-data" es obligatorio para poder enviar archivos ($_FILES) -->
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">

        <label>
            Caso a ejecutar:
            <select name="caso">
                <option value="1">Caso 1: Usuario sin foto</option>
                <option value="2">Caso 2: Foto como archivo en el servidor</option>
                <option value="3">Caso 3: Varios usuarios simultáneamente</option>
                <option value="4">Caso 4: Foto como texto (Base64) en la BD</option>
            </select>
        </label>

        <label>
            Nombre:
            <input type="text" name="nombre" placeholder="Ej. Laura">
        </label>

        <label>
            Apellidos:
            <input type="text" name="apellidos" placeholder="Ej. Martínez Gómez">
        </label>

        <label>
            Nombre de usuario:
            <input type="text" name="usuario" placeholder="Ej. lmartinez">
        </label>

        <label>
            Contraseña:
            <input type="password" name="password">
        </label>

        <label>
            Administrador:
            <select name="administrador"> 
                <option value="1">Administrador</option>
                <option value="2">Cliente</option>
            </select>
        </label>

        <label>
            Foto de perfil:
            <input type="file" name="foto" accept="image/*">
        </label>

        <!-- Campo Moroso inicializado a false (0) -->
        <input type="hidden" name="moroso" value="0">

        <button type="submit">Guardar usuario(s)</button>
    </form>

</body>
</html>
