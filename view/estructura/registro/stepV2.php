<div class="row gx-3 gy-4 heightContent">
    <div class="col-sm-4">
        <div class="form-floating" id="prefijodiv">
            <select class="form-select" id="prefijos" name="prefijo" aria-label="Prefijo" required>
                <option value="" selected disabled>Título</option>
            </select>
        </div>

        <div class="form-floating d-none" id="prefijo2div">
            <input type="text" class="form-control" id="prefijo2" name="prefijo2" placeholder="Especificar prefijo" oninput="this.value = this.value.toUpperCase()" />
            <label for="floatingInput">Especificar título <span class='obligatorio'>*</span></label>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-floating">
            <input type="text" class="form-control" id="Nombres" name="nombre" placeholder="Nombres(s)" oninput="this.value = this.value.toUpperCase()" required />
            <label for="floatingInput">Nombres(s) <span class='obligatorio'>*</span></label>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-floating">
            <input type="text" class="form-control" id="Apellidos" name="apellidos" placeholder="Apellidos" oninput="this.value = this.value.toUpperCase()" required />
            <label for="floatingInput">Apellidos <span class='obligatorio'>*</span></label>
        </div>
    </div>

    <div class="col-sm-6 mt-0">
        <div class="form-floating">
            <select class="form-select" required id="genero" name="genero" aria-label="genero">
                <option value='' disabled selected>Género</option>
                <option value='1'>Hombre</option>
                <option value='2'>Mujer</option>
                <option value='3'>Prefiero no responder</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6 mt-0">
        <div class="form-floating">
            <select class="form-select" name="edad" id="edad" required>
                <option value='' disabled selected>Edad</option>
            </select>
        </div>
    </div>

</div>