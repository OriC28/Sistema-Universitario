<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/styles_edit_add_notes.css"/>
    <title>Agregar calificaciones</title>
</head>
<body>
    <!--HEADER -->
    <?php require_once "header.php";?>

    <!--CONTENIDO-->
    <main>
        <?php require_once "sub_header.php";?>

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
                <!--BOTÓN PARA ENVIAR EL FORMULARIO-->
                <input type="submit" value="Guardar">
            </form>
        </div>
    </main>
    <!--FOOTER-->
    <footer>Copyright 2024 - Hecho por la demencia</footer>
</body>
</html>