<?php

require_once "./model/addNotesModel.php";

class addNotesController{
    public function compareData(){
        $cedula = htmlspecialchars($_POST['cedula']);
        $name = htmlspecialchars($_POST['name']);
        $model = new recoveryRowData($cedula, $name);
        $model->compareData();
    }
}

?>