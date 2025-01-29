<?php

/**
 * Clase para manejar los errores en los formularios
 */
class ErrorMessages{
    private $errors;

    public function __construct(){
        $this->errors = [];
    }

    /**
     * Verifica y obtiene los mensajes de error que arrojan los métodos dentro del modelo User
     * @param User $user instancia de clase User
     * @return void
     */
    public function verifyInputErrors(User $user, array $methods, string $view): void{
        foreach ($methods as $method) {
            try{
                $user->$method();
            }catch (Exception $e){
                if ($method == "getPassword" && $e->getMessage() == "Contraseña inválida.") {
                    continue;
                }
                $this->errors[] = $e->getMessage();
            }
        }
        $this->checkErrors($view);
        $this->cleanErrors();
    }

    /**
     * Almacena los errores captuadores en una variable de sesión y llama a la vista correspondiente
     * @param string $view vista a la cual se le mostrarán los errores
     * @return void
     */
    private function checkErrors(string $view): void{
        if ($this->errors) {
            $_SESSION["signupErrors"] = $this->errors;
            require_once "views/" . basename($view) . ".php";
            exit();
        }
    }

    /**
     * Elimina los errores de la variable de sesión antes creada
     * @return void
     */
    private function cleanErrors(): void{
        unset($_SESSION["signupErrors"]);
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