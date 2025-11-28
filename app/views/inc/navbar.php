<div class="full-width navBar">
    <div class="full-width navBar-options">
        <i class="fas fa-exchange-alt fa-fw" id="btn-menu"></i> 
        <nav class="navBar-options-list">
            <ul class="list-unstyle">
                <li class="text-condensedLight noLink">
                    <a class="btn-exit" href="<?php echo APP_URL . "logOut/"; ?>">
                        <i class="fas fa-power-off"></i>
                    </a>
                </li>

     <!-- 🔔 Notificaciones -->
<li class="text-condensedLight noLink">
    <div style="position: relative; display: inline-block;">
        <i class="fas fa-bell fa-2x" style="font-size: 18px; cursor: pointer;" id="campana-notificacion"></i>

        <span id="contador-stock" class="notificacion-contador" style="
              position: absolute;
              top: 2px;
              right: -10px;
              background-color: red;
              color: white;
              border-radius: 999px;
              padding: 2px 5px;
              font-size: 10px;
              font-weight: bold;
              min-width: 18px;
              text-align: center;
              line-height: 1;
              display: inline-block;">
            0
        </span>

        <!-- Dropdown -->
        <div id="dropdown-stock" style="
             display: none;
             position: absolute;
             right: 0;
             top: 30px;
             background-color: white;
              color: black;
             border: 1px solid #ccc;
             border-radius: 6px;
             box-shadow: 0px 2px 8px rgba(0,0,0,0.2);
             width: 250px;
             max-height: 300px;
             overflow-y: auto;
             z-index: 1000;
             padding: 10px;">
             
            <strong>Productos con bajo stock:</strong>
            
            <!-- CAMBIAMOS <ul> por <div> -->
            <div id="lista-stock" style="display: flex; flex-direction: column; gap: 10px; margin-top: 10px;"></div>
        </div>
    </div>
</li>


                <!-- 👤 Usuario -->
                <li class="text-condensedLight noLink">
                    <small><?php echo $_SESSION['usuario']; ?></small>
                </li>

                <!-- 🖼️ Foto de perfil -->
                <li class="noLink">
                    <?php
                    if (is_file("./app/views/fotos/" . $_SESSION['foto'])) {
                        echo '<img class="is-rounded img-responsive" src="' . APP_URL . 'app/views/fotos/' . $_SESSION['foto'] . '">';
                    } else {
                        echo '<img class="is-rounded img-responsive" src="' . APP_URL . 'app/views/fotos/default.png">';
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </div>
</div>
