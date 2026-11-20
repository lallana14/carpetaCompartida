<?php
echo"\nEJERCICIO 1: \n";
function pesetas2euros($pesetas, $factor){//creamos la funcion peseta2euros
    $euros = $pesetas / $factor;//convertimos pesetas a euros
    return $euros;//devolvemos el valor
}
//probamos la funcion y comprobamos que vaya bien
$valor = pesetas2euros(1600, 166);
echo $valor;

echo"\nEJERCICIO 2: \n";
function euros2pesetas($euros, $factor){//creamos la funcion euros2peseta
    $pesetas = $euros * $factor;//convertimos euros a pesetas
    return $pesetas;//devolvemos el valor
}
//comprobamos que la funcion vaya bien
$valor = euros2pesetas(5, 166);
echo $valor;

?>