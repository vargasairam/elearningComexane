<div class="row gx-3 gy-4 heightContent">
    <div class="col-sm-4">
        <div class="form-floating">
            <input type="text" class="form-control" id="Nombres" name="nombre" placeholder="Nombres(s)" oninput="this.value = this.value.toUpperCase()" required />
            <label for="floatingInput">Nombres(s) <span class='obligatorio'>*</span></label>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-floating">
            <input type="text" class="form-control" id="Apellidop" name="apellidop" placeholder="Apellido paterno" oninput="this.value = this.value.toUpperCase()" required />
            <label for="floatingInput">Apellido paterno <span class='obligatorio'>*</span></label>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-floating">
            <input type="text" class="form-control" id="Apellidom" name="apellidom" placeholder="Apellido materno" oninput="this.value = this.value.toUpperCase()" required />
            <label for="floatingInput">Apellido materno <span class='obligatorio'>*</span></label>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-floating" id="prefijodiv">
            <select class="form-select" id="prefijos" name="prefijo" aria-label="Prefijo" required>
                <option value="" selected disabled>Título</option> 
                <option value="DR.">DR.</option>
                <option value="DRA.">DRA.</option>
                <option value="ENFERMERA(O)">ENFERMERA(O)</option>
                <option value="ESTUDIANTE">ESTUDIANTE</option>
            </select>
        </div>

        <div class="form-floating d-none" id="prefijo2div">
            <input type="text" class="form-control" id="prefijo2" name="prefijo2" placeholder="Especificar prefijo" oninput="this.value = this.value.toUpperCase()" />
            <label for="floatingInput">Especificar título <span class='obligatorio'>*</span></label>
        </div>
    </div>

    <div class="col-sm-9">
        <div class="form-floating">
            <input type="text" class="form-control" id="nombreConstancia" name="nombreConstancia" placeholder="Nombre para la constancia" oninput="this.value = this.value.toUpperCase()" required />
            <label for="floatingInput">Nombre en Constancia<span class="obligatorio" aria-required="true">*</span> <small class="text-warning"> (Incluya acentos)</small></label>
            
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-floating">
            <input type="date" class="form-control" id="f_nacimiento" name="f_nacimiento" placeholder="" oninput="this.value = this.value.toUpperCase()" />
            <label for="floatingInput">Fecha de nacimiento </label>
        </div>
    </div>

    <div class="col-sm-6 mt-0">
        <div class="form-floating">
            <input type="text" class="form-control" id="curp" name="curp" placeholder="Cargo" />
            <label for="floatingInput">CURP <span class='obligatorio'>*</span></label>
        </div>
    </div>   

    <div class="col-sm-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="celular" name="celular" maxlength="10" placeholder="" oninput="this.value = this.value.toUpperCase()" required />
            <label for="floatingInput">Teléfono celular <span class='obligatorio'>*</span></label>
        </div>
    </div>

    <!-- <div class="col-sm-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="particular1" name="particular1" maxlength="10" placeholder="" oninput="this.value = this.value.toUpperCase()" />
            <label for="floatingInput">Teléfono particular 1</label>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="particular2" name="particular2" maxlength="10" placeholder="" oninput="this.value = this.value.toUpperCase()" />
            <label for="floatingInput">Teléfono particular 2 </label>
        </div>
    </div> -->
</div>