<?php
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $diametro = $_POST['diametro'] ?? '';
    $altura = $_POST['altura'] ?? '';

    if (!is_numeric($diametro) || $diametro <= 0) {
        $errores[] = 'El diámetro debe ser un número mayor que cero.';
    }
    if (!is_numeric($altura) || $altura <= 0) {
        $errores[] = 'La altura debe ser un número mayor que cero.';
    }

    if (empty($errores)) {
        $radio = $diametro / 2;
        $volumen = 3.141593 * $radio * $radio * $altura;
        header('Location: ejemplo09Solucion.php?volumen=' . $volumen);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Volumen de un cilindro</title>
</head>
<body>
	<h1>Cálculo del volumen de un cilindro</h1>

	<?php if (isset($_GET['volumen']) && is_numeric($_GET['volumen'])): ?>
		<p>El volumen es <?= number_format((float) $_GET['volumen'], 6, ',', '.') ?> metros cúbicos.</p>
	<?php endif; ?>

	<?php foreach ($errores as $error): ?>
		<p><?= $error ?></p>
	<?php endforeach; ?>
</body>
</html>
