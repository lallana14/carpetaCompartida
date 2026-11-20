<?php 
//funcion para mostar variables seguras de PHP
function imprimir($variable){
    if(isset($_SERVER[$variable])){
        return htmlspecialchars($_SERVER[$variable], ENT_QUOTES, 'UTF-8');
    }
    return "No hay variable";
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Datos del servidor</title>
    </head>
    <body>
        <h2>Datos de la variable $_SERVER</h2>
        <ul>
            <li><!-- ruta del archivo actual -->
                <span class="variable">PHP_SELF:</span>
                <span class="valor"><?php echo imprimir('PHP_SELF'); ?></span>
            </li>
            <li><!-- servicio del servidor y versiones-->
                <span class="variable">SERVER_SOFTWARE:</span>
                <span class="valor"><?php echo imprimir('SERVER_SOFTWARE'); ?></span>
            </li>
            <li><!-- localhost-->
                <span class="variable">SERVER_NAME:</span>
                <span class="valor"><?php echo imprimir('SERVER_NAME'); ?></span>
            </li>
            <li><!-- método de solicitud -->
                <span class="variable">REQUEST_METHOD:</span>
                <span class="valor"><?php echo imprimir('REQUEST_METHOD'); ?></span>
            </li>
            <li><!-- ruta de la solicitud a partir de la raíz del servidor -->
                <span class="variable">REQUEST_URI:</span>
                <span class="valor"><?php echo imprimir('REQUEST_URI'); ?></span>
            </li>
            <li><!-- cadena de consulta -->
                <span class="variable">QUERY_STRING:</span>
                <span class="valor"><?php echo imprimir('QUERY_STRING'); ?></span>
            </li>
        </ul>
    </body>
</html> 