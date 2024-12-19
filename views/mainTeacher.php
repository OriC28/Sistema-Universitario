<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/styles_edit_add_notes.css" />
    <link rel="stylesheet" href="assets/css/styles_main_teacher.css" />

    <title>Inicio</title>
</head>

<body>
    <!--HEADER-->
    <?php require_once "templates/header.php";?>
    <!--CONTENIDO-->
    <main>
        <!--SUB-HEADER-->
        <div class="student-data">
            <div class="container-name">
                <h2>Lista de estudiantes</h2>
            </div>
        </div>

        <!--SEPARADOR-->
        <div class="separator">
            <p></p>
        </div>

        <!--TABLA DE DATOS-->
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>Correo electrónico</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($students as $index => $data) {
                    printf(
                        '<tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>
                                <div class="options">
                                    <form action="index.php?controller=addNotes&action=compareData" method="POST" style="display:inline;">
                                        <input type="hidden" name="cedula" value="%s">
                                        <input type="hidden" name="name" value="%s">
                                        <button class="add-button" type="submit">Agregar</button>
                                    </form>
                                    <form action="views/editNotes.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="cedula" value="%s">
                                        <input type="hidden" name="name" value="%s">
                                        <button class="edit-button" type="submit">Editar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>',
                        htmlspecialchars($data['cedula']),
                        htmlspecialchars($data['primer_apellido']) . " " . htmlspecialchars($data['segundo_apellido']),
                        htmlspecialchars($data['primer_nombre']) . " " . htmlspecialchars($data['segundo_nombre']),
                        htmlspecialchars($data['correo_electronico']),
                        htmlspecialchars($data['cedula']),
                        htmlspecialchars($data['primer_nombre']) . " " . htmlspecialchars($data['segundo_nombre']) . " " . htmlspecialchars($data['primer_apellido']) . " " . htmlspecialchars($data['segundo_apellido']),
                        htmlspecialchars($data['cedula']),
                        htmlspecialchars($data['primer_nombre']) . " " . htmlspecialchars($data['segundo_nombre']) . " " . htmlspecialchars($data['primer_apellido']) . " " . htmlspecialchars($data['segundo_apellido'])
                    );
                }
            ?>
            </tbody>
        </table>
    </main>
    <script src="views/test.js"></script>
    <footer>Copyright 2024 - Hecho por la demencia</footer>
</body>

</html>