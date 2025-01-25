<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    function showSignupErrors(): void {
        if (isset($_SESSION["signupErrors"])) {
            $errors = $_SESSION["signupErrors"];
    
            echo "<br>";
    
            foreach ($errors as $error) {
                echo '<div class="container"><p class="error-message">' . $error . '</p></div>';
            }
    
            unset($_SESSION["signupErrors"]);
        } 
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/website/universidad/Sistema-Universitario/assets/css/login-register.css?v=<?php echo time(); ?>" />
    <title>Recuperación de contraseña</title>
</head>
<body class="responsive">
    <header class="header">
        <h1>Preguntas de Seguridad</h1>
    </header>
    <main>
        <div class="container">
            <form class="form-recovery" action="http://localhost/website/universidad/Sistema-Universitario/index.php?controller=register&action=finishSignUp" method="post">
                <div class="div-recovery-password">
                    <label for="question1">Pregunta 1</label>
                    <input class="input-recovery" type="text" name="question1" placeholder="¿Cuál es mi color favorito?" required>
                    <label for="answer1">Respuesta 1</label>
                    <input class="input-recovery" type="text" name="answer1" placeholder="Amarillo" required>
                </div>

                <div class="div-recovery-password">
                    <label for="question2">Pregunta 2</label>
                    <input class="input-recovery" type="text" name="question2" placeholder="¿Cuál es mi comida favorita?" required>
                    <label for="answer2">Respuesta 2</label>
                    <input class="input-recovery" type="text" name="answer2" placeholder="Pasticho" required>
                </div>

                <div class="div-recovery-password">
                    <label for="question3">Pregunta 3</label>
                    <input class="input-recovery" type="text" name="question3" placeholder="¿Lugar favorito?" required>
                    <label for="answer3">Respuesta 3</label>
                    <input class="input-recovery" type="text" name="answer3" placeholder="Mi Casa" required>
                </div>
                <?php showSignupErrors(); ?>
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