<div class="modal fade" id="modalCuestionario" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Cuestionario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form id='formModal'>
            <div class="modal-body">

                <div class="row g-3">

                    <!-- Accesibilidad -->
                    <div class="col-md-6">
                        <label class="form-label">
                        ¿Tienes alguna necesidad de movilidad o accesibilidad?
                        </label>

                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" required name="accesibilidad" value="si">
                                <label class="form-check-label">Sí</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="accesibilidad" value="no">
                                <label class="form-check-label">No</label>
                            </div>
                            
                        </div>
                        <div class='mt-2'>
                            <input class="form-control d-none" id='detalleAccesibilidad' placeholder="Especifique">
                        </div>
                    </div>
                    <!-- Traducción -->
                    <?php if(!isset($virtual)): ?>
                        <div class="col-md-6">
                            <label class="form-label">
                            ¿Requiere traducción simultánea para el congreso presencial?
                            </label>

                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" required name="traduccion" value="si">
                                    <label class="form-check-label">Sí</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="traduccion" value="no">
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>

                            <small class="text-muted">
                                * La traducción simultánea está disponible únicamente para el congreso presencial.
                            </small>
                        </div>
                    <?php endif; ?>
                    

                    <!-- Enterado -->
                    <div class="col-md-6">
                        <label class="form-label">
                        ¿Cómo te enteraste del congreso?
                        </label>

                        <select class="form-select" required id='enterado'>
                            <option value='' disbaled select>Seleccione una opción</option>
                            <option value='1'>Redes sociales</option>
                            <option value='2'>Correo institucional</option>
                            <option value='3'>Página web</option>
                            <option value='4'>Colega / recomendación</option>
                            <option value='5'>Universidad</option>
                            <option value='6'>Otro</option>
                        </select>

                        <input type="text" class="form-control mt-2 d-none" name="otro_medio" id="otro_medio" placeholder="Especifique">
                    </div>

                    <!-- Eventos -->
                    <div class="col-md-6">
                        <label class="form-label">
                        ¿Desea recibir información de otros eventos académicos?
                        </label>

                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" required name="eventos" value="si">
                                <label class="form-check-label">Sí</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="eventos" value="no">
                                <label class="form-check-label">No</label>
                            </div>
                        </div>
                    </div>

                    <!-- Alergia -->
                    <div class="col-md-12">
                        <label class="form-label">
                        ¿Tienes alguna alergia alimentaria?
                        </label>

                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" required name="alergia" value="si">
                                <label class="form-check-label">Sí</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="alergia" value="no">
                                <label class="form-check-label">No</label>
                            </div>
                        </div>
                        <div class="mt-2 d-none" id='opcionesDieta'>
                            <label class="form-label">¿Cuál es su alergia alimentaria o requisito dietético?:</label>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dieta[]" value="1" id="vegetariano">
                                        <label class="form-check-label" for="vegetariano">
                                            Vegetariano
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dieta[]" value="2" id="vegano">
                                        <label class="form-check-label" for="vegano">
                                            Vegano
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dieta[]" value="3" id="gluten">
                                        <label class="form-check-label" for="gluten">
                                            Sin gluten
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dieta[]" value="4" id="kosher">
                                        <label class="form-check-label" for="kosher">
                                            Kosher
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dieta[]" value="5" id="halal">
                                        <label class="form-check-label" for="halal">
                                            Halal
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dieta[]" value="6" id="lactosa">
                                        <label class="form-check-label" for="lactosa">
                                            Intolerante a la lactosa
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="otroDieta">
                                        <label class="form-check-label" for="otroDieta">
                                            Otro
                                        </label>
                                    </div>

                                    <input type="text" class="form-control mt-2 d-none" name="dieta_otro" id="dieta_otro" placeholder="Especifique">
                                </div>

                                </div>
                        </div>
                    </div>

                    <!-- Recibo -->
                    <div class="col-md-12">
                        <label class="form-label">
                        ¿Requiere recibo de deducibilidad?
                        </label>

                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" required name="recibo" value="si">
                                <label class="form-check-label">Sí</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="recibo" value="no">
                                <label class="form-check-label">No</label>
                            </div>
                        </div>

                            <div id="facturacionBox" class="border rounded p-3 mt-3 d-none">

                                <h6 class="mb-3">Datos de facturación</h6>

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="rfc" id='rfc' placeholder="RFC (Opcional)">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="razon_social" id='razon_social' placeholder="Razón social (Opcional)">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="correo_factura" id='correo_factura' placeholder="Correo para factura (Opcional)">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="cp_factura" id='cp_factura' placeholder="Código postal fiscal (Opcional)">
                                    </div>

                                    </div>

                                    <div class="mt-3">
                                        <h5 class="mb-2">Solicitud de recibo</h5>
    
                                        <p class="mb-3 text-muted">
                                            Si requiere su recibo, puede solicitarlo en la siguiente plataforma de recibos 
                                            dando click en el siguiente botón.
                                        </p>

                                        <a href="https://kardias.org/recibos/" target="_blank" class="btn btn-secondary" style="background: #D43D4A;border-color: #D43D4A;color: white;">
                                        Ir a plataforma de recibos
                                        </a>

                                    </div>

                                </div>
                        
                    </div>

                    <?php if(isset($virtual)): ?>
                        <label class="form-check-label">
                            * La traducción del congreso virtual contará con dos canales (español e inglés). Puedes elegir el idioma de tu preferencia.
                        </label>
                    <?php endif; ?>

                    

                </div>

            </div>

            <div class="modal-footer">
                <a class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</a>
                <button class="btn btn-primary" type="submit" id='guardarPreferencias'>Guardar Información</button>
            </div>
        </form>

        

        </div>
    </div>
</div>