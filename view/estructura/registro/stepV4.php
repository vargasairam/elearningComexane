<div class="row gx-3 gy-4 heightContent">
    <div class="col-sm-6 mt-0">
        <div class="form-floating">
            <select class="form-select" required id="Paises" name="pais" aria-label="Paises">
            </select>
        </div>
    </div>
    
    <div class="col-sm-6 mt-0">
        <div class="form-floating">
            <select class="form-select" required id="Estado" name="estado" aria-label="Estado">
            </select>
        </div>
    </div>

    <div class="col-sm-6 mt-0">
        <div class="input-group">

            <!-- bandera + extension -->
            <span class="input-group-text">
                <img id="banderaPais"
                    src="https://flagcdn.com/24x18/mx.png"
                    width="24"
                    height="18"
                    style="margin-right:5px;">
                <span id="codigoPais">+52</span>
            </span>

            <!-- telefono -->
            <div class="form-floating">
                <input type="text"
                    required
                    class="form-control"
                    id="Telefono"
                    name="telefono"
                    placeholder="Teléfono">
                <label for="Telefono">Teléfono</label>
            </div>

        </div>
    </div>

</div>
