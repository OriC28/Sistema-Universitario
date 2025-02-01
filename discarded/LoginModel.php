<?php 
require_once "User.php";

class LoginModel{
    private $conn;
    private $user;

    public function __construct(){
        # ESTABLECIENDO CONEXIÓN A LA BASE DE DATOS
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }

    public function setUser(User $user): void{
        $this->user = $user;
    }

    public function getUserData(){
        try{
            $sql = "SELECT * FROM usuarios WHERE cedula = :cedula";

            $cursor = $this->conn->prepare($sql);
            // $cursor->bindParam(':cedula', $this->loginCedula, PDO::PARAM_INT);

            if(!$cursor->execute()){
                return false;
            }
            return $cursor->fetch(PDO::FETCH_ASSOC);
        }catch (\Throwable $th){
            die($th->getMessage());
        }
    }

    public function ValidateUser(string $passwordHashed){
        // if(!password_verify($this->loginPassword, $passwordHashed)){
        //     return false;
        // }
        // return true;
    }
}