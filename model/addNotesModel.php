<?php 

class recoveryRowData{
    private $cedula;
    private $name;
    private $conn;

    public function __construct(string $cedula, string $name){
        $this->cedula = $cedula;
        $this->name = $name;
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();
    }

    public function compareData(){
        $sql = "SELECT * FROM estudiantes WHERE cedula = :cedula";
            
        $cursor = $this->conn->prepare($sql);
        $cursor->bindParam(':cedula', $this->cedula);
        if($cursor->execute()){
            if($cursor->fetch(PDO::FETCH_ASSOC)){
                session_start();
                $_SESSION['cedula'] = $this->cedula;
                $_SESSION['name'] = $this->name;
                header("Location: ./views/addNotes.php");
                exit();
            }else{
                echo "El estudiante no existe en la base de datos.";
            }
        }
    }
}

?>