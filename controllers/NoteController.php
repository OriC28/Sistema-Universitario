<?php
include('./model/NoteModel.php');
session_start();
class NoteController{
    private $notes_user;
    public function __construct(){
        $this->cedula = htmlspecialchars($_SESSION['cedula']);
        $this->notes_user = new NoteModel();
    }
    private function get_notes_array(){
        if(isset($_SERVER['REQUEST_METHOD']) == 'post' && $_POST['submit']){
            $corte1 = (float)htmlspecialchars($_POST['corte1']);
            $corte2 = (float)htmlspecialchars($_POST['corte2']);
            $corte3 = (float)htmlspecialchars($_POST['corte3']);
            $corte4 = (float)htmlspecialchars($_POST['corte4']);

            return [$corte1, $corte2, $corte3, $corte4];
        }
    }
    public function setNotes(){
        $notes = $this->get_notes_array();
        $this->notes_user->setNotes($this->cedula, $notes);
    }

    public function updateNotes(){
        $notes = $this->get_notes_array();
        $this->notes_user->updateNotes($this->cedula, $notes);
    }
}

