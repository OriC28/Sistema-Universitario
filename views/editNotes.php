<?php 
    define('BASE_URL', '/Sistema-Universitario/');

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if(!isset($_SESSION['logged-in-teacher']) || empty($_SESSION['logged-in-teacher']) || !isset($_SESSION['rol']) || empty($_SESSION['rol'])){
        if(!$_SESSION['logged-in-teacher'] || $_SESSION['rol'] !== 'profesor'){
            header('Location: '.BASE_URL.'views/loginTeacher.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles_edit_add_notes.css?v=<?php echo time(); ?>" />
    <title>Editar calificaciones</title>
</head>
<body class=>
    <!--HEADER-->
    <header>
        <div class="container-admin">
            <h1>DOCENTES</h1>
            
        </div>
        <a class="button-logout" href="views/templates/logout.php">Cerrar Sesión</a>
    </header>

    <!--CONTENIDO-->
    <main>
        <!--SUB-HEADER-->
        <?php require_once "views/templates/sub_header.php"; ?>
        <!--SEPARADOR-->
        <div class="separator"><p></p></div>

        <!--DATOS DE LA MATERIA Y DOCENTE-->
        <div class="container-subject">
            <h3>Materia: <?= htmlspecialchars($subject);?></h3>
            <h3>Docente: <?=htmlspecialchars($teacher_name);?></h3>
        </div>
        <!--INGRESO DE LAS NOTAS POR CORTE-->
        <div class="container-form">
            <form action="index.php?controller=note&action=updateNotes" method="post">
                <div class="container-notes">
                    <!--CORTES-->
                    <div class="field">
                        <h3 for="">Corte I</h3>
                        <input class="input-corte" type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte1" id="" required>
                    </div>
                    <div class="field">
                        <h3 for="">Corte II</h3>
                        <input class="input-corte" type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte2" id="" required>
                    </div>
                    <div class="field">
                        <h3 for="">Corte III</h3>
                        <input class="input-corte" type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte3" id="" required>
                    </div>
                    <div class="field">
                        <h3 for="">Corte IV</h3>
                        <input class="input-corte" type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte4" id="" required>
                    </div>
                    <div class="field">
                        <!--NOTA DEFINITIVA-->
                        <h3 id="def-label">Definitiva: <?= $notes['nota_definitiva'] ?? "No definida";?></h3>
                    </div>
                </div>
                
                
                
                <!--BOTÓN PARA ENVIAR EL FORMULARIO-->
                <input class="button-right" type="submit" name="submit" value="Modificar">
            </form>
        </div>
    </main>
    <script>
        // CAPTURA DE TODOS LOS INPUTS
        let inputs = document.querySelectorAll("div.field > input");
        // CAMPOS DE LAS NOTAS
        let cortes = ["primer_corte", "segundo_corte", "tercer_corte", "cuarto_corte"];
        // NOTAS DE LOS CORTES OBTENIDAS DE LA BASE DE DATOS
        let notes = <?php echo json_encode(array_map('intval', $notes)); ?>;
        let sum_notes = 0;       

        // INSERTANDO LAS NOTAS EN LOS INPUTS
        inputs.forEach((input, index) => {
            input.value = notes[cortes[index]];
        });        
        /**
         * Calcula la nota definitiva a medida que se modifican las notas de los cortes.
         * 
         */
        const calculateDefinitiveNote = () =>{
            let sumNotes = 0;
            let countValid = 0;
             // CAPTURA DE LAS NOTAS A MEDIDA QUE SE MODIFICAN
            inputs.forEach((input) =>{
                // VALIDAR QUE EL CAMPO NO ESTÉ VACÍO
                if(input.value){ 
                    let note = parseFloat(input.value);
                    // VALIDAR QUE LA NOTA ESTÉ ENTRE 0 Y 20
                    if(!isNaN(note) && note>=0 && note<=20){
                        // REALIZAR SUMATORIA TOTAL DE LAS NUEVAS NOTAS
                        sumNotes+= note;  
                        countValid++;
                    }
                }
            });
            // CALCULAR LA NOTA DEFINITIVA Y MOSTRARLA EN EL LABEL
            let definitiva = countValid > 0 ? (sumNotes / countValid).toFixed(2) : 'No definida';
            document.getElementById("def-label").textContent = `Definitiva: ${definitiva}`;
        };
        // EVENTO QUE SE EJECUTA CADA VEZ QUE SE MODIFICA UNA NOTA
        inputs.forEach(input => {
            input.addEventListener('input', calculateDefinitiveNote);
        });
        
        // CALCULAR AL CARGAR LA PÁGINA
        calculateDefinitiveNote(); 
    </script>
    <!--FOOTER-->
    <footer>Copyright 2024 - Hecho por la demencia</footer>
</body>
</html>