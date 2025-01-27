<?php
/**
 * Clase para manejar las variables de sesiones
 */
class Session{
    /**
     * Inicia una sessión en caso de que no esté inicializada
     * @return void
     */
    public static function startSession(): void{
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }
    /**
     * Obtiene un valor de sesión determinado
     * 
     * @param string $key llave de la cual se quiere obtener su valor
     * @return string|null el valor de la sesión o nulo si no existe
     */
    public static function get(string $key): string|null{
        return $_SESSION['$key'] ?? NULL;
    }
    /**
     * Establece el nombre de la sesión
     * 
     * @param string $name nombre de la sesión
     * @return void
     */

    /**
     * Crea la variable de sesión
     * 
     * @param string $key llave a asignar
     * @param string $value valor a asignarle a la sesión
     * @return void
     */
    public static function set(string $key, string $value):void{
        self::startSession();
        $_SESSION[$key] = $value;
    }
    /**
     * Destruye la sesión creada
     * @return void
     */
    public static function destroySession(string $name):void{
        self::startSession($name);
        session_destroy();
        $_SESSION = [];
    }
    /**
     * Verifica si la sessión está definida
     * 
     * @param string $key llave de la cual se quiere saber su existencia
     */
    public static function isSetSession(string $key, string $name): bool{
        self::startSession($name);
        return isset($_SESSION[$key]);
    }
}