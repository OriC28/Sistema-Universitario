<?php 
    # NOTAS OBTENIDAS DE LA "BASE DE DATOS"
    $_SESSION['corte1'] = 20;
    $_SESSION['corte2'] = 20;
    $_SESSION['corte3'] = 10;
    $_SESSION['corte4'] = 20;

    # SUMA TOTAL DE LOS CORTES
    $total = $_SESSION['corte1'] + $_SESSION['corte2'] + $_SESSION['corte3'] + $_SESSION['corte4'];

    # DEFINITIVA OBTENIDA DE LA "BASE DE DATOS"
    $_SESSION['definitiva'] = $total/4; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles_edit_add_notes.css">
    <title>Editar calificaciones</title>
</head>
<body class=>
    <!--HEADER-->
    <header>
        <div class="container-admin">
            <h2>DOCENTES</h2>
            <div id="container-img">
                <img src="../assets/icons/admin.png" alt="admin" />
            </div>
            <label for="">ADMIN</label>
        </div>
        <input id="button-logout" type="button" value="Cerrar Sesión">
    </header>

    <!--CONTENIDO-->
    <main>
        <!--SUB-HEADER-->
        <?php require_once "templates/sub_header.php";?>

        <!--SEPARADOR-->
        <div class="separator"><p></p></div>

        <!--DATOS DE LA MATERIA Y DOCENTE-->
        <div class="container-subject">
            <h4>Materia: Programación</h4>
            <h4>Docente: Carlos José Medina González</h4>
        </div>
        <!--INGRESO DE LAS NOTAS POR CORTE-->
        <div class="container-form">
            <form action="">
                <div class="container-notes">
                    <!--CORTES-->
                    <div class="field">
                        <label for="">Corte I</label>
                        <input type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte1" id="" required>
                    </div>
                    <div class="field">
                        <label for="">Corte II</label>
                        <input type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte2" id="" required>
                    </div>
                    <div class="field">
                        <label for="">Corte III</label>
                        <input type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte3" id="" required>
                    </div>
                    <div class="field">
                        <label for="">Corte IV</label>
                        <input type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte4" id="" required>
                    </div>
                </div>
                <!--NOTA DEFINITIVA-->
                <label id="def-label">Definitiva: <?php echo $_SESSION['definitiva'];?></label>
                
                <!--BOTÓN PARA ENVIAR EL FORMULARIO-->
                <input type="submit" value="Modificar">
            </form>
        </div>
    </main>
    <script>
        // CAPTURA DE TODOS LOS INPUTS
        let inputs = document.querySelectorAll("div.field > input");
        let sum_notes = 0;
        // NOTAS EXTRAÍDAS DE LA "BASE DE DATOS"
        let notes = [
            <?php echo $_SESSION['corte1'];?>, <?php echo $_SESSION['corte2'];?>,
            <?php echo $_SESSION['corte3'];?>, <?php echo $_SESSION['corte4'];?>
        ];
        // INSERTANDO LAS NOTAS EN LOS INPUTS
        inputs.forEach((input, index) => {
            input.value = notes[index];
        });        
        // CAPTURA DE LAS NOTAS A MEDIDA QUE SE MODIFICAN
        inputs.forEach(input => {
            input.addEventListener('input', ()=>{
                inputs.forEach((input) => {
                    if(input.value){ // VERIFICAR LA EXISTENCIA DE LA NOTA EN EL INPUT
                        let note = parseInt(input.value);
                        if(note>=0 && note<=20){
                            sum_notes+= parseInt(note);  // REALIZAR SUMATORIA TOTAL DE LAS NUEVAS NOTAS
                        }
                    }
                });
                document.getElementById("def-label").innerHTML = "Definitiva: "; // BORRAR LAS NOTAS ANTERIORES
                document.getElementById("def-label").innerHTML = "Definitiva: " + sum_notes/4; // ESTABLECER LAS NOTAS MODIFICADAS
                sum_notes = 0; // BORRAR LA SUMATORIA TOTAL PARA IR ACTUALIZANDO LA NOTA DEFINITIVA
            });
        });  
    </script>
    <!--FOOTER-->
    <footer>Copyright 2024 - Hecho por la demencia</footer>
</body>
</html>