<?php
$personas = [
	['nombre' => 'Aitor', 'altura' => 182, 'email' => 'aitor@correo.com'],
	['nombre' => 'Lucía', 'altura' => 165, 'email' => 'lucia@correo.com'],
	['nombre' => 'Carlos', 'altura' => 178, 'email' => 'carlos@correo.com'],
	['nombre' => 'Marta', 'altura' => 170, 'email' => 'marta@correo.com'],
	['nombre' => 'Javier', 'altura' => 185, 'email' => 'javier@correo.com'],
];

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Personas</title>
</head>
<body>
	<table border="1">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Altura (cm)</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($personas as $persona): ?>
				<tr>
					<td><?= $persona['nombre'] ?></td>
					<td><?= $persona['altura'] ?></td>
					<td><?= $persona['email'] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>