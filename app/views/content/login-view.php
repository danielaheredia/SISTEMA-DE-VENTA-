<div class="main-container">
    <!-- Formulario de login (lado izquierdo) -->
    <div class="login-box">
        <div class="logo">
            <img src="http://localhost/VENTAS/app/views/img/l.jpg" alt="Wichitroco">
        </div>

        <h5 class="title is-5 has-text-centered">Inicia sesión con tu cuenta</h5>

        <?php
            if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
                $insLogin->iniciarSesionControlador();
            }
        ?>

        <form class="box login" action="" method="POST" autocomplete="off">
            <div class="field">
                <label class="label"><i class="fas fa-user-secret"></i> &nbsp; Usuario</label>
                <div class="control">
                    <input class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>

            <div class="field">
                <label class="label"><i class="fas fa-key"></i> &nbsp; Clave</label>
                <div class="control">
                    <input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>

            <p class="has-text-centered mb-4 mt-3">
                <button type="submit" class="button is-info is-rounded">Iniciar sesión</button>
            </p>
        </form>
    </div>

    <!-- Imagen de herramientas (lado derecho) -->
    <div class="tools-image"></div>
</div>
