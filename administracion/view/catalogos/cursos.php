<section class="content_global">
    <?php include_once "view/estructura/header.php"; ?>
    <div class="row g-6 mt-0">
        <div class="col-xxl mt-3">            
            <div>
                <div class="card-header">
                    <div class="row m-3 my-0 justify-content-between">
                        <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto">
                            <button class="btn btn-inicio add-new btn-primary" tabindex="0" aria-controls="tb_empresas" type="button" data-bs-toggle="modal" data-bs-target="#modal_curso"><span><span class="d-flex align-items-center gap-2"><i class="fa-solid fa-circle-plus"></i> <span class="d-none d-sm-inline-block">Agregar</span></span></span></button>
                        </div>
                    </div>                
                </div>
                <div class="card-body">
                    <!-- TABLA EMPRESAS -->
                    <div class="card-datatable">
                        <table id="tb_cursos" class="datatables-users table">
                            <thead class="border-top">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Tipo de producto</th>
                                    <th>Descripción</th>
                                    <th>Fecha inicio</th>
                                    <th>Fecha fin</th>
                                    <th>Precio</th>
                                    <th>Módulos</th>
                                    <th>% para constancia</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-lg" id="modal_curso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel1">Nuevo Curso </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add-new-user pt-0" id="addCurso" enctype="multipart/form-data">
                    <div class="modal-body size-f-modal">
                        <div class="row">
                            <div class="col-6 mb-4">
                                <label class="form-label">Tipo de producto<span class='obligatorio'>*</span></label>
                                <select name="tipoCurso" class="form-control tipos" required>
                                    <option value="">Seleccione un tipo de curso</option>
                                    <?php
                                        $tipoCursos = $CC->GetTipoProductos();
                                        foreach($tipoCursos as $tipoCurso){
                                            echo "<option value='".$tipoCurso->id."'>".$tipoCurso->tipoProducto."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Título<span class='obligatorio'>*</span></label>
                                <input type="text" name="titulo" class="form-control" required placeholder="Ingrese el titulo del curso">
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Descripción<span class='obligatorio'>*</span></label>
                                <textarea name="descripcion" class="form-control" required></textarea>
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Fecha inicio<span class='obligatorio'>*</span></label>
                                <input type="date" name="f_inicio" class="form-control" required>
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Fecha fin<span class='obligatorio'>*</span></label>
                                <input type="date" name="f_fin" class="form-control" required placeholder="Ingrese el titulo del curso">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Precio<span class='obligatorio'>*</span></label>
                                <input type="text" name="precio" class="form-control" required placeholder="Ingrese el precio del curso">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Estado<span class='obligatorio'>*</span></label>
                                <select name="habilitado" class="form-control" required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="0">Activo</option>
                                    <option value="1">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">% necesario para constancia<span class='obligatorio'>*</span></label>
                                <input type="number" name="porcentaje_constancia" required class="form-control" placeholder="Ingrese el porcentaje">
                            </div>
                            <div class="col-6 mb-4 modulos d-none">
                                <label class="form-label">¿Contará con módulos?</label>
                                <select name="modulos" class="form-control mods">
                                    <option value="">Seleccione una opción</option>
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                            <div class="col-6 n_modulos mb-4 d-none">
                                <label class="form-label"># de módulos con lo que contará<span class='obligatorio'>*</span></label>
                                <input type="number" name="n_modulos" class="form-control" placeholder="Ingrese el número de módulos">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Póster <small>(Debe ser una imagen .jpg, .png o .jpeg)</small><span class='obligatorio'>*</span></label>
                                <input type="file" name="poster_small" class="form-control" required placeholder="Ingrese el póster small" accept=".jpg,.png,.jpeg">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Constancia pantilla <small>(Debe ser un archivo .pdf)</small><span class='obligatorio'>*</span></label>
                                <input type="file" name="constancia_pantilla" class="form-control" required placeholder="Ingrese la constancia pantilla" accept=".pdf">
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-inicio waves-effect waves-light">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-lg" id="modal_update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel1">Actualizar datos del Curso </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add-new-user pt-0" id="updateCurso" enctype="multipart/form-data">
                    <div class="modal-body size-f-modal">
                        <div class="row">
                            <div class="col-6 mb-4">
                                <label class="form-label">Tipo de producto</label>
                                <select name="tipoCurso" id="tipoCurso" class="form-control tipos" required>
                                    <option value="">Seleccione un tipo de curso</option>
                                    <?php
                                        $tipoCursos = $CC->GetTipoProductos();
                                        foreach($tipoCursos as $tipoCurso){
                                            echo "<option value='".$tipoCurso->id."'>".$tipoCurso->tipoProducto."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Título</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" required placeholder="Ingrese el titulo del curso">
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
                                <input type="hidden" name="id_update" id="id_update">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Fecha inicio</label>
                                <input type="date" name="f_inicio" id="f_inicio" class="form-control" required>
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Fecha fin</label>
                                <input type="date" name="f_fin" class="form-control" required placeholder="Ingrese el titulo del curso">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Precio</label>
                                <input type="text" name="precio" class="form-control" required placeholder="Ingrese el precio del curso">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Estado</label>
                                <select name="habilitado" id="habilitado" class="form-control" required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="0">Activo</option>
                                    <option value="1">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">% necesario para constancia</label>
                                <input type="number" name="porcentaje_constancia" id="porcentaje_constancia" class="form-control" required placeholder="Ingrese el porcentaje">
                            </div>
                            <div class="col-6 mb-4 modulos">
                                <label class="form-label">¿Contará con módulos?</label>
                                <select name="modulos" id="modulos" class="form-control mods" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </div>
                            <div class="col-6 n_modulos mb-4 d-none">
                                <label class="form-label"># de módulos con lo que contará<span class='obligatorio'>*</span></label>
                                <input type="number" id="n_modulos" name="n_modulos" class="form-control" placeholder="Ingrese el número de módulos">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Póster <small>(Debe ser una imagen .jpg, .png o .jpeg)</small></label>
                                <input type="file" name="poster_small" class="form-control" placeholder="Ingrese el póster small" accept=".jpg,.png,.jpeg">
                            </div>
                            <div class="col-6 mb-4">
                                <label class="form-label">Constancia pantilla <small>(Debe ser un archivo .pdf)</small></label>
                                <input type="file" name="constancia_pantilla" class="form-control" placeholder="Ingrese la constancia pantilla" accept=".pdf">
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-inicio waves-effect waves-light">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
    $scripts_js = [
        "js" => [
            "js/Catalogos/cursos.js"
        ]
    ];
?>