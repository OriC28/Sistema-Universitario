<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="es">
<?php define('BASE_URL', '/Sistema-Universitario/');?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login-register.css?v=<?php echo time(); ?>" />
    <title>Iniciar Sesión</title>
</head>
<body class="responsive">
    <header class="header">
        <h1>Iniciar Sesión</h1>
    </header>
    <main>
        <div class="container">
            <h2>Estudiante</h2>
            <form action="<?= BASE_URL?>index.php?controller=login&action=loginStudent" method="post">
                <label for="email">Cédula</label>
                <div class="div-input-email">
                    <span><img src="..\assets\icons\user.png" alt="icon-user"/></span>
                    <input class="input-login" type="text" name="cedula" placeholder="Ej: 30569304" required>
                </div>
                
                <label for="password">Contraseña</label>
                <div class="div-input-password">
                    <span><img src="..\assets\icons\password.png" alt="icon-password"/></span>
                    <input class="input-login" type="password" name="password" placeholder="Ingresa tu contraseña" required>
                </div>
                
                <div class="center-button">
                    <input type="submit" class="button-styles" name="submit" value="Iniciar sesión">
                    <button class="button-styles" type="button"><a class="button-text" href="signupForm.php">O regístrate</a></button>
                </div>
                <span><a id="link-recovery" href="changePasswordStep1.php">¿Haz olvidado tu contraseña?</a></span>
            </form>
        </div>
    </main>
    <footer>
        <p>copinai</p>
    </footer>
</body>
</html>

