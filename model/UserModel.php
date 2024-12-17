<?php

require_once "BDModel.php";

class UserModel{
    private $cedula;
    private $password;
    private $confirm_password;
    private $rol;
    private $conn;
    private $config;

    public function __construct(string $cedula, string $password, string $confirm_password=null){
        $this->cedula = $cedula;
        $this->password = $password;
        $this->rol = "estudiante"; # rol por defecto para los estudiantes
        $this->confirm_password = $confirm_password;

        # Estableciendo la conexión a la base de datos
        $this->config = include("./config/config.php");
        $conn_object = new BDModel($this->config);
        $this->conn = $conn_object->connect();
    }
    public function insertUser(){
        try{
            # Verificar si las contraseñas son iguales
            if($this->password != $this->confirm_password){
                throw new Exception("Las contraseñas no coinciden");
            }
            # Hashear la contraseña ingresada para almacenarla en la base de datos
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            
            # Consulta para insertar los datos del usuario
            $sql = "INSERT INTO usuarios (cedula, clave, rol) VALUES (:cedula, :password_hash, :rol);";
           
            # Empleo de una consulta preparada
            $cursor = $this->conn->prepare($sql);

            # Paso de los parámetros necesarios para la consulta
            $cursor->bindParam(':cedula', $this->cedula);
            $cursor->bindParam(':password_hash', $password_hash);
            $cursor->bindParam(':rol', $this->rol);
            
            # Verificar si el usuario se registró
            if($cursor->execute()){
                return true;
            }else{
                throw new Exception("No se pudo registrar el usuario.");
            }

        }catch(Exception $e){
            die("Ha ocurrido un error: ".$e->getMessage());
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
                    if(password_verify($this->password, $user_data['clave']) && $user_data['rol'] == 'estudiante'){
                        header("Location: ./views/systemStudent.php"); # <--- Redirigir al estudiante
                        exit();
                    }else{
                        echo "Cedula o contraseña incorrectos";
                    }
                }else{
                    echo "Cedula o contraseña incorrrectos.";
                }
            }
        }catch(\Throwable $th) {
            die("Error: ".$th->getMessage());
        }
    }
}
