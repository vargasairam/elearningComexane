<div class="dropdown mt-2 d-flex align-items-center">
    <button class="btn position-relative" data-bs-toggle="dropdown" aria-expanded="false">

        <i id="carrito_badge" class="ri-shopping-cart-2-line fs-3"></i>       
    </button>

    <ul id="carrito_compras" class="dropdown-menu dropdown-menu-end mt-5 p-3" style="min-width: 300px;">
        <li class="mb-2">
            <strong>Carrito</strong>
        </li>

        <!-- producto -->
        <!-- <li  class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <small>Curso A</small><br>
                <small class="text-muted">$100</small>
            </div>
            <button class="btn btn-sm">x</button>
        </li>

        <li class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <small>Curso B</small><br>
                <small class="text-muted">$200</small>
            </div>
            <button class="btn btn-sm">x</button>
        </li>

        <li>
            <hr class="dropdown-divider" />
        </li>

        <li class="d-flex justify-content-between">
            <strong>Total:</strong>
            <strong>$300</strong>
        </li> -->

        
    </ul>
</div>

<div class="dropdown">
    <button
        class="btn dropdown-toggle"
        data-bs-toggle="dropdown"
        aria-expanded="false">
        <div class="box_info_user">
            <small class="c_primary">Bienvenido</small>
            <h6 class="m-0"><span><?= $user->prefijotxt . " " . $user->nombreconstancia  ?></span> </h6>
        </div>
        <div class="box_photo_user">
            <i class="ri-user-line"></i>
        </div>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item" href="?seccion=perfil"><i class="ri-user-line"></i> Mi perfil</a>
        </li>
        <!-- <li>
            <a class="dropdown-item" href="#"><i class="ri-error-warning-line"></i> Ayuda</a>
        </li> -->
        <!-- <li>
            <hr class="dropdown-divider" />
        </li> -->
        <li>
            <a class="dropdown-item" href="?seccion=logout"><i class="ri-logout-circle-r-line"></i> Salir</a>
        </li>
    </ul>
</div>