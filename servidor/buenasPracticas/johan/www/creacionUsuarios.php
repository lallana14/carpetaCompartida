<?php
session_start();

// Conexión y funciones comunes del proyecto (ajusta la ruta si este archivo está fuera de /www)
require_once __DIR__ . "/conexion.php";
require_once __DIR__ . "/funciones.php";

// Si tu conexion.php define una función (ej. obtenerConexion()) en lugar de $conexion,
// descomenta y adapta la línea correspondiente:
// if (!isset($conexion) && function_exists("obtenerConexion")) {
//     $conexion = obtenerConexion();
// }

$mensaje = ""; // Variable para mostrar avisos de éxito o error en el HTML
$tipoMensaje = "info"; // "info", "exito" o "error"

// =========================================================================
// PROCESAMIENTO DEL FORMULARIO
// =========================================================================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. Recogida y limpieza básica de datos comunes del formulario
    $nombre        = trim($_POST["nombre"] ?? "");
    $apellidos     = trim($_POST["apellidos"] ?? "");
    $usuario       = trim($_POST["usuario"] ?? "");
    $password      = $_POST["password"] ?? "";
    $administrador = (int) ($_POST["administrador"] ?? 2); // 1 = Administrador, 2 = Cliente
    $nss           = trim($_POST["nss"] ?? "");            // Nº Seguridad Social (obligatorio solo para administradores)

    // Campo Moroso siempre a false (0 en MySQL / TINYINT(1))
    $moroso        = 0;

    // Archivo de foto (disponible en $_FILES["foto"] si se ha seleccionado alguno)
    $foto          = $_FILES["foto"] ?? null;

    // Identificador del caso seleccionado
    $caso          = $_POST["caso"] ?? "1";

    // Función auxiliar local para validar y mover la imagen al servidor (Caso 2)
    $subirFotoServidor = function (?array $archivo): string {
        if (!$archivo || !isset($archivo["error"]) || $archivo["error"] !== UPLOAD_ERR_OK) {
            throw new RuntimeException("Debes seleccionar una imagen válida sin errores de subida.");
        }

        $maxBytes = 2 * 1024 * 1024; // 2 MB
        if ($archivo["size"] > $maxBytes) {
            throw new RuntimeException("La imagen supera el tamaño máximo permitido (2 MB).");
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($archivo["tmp_name"]);
        $extensionesPermitidas = [
            "image/jpeg" => "jpg",
            "image/png"  => "png",
            "image/webp" => "webp",
            "image/gif"  => "gif",
        ];

        if (!isset($extensionesPermitidas[$mimeType])) {
            throw new RuntimeException("Formato de imagen no permitido. Usa JPG, PNG, WEBP o GIF.");
        }

        $carpetaDestino = __DIR__ . "/imagenes/usuarios/";
        $rutaRelativaBase = "imagenes/usuarios/";

        if (!is_dir($carpetaDestino) && !mkdir($carpetaDestino, 0775, true)) {
            throw new RuntimeException("No se pudo crear el directorio de destino para las imágenes.");
        }

        $nombreUnico = uniqid("usr_", true) . "." . $extensionesPermitidas[$mimeType];
        $rutaFisica  = $carpetaDestino . $nombreUnico;
        $rutaBD      = $rutaRelativaBase . $nombreUnico;

        if (!move_uploaded_file($archivo["tmp_name"], $rutaFisica)) {
            throw new RuntimeException("Error al mover la imagen subida al servidor.");
        }

        return $rutaBD;
    };

    // Función auxiliar local: inserta en `usuarios` y, según el rol, en `bibliotecarios` (admin) o `clientes`.
    // Va en una transacción para no dejar un usuario sin rol si algo falla (el catch hace el rollBack).
    $crearUsuario = function (PDO $conexion, array $d): void {
        $conexion->beginTransaction();

        $stmt = $conexion->prepare(
            "INSERT INTO usuarios (Nombre, Apellidos, Nombre_Usuario, Contrasena, Foto, Moroso)
             VALUES (:nombre, :apellidos, :usuario, :password, :foto, :moroso)"
        );
        $stmt->execute([
            ":nombre"    => $d["nombre"],
            ":apellidos" => $d["apellidos"],
            ":usuario"   => $d["usuario"],
            ":password"  => $d["password"],
            ":foto"      => $d["foto"],
            ":moroso"    => $d["moroso"],
        ]);
        $idUsuario = (int) $conexion->lastInsertId();

        if ($d["administrador"] === 1) {
            $stmt = $conexion->prepare("INSERT INTO bibliotecarios (Id_Usuario, Num_Seguridad_Social) VALUES (:id, :nss)");
            $stmt->execute([":id" => $idUsuario, ":nss" => $d["nss"]]);
        } else {
            $stmt = $conexion->prepare("INSERT INTO clientes (Id_Usuario) VALUES (:id)");
            $stmt->execute([":id" => $idUsuario]);
        }

        $conexion->commit();
    };

    try {
        // Conexión con el usuario que tiene permisos de escritura (conexion.php ya activa ERRMODE_EXCEPTION)
        $conexion = conectarAdmin();

        switch ($caso) {
            case "1":
                // -------------------------------------------------------------
                // CASO 1: Crear un usuario SIN foto
                // -------------------------------------------------------------
                if ($nombre === "" || $apellidos === "" || $usuario === "" || $password === "") {
                    throw new InvalidArgumentException("Completa nombre, apellidos, usuario y contraseña.");
                }
                if ($administrador === 1 && $nss === "") {
                    throw new InvalidArgumentException("Un administrador necesita su número de Seguridad Social.");
                }

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $fotoNull = null;

                $crearUsuario($conexion, [
                    "nombre"        => $nombre,
                    "apellidos"     => $apellidos,
                    "usuario"       => $usuario,
                    "password"      => $passwordHash,
                    "administrador" => $administrador,
                    "nss"           => $nss,
                    "moroso"        => $moroso,
                    "foto"          => $fotoNull,
                ]);

                $mensaje = "Caso 1 completado: usuario '$usuario' creado sin foto.";
                $tipoMensaje = "exito";
                break;

            case "2":
                // -------------------------------------------------------------
                // CASO 2: Crear un usuario subiendo la foto como ARCHIVO al servidor
                // -------------------------------------------------------------
                if ($nombre === "" || $apellidos === "" || $usuario === "" || $password === "") {
                    throw new InvalidArgumentException("Completa nombre, apellidos, usuario y contraseña.");
                }
                if ($administrador === 1 && $nss === "") {
                    throw new InvalidArgumentException("Un administrador necesita su número de Seguridad Social.");
                }

                $rutaFoto = $subirFotoServidor($foto);
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $crearUsuario($conexion, [
                    "nombre"        => $nombre,
                    "apellidos"     => $apellidos,
                    "usuario"       => $usuario,
                    "password"      => $passwordHash,
                    "administrador" => $administrador,
                    "nss"           => $nss,
                    "moroso"        => $moroso,
                    "foto"          => $rutaFoto,
                ]);

                $mensaje = "Caso 2 completado: usuario '$usuario' creado y foto guardada en '$rutaFoto'.";
                $tipoMensaje = "exito";
                break;

            case "3":
                // -------------------------------------------------------------
                // CASO 3: Crear VARIOS usuarios simultáneamente
                // -------------------------------------------------------------
                $usuariosLote = [
                    [
                        "nombre"        => "Ana",
                        "apellidos"     => "Pérez López",
                        "usuario"       => "aperez_" . rand(100, 999),
                        "password"      => password_hash("1234", PASSWORD_DEFAULT),
                        "administrador" => 2,
                        "moroso"        => 0,
                        "foto"          => null,
                    ],
                    [
                        "nombre"        => "Carlos",
                        "apellidos"     => "Ruiz Martín",
                        "usuario"       => "cruiz_" . rand(100, 999),
                        "password"      => password_hash("1234", PASSWORD_DEFAULT),
                        "administrador" => 2,
                        "moroso"        => 0,
                        "foto"          => null,
                    ],
                    [
                        "nombre"        => "Elena",
                        "apellidos"     => "Sánchez Gil",
                        "usuario"       => "esanchez_" . rand(100, 999),
                        "password"      => password_hash("1234", PASSWORD_DEFAULT),
                        "administrador" => 1,
                        "nss"           => "ES" . rand(1000000000, 9999999999),
                        "moroso"        => 0,
                        "foto"          => null,
                    ],
                ];

                $conexion->beginTransaction();

                $sql = "INSERT INTO usuarios (Nombre, Apellidos, Nombre_Usuario, Contrasena, Foto, Moroso)
                        VALUES (:nombre, :apellidos, :usuario, :password, :foto, :moroso)";
                $stmt = $conexion->prepare($sql);
                $stmtBibliotecario = $conexion->prepare("INSERT INTO bibliotecarios (Id_Usuario, Num_Seguridad_Social) VALUES (:id, :nss)");
                $stmtCliente = $conexion->prepare("INSERT INTO clientes (Id_Usuario) VALUES (:id)");

                // Variables enlazadas por referencia mediante bindParam()
                $bNombre = "";
                $bApellidos = "";
                $bUsuario = "";
                $bPassword = "";
                $bMoroso = 0;
                $bFoto = null;

                $stmt->bindParam(":nombre", $bNombre, PDO::PARAM_STR);
                $stmt->bindParam(":apellidos", $bApellidos, PDO::PARAM_STR);
                $stmt->bindParam(":usuario", $bUsuario, PDO::PARAM_STR);
                $stmt->bindParam(":password", $bPassword, PDO::PARAM_STR);
                $stmt->bindParam(":moroso", $bMoroso, PDO::PARAM_INT);
                $stmt->bindParam(":foto", $bFoto, PDO::PARAM_NULL);

                foreach ($usuariosLote as $u) {
                    $bNombre    = $u["nombre"];
                    $bApellidos = $u["apellidos"];
                    $bUsuario   = $u["usuario"];
                    $bPassword  = $u["password"];
                    $bMoroso    = $u["moroso"];
                    $bFoto      = $u["foto"];

                    $stmt->execute();

                    $idNuevo = (int) $conexion->lastInsertId();
                    if ($u["administrador"] === 1) {
                        $stmtBibliotecario->execute([":id" => $idNuevo, ":nss" => $u["nss"]]);
                    } else {
                        $stmtCliente->execute([":id" => $idNuevo]);
                    }
                }

                $conexion->commit();
                $mensaje = "Caso 3 completado: se insertaron " . count($usuariosLote) . " usuarios en una transacción.";
                $tipoMensaje = "exito";
                break;

            case "4":
                // -------------------------------------------------------------
                // CASO 4: Subir la foto como TEXTO (Base64) directamente a la BD
                // -------------------------------------------------------------
                if ($nombre === "" || $apellidos === "" || $usuario === "" || $password === "") {
                    throw new InvalidArgumentException("Completa nombre, apellidos, usuario y contraseña.");
                }
                if ($administrador === 1 && $nss === "") {
                    throw new InvalidArgumentException("Un administrador necesita su número de Seguridad Social.");
                }
                if (!$foto || !isset($foto["error"]) || $foto["error"] !== UPLOAD_ERR_OK) {
                    throw new RuntimeException("Debes seleccionar una imagen para codificar en Base64.");
                }

                $contenidoBinario = file_get_contents($foto["tmp_name"]);
                if ($contenidoBinario === false) {
                    throw new RuntimeException("No se pudo leer el archivo temporal subido.");
                }

                $fotoBase64 = base64_encode($contenidoBinario);
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $crearUsuario($conexion, [
                    "nombre"        => $nombre,
                    "apellidos"     => $apellidos,
                    "usuario"       => $usuario,
                    "password"      => $passwordHash,
                    "administrador" => $administrador,
                    "nss"           => $nss,
                    "moroso"        => $moroso,
                    "foto"          => $fotoBase64,
                ]);

                $mensaje = "Caso 4 completado: usuario '$usuario' creado con foto guardada en Base64.";
                $tipoMensaje = "exito";
                break;

            default:
                throw new InvalidArgumentException("Caso no válido seleccionado.");
        }

    } catch (Throwable $e) {
        if (isset($conexion) && $conexion instanceof PDO && $conexion->inTransaction()) {
            $conexion->rollBack();
        }
        $mensaje = "Error: " . $e->getMessage();
        $tipoMensaje = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios - Biblioteca</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav>
        <a href="index.php">Inicio</a>
        <a href="gestionBiblioteca.php">Gestión Biblioteca</a>
        <a href="login.php">Login</a>
        <a href="logout.php">Salir</a>
    </nav>

    <h1>Alta de Usuarios</h1>

    <?php if (!empty($mensaje)): ?>
        <div class="mensaje <?= htmlspecialchars($tipoMensaje) ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <!-- IMPORTANTE: enctype="multipart/form-data" es obligatorio para poder enviar archivos ($_FILES) -->
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data" class="formulario">

        <label>
            Caso a ejecutar:
            <select name="caso">
                <option value="1" <?= (($_POST["caso"] ?? "1") === "1") ? "selected" : "" ?>>Caso 1: Usuario sin foto</option>
                <option value="2" <?= (($_POST["caso"] ?? "") === "2") ? "selected" : "" ?>>Caso 2: Foto como archivo en el servidor</option>
                <option value="3" <?= (($_POST["caso"] ?? "") === "3") ? "selected" : "" ?>>Caso 3: Varios usuarios simultáneamente</option>
                <option value="4" <?= (($_POST["caso"] ?? "") === "4") ? "selected" : "" ?>>Caso 4: Foto como texto (Base64) en la BD</option>
            </select>
        </label>

        <label>
            Nombre:
            <input type="text" name="nombre" value="<?= htmlspecialchars($_POST["nombre"] ?? "") ?>" placeholder="Ej. Laura">
        </label>

        <label>
            Apellidos:
            <input type="text" name="apellidos" value="<?= htmlspecialchars($_POST["apellidos"] ?? "") ?>" placeholder="Ej. Martínez Gómez">
        </label>

        <label>
            Nombre de usuario:
            <input type="text" name="usuario" value="<?= htmlspecialchars($_POST["usuario"] ?? "") ?>" placeholder="Ej. lmartinez">
        </label>

        <label>
            Contraseña:
            <input type="password" name="password">
        </label>

        <label>
            Administrador:
            <select name="administrador">
                <option value="1" <?= (($_POST["administrador"] ?? "") === "1") ? "selected" : "" ?>>Administrador</option>
                <option value="2" <?= (($_POST["administrador"] ?? "2") === "2") ? "selected" : "" ?>>Cliente</option>
            </select>
        </label>

        <label>
            Nº Seguridad Social (solo administradores):
            <input type="text" name="nss" value="<?= htmlspecialchars($_POST["nss"] ?? "") ?>" placeholder="Ej. ES1234567890">
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