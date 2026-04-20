<div class="dropdown">
    <button
        class="btn dropdown-toggle"
        data-bs-toggle="dropdown"
        aria-expanded="false">
        <div class="box_info_user">
            <small class="c_primary">Bienvenido</small>
            <h6 class="m-0"><span>
                <?= $user[0]->nombre . " " . $user[0]->apellidos  ?></span> </h6>
        </div>
        <div class="box_photo_user">
            <i class="ri-user-line"></i>
        </div>
    </button>
    <ul class="dropdown-menu">
        <!-- <li>
            <a class="dropdown-item" href="?seccion=perfil"><i class="ri-user-line"></i> Mi perfil</a>
        </li> -->
        <li>
            <a class="dropdown-item" href="./?seccion=logout"><i class="ri-logout-circle-r-line"></i> Salir</a>
        </li>
    </ul>
</div>