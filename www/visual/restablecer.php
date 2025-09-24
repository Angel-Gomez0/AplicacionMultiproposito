<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Restablecer contraseña</title>
  <link rel="stylesheet" href="css/restablecer.css" />
</head>
<body>
  <main class="container">
    <section class="card" aria-labelledby="recover-title">
      <h1 id="recover-title" class="title">Restablecer contraseña</h1>
      <p class="hint">Ingresa tu correo para enviar un enlace de restablecimiento.</p>
      <form action="#" method="post" autocomplete="on" novalidate>
        <div class="row">
          <div class="field">
            <label for="recover-email">Correo:</label>
            <br>
            <input type="email" id="recover-email" name="email" placeholder="usuario@ejemplo.com" required />
          </div>
        </div>
        <br>
        <div class="actions">
          <button class="btn-primary" type="submit">Enviar enlace de restablecimiento</button>
          <a class="btn-secondary" href="login.php" style="display:inline-block; text-decoration:none; line-height:38px; padding:0 16px;">Volver a iniciar sesión</a>
        </div>
      </form>
    </section>
  </main>
</body>
</html>