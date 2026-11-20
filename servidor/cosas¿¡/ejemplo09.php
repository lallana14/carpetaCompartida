<!DOCTYPE html>
<!--
*******************************************************************************************
Ejercicio a realizar:
Programa que pida por pantalla dos valores (diametro y altura).
El resultado se mostrará en otra pagina (resultado.php) redireccionando mediante Location y Header. 
Verifique y valide que se han introducido los valores correctos. Si no es así no se redireccionará e indicará al cliente qué valor falta o es erroneo.

Formular calculo volumen -> 	
volumen = Pi*radio*radio*altura;
Pi = 3.141593;
*******************************************************************************************
-->
<html>
	<head>
	<title>Ejemplo location DAW2</title>
	<meta charset="utf-8">
	</head>

	<body>

		<form name="formularioDatos" method="post" action="resultado.php">

			<p> CÁLCULO DEL VOLUMEN DE UN CILINDRO </p>
			<br/>

				Introduzca el diámetro en metros: <input type="text" name="diametro" value="">

			<br/> <br/>

				Introduzca la altura en metros: <input type="text" name="altura" value="">

			<br/> <br/>

			<input value="Calcular" type="submit" />

		</form>

	</body>
</html>


<!-- PSEUDOCODIGO:

		1. Inicio

		2. Mostrar “Introduzca el diámetro, en metros” : Pedir D

		3. Mostrar “Introduzca la altura, en metros” : Pedir A

		4. R = D/2 : Pi = 3,141593

		5. V = Pi * (R ^ 2) * A

		6. Mostrar “El volumen del cilindro es de”, V, “metros cúbicos”

		7. Fin
