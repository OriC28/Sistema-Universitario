<?php

require_once 'C:\xampp\htdocs\Sistema-Universitario\model\Session.php';

Session::startSession();

/**
 * Clase para manejar los errores en los formularios
 */
class ErrorMessages{
    private $errors;

    public function __construct(){
        $this->errors = [];
    }

    /**
     * Verifica y obtiene los mensajes de error que arrojan los métodos de validación de una clase
     * @param object $object instancia de la clase
     * @param array $methods métodos a verificar
     * @param string $sessionError nombre de la variable de sesión a crear para almacenar los errores
     * @param string $view vista que se cargara para mostrar los errores
     * @return void
     */

    public function verifyInputErrors(object $object, array $methods, string $sessionError, string $view, $parameter=null): void{
        foreach ($methods as $method) {
            try{
                if ($parameter === null) {
                    $object->$method();
                } else {
                    $object->$method($parameter);

                }
            }catch (Exception $e){
                $message = $e->getMessage();

                // if ($sessionError == "signupErrors" || $sessionError == "changePasswordErrors") {
                //     if ($method == "getPassword" && ($message == "Contraseña inválida." || $message == "Contraseña ausente.")) {
                //         continue;
                //     }
                // }

                $this->errors[] = $message;
            }
        }
        $this->checkErrors($sessionError, $view);
    }

    /**
     * Almacena los errores captuadores en una variable de sesión y llama a la vista correspondiente
     * @param string $view vista a la cual se le mostrarán los errores
     * @return void
     */
    private function checkErrors(string $sessionError, string $view): void{
        if ($this->errors) {
            $_SESSION["$sessionError"] = $this->errors;
            require_once "views/" . basename($view) . ".php";
            exit();
        } else {
            $this->cleanErrors($sessionError);
        }
    }

    /**
     * Elimina los errores de la variable de sesión antes creada
     * @return void
     */
    private function cleanErrors(string $sessionError): void{
        unset($_SESSION["$sessionError"]);
        $this->errors = [];
    }

    /**
     * Verifica si existen errores en una variable de sesión y los muestra al usuario en la vista desde la cual se llama
     * @param string $sessionError nombre de la variable de sesión a verificar
     * @return void
     */
    public static function showErrors(string $sessionError): void {
        if (isset($_SESSION["$sessionError"])) {
            $errors = $_SESSION["$sessionError"];
            // echo "<br>";
            foreach ($errors as $error) {
                echo '<div class="container-errors"><p class="error-message">' . $error . '</p></div>';
            }
            unset($_SESSION["$sessionError"]);
        }
    }
}