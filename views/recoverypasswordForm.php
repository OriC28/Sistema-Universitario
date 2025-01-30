<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if(!isset($_SESSION["userSignupData"])){
        header("Location: loginStudent.php");
        exit();
    }

    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\ErrorMessages.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php define('BASE_URL', '/Sistema-Universitario/');?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/login-register.css?v=<?php echo time(); ?>" />
    <title>Preguntas de seguridad</title>
</head>
<body class="responsive">
    <header class="header">
        <h1>Preguntas de Seguridad</h1>
    </header>
    <main>
        <div class="container">
            <form class="form-recovery" action="<?= BASE_URL ?>index.php?controller=register&action=finishSignUp" method="post">
                <div class="div-recovery-password">
                <label for="question1">Pregunta 1</label>
                    <input class="input-recovery" type="text" name="primera-pregunta" placeholder="¿Cuál es mi color favorito?" required autocomplete="off">
                    <label for="answer1">Respuesta 1</label>
                    <input class="input-recovery" type="text" name="primera-respuesta" placeholder="Amarillo" required autocomplete="off">
                </div>

                <div class="div-recovery-password">
                    <label for="question2">Pregunta 2</label>
                    <input class="input-recovery" type="text" name="segunda-pregunta" placeholder="¿Cuál es mi comida favorita?" required autocomplete="off">
                    <label for="answer2">Respuesta 2</label>
                    <input class="input-recovery" type="text" name="segunda-respuesta" placeholder="Pasticho" required autocomplete="off">
                </div>

                <div class="div-recovery-password">
                    <label for="question3">Pregunta 3</label>
                    <input class="input-recovery" type="text" name="tercera-pregunta" placeholder="¿Lugar favorito?" required autocomplete="off">
                    <label for="answer3">Respuesta 3</label>
                    <input class="input-recovery" type="text" name="tercera-respuesta" placeholder="Mi Casa" required autocomplete="off">
                </div>
                <?php ErrorMessages::showErrors("signupErrors"); ?>
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