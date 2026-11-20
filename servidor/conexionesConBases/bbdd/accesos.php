<?php
$accesosPagina;
 
if (isset($_COOKIE['accesosPagina'])){
    $accesosPagina = $_COOKIE['accesosPagina'];
    if ($accesosPagina <= 10){
        setcookie("accesosPagina", ++$accesosPagina);
       
    } else {
        setcookie("accesosPagina","",1);
    }
} else {
    $accesosPagina =1;
    setcookie("accesosPagina", "1", ['expires' => time() + (7*24*60*60),
    'path' => '/'
    ]);
};
 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accesos Página</title>
    </head>
    <body>
        <h1>Acceso a página</h1>
        <p>Has accedido a esta página  <?php echo $accesosPagina ?> veces </p>
    </body>
</html>