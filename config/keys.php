<?php
/**
 * Este archivo proporciona los parámetros necesarios para encriptar y desencriptar los datos 
 * (cédula y nombre del estudiante). Los datos encriptados se enviarán por la URL al presioanr
 * los botones Agregar o Editar en la vista mainTeacher.php, luego el controlador StudentDataController
 * se encargará de desencriptarlos y cargar los datos en las vistas correspondientes de acuerdo al 
 * parámetro site (addNotes.php o editNotes.php).
 * 
 */
$key = file_get_contents("config/private-key.pem");
$iv = substr($key, 0, 16);
$method = "aes-256-cbc";
?>