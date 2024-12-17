<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login-register.css?v=<?php echo time(); ?>" />
    <title>Recuperación de contraseña</title>
</head>
<body class="responsive">
    <header class="header">
        <h1>Preguntas de Seguridad</h1>
    </header>
    <main>
        <div class="container">
            <form class="form-recovery" action="" method="post">
                <div class="div-recovery-password">
                    <label for="question1">Pregunta 1</label>
                    <input class="input-recovery" type="text" placeholder="¿Cuál es mi color favorito?" required>
                    <label for="answer1">Respuesta 1</label>
                    <input class="input-recovery" type="text" placeholder="Amarillo" required>
                </div>

                <div class="div-recovery-password">
                    <label for="question2">Pregunta 2</label>
                    <input class="input-recovery" type="text" placeholder="¿Cuál es mi comida favorita?" required>
                    <label for="answer2">Respuesta 2</label>
                    <input class="input-recovery" type="text" placeholder="Pasticho" required>
                </div>

                <div class="div-recovery-password">
                    <label for="question3">Pregunta 3</label>
                    <input class="input-recovery" type="text" placeholder="¿Lugar favorito?" required>
                    <label for="answer3">Respuesta 3</label>
                    <input class="input-recovery" type="text" placeholder="Mi Casa" required>
                </div>
                
                <div class="center-button2">
                    <input type="submit" class="button-styles" name="submit" value="Aceptar">
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>copinai</p>
    </footer>
</body>
</html>