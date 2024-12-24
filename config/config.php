<?php
/**
 * Este archivo sirve para proporcionar los parámetros necesarios al modelo BDModel a la hora de realizar una conexión a la base de datos.
 */
return [
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "sistema_universitario",
    "username" => "root",
    "password" => "Ori31525588$$.",
    "charset" => "utf8",
    "options" => [
        PDO::ATTR_EMULATE_PREPARES => FALSE, 
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
];


