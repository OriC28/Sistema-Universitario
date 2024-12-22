
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles_edit_add_notes.css">
    <title>Editar calificaciones</title>
</head>
<body class=>
    <!--HEADER-->
    <header>
        <div class="container-admin">
            <h2>DOCENTES</h2>
            <div id="container-img">
                <img src="assets/icons/admin.png" alt="admin" />
            </div>
            <label for="">ADMIN</label>
        </div>
        <input id="button-logout" type="button" value="Cerrar Sesión">
    </header>

    <!--CONTENIDO-->
    <main>
        <!--SUB-HEADER-->
        <?php require_once "views/templates/sub_header.php"; ?>
        <!--SEPARADOR-->
        <div class="separator"><p></p></div>

        <!--DATOS DE LA MATERIA Y DOCENTE-->
        <div class="container-subject">
            <h4>Materia: Programación</h4>
            <h4>Docente: Carlos José Medina González</h4>
        </div>
        <!--INGRESO DE LAS NOTAS POR CORTE-->
        <div class="container-form">
            <form action="index.php?controller=note&action=updateNotes" method="post">
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
                <label id="def-label">Definitiva: <?= $notes['nota_definitiva'] ?? "No definida";?></label>
                
                <!--BOTÓN PARA ENVIAR EL FORMULARIO-->
                <input type="submit" value="Modificar">
            </form>
        </div>
    </main>
    <script>
        // CAPTURA DE TODOS LOS INPUTS
        let inputs = document.querySelectorAll("div.field > input");
        let cortes = ["primer_corte", "segundo_corte", "tercer_corte", "cuarto_corte"];
        let notes = <?php echo json_encode(array_map('intval', $notes)); ?>;
        let sum_notes = 0;       

        // INSERTANDO LAS NOTAS EN LOS INPUTS
        inputs.forEach((input, index) => {
            input.value = notes[cortes[index]];
        });        
       
        const calculateDefinitiveNote = () =>{
            let sumNotes = 0;
            let countValid = 0;
             // CAPTURA DE LAS NOTAS A MEDIDA QUE SE MODIFICAN
            inputs.forEach((input) =>{
                if(input.value){ // VERIFICAR LA EXISTENCIA DE LA NOTA EN EL INPUT
                    let note = parseFloat(input.value);
                    if(!isNaN(note) && note>=0 && note<=20){
                        sumNotes+= note;  // REALIZAR SUMATORIA TOTAL DE LAS NUEVAS NOTAS
                        countValid++;
                    }
                }
            });

            let definitiva = countValid > 0 ? (sumNotes / countValid).toFixed(2) : 'No definida';
            document.getElementById("def-label").textContent = `Definitiva: ${definitiva}`;
        };

        inputs.forEach(input => {
            input.addEventListener('input', calculateDefinitiveNote);
        });

        calculateDefinitiveNote(); // CALCULAR AL CARGAR LA PÁGINA

    </script>
    <!--FOOTER-->
    <footer>Copyright 2024 - Hecho por la demencia</footer>
</body>
</html>