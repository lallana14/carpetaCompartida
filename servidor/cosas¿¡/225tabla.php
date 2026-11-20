<?php
$filas = filter_input(INPUT_POST, 'filas', FILTER_VALIDATE_INT);
$columnas = filter_input(INPUT_POST, 'columnas', FILTER_VALIDATE_INT);

if ($filas !== false && $filas > 0 && $columnas !== false && $columnas > 0) {
	echo '<table>';
	for ($fila = 0; $fila < $filas; $fila++) {
		echo '<tr>';
		for ($columna = 0; $columna < $columnas; $columna++) {
			echo '<td>(' . $fila . ', ' . $columna . ')</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}
?>