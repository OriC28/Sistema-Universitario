
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/styles_edit_add_notes.css"/>
    <title>Agregar calificaciones</title>
</head>
<body>
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
            <form action="index.php?controller=note&action=setNotes" method="post">
                <div class="container-notes">
                    <!--CORTES-->
                    <div class="field">
                        <label for="">Corte I</label>
                        <input type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte1" required>
                    </div>
                    <div class="field">
                        <label for="">Corte II</label>
                        <input type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte2" required>
                    </div>
                    <div class="field">
                        <label for="">Corte III</label>
                        <input type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte3" required>
                    </div>
                    <div class="field">
                        <label for="">Corte IV</label>
                        <input type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte4" required>
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