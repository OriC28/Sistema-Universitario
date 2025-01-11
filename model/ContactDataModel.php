<?php
/**
 * Modelo de datos para la actualización de la información de contacto de un estudiante.
 */
class ContactDataModel{ 
    private $conn;
    private $conn_object;

    public function __construct(){
        
        $config = require_once("./config/config.php");
        $this->conn_object = new BDModel($config);
        $this->conn = $this->conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }
    /**
     * Valida el número de teléfono ingresado.
     * 
     * @param string $phone Número de teléfono a validar
     * @return string número de teléfono validado
     * @throws Exception si el número de teléfono no es válido
     */
    private function validatePhone(string $phone){
        if(!is_numeric($phone) || strlen($phone) != 11 || !preg_match('/^04(12|14|24|26)/', $phone)){
            throw new Exception("Número de teléfono inválido.", 1);
        }
        return $phone;
    }
    /**
     * Valida el correo electrónico ingresado.
     * 
     * @param string $email Correo electrónico a validar
     * @return string correo electrónico validado
     * @throws Exception si el correo electrónico no es válido
     */
    private function validateEmail(string $email){
        $emailSanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(!filter_var($emailSanitized, FILTER_VALIDATE_EMAIL)){
            throw new Exception("Correo electrónico inválido.", 1);
        }
        return $emailSanitized;
    }
    /**
     * Actualiza la información de contacto de un estudiante.
     * 
     * @param int $cedula identificador único del estudiante
     * @param string $phone número de teléfono del estudiante
     * @param string $email correo electrónico del estudiante
     */
    public function addContactData(int $cedula, string $phone, string $email){
        try{
            $emailSanitized = $this->validateEmail($email);
            $phoneValidated = $this->validatePhone($phone);

            if($emailSanitized && $phoneValidated){
                # PREPARANDO LA CONSULTA Y SUS PARÁMETROS
                $sql = "UPDATE estudiantes SET telefono = :phone, correo_electronico = :email WHERE cedula = :cedula;";

                $cursor = $this->conn->prepare($sql);
                $cursor->bindParam(':phone', $phone, PDO::PARAM_STR);
                $cursor->bindParam(':email', $email, PDO::PARAM_STR);
                $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);

                if(!$cursor->execute()){
                    throw new Exception("Su información de contacto no pudo ser actualizada.", 1);
                }
                echo "Datos actualizados.";
            }
        }catch(\Throwable $th){
            echo $th->getMessage();
        }
    }
}