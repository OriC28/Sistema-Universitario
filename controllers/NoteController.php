<?php
include('./model/NoteModel.php');
session_start();
class NoteController{

    private function get_notes_array(){
        $corte1 = (float)htmlspecialchars($_POST['corte1']);
        $corte2 = (float)htmlspecialchars($_POST['corte2']);
        $corte3 = (float)htmlspecialchars($_POST['corte3']);
        $corte4 = (float)htmlspecialchars($_POST['corte4']);

       return [$corte1, $corte2, $corte3, $corte4];
    }
    public function setNotes(){
        $notes_user = new NoteModel();
        $notes = $this->get_notes_array();
        $cedula = htmlspecialchars($_SESSION['cedula']);
        $notes_user->setNotes($cedula, $notes);
    }

    public function updateNotes(){
        $notes_user = new NoteModel();
        $notes = $this->get_notes_array();
        $cedula = htmlspecialchars($_SESSION['cedula']);
        $notes_user->updateNotes($cedula, $notes);
    }

}

