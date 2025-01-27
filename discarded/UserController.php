<?php

require_once './model/UserModel (prueba inicial).php';

class UserController {
    private $userInputs;
    private $errors;

    public function __construct() {
        $this->userInputs = [];
        $this->errors = [];
    }

    public function signUp(){
        /**
         * Se le agregó $_POST['submit'] para verificar si el usuario hizo click en el botón 'Siguiente'
         */
        if ($_SERVER["REQUEST_METHOD"] === "POST" || isset($_POST['submit'])) {
            $this->userInputs = [
                "first_name" => trim($_POST["primer-nombre"]),
                "second_name" => trim($_POST["segundo-nombre"]),
                "first_lastname" => trim($_POST["primer-apellido"]),
                "second_lastname" => trim($_POST["segundo-apellido"]),
                "cedula" => trim($_POST["cedula"]),
                "password" => trim($_POST["password"]),
                "confirm_password" => trim($_POST["confirm_password"])
            ];
            
            try {
                # Error handling
                
                # Verifica si existen campos vacios
                $this->checkEmptyInputs();

                # Verifica si los campos son válidos o contienen caracteres especiales
                $this->validateTextInputs();
                
                # Verifica si la cédula es válida y si ya está registrada
                $this->validateCedula();

                # Verifica si la contraseña cumple con los requisitos
                $this->validatePassword();
                /**
                 * Modificación de las rutas, al emplear una ruta de la forma index.php?controller=controller&action=method
                 * se estaría accediendo a los demás archivos desde la ubicación del archivo index.php, por lo que no es 
                 * necesario emplear ./ o ../ para ubicarse en la ruta determinada
                 */
                # require_once "config/config_session.php";
                
                if ($this->errors) {
                    $_SESSION["signupErrors"] = $this->errors;

                    #$_SESSION["signupData"] = $this->userInputs;

                    require_once "views/signupForm.php";
                    die();
                }

                $this->signupUser();

                header("Location: views/recoverypasswordForm.php");
                die();
            } catch (Exception $e) {
                die("Error: " . $e->getMessage());
            }
        }
    }

    public function login_student(){
        require_once "./views/loginStudent.php";
    }

    public function signupUser() {
        $user = new UserModel($this->userInputs);

        $result = $user->insertUser();

        if ($result){
            echo "Usuario registrado con éxito.";
        } else {
            echo "No se pudo registrar el usuario.";
        }
    }

    public function checkEmptyInputs(): void {
        foreach ($this->userInputs as $key => $value) {
            if(empty($value)){
                $this->errors["empty_inputs"] = "Por favor, rellene todos los campos.";
                return;
            }
        }
    }
    
    function validateTextInputs(): void {
        foreach ($this->userInputs as $key => $value) {
            if ($key !== "cedula" || $key !== 'password' || $key !== 'confirm_password'){

                if(mb_strlen($value) < 2 || mb_strlen($value) > 16) {
                    $this->errors["fields_length"] = "EL campo debe tener mínimo 2 y máximo 16 caracteres.";
                    break;
                }
                /*
                if(!preg_match('/^[a-zA-ZáéíóúüñÁÉÍÓÚÑ]+$/u', $value)){
                    $this->errors["fields_characters"] = "El campo no puede contener caracteres especiales.";
                    break;
                }*/
            }
        }
    }

    function validateCedula(): void {
        $cedula = $this->userInputs["cedula"];

        # Verifica la longitud de la cédula y si solo contiene numeros
        if (((strlen($cedula) !== 7) && (strlen($cedula) !== 8)) || !is_numeric($cedula)) {
            $this->errors["cedula_error"] = "La cédula no es válida.";
        }

        $user = new UserModel($this->userInputs);

        # Verifica si la cédula ya está registrada
        if ($user->getCedula()) {
            $this->errors["cedula_used"] = "La cédula ya está registrada.";
        }
        return;
    }

    function validatePassword(): void {
        $password = $this->userInputs["password"];
        $confirm_password = $this->userInputs["confirm_password"];

        if (mb_strlen($password) < 8) {
            $this->errors["password_length"] = "La contraseña debe tener mínimo 8 caracteres.";
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $this->errors["password_uppercase"] = "La contraseña debe tener al menos una letra mayúscula.";
        }

        if (!preg_match('/[a-z]/', $password)) {
            $this->errors["password_lowercase"] = "La contraseña debe tener al menos una letra minúscula.";
        }

        if (!preg_match('/[0-9]/', $password)) {
            $this->errors["password_number"] = "La contraseña debe tener al menos un número.";
        }

        if (!preg_match('/[!?@#$%&*()-_,.]/', $password)) {
            $this->errors["password_special"] = "La contraseña debe tener al menos un caracter especial '!?@#$%&*()-_,.'.";
        }

        if ($password !== $confirm_password) {
            $this->errors["password_diff"] = "Las contraseñas no coinciden.";
        }
        return;
    }
}