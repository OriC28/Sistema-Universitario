<!DOCTYPE html>
<html lang="es">
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
            <form action="../index.php?controller=user&action=getUser" method="post">
                <label for="email">Cédula</label>
                <div class="div-input-email">
                    <span><img class="icon" width="30" height="30" src="https://img.icons8.com/ios-glyphs/30/gender-neutral-user.png" alt="gender-neutral-user"/></span>
                    <input class="input-login" type="text" name="cedula" placeholder="Ej: 30569304" required>
                </div>
                
                <label for="password">Contraseña</label>
                <div class="div-input-password">
                    <span><img class="icon" width="30" height="30" src="https://img.icons8.com/ios-glyphs/30/password--v1.png" alt="password--v1"/></span>
                    <input class="input-login" type="password" name="password" placeholder="Ingresa tu contraseña" required>
                </div>
                
                <div class="center-button">
                    <input type="submit" class="button-styles" name="submit" value="Iniciar sesión">
                    <button class="button-styles" type="button"><a class="button-text" href="signupForm.php">O regístrate</a></button>
                </div>
                <span><a id="link-recovery" href="recoverypasswordForm.php">¿Haz olvidado tu contraseña?</a></span>
            </form>
        </div>
    </main>
    <footer>
        <p>copinai</p>
    </footer>
</body>
</html>

