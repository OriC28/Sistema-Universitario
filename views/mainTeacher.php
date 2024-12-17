<?php

$_SESSION['students'] = [
    ['31525588', 'Colina Perea', 'Oriana Guadalupe', 'oriana@gmail.com'],
    ['30563976', 'García Jiménez', 'Manuel Jesús', 'manuelj@gmail.com'],
    ['28674120', 'Pérez Goitia', 'Lisa Adriannys', 'lisa@hotmail.com'],
    ['30562437', 'Colina Goitia', 'Ánge Eduardo', 'angeleduardiogoitia12@gmail.com'],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/styles_edit_add_notes.css?v=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="../assets/styles_main_teacher.css?v=<?php echo time(); ?>"/>

    <title>Inicio</title>
</head>
<body>
    <!--HEADER-->
    <?php require_once "header.php";?>
    <!--CONTENIDO-->
    <main>
        <!--SUB-HEADER-->
        <div class="student-data">
            <div class="container-name">
                <h2>Lista de estudiantes</h2>
            </div>
        </div>
        
        <!--SEPARADOR-->
        <div class="separator"><p></p></div>
        
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
                    $num_students = sizeof($_SESSION['students']);
                    foreach($_SESSION['students'] as $data){
                        printf(
                            ' <tr>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>
                                    <div class="options">
                                        <button class="add-button" type="button"><a href="addNotes.php" class="text-button">Agregar</a></button>
                                        <button class="edit-button" type="button"><a href="editNotes.php" class="text-button">Editar</a></button>
                                    </div>
                                </td>
                            </tr>',
                            $data[0],
                            $data[1],
                            $data[2],
                            $data[3],
                        );
                    }
                ?>
            </tbody>
        </table>
    </main>
    <footer>Copyright 2024 - Hecho por la demencia</footer>
</body>
</html>