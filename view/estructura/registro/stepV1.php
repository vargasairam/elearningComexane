<div class="row gx-3 gy-4 heightContent">
    <div class="col-sm-6 mt-0">
        <div class="form-floating">
            <input type="email" class="form-control" required id="Correo" name="email" placeholder="Correo electrónico" />
            <label for="floatingInput">Correo electrónico <span class='obligatorio'>*</span></label>
        </div>
    </div>

    <div class="col-sm-6 mt-0">
        <div class="form-floating position-relative">

            <input type="password" class="form-control" required id="Password" name="password" placeholder="Contraseña">
            <label for="Password">Contraseña <span class='obligatorio'>*</span></label>

        </div>
    </div>
    <div class="col-sm-12 mt-0">
        <div id="passwordHelp" class="mt-2 small border rounded p-2 bg-light">
            <strong>La contraseña debe contener:<span class="text-muted"> (The password must contain)</span></strong>
            <ul class="mb-0 ps-3">
                <li id="rule-length" class="text-danger">Mínimo 8 caracteres / Minimum 8 characters</li>
                <li id="rule-upper" class="text-danger">Al menos una letra mayúscula / At least one uppercase letter</li>
                <li id="rule-lower" class="text-danger">Al menos una letra minúscula / At least one lowercase letter</li>
                <li id="rule-number" class="text-danger">Al menos un número / At least one number</li>
            </ul>
        </div>
    </div>

    <div class="col-sm-6 mt-0">
        <div class="form-floating position-relative">

            <input type="password" class="form-control" required id="PasswordC" name="passwordC" placeholder="Confirmar Contraseña">
            <label for="Password">Confirmar Contraseña</label>

        </div>
    </div>

    <div class="col-sm-6 mt-0">
        <div class="form-floating" id="categoriaDivSelect">
            <select class="form-select" required id="Categoria" name="categoria" aria-label="categoria">
                <option value="" disabled selected>Seleccionar una categoria</option>
            </select>
        </div>
        <div class="form-floating d-none" id="categoriaDiv">
            <input type="text" class="form-control" id="categoria2" name="categoria2" placeholder="Especificar categoria" oninput="this.value = this.value.toUpperCase()" />
            <label for="floatingInput">Especificar categoria <span class='obligatorio'>*</span></label>
        </div>
    </div>
</div>