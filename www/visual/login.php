<?php

  
 
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inicio de sesión</title>
  <link rel="stylesheet" href="css/login.css" />
</head>
<body>
  <main class="container">
    <section class="card"  aria-labelledby="login-title">
      <h1 id="login-title" class="title">Inicio de sesión</h1>
      <p class="hint">Accede a tu cuenta existente. Si olvidaste tu contraseña, utiliza la opción de restablecimiento.</p>
      <form action="../controller/login.php" method="post" autocomplete="on" >
        <div class="row">
          <div class="field">
            <label for="login-user">Usuario o correo</label>
            <input type="text" id="login-user" name="email" placeholder="anymail@gmail.com" required />
          </div>
          <br>
          <div class="field password-field">
            <label for="login-password">Contraseña</label>
            <div class="password-wrap">
              <input type="password" id="login-password" name="password" placeholder="*******" required />
              <button type="button" class="toggle-password" aria-label="Mostrar u ocultar contraseña" onclick="togglePassword('login-password', this)">
                👁️
              </button>
            </div>
          </div>
        </div>

        <div class="row" style="align-items:center;">
          <div style="display:flex; align-items:center; gap:8px;">
            <input type="checkbox" id="remember" name="remember" />
            <label for="remember" style="margin-top: 10px;">Recuérdame</label>
          </div>
        </div>

       <br>
        
        <div class="actions">
          <button class="btn-primary" type="submit">Iniciar sesión</button>
          <button class="btn-secondary" type="button" onclick="document.querySelector('form').reset()">Limpiar</button>
        </div>

        <!-- Enlace a registro -->
        <p class="hint" style="text-align:center; margin-top:12px;">
          ¿No tienes cuenta? 
          <a href="register.html" style="color:#9bd0ff; text-decoration: none;">Regístrate</a>
        </p>

        <!-- Enlace a restablecimiento (página estática) -->
        <p class="hint" style="text-align:center; margin-top:6px;">
          ¿Olvidaste tu contraseña? <a href="restablecer.html" style="color:#9bd0ff; text-decoration: none;">Restablecer</a>
        </p>
      </form>
    </section>
  </main>

  <script src="js/password-toggle.js"></script>
  <script src="js/form-validation.js"></script>
  <script>
    // Inicializar validaciones si es necesario
    // setupLoginValidation();
  </script>
</body>
</html>