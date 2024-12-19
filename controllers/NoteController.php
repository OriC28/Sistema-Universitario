<?php

include('./model/NoteModel.php');

class NoteController{
    public function addNote(){
        require_once "./views/addNote.php";
    }

    public function setNotes(){
        $corte1 = (float)htmlspecialchars($_POST['corte1']);
        $corte2 = (float)htmlspecialchars($_POST['corte3']);
        $corte3 = (float)htmlspecialchars($_POST['corte4']);
        $corte4 = (float)htmlspecialchars($_POST['corte2']);

        $notes = [$corte1, $corte2, $corte3, $corte4];
        
        $notes_user = new NoteModel();
        session_start();
        $cedula = htmlspecialchars($_SESSION['cedula']);
        $notes_user->setNotes($cedula, $notes);
    }
}

