<?php
/**
 * Este archivo sirve para proporcionar los parámetros necesarios al 
 * modelo BDModel a la hora de realizar una conexión a la base de datos.
 */

# host: Nombre del host donde se encuentra la base de datos.
# port: Puerto de conexión a la base de datos.
# dbname: Nombre de la base de datos.
# username: Nombre de usuario de la base de datos.
# password: Contraseña de la base de datos.
# charset: Codificación de caracteres.
# options: Opciones de configuración de la conexión a la base de datos.
# ATTR_EMULATE_PREPARES: Desactiva la emulación de consultas preparadas.
# ERRMODE_EXCEPTION: Lanza una excepción en caso de error.

return [
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "sistema_universitario",
    "username" => "root",
    "password" => "",
    "charset" => "utf8",
    "options" => [
        PDO::ATTR_EMULATE_PREPARES => FALSE, 
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
];

