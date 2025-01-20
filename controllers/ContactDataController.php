<?php

require_once "./model/ContactDataModel.php";
require_once './model/NoteModel.php';
require_once 'ViewerNoteController.php';
require_once './model/ProfileStudentModel.php';

/**
 * Controlador de los datos de contacto
 */
class ContactDataController extends ViewerNoteController{
    /**
     * Obtiene los parámetros enviados por el formulario.
     *
     * @return array con los datos de contacto
     * @throws Exception si no se ha enviado ninguna petición
     */
    private function getParams():array{
        if($_SERVER['REQUEST_METHOD'] != 'POST' || !$_POST['submit']){
            throw new Exception("No se ha enviado ninguna petición.", 1);
        }
        if(!isset($_POST['phone']) || !isset($_POST['email'])){
            throw new Exception("Faltan datos en la petición.", 1);
        }
        return ['phone' => htmlspecialchars($_POST['phone']), 'email' => htmlspecialchars($_POST['email'])];
    }
    /**
     * Verifica la existencia de la cédula del estudiante en la tabla Calificaciones.
     *
     * @return int si la cédula es encontrada en la base de datos 
     * @param NoteModel $modelObject objeto de la clase NoteModel
     * @throws Exception si la cédula no es válida
     */
    public function addContactData():void{
        try{
            $modelObject = new NoteModel();
            $modelStudentData = new ProfileStudentModel();
            $cedulaValidated = $this->existsStudentInSession($modelObject);
    
            $contactmodel = new ContactDataModel();
            $params = $this->getParams();
            $contactmodel->addContactData($cedulaValidated, $params['phone'], $params['email']);
        }catch(\Throwable $th){
            echo $th->getMessage();
        }
    }
}   