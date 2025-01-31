<?php

require_once './model/ProfileStudentModel.php';
require_once './model/NoteModel.php';
require_once 'ViewerNoteController.php';
/**
 * Controlador para la vista de perfil del estudiante.
 *
 */
class ProfileStudentController extends ViewerNoteController{
    /**
     * Obtiene los datos del estudiante y los muestra en la vista.
     *
     */
    public function getStudentData(){
        try{
            $modelStudentData = new ProfileStudentModel();

            $cedulaValidated = $this->existsStudentInSession();

            $data = $modelStudentData->getStudentData($cedulaValidated);
        
            require_once "views/profileStudent.php";
        }catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}