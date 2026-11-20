<?php
// Opción actual
// setcookie(nombre [valor =""[opciones =[]]]); (Esquema de funcionamiento de la creación de una cookie).
    setcookie("preferencias_tema", "oscuro",[
        'expires' => time() + (7*24*60*60), // expira (7 días en el futuro)
        'path' => '/', // ruta (disponible en toda la web)
        'domain' => '', // dominio (vacío = dominio actual)
        'secure' => true, // seguro (solo se envía por HTTPS)
        'httponly' => true, // httponly (bloquea acceso desde JavaScript, evita XSS)
        'samesite' => 'Strict' // Atributo de seguridad moderno contra ataques: CSRF
    ]
 
    );
?>