<?php

require_once "BDModel.php";

class UserModel {
    private $first_name;
    private $second_name;
    private $first_lastname;
    private $second_lastname;

    private $cedula;
    private $password;
    private $confirm_password;
    private $rol;

    private $conn;
    private $config;

    public function __construct(array $userData) {
        /**
         * Aquí se estaba intentado acceder a los valores del array con keys incorrectas
         */
        $this->first_name = $userData["first_name"];
        $this->second_name = $userData["second_name"];
        $this->first_lastname = $userData["first_lastname"];
        $this->second_lastname = $userData["second_lastname"];

        $this->cedula = $userData["cedula"];
        $this->password = $userData["password"];
        $this->confirm_password = $userData["confirm_password"];
        $this->rol = "estudiante"; # rol por defecto para los estudiantes

        # Estableciendo la conexión a la base de datos
        $this->config = include("./config/config.php");
        $conn_object = new BDModel($this->config);
        $this->conn = $conn_object->connect();
    }

    public function insertUser() {
        try {
            # Consulta para insertar los datos del usuario
            $sql = "INSERT INTO usuarios (cedula, clave, rol) VALUES (:cedula, :password_hash, :rol);";

            # Empleo de una consulta preparada
            $cursor = $this->conn->prepare($sql);

            $options = [
                'cost' => 12,
            ];

            # Hashear la contraseña ingresada para almacenarla en la base de datos
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT, $options);

            # Paso de los parámetros necesarios para la consulta
            $cursor->bindParam(':cedula', $this->cedula);
            $cursor->bindParam(':password_hash', $password_hash);
            $cursor->bindParam(':rol', $this->rol);
            
            # Verificar si el usuario se registró
            if ($cursor->execute()) {
                $this->saveUserData();
                return true;
            } else {
                throw new Exception("No se pudo registrar el usuario.");
            }

        } catch(Exception $e) {
            die("Ha ocurrido un error: " . $e->getMessage());
            return false;
        }
    }

    public function saveUserData() {
        try {
            $sql = "INSERT INTO estudiantes (
                cedula,
                primer_nombre_estudiante,
                segundo_nombre_estudiante,
                primer_apellido_estudiante,
                segundo_apellido_estudiante
                )
                VALUES (
                :cedula,
                :first_name,
                :second_name,
                :first_lastname,
                :second_lastname
                );";

            $cursor = $this->conn->prepare($sql);

            $cursor->bindParam(":cedula", $this->cedula);
            $cursor->bindParam(":first_name", $this->first_name);
            $cursor->bindParam(":second_name", $this->second_name);
            $cursor->bindParam(":first_lastname", $this->first_lastname);
            $cursor->bindParam(":second_lastname", $this->second_lastname);

            if ($cursor->execute()) {
                echo "Los datos personales se registraron correctamente.";
            } else {
                echo "No se pudo agregar los datos personales.";
            }

        } catch(Exception $e) {
            die("Ha ocurrido un error: " . $e->getMessage());
            return false;
        }
    }

    public function getUser(){
        try {
            # Consulta para obtener los datos del usuario
            $sql = "SELECT cedula, clave, rol FROM usuarios WHERE cedula = :cedula;";
            
            # Consulta preparada
            $cursor = $this->conn->prepare($sql);

            # Paso del parámetro necesario
            $cursor->bindParam(':cedula', $this->cedula);
            
            # Verificar si se realizó la consulta
            if($cursor->execute()){
                # Obtener los datos
                $user_data = $cursor->fetch(PDO::FETCH_ASSOC);
                # Verificar existencia de los datos 
                if($user_data){
                    # Verificar si las contraseñas coinciden y si el rol del usuario es de estudiante
                    if(!password_verify($this->password, $user_data['clave']) && $user_data['rol'] !== 'estudiante'){
                        throw new Exception("Cedula o contraseña incorrectos", 1);
                    }
                }else{
                    echo "Cedula o contraseña incorrectos.";
                }
            }
        }catch(\Throwable $th) {
            die("Error: ".$th->getMessage());
        }
    }

    public function getCedula() {
        try {
            $sql = "SELECT cedula FROM usuarios where cedula = :cedula;";

            $cursor = $this->conn->prepare($sql);

            $cursor->bindParam(":cedula", $this->cedula);

            if ($cursor->execute()) {
                $userCedula = $cursor->fetch(PDO::FETCH_ASSOC);
                
                return $userCedula ?: null;
            }
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}
