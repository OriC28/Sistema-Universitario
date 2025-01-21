<?php include("config/keys.php");?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/styles_edit_add_notes.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="assets/css/styles_main_teacher.css?v=<?php echo time(); ?>" />

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
                <h1>Lista de estudiantes</h1>
            </div>
        </div>

        <!--SEPARADOR-->
        <div class="separator">
            <p></p>
        </div>

        <!--TABLA DE DATOS-->
        <table>
            <!--ENCABEZADO-->
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
                <!-- DATOS INDIVIDUALES DE LOS ESTUDIANTES REGISTRADOS-->
            <?php
                foreach ($students as $index => $data):
                    $name =  htmlspecialchars(trim($data['primer_nombre_estudiante'])) . " " . htmlspecialchars(trim($data['segundo_nombre_estudiante'])) . " " 
                            . htmlspecialchars(trim($data['primer_apellido_estudiante'])) . " " . htmlspecialchars(trim($data['segundo_apellido_estudiante']));
                    $cedula = (int) trim($data['cedula']);
                    $name_encrypted = base64_encode(openssl_encrypt($name, "aes-256-cbc", $key, 0, $iv));
                    $ci_encrypted = base64_encode(openssl_encrypt($cedula, "aes-256-cbc", $key, 0, $iv));
                ?>
                <tr>
                    <td><?php echo htmlspecialchars(trim($data['cedula']));?></td>
                    <td><?php echo htmlspecialchars(trim($data['primer_apellido_estudiante'])) . " " . htmlspecialchars(trim($data['segundo_apellido_estudiante']));?></td>
                    <td><?php echo htmlspecialchars(trim($data['primer_nombre_estudiante'])) . " " . htmlspecialchars(trim($data['segundo_nombre_estudiante']));?></td>
                    <td><?php echo htmlspecialchars(trim($data['correo_electronico']));?></td>
                    <td>
                        <div class="options">
                            <button class="add-button" type="button"><a href="index.php?controller=studentData&action=getRowData&site=addnotes&id=<?= urlencode($ci_encrypted);?>&n=<?= urlencode($name_encrypted); ?>">Agregar</a></button>
                            <button class="edit-button" type="button"><a href="index.php?controller=studentData&action=getRowData&site=editnotes&id=<?= urlencode($ci_encrypted);?>&n=<?= urlencode($name_encrypted); ?>">Editar</a></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </main>
    <footer>Copyright 2024 - Hecho por la demencia</footer>
</body>
</html>