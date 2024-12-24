<?php

/**
*
* VIEW: ./views/editNotes.php
* VIEW: ./views/addNotes.php
* MODEL: ./model/NoteModel.php
* BASE DE DATOS: sistema_universitario
*
*/

include('./model/NoteModel.php');

session_start();

/**
* Controlador conectado al modelo NoteModel para establecer y actualizar las notas de un estudiante seleccionado por el docente.
* NOTA: Los métodos de este controlador son ejecutados al enviar los formularios de addNotes.php o editNotes.php respectivamente.
*
*/
class NoteController{
    /** 
    * variable para instanciar el modelo NoteModel
    * @var NoteModel instancia de NoteModel
    * @access private 
    */ 
    private $notes_user;
    /** 
    * variable para almacenar la cédula del estudiante
    * @var string identificador único del estudiante
    * @access private 
    */ 
    private $cedula;
    /**
    * Constructor que inicializa la cédula capturada y la instancia del modelo NoteModel.
    */
    public function __construct(){
        $this->cedula = htmlspecialchars($_SESSION['cedula']);
        $this->notes_user = new NoteModel();
    }
    
    /**
    * Verifica que el formulario ha sido enviado, convierte algunos caracteres predefinidos en entidades HTML
    * y convierte a tipo flotantes las notas en caso de existir.
    *
    * @return array notas de cada corte académico
    */
    private function get_notes_array():array{
        if($_SERVER['REQUEST_METHOD'] != 'POST' || !$_POST['submit']){
           throw new Exception("No se ha enviado ninguna petición.", 1);
        }

        $corte1 = (float)htmlspecialchars($_POST['corte1']);
        $corte2 = (float)htmlspecialchars($_POST['corte2']);
        $corte3 = (float)htmlspecialchars($_POST['corte3']);
        $corte4 = (float)htmlspecialchars($_POST['corte4']);

        return [$corte1, $corte2, $corte3, $corte4];
    }
    /**
    * Llama al método get_notes_array() para obtener las notas del estudiante si existen y las registra en la base de datos
    * mediante el método setNotes() del modelo NoteModel.
    *
    * @return void 
    */
    public function setNotes():void{
        try{
            $notes = $this->get_notes_array();
            $cedula_validated = $this->notes_user->validateCedula($this->cedula);
            if($cedula_validated){
                $this->notes_user->setNotes($cedula_validated, $notes);
            }
        }catch(\Throwable $th) {
            die("Error: ". $th->getMessage());
        }
    }
    /**
    * Llama al método get_notes_array() para obtener las notas del estudiante si existen y las actualiza en la base de datos
    * mediante el método updateNotes() del modelo NoteModel.
    *
    * @return void 
    */
    public function updateNotes():void{
        try{
            $notes = $this->get_notes_array();
            $cedula_validated = $this->notes_user->validateCedula($this->cedula);
            if($cedula_validated){
                $this->notes_user->updateNotes($cedula_validated, $notes);
            }
        }catch(\Throwable $th) {
            die("Error: ". $th->getMessage());
        }
    }
}

